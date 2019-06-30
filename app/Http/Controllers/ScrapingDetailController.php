<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scraping;


class ScrapingDetailController extends Controller
{
    public function index () {
        $scrape_url_list = array( //配列でURLを送ると並列処理されます
            // htmlspecialchars_decode( 'https://movie.eroterest.net/page/17192995/' ),
            htmlspecialchars_decode( 'https://movie.eroterest.net/page/17256659/' ),
        );

        // 正規表現を書く。
        $seikihyougen = '/<div class="itemFootReport"(.*?)<div class="kokArea"/s'; //20人取れないけど暫定。

        $scrape_content = $this->scraping_content($scrape_url_list, $seikihyougen);
    }


    function scraping_content($scrape_url_list, $seikihyougen){

        $TIMEOUT = 40;
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
                        echo "$info[url]: $info[http_code]: $info[total_time]\n";

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
                            dd($scrape_content);


                        }// else
                        curl_multi_remove_handle($mh, $raised['handle']);
                        curl_close($raised['handle']);
                    } while ($remains);
            } while ($running);
            dd($scrape_content);
            echo 'finished', PHP_EOL;
            curl_multi_close($mh);
            return $scrape_content;
        }

        // ここから関数
        function castList($match, $count){
            $scrape_content = array ();
            for ($j = 0; $j< $count; $j++) {
                // リンク先を追って、URLを表示させる。
                $castList = $this->castListUrl($match[$j][0]);

                // 格納する。
                $hinban[$j][] = $castList[1];
                array_push($scrape_content, $hinban[$j]);
            } // for $j
            return $scrape_content;
        }



        function castListUrl($match){
            preg_match(
                '/<div class="gotoBlog">(.*?)<\/div>/s',
                $match,
                $castList
            );

            // htmlのaタグから、リンクと文字を抜き出す
            preg_match("|<a href=\"(.*?)\".*?>(.*?)|mis",$castList[1],$matches);

            return $matches;

        }

}
