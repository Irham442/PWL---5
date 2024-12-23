<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{

    protected $fillable = [
        'user_id',
        'loan_at',
        'return_at',
    ];

    public function details()
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function books()
    {
        return $this->belongsToMany(Book::class, 'loan_book', 'loan_id', 'book_id');
    }
}
