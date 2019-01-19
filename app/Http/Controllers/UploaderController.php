<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploaderController extends Controller
{
    //
    public function getIndex(){
        $uploader = \App\Uploader::orderBy('created_at', 'desc')->paginate(5);
        return view('uploader.index')->with('uploaders',$uploader);
    }



    public function confirm(\App\Http\Requests\UploaderRequest $request){

        $username = $request->username;

        // echo uniqid("photo_");
        // //実行結果例：photo_58ddab7574ff3

        // アップロードしたファイルの拡張子の取得
        // $request->file('photo')->guessExtension()
        $thum_name = uniqid("THUM_") . "." . $request->file('thum')->guessExtension(); // TMPファイル名

        // /public/img/tmpディレクトリ に画像データを格納する。
        $request->file('thum')->move(public_path() . "/img/tmp", $thum_name);
        $thum = "/img/tmp/".$thum_name;

        //  下記で{{ $thum }}　 {{ $username }}　で表示できる。  {{ $hash }}　とかはではない。
        $hash = array(
            'thum' => $thum,
            'username' => $username,
        );

        return view('uploader.confirm')->with($hash);
    }




    public function finish(Request $request){
        $uploader = new \App\Uploader;
        $uploader->username = $request->username;
        $uploader->save();

        // レコードを挿入したときのIDを取得
        $lastInsertedId = $uploader->id;

        // ディレクトリを作成
        if (!file_exists(public_path() . "/img/" . $lastInsertedId)) {
            mkdir(public_path() . "/img/" . $lastInsertedId, 0777);
        }

        // 一時保存から本番の格納場所へ移動
        rename(
            public_path() . $request->thum,
            public_path() . "/img/" . $lastInsertedId . "/thum." .pathinfo($request->thum, PATHINFO_EXTENSION)
        );

        return view('uploader.finish');
    }


}
