<?php

namespace App\Listeners;

use App\Events\BookBorrowedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendBorrowNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookBorrowedEvent $event): void
    {
        
        $borrow = $event->borrow;
        Log::info("User {$borrow->user_id} borrowed Book {$borrow->book_id} at {$borrow->borrowed_at}");
    }
}
