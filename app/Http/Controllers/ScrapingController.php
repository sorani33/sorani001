<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScrapingDetail;
use App\ScrapingFromPersonalPage;
use App\Http\Controller\ScrapingDetailController;


class ScrapingController extends Controller
{
    public function test () {
        $url = "https://www.sejuku.net/blog/";

        //cURLセッションを初期化する
        $ch = curl_init();

        //URLとオプションを指定する
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //URLの情報を取得する
        $res =  curl_exec($ch);

        //結果を表示する
        var_dump($res);

        // //セッションを終了する
        // curl_close($conn);
    }


    public function index () {
        // $scrape_url_list = array( //配列でURLを送ると並列処理されます
        //     htmlspecialchars_decode( 'https://movie.eroterest.net/?word=&c=&page=1' ),
        //     htmlspecialchars_decode( 'https://movie.eroterest.net/?word=&c=&page=2' ),
        //     htmlspecialchars_decode( 'https://movie.eroterest.net/?word=&c=&page=3' ),
        // );
        $scrape_url_list = array();
        for($i = 1; $i < config('bootstrap.urlcount'); $i++){
            $scrape_url_list[] = htmlspecialchars_decode( 'https://movie.eroterest.net/?word=&c=&page='.$i );
        }

        // dd(ScrapingDetail::index($scrape_url_list));

        // 正規表現を書く。
        $seikihyougen = '/<div class="itemBody"(.*?)<div class="itemHead"/s'; //20人取れないけど暫定。
        $scrape_content = $this->scraping_content($scrape_url_list, $seikihyougen);
    }


