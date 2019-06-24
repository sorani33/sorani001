<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function form()
    {
        return view('form');
    }
    public function confirm(Request $request)
    {
        $contact = new Contact($request->all());
        return view('confirm', compact('contact'));
    }


    public function process(Request $request)
    {
// エラー内容
// Expected response code 250 but got code "530",
// with message "530 5.7.1 Authentication required
// envの、MAIL_DRIVER～MAIL_ENCRYPTIONの修正をしないとだめ。
// 参考：https://qiita.com/yutaroshimamura/items/8a89fc57bd3c73a24c32
// dd(\Config::get('mail'));

        // 送信メール
        \Mail::send(new \App\Mail\Contact([
            'to' => $request->email,
            'to_name' => $request->name,
            'message' => $request->message,
            'from' => 'from@example.com',
            'from_name' => 'MySite',
            'subject' => 'お問い合わせありがとうございました。',
            'content' => '本文欄',
        ]));

        // 受信メール
        // \Mail::send(new \App\Mail\Contact([
        //     'to' => 'from@example.com',
        //     'to_name' => 'MySite',
        //     'from' => $request->email,
        //     'from_name' => $request->name,
        //     'subject' => 'サイトからのお問い合わせ',
        //     'content' => '本文欄',
        // ], 'from'));

        return view('complete');
    }
}
