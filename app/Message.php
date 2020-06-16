<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Pusher\Pusher;

class Message extends Model
{
    //
    protected $fillable = ['message'];
    public $timestamp;

public static function getmessages($user_id,$my_id){

	  Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

	        // Get all message from selected user
	        $messages = Message::where(function ($query) use ($user_id, $my_id) {
	            $query->where('from', $user_id)->where('to', $my_id);
	        })->oRwhere(function ($query) use ($user_id, $my_id) {
	            $query->where('from', $my_id)->where('to', $user_id);
	        })->get();

	        return $messages;

	}

	public static function sendMessages($response){
       
		$data = new Message;
        $data->from = $response['from'];
        $data->to = $response['to'];
        $data->message =$response['message'];
        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $response['from'], 'to' => $response['to']]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
	}
}



