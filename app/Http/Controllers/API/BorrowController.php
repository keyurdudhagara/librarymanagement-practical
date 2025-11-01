<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;
use App\Events\BookBorrowedEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    //  Borrow a book
    public function borrow($bookId)
    {
        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        if ($book->available_copies < 1) {
            return response()->json(['message' => 'Book not available'], 400);
        }

        
        $existing = Borrow::where('user_id', $user->id)
                          ->where('book_id', $bookId)
                          ->whereNull('returned_at')
                          ->first();

        if ($existing) {
            return response()->json(['message' => 'You already borrowed this book'], 400);
        }

      
        $borrow = Borrow::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

      
        $book->decrement('available_copies');

        // fire event
        event(new BookBorrowedEvent($borrow));

        return response()->json(['message' => 'Book borrowed successfully', 'borrow' => $borrow]);
    }

    //  Return a book
    public function returnBook($bookId)
    {
        $user = Auth::user();

        $borrow = Borrow::where('user_id', $user->id)
                        ->where('book_id', $bookId)
                        ->whereNull('returned_at')
                        ->first();

        if (!$borrow) {
            return response()->json(['message' => 'No active borrowing record found'], 404);
        }

        $borrow->update(['returned_at' => now()]);

        
        $book = Book::find($bookId);
        $book->increment('available_copies');

        return response()->json(['message' => 'Book returned successfully']);
    }
}
