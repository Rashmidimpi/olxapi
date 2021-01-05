<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chatroom;
use App\Message;

class ChatController extends Controller
{
    public function createChatRoom(Request $request) {
        $user_1 = $request->user_1; 
        $user_2 = $request->user_2; 

        if($user_1 != $user_2) {

            $chatid = Chatroom::create($request->all());
    
            return response()->json([
                "message" => "Room Created",
                "chatid" => $chatid
            ], 201);
        }
        return response()->json([
            "error" => "cannot creat chat for same snder and receiver",
        ], 201);
    }

    public function addNewMessage(Request $request) {
        $messageID = Message::create($request->all());

        return response()->json([
            "message" => "Room Created",
            "messageID" => $messageID
        ], 201);
    }

    public function deleteMessage(Request $request) {

    }

    public function markRead(Request $request) {
        // will receive chat room id and user name 
        // function will called whenever user has clicked message from inbox
        // error_log();
        $updated = Message::where('receiver', $request->userID)
                            ->where('chat_id',$request->chat_id)
                            ->update(['is_read' => 1]);

        if($updated) {
            return response()->json([
                "message" => "message read",
            ], 201);
        }
        
    }
    
    public function getInboxlist(Request $request) {
        
        // error_log($request->userID);
        $roomlist = Chatroom::select('chatroom.*')
                    ->where('user_1', $request->userID)
                    ->orWhere('user_1', $request->userID)
                    ->get();
        
        $lastMessage = Message::select('message.*')
                        ->where('sender', $request->userID)
                        ->orWhere('receiver', $request->userID)
                        ->groupBy('chat_id')
                        ->orderBy('created_at','DESC')
                        ->get();

        return response()->json([
            $roomlist,
            $lastMessage
        ], 201);
    }

    public function noOfUnread(Request $request) {
        // function will receive userID in post method
        // will return number of unread messages
        $count =0 ;
        $count = Message::where('sender', $request->userID)
                    ->orWhere('receiver', $request->userID)
                    ->groupBy('chat_id')
                    ->where('is_read',0)
                    ->orderByRaw('created_at','DESC')
                    ->count();

        $messagelist = Message::where('sender', $request->userID)
                    ->orWhere('receiver', $request->userID)
                    ->groupBy('chat_id')
                    ->where('is_read',0)
                    ->orderByRaw('created_at','DESC');

        return response()->json([
            "unreadmessage" => $count,
            "messagelist" => $messagelist
        ], 201);
    }
}
