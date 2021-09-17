<?php

namespace App\Http\Controllers;

use App\Task;
use DB;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Package;
use App\Packsub;
use Carbon\Carbon;
use App\AssignedTask;
use App\Mail\SendTask;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $packages = Package::all();
        } else {
            $packages = DB::table('packages')
                ->select(
                    '*'
                )
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('package_user')
                        ->whereRaw('packages.id = package_user.package_id')
                        ->where('package_user.user_id', '=', Auth::user()->id)
                        ->where('package_user.package_id', '=', 4);
                })
                ->get();
        }


        $tasks = DB::table('tasks')->where('is_sent', 0)->get();

        $withdrawls     = Auth::user()->withdrawls()->latest()->get();
        $total          = number_format(Auth::user()->withdrawls()->sum("amount"), 2);
        $available      = number_format(Auth::user()->balance, 2);
        $totalRequested = number_format(Auth::user()->withdrawls()->where("flag", 1)->sum("amount"), 2);
        $accepted       = number_format(Auth::user()->withdrawls()->where("flag", 2)->sum("amount"), 2);
        $rejected       = number_format(Auth::user()->withdrawls()->where("flag", 3)->sum("amount"), 2);


        return view("package.index", compact("packages", "total", "available", "accepted", "rejected", "totalRequested", "tasks"));
    }

    public function add()
    {
        return view("package.add");
    }
 public function refs()
    {
        return view("aff");
    }
    public function edit($id)
    {
        $package = Package::find($id);
        return view('package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::find($id);
        $package->package_name =  $request->get('package_name');
        $package->package_price = $request->get('package_price');
        $package->work_type = $request->get('work_type');
        $package->contract_period = $request->get('contract_period');
        $package->payment_task = $request->get('payment_task');
        $package->total_task = $request->get('total_task');
        $package->com = $request->get('com');
        $package->tcom = $request->get('tcom');
        $package->save();
        return redirect('/packages')->with('success', 'Package updated!');
    }

    public function save(Request $request)
    {
        $package = new package();
        $package->package_name = $request->package_name;
        $package->package_price = $request->package_price;
        $package->work_type = $request->work_type;
        $package->contract_period = $request->contract_period;
        $package->payment_task = $request->payment_task;
        $package->total_task = $request->total_task;
        $package->com = $request->com;
        $package->tcom = $request->get('tcom');
        $package->save();
        return redirect()->route('packages');
    }

    public function destroy($id)
    {
        $package = Package::find($id);

        foreach ($package->tasks as $key => $task) {
            $task->assignedTasks()->delete();
            $task->taskReplies()->delete();
        }

        $package->tasks()->delete();
        $package->delete();
        return redirect('/packages')->with('success', 'Package deleted!');
    }

    public function subscribe(Request $request)
    {
        $package = Packsub::where('user_id', $request->user_id)->where('is_activated', 1)->first();
        if (empty($package)) {
            $package = new Packsub();
            $package->package_id = $request->package_id;
            $package->user_id = $request->user_id;
            $package->address = $request->address;
            $package->is_activated = "1";
            $package->invoice_id = "Free";
            $package->payment_status = "0";
            $package->save();
        }
        return redirect()->route('packages');
    }

    public function unSubscribe($package_id)
    {
        if (Auth::user()->packages()->where("package_id", $package_id)->exists()) {
            Auth::user()->packages()->detach($package_id);
        }
        return back();
    }

    public function myPackages()
    {
        $packages = Auth::user()->packages;
        return view("package.myPackages", compact("packages"));
    }

   public function sendTask($id)
    {
        $package     = Package::find($id);
        $tasks       = $package->tasks()->where('is_sent', 0)->get();

        if (!count($tasks)) {
            return back()->with("error", "No active tasks found!");
        }
        if (count($tasks) < $package->total_task) {
            return back()->with("error", "Please add atleast " . $package->total_task . " before sending.");
        }
        $task_ids    = collect($tasks)->pluck('id');
        $subscribers = $package->users()->wherePivot("is_activated", 1)->get();

        if (!count($subscribers)) {
            return back()->with("error", "No freelancer registered in this package!");
        }

        if (count($subscribers) <= count($tasks) * $package->total_task) {
            $subscriber_ids = [];
            for ($i = 0; $i < count($subscribers) * $package->total_task; $i++) {
                $subscriber_ids[$i] = $i;
            }
            $task_id =  $tasks->shuffle()->pluck('id')->toArray();
            $diff =  $this->array_diff_key_recursive($task_id, $subscriber_ids);
            $task_ids = '';
            if (count($diff) > 0) {
                $task_ids  = array_values($diff);
            }
            $collection = collect($tasks);
            $filter_task = $collection->whereNotIn('id', $task_ids);
            $collection = collect($filter_task);
            $arrays = $collection->split(count($subscribers))->toArray();
            foreach ($filter_task as $t) {
                $package->tasks()->where('id', $t->id)->where('is_sent', 0)->update(["is_sent" => 1]);
            }

            for ($i = 0; $i < count($subscribers); $i++) {
                $subscriber_id = $subscribers[$i]['id'];
                for ($j = 0; $j < count($arrays[$i]); $j++) {
                    if (isset($arrays[$i][$j])) {
                        $assign = new AssignedTask();
                        $assign->user_id = $subscriber_id;
                        $assign->package_id = $arrays[$i][$j]['package_id'];
                        $assign->task_id = $arrays[$i][$j]['id'];
                        $assign->save();
                    }
                }
            }
        } else {
            return back()->with("error", "Enough task not found for this package! please add task");
        }

        return back()->with("success", "All the tasks has been sent to freelancers, successfully!");
    }

    public function array_diff_key_recursive(array $arr1, array $arr2)
    {
        $diff = array_diff_key($arr1, $arr2);
        $intersect = array_intersect_key($arr1, $arr2);

        foreach ($intersect as $k => $v) {
            if (is_array($arr1[$k]) && is_array($arr2[$k])) {
                $d = $this->array_diff_key_recursive($arr1[$k], $arr2[$k]);

                if ($d) {
                    $diff[$k] = $d;
                }
            }
        }

        return $diff;
    }
}