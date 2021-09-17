<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use App\AddNotice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function index()
    {
        $notices = DB::select('select * from notice order by id desc');
      return view('notice.notice',['notices'=>$notices]);
    }
    public function add(){
        return view('notice.notice');
    }

    public function save(Request $request){
        $notice                 = new AddNotice();
        $notice->title    = $request->notice_title;
        $notice->description    = $request->notice_description;
        $notice->save();
        return redirect()->route('notice');
    }
    public function delete($id){
        DB::delete('delete from notice where id = ?',[$id]);
        return redirect()->route('notice');
  }
}