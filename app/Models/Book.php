<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'year',
        'publisher',
        'city',
        'cover',
        'stock',
        'bookshelf_id'
    ];
    public function bookshelf(): BelongsTo{
        return $this->belongsTo(Bookshelf::class);
    }
    public function loans()
    {
        return $this->belongsToMany(Loan::class, 'loan_book', 'book_id', 'loan_id');
    }

}
