<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    
    protected $fillable = [
        'title',
        'author',
        'description',
        'isbn',
        'published_year',
        'total_copies',
        'available_copies',
    ];
}
