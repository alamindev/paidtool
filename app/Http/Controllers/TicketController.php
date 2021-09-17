<?php

namespace App\Http\Controllers;
use App\Ticket;
use Illuminate\Http\Request;
use auth;
use App\User;
use App\TicketReply;

class TicketController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function index(){
        if(Auth::user()->isAdmin()){
            $tickets = Ticket::all()->sortByDesc('created_at');
        } else {
            $tickets = Auth::user()->tickets->sortByDesc('created_at');
        }
        $total      =   $tickets->count();
        $inProgress =   $tickets->where("status", "2")->count();
        $opened     =   $tickets->where("status", "1")->count();
        $resolved   =   $tickets->where("status", "3")->count();
        $stats      =   (object) [   "total"         => $total,
                            "inProgress"    => $inProgress,
                            "opened"        => $opened,
                            "resolved"      => $resolved,
                        ];

        return view("ticket.index",compact('tickets', 'stats'));
    }

    public function ticketDetail($id){
        $ticketReplies  = Ticket::find($id)->ticketReplies;
        $ticket         = Ticket::find($id);
        $userId         = $ticket->user_id;
        $adminName      = User::where('role_id',1)->first();
        return view('ticket.ticket-detail',compact('ticket','adminName','ticketReplies'));
    }

    public function add(){
        return view('ticket.add');
    }

    public function save(Request $request){
        $ticket                 = new Ticket();
        $ticket->user_id        = Auth::user()->id;
        $ticket->title          = $request->ticket_title;
        $ticket->description    = $request->ticket_description;
        $ticket_id              = mt_rand(100000,999999);
        $ticket->ticket_id      = $ticket_id;
        $ticket->save();
        return redirect()->route('tickets');
        

    }

    public function ticketReply(Request $request,$id){
        $ticketReply            = new TicketReply();
        $ticketReply->message   = $request->ticketMessages;
        $ticketReply->ticket_id = $id;
        $ticket                 = Ticket::find($id);
        if(Auth::user()->isAdmin()){
            $ticketReply->type  = 1;
            if ($ticket->status == 1) {
                $ticket->status = 2;
                $ticket->save();
            }
        } else {
            $ticketReply->type  = 2;
        }
        $ticketReply->save();

        return back();
    }

    public function resolveTicket($id)
    {
        $ticket = Ticket::find($id);
        $ticket->status = 3;
        $ticket->save();
        return back();
    }
}