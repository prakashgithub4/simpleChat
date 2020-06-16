<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Message;
use Pusher\Pusher;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   


   public static function userRead($user_id){
    
    $users = DB::select("select users.id, users.name, users.email,users.is_online, count(is_read) as unread 
        from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " .$user_id . "
        where users.id != " . $user_id . " 
        group by users.id, users.name, users.avatar, users.email,users.is_online");
   
    return $users;

   }

   public static function status($id,$status){
     
     $user = User::find($id);
     $user->is_online = $status;
     $user->save();

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

        $data = array('status'=>$user->is_online,'id'=>Auth::id()); // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);

   }
}
