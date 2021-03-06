<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class StudentController extends Controller
{
    //
    public function getIndex(Request $request){
        $keyword = $request->input('keyword');

        $query = Student::query();
        if(isset($keyword)){
            $query
                ->where('email','like','%'.$keyword.'%')
                ->orWhere('name','like','%'.$keyword.'%');
        }

        // 全件取得 +ページネーション
        $students = $query->orderBy('id','desc')->paginate(10);
        return view('student.list')->with('students',$students)->with('keyword',$keyword);
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
        return redirect()->to('student/list')->with('flashmessage', '登録が完了いたしました。');
    }



    public function edit_index($id){
        $student = Student::findOrFail($id);
        return view('student.editIndex')->with('student', $student);
    }

    public function edit_confirm(\App\Http\Requests\CheckStudentRequest $request){
        $data = $request->all();
        return view('student.editConfirm')->with($data);
    }

    public function edit_finish(Request $request, $id){
        // Studentオブジェクト生成
        $student = Student::findorFail($id);

        // 値の登録
        $student->name = $request->name;
        $student->email = $request->email;
        $student->tel = $request->tel;
        $student->save();

        //リダイレクト
        return redirect()->to('student/list')->with('flashmessage', '更新が完了いたしました。');
    }



    public function delete($id){
        $student = Student::find($id);
        $student->delete();
        return redirect()->to('student/list')->with('flashmessage', '削除が完了いたしました。');
    }


}
