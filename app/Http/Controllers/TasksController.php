<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;//追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     //getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        //いったんコメントアウト
        // $tasks = Task::all();
        
        // return view('tasks.index', [
        //         'tasks' => $tasks,
        // ]);
        
        //追記箇所
        $data = [];
        if(\Auth::check()){
            $user = \Auth::user();
            $tasks = $user->tasks()->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        
        return view('welcome',$data);
        //追記箇所おわり
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     //getでtasks/にアクセスされたときの「一覧表示処理」
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create',[
                'task' => $task,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //getでtasks/createにアクセスされたときの「新規登録画面表示処理」
    public function store(Request $request)
    {
        $this->validate($request,[
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
        //ひとまずコメント    
        // $task = new Task;
        // $task->status = $request->status;
        // $task->content = $request->content;
        // $task->save();
        
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);

        // return back();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //postでtasks/idアクセスされた場合の「新規登録処理」
    public function show($id)
    {
        $task = Task::find($id);
        //存在しないuser_idでアクセス
        if(empty($task->user_id)){
            return redirect('/');
        }
        
        if(\Auth::id() === $task->user_id){
            return view('tasks.show',[
                    'task' => $task,
            ]);
        }
            return redirect('/');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //getでtasks/id/editにアクセスされたときの「更新画面表示処理」
    public function edit($id)
    {
        $task = Task::find($id);
        
        if(\Auth::id() === $task->user_id){
            return view('tasks.edit',[
                    'task' => $task,
            ]);
        }
            return redirect('/');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //putでmessages/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'status' => 'required|max:10',    
            'content' => 'required|max:191',    
        ]);
        
        $task = Task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //deleteでtasks/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = \App\Task::find($id);
        // $task = Task::find($id);
        //$task->delete();
        
        //追記
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        // return back();
        return redirect('/');
        
    }
}
