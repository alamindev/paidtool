<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use DB;
use App\Package;
use App\TaskReply;
use App\AssignedTask;
use App\Imports\TasksImport;
use App\Imports\TaskUrlImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index($id = "")
    {
        $tasks = [];
        if (Auth::user()->isAdmin()) {
            if (!$id) {
                $tasksNotSent  = Task::whereHas("package")->where("is_sent", 0)->Latest()->Paginate(15);
                $tasksSent     = Task::whereHas("package")->where("is_sent", 1)->Latest()->Paginate(15);

                $tasksReplied  = Task::whereHas("package")
                    ->whereHas("taskReplies")
                    ->whereHas('assignedTasksReplied')->Latest()->Paginate(15);

                $tasksAccepted = Task::whereHas("package")
                    ->whereHas("assignedTasksAccepted")->Paginate(15);
                    $tasks = Task::latest()->paginate(15);
            } else {
                $tasksNotSent  = Task::whereHas("package")->where("package_id", $id)->where("is_sent", 0)->Latest()->Paginate(15);
                $tasksSent     = Task::whereHas("package")->where("package_id", $id)->where("is_sent", 1)->Latest()->Paginate(15);
                $tasksReplied  = Task::whereHas("package")->where("package_id", $id)->whereHas("taskReplies")->whereHas("assignedTasks", function ($query) {
                    $query->where("is_accepted", "!=", 1);
                })->Latest()->get();
                $tasksAccepted = Task::whereHas("package")->where("package_id", $id)->whereHas("assignedTasks", function ($query) {
                    $query->where("is_accepted", 0);
                })->Latest()->Paginate(15);
                 $tasks = Task::latest()->paginate(15);
            }
        } else {
            if (!$id) {
                $tasksNotSent  = Auth::user()->assignedTask()->where("is_sent", 0)->Latest()->Paginate(15);
                $tasksSent     = Auth::user()->assignedTask()->where("is_sent", 1)->Latest()->Paginate(15);
                $tasksReplied  = Auth::user()->assignedTask()->whereHas("taskReplies")->Latest()->get();
                $tasksAccepted = Auth::user()->assignedTask()->whereHas("assignedTasks", function ($query) {
                    $query->where("is_accepted", 1);
                })->Latest()->Paginate(15);
            } else {
                $tasksNotSent  = Auth::user()->assignedTask()->where("tasks.package_id", $id)->where("is_sent", 0)->Latest()->Paginate(15);
                $tasksSent     = Auth::user()->assignedTask()->where("tasks.package_id", $id)->where("is_sent", 1)->Latest()->Paginate(15);
                $tasksReplied  = Auth::user()->assignedTask()->where("tasks.package_id", $id)->whereHas("taskReplies")->Latest()->Paginate(15);
                $tasksAccepted = "";
            }
        }

        return view("task.index", compact("tasksNotSent", "tasksSent", "tasksReplied", "tasksAccepted", 'tasks'));
    }

    public function add()
    {
        $packages = Package::all();
        return view("task.add", compact("packages"));
    }

    
    public function addUrlTask()
    {
        $packages = Package::all();
        return view("urltask.add", compact("packages"));
    }

    public function saveUrlTask(Request $request)
    { 
        $request->validate([ 
            'url' => 'required',  
            'time' => 'required',  
            'package_id' => 'required', 
        ]);
       Task::create([
            'url'       => $request->url, 
            'time'       => $request->time, 
            'package_id'  => $request->package_id,
            'type'  => 1
        ]);

        return redirect()->route('tasks');
    }


    public function uploadUrlSheet(Request $request)
    { 
        Excel::import(new TaskUrlImport, $request->file("tasks_sheet"));
        return redirect("/tasks");
    }


    public function edit($id)
    {
        $task     = Task::find($id);
        $packages = Package::all();
        return view('task.edit', compact('task', 'packages'));
    }

    public function editUrl($id)
    {
        $task     = Task::find($id);
        $packages = Package::all();
        return view('urltask.edit', compact('task', 'packages'));
    }

    public function update(Request $request, $id)
    {
        // return $request;
        $task = Task::find($id);
        $task->title =  $request->get('task_name');
        $task->description = $request->get('task_description');
        $task->package_id = $request->get('package_id');
        $task->save();
        return redirect('/tasks')->with('success', 'Package updated!');
    }

    public function updateUrl(Request $request, $id)
    {
        // return $request;
        $task = Task::find($id);
        $task->url =  $request->get('url'); 
        $task->package_id = $request->get('package_id');
        $task->save();
        return redirect('/tasks')->with('success', 'Package updated!');
    }

    public function saveReply(Request $request, $id)
    {
        $filepath = "";

        if ($request->hasFile("attachment")) {
            $filepath = str_replace("public", "storage", $request->file('attachment')->store('public/attachments'));
        }

        $task                       = Auth::user()->assignedTask()->where('task_id', $id)->first();

        $taskReply                  = new TaskReply();
        $taskReply->task_id         = $id;
        $taskReply->user_id         = Auth::user()->id;
        $taskReply->task_reply      = $request->task_reply;
        $taskReply->task_attachment = $filepath;
        $taskReply->save();

        $task->pivot->is_replied = 1;
        $task->pivot->save();

        return redirect('/tasks')->with('success', 'Reply has been sent!');
    }

    public function addReply($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return back();
        }
        return view('task.taskReply', compact('task'));
    }
    public function visitUrl($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return back();
        }
        return view('urltask.visiturl', compact('task'));
    }

    public function showReply($id)
    {
        $taskTitle   = Task::select('title')->where('id', $id)->first();
        if (Auth::user()->isAdmin()) {
            $taskReplies = TaskReply::where('task_id', $id)->get();
        } else {
            $taskReplies = TaskReply::where('task_id', $id)->where("user_id", Auth::user()->id)->where('status', '0')->get();
        }
        return view('task.showReply', compact('taskReplies', 'taskTitle'));
    }

    public function UpdateTask($taskID)
    {
        $assignedTask = AssignedTask::where("task_id", $taskID)->first();

            if ($assignedTask) {
                $assignedTask->is_accepted = 1;
                $assignedTask->is_replied = 1;
                $assignedTask->save();

                $user = $assignedTask->user;
                if ($user) {
                    $user->balance = $user->balance + $assignedTask->package->payment_task;
                    $user->save();
                    $task = Task::where('id', $taskID)->first();
                    $pp = Package::where('id', $task->package_id)->first();
                    $user = User::where('id', $user->id)->first();
                    if ($user->ref != '0') {
                        $refuser = User::where('id', $user->ref)->first();
                        $com = ($assignedTask->package->payment_task * $pp->tcom) / 100;
                        $refuser->balance = $refuser->balance + $com;
                        $refuser->refcommission = $refuser->refcommission + $com;
                        $refuser->save();
                    }
                } 
                
                $taskReply                  = new TaskReply();
                $taskReply->task_id         = $taskID;
                $taskReply->user_id         = $user->id;
                $taskReply->task_reply      = 'null'; 
                $taskReply->save();

                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
    }
    public function acceptSelected()
    {
        foreach (request()->ids as $key => $taskID) {
            $assignedTask = AssignedTask::where("task_id", $taskID)->first();

            if ($assignedTask) {
                $assignedTask->is_accepted = 1;
                $assignedTask->save();

                $user = $assignedTask->user;
                if ($user) {
                    $user->balance = $user->balance + $assignedTask->package->payment_task;
                    $user->save();
                    $task = Task::where('id', $taskID)->first();
                    $pp = Package::where('id', $task->package_id)->first();
                    $user = User::where('id', $user->id)->first();
                    if ($user->ref != '0') {
                        $refuser = User::where('id', $user->ref)->first();
                        $com = ($assignedTask->package->payment_task * $pp->tcom) / 100;
                        $refuser->balance = $refuser->balance + $com;
                        $refuser->refcommission = $refuser->refcommission + $com;
                        $refuser->save();
                    }
                }
            }
        }
    }

    public function rejectSelected()
    {
        foreach (request()->ids as $key => $taskID) {
            $assignedTask = AssignedTask::where("task_id", $taskID)->first();

            if ($assignedTask) {
                $assignedTask->is_accepted = 0;
                $assignedTask->is_replied  = 1;
                $assignedTask->save();
            }
        }
    }

    public function accept($taskID, $userID, $packageID, $id)
    {
        $assignedTask = AssignedTask::where("task_id", $taskID)->where("user_id", $userID)->where("package_id", $packageID)->first();

        if ($assignedTask) {
            $assignedTask->is_accepted = 1;
            $assignedTask->save();
            DB::table('task_replies')
                ->where('id', $id)
                ->update(['status' => 1]);

            $user = $assignedTask->user;
            if ($user) {
                $user->balance = $user->balance + $assignedTask->package->payment_task;
                $user->save();
                $task = Task::where('id', $taskID)->first();
                $pp = Package::where('id', $task->package_id)->first();
                $user = User::where('id', $user->id)->first();
                if ($user->ref != '0') {
                    $refuser = User::where('id', $user->ref)->first();
                    $com = ($assignedTask->package->payment_task * $pp->tcom) / 100;
                    $refuser->balance = $refuser->balance + $com;
                    $refuser->refcommission = $refuser->refcommission + $com;
                    $refuser->save();
                }
            }
        }



        return redirect("tasks");
    }

    public function reject($taskID, $userID, $packageID)
    {
        $assignedTask = AssignedTask::where("task_id", $taskID)->where("user_id", $userID)->where("package_id", $packageID)->first();

        if ($assignedTask) {
            $assignedTask->is_accepted = 0;
            $assignedTask->is_replied  = 1;
            $assignedTask->save();
        }

        return redirect("tasks");
    }

    public function save(Request $request)
    {
        $request->validate([ 
            'title' => 'required', 
            'description' => 'required', 
            'package_id' => 'required', 
        ]);

        Task::create([
            'title'       => $request->task_name,
            'description' => $request->task_description,
            'package_id'  => $request->package_id
        ]);

        return redirect()->route('tasks');
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect('/tasks')->with('success', 'Package deleted!');
    }
    public function deletetask($id)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect('/tasks')->with('success', 'Package deleted!');
    }

    public function uploadSheet(Request $request)
    {
        Excel::import(new TasksImport, $request->file("tasks_sheet"));
        return redirect("/tasks");
    }
}