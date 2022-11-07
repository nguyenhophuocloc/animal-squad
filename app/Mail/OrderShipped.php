<?php
 
namespace App\Mail;
 

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
 
class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;
 
    /**
     * The order instance.
     *
     * @var \App\Models\Order
     */
    public $order;
 
    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct()
    {
   
    }
 
    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.success',
        );
    }
}