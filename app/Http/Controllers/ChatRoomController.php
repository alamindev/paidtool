<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use App\User;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat-room.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChatData()
    {
        $chats = ChatRoom::with('user', 'replies')->where('parent_id', null)->latest()->limit(10)->get();
        if (count($chats) > 0) {
            return response()->json(['success' => true, 'data' => $chats]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chat = new ChatRoom();
        $chat->text = $request->text;
        $chat->user_id = $request->user_id;
        $chat->reply_user_name = $request->user_name;
        $chat->reply_created_at = $request->reply_created_at;
        $chat->save();
        $chat = ChatRoom::with('user', 'replies')->where('parent_id', null)->where('id', $chat->id)->first();
        return response()->json(['success' => true, 'data' => $chat]);
    }

    public function replyStore(Request $request)
    {
        $chat = new ChatRoom();
        $chat->text = $request->text;
        $chat->user_id = $request->user_id;
        $chat->parent_id = $request->parent_id;
        $chat->save();
        $chat = ChatRoom::with('user', 'replies')->where('parent_id', '!=', null)->where('id', $chat->id)->first();
        return response()->json(['success' => true, 'data' => $chat]);
    }

    public function loadUserMessage(Request $request)
    {
        $chats = ChatRoom::with('user', 'replies')->where('parent_id', null)->where('id', '<', $request->last_id)->latest()->limit(10)->get();
        if (count($chats) > 0) {
            return response()->json(['success' => true, 'data' => $chats]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public function DeleteMessage($id)
    {
        $chat = ChatRoom::where('id', $id)->first();
        if (!empty($chat)) {
            $chat->delete();
            return response()->json(['success' => true, 'data' => $chat->id]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public function loadUser()
    {
        $user = User::latest()->limit(10)->select('name', 'id', 'created_at')->get();
        if (!empty($user)) {
            return response()->json(['success' => true, 'data' => $user]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public function loadUserById($id)
    {
        $user = User::where('name', 'like', '%' . $id . '%')->select('name', 'id', 'created_at')->get();
        if (!empty($user)) {
            return response()->json(['success' => true, 'data' => $user]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}