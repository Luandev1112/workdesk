<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatThread;
use App\Models\Project;
use App\Models\Chat;
use App\User;
use App\Models\Role;
use Session;
use Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show user chats'])->only('admin_chat_index');
    }

    public function index(Request $request)
    {
        $bidder = User::where('user_name', $request->user_name)->first();
        $existing_chat_thread = ChatThread::where('sender_user_id', Auth::user()->id)->where('receiver_user_id', $bidder->id)->first();
        if ($existing_chat_thread == null) {
            $existing_chat_thread = new ChatThread;
            $existing_chat_thread->thread_code = $bidder->id.date('Ymd').Auth::user()->id;
            $existing_chat_thread->sender_user_id = Auth::user()->id;
            $existing_chat_thread->receiver_user_id = $bidder->id;
            $existing_chat_thread->save();
        }

        return redirect()->route('all.messages');
    }

    public function chat_index()
    {
        $chat_threads = ChatThread::where('sender_user_id', Auth::user()->id)->orWhere('receiver_user_id', Auth::user()->id)->get();
        return view('frontend.default.user.messages', compact('chat_threads'));
    }

    public function admin_chat_index(Request $request)
    {        
        $sort_search = null;
        $chat_threads = ChatThread::orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $user_ids = User::where(function($user) use ($sort_search){
                $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
            })->pluck('id')->toArray();
            $chat_threads = $chat_threads->where(function($chat_thread) use ($user_ids){
                $chat_thread->whereIn('sender_user_id', $user_ids)->orWhereIn('receiver_user_id', $user_ids);
            });
            $chat_threads = $chat_threads->paginate(10);
        }
        else {
            $chat_threads = $chat_threads->paginate(12);
        }


        return view('admin.default.chats.index', compact('chat_threads', 'sort_search'));        
    }

    public function admin_chat_details($id)
    {        
        $chat_thread = ChatThread::findOrFail(decrypt($id));
        $chats = $chat_thread->chats;
        return view('admin.default.chats.show', compact('chats','chat_thread'));
        
    }

    public function chat_view($id)
    {
        $chat_thread = ChatThread::findOrFail($id);
        foreach ($chat_thread->chats as $key => $chat) {
            if($chat->sender_user_id != Auth::user()->id){
                $chat->seen = 1;
                $chat->save();
            }
        }
        $chats = $chat_thread->chats()->latest()->limit(20)->get();

        return view('frontend.default.partials.chat-messages', compact('chats', 'chat_thread'));
    }

    public function get_old_messages(Request $request)
    {
        $chat = Chat::findOrFail($request->first_message_id);
        $chats = Chat::where('id', '<', $chat->id)->where('chat_thread_id', $chat->chat_thread_id)->latest()->limit(20)->get();
        if(count($chats) > 0){
            return array('messages' => view('frontend.default.partials.chat-messages-part', compact('chats'))->render(),
                         'first_message_id' => $chats->last()->id);
        }
        else {
            return array('messages' => "",
                         'first_message_id' => 0);
        }
    }

    public function chat_refresh($id)
    {
        $chat_thread = ChatThread::findOrFail($id);
        $chats = $chat_thread->chats()->where('sender_user_id', '!=', Auth::user()->id)->where('seen' , 0)->get();
        foreach ($chats as $key => $value) {
            $value->seen = 1;
            $value->save();
        }

        return array('messages' => view('frontend.default.partials.chat-messages-left-single', compact('chats'))->render(),
                     'count' => count($chats));
    }


    public function chat_reply(Request $request)
    {
        $chat = new Chat;
        $chat->chat_thread_id = $request->chat_thread_id;
        $chat->sender_user_id = Auth::user()->id;
        $chat->message = $request->message;
        if($request->attachment != null){
            $chat->attachment = json_encode(explode(',', $request->attachment));
        }
        $chat->save();
        return view('frontend.default.partials.chat-messages-right-single', compact('chat'));
    }

    public function interview_status(Request $request)
    {
        $chat_thread = ChatThread::findOrFail($request->chat_thread_id);
        if ($chat_thread->interview == 1) {
            $chat_thread->interview = 0;
        }
        else {
            $chat_thread->interview = 1;
        }
        if ($chat_thread->save()) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function block_status(Request $request)
    {
        $chat_thread = ChatThread::findOrFail($request->chat_thread_id);
        if ($chat_thread->active == 1) {
            $chat_thread->active = 0;
        }
        else {
            $chat_thread->active = 1;
        }
        if ($chat_thread->save()) {
            return 1;
        }
        else {
            return 0;
        }
    }
}
