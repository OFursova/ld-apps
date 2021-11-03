<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ListingMessageNotification extends Notification
{
    use Queueable;

    private $name;
    private $email;
    private $listingName;
    private $messageText;

    /**
     * Create a new notification instance.
     *
     * @param $name
     * @param $email
     * @param $listingName
     * @param $messageText
     */
    public function __construct($name, $email, $listingName, $messageText)
    {
        //
        $this->name = $name;
        $this->email = $email;
        $this->listingName = $listingName;
        $this->messageText = $messageText;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from($this->email)
            ->line($this->name . ' (' . $this->email . ') has sent you a message about ' . $this->listingName)
            ->line($this->messageText)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
