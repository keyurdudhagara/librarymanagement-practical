<?php

namespace App\Events;

use App\Models\Borrow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookBorrowedEvent
{
    use Dispatchable, SerializesModels;

    public $borrow;

    public function __construct(Borrow $borrow)
    {
         $this->borrow = $borrow;
    }
}
