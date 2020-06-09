<?php

namespace App\Notifications;

use App\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UserCreateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user,$ownerName; 

    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public function __construct($user,$ownerName)
    {
        $this->user = $user;
        $this->ownerName = $ownerName;
    } 

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        //dd(auth()->user()->name." created a user ".$this->user->name."(".$this->user->email.")");
        return [
            "message" => $this->ownerName." created a user ".$this->user->name."(".$this->user->email.")"
        ];
    }
}
