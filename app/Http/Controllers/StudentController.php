<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function getIndex(){
        $query = \App\Student::query();
        // 全件取得 +ページネーション
        $students = $query->orderBy('id','desc')->paginate(10);
        return view('student.list')->with('students',$students);
    }

    public function new_index(){
        return view('student.newIndex');
    }


    public function new_confirm(\App\Http\Requests\CheckStudentRequest $request){
        $data = $request->all();
        return view('student.confirm')->with($data);
    }


    public function new_finish(Request $request){
        // Studentオブジェクト生成
        $student = new \App\Student;

        // 値の登録
        $student->name = $request->name;
        $student->email = $request->email;
        $student->tel = $request->tel;
        $student->save();

        //リダイレクト
        return redirect()->to('student/list');
    }
}