    function scraping_content($scrape_url_list, $seikihyougen){

        $TIMEOUT = 40;
        $result= array();
        // 1) 準備
        // 複数の cURL ハンドルを並列で実行する。
        $mh = curl_multi_init();

        foreach ($scrape_url_list as $url) {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => $TIMEOUT,
                CURLOPT_CONNECTTIMEOUT => $TIMEOUT,
                //CURLOPT_PROXYPORT      => "プロキシのポート",
                //CURLOPT_PROXY          => "プロキシ",
                //CURLOPT_PROXYUSERPWD   => "プロキシのパスワード",
            ));
            curl_multi_add_handle($mh, $ch);
        }


        /*
         * 2) リクエストを開始する
         *  - curl_multiでは即座に制御が戻る（レスポンスが返ってくるのを待たない）
         *  - いきなり失敗するケースを考えてエラー処理を書いておく
         *  - do～whileはlibcurl<7.20で必要
         */
        do {
            $stat = curl_multi_exec($mh, $running);
        } while ($stat === CURLM_CALL_MULTI_PERFORM);
        if ( ! $running || $stat !== CURLM_OK) {
            throw new RuntimeException('リクエストの開始不可、URLの設定を確認');
        }


        /*
         * 3) レスポンスをcurl_multi_selectで待つ
         *  - 何かイベントがあったらループが進む
         *    selectはイベントが起きるまでCPUをほとんど消費せずsleep状態になる
         *  - どれか一つレスポンスが返ってきたらselectがsleepを中断して何か数字を返す。
         *
         */
        do switch (curl_multi_select($mh, $TIMEOUT)) {
            case -1: //selectに失敗
                usleep(5);
                do {
                    $stat = curl_multi_exec($mh, $running);

                } while ($stat === CURLM_CALL_MULTI_PERFORM);
                continue 2;
            case 0:  //タイムアウト
                continue 2;
            default: //どれかが成功 or 失敗した
                do {
                    $stat = curl_multi_exec($mh, $running);
                } while ($stat === CURLM_CALL_MULTI_PERFORM);
                do if ($raised = curl_multi_info_read($mh, $remains)) {
                        //変化のあったcurlハンドラを取得する
                        $info = curl_getinfo($raised['handle']);
                        // echo "$info[url]: $info[http_code]: $info[total_time]\n";

                        // URL本体が下記に入る。
                        $response = curl_multi_getcontent($raised['handle']);

                        if ($response === false) {
                            echo 'ERROR!!!', PHP_EOL;
                        } else {
                            //正常にレスポンスを取得する
                            $pattern = "$seikihyougen";
                            $match = array();

                            preg_match_all($pattern, $response, $match, PREG_SET_ORDER);
                            $count = count($match);
                            $scrape_content = $this->castList($match, $count);
                            $result = array_merge($result, $scrape_content);
                        }// else
                        curl_multi_remove_handle($mh, $raised['handle']);
                        curl_close($raised['handle']);
                    } while ($remains);
            } while ($running);

            echo 'finished01', PHP_EOL;
            curl_multi_close($mh);

            $detailUrlTotal = array();
            foreach($result as $detailUrl){
                $detailUrlTotal[] = $detailUrl[4];
            }
            $resultCount = count($result);
            $detailUrlTotalResult = ScrapingDetail::index($detailUrlTotal);

            for($i = 0; $i < $resultCount; $i++){
                $result[$i][] = $detailUrlTotalResult[$i][0];
            }
            /* ファイルポインタをオープン */
            $file = fopen("/var/www/html/sorani001/test.csv", "w");
            foreach($result as $content){
                fputcsv($file, $content);
            }
            /* ファイルポインタをクローズ */
            fclose($file);
        }






        // ここから関数
        function castList($match, $count){
            $scrape_content = array ();
            for ($j = 0; $j< $count; $j++) {
                // 元動画サイトとアクセス数の格納処理をする。
                $quoteAndAccessResult = $this->quoteAndAccess($match[$j][0]);
                // クリック数を数字の型に変更して、
                $clickCount = 0 ;
                if(isset($quoteAndAccessResult[2])){
                    $clickCount = $price = preg_replace('/[^0-9]/', '', $quoteAndAccessResult[2]);
                }
                //一定以上クリックされてない場合は、処理を飛ばす。
                if($clickCount < config('bootstrap.clickcount')){
                    continue;
                }

                // 再生時間の格納処理をする。
                $movieTime = $this->movieTime($match[$j][0]);
                // リンク先を追って、URLを表示させる。
                $castList = $this->castListUrl($match[$j][0]);

                // 格納する。
                $hinban[$j][] = date("Y/m/d H:i:s");
                $hinban[$j][] = $quoteAndAccessResult[0];
                if(isset($quoteAndAccessResult[2])){
                    $hinban[$j][] = $quoteAndAccessResult[2];
                }
                if(isset($movieTime[1])){
                    $hinban[$j][] = $movieTime[1];
                }
                $hinban[$j][] = $castList[1];
                array_push($scrape_content, $hinban[$j]);
            } // for $j
            return $scrape_content;
        }

        function castListUrl($match){
            preg_match(
                '/<div class="itemImage">(.*?)<\/div>/s',
                $match,
                $castList
            );
            // htmlのaタグから、リンクと文字を抜き出す
            preg_match("|<a href=\"(.*?)\".*?>(.*?)|mis",$castList[0],$matches);
            return $matches;
        }


        // 元動画サイトとアクセス数の格納処理をする。
        function quoteAndAccess ($match) {
            preg_match(
                '/<div class="itemInfo">(.*?)<\/div>/s',
                $match,
                $quoteAndAccess
            );
            // htmlタグを除去する。
            $quoteAndAccessTagExclusion = strip_tags($quoteAndAccess[0], '');
            // 複数スペースを１つのスペースにする。
            $quoteAndAccessTagExclusion = preg_replace("/\s+/", " ", trim($quoteAndAccessTagExclusion));
            // 変数として格納する。
            $quoteAndAccessResult = explode(' ',$quoteAndAccessTagExclusion);
            return $quoteAndAccessResult;
        }


        // 再生時間の格納処理をする。
        function movieTime ($match) {
            preg_match(
                '/<span class="movieTime">(.*?)<\/span>/s',
                $match,
                $movieTime
            );
            return $movieTime;
        }

}
