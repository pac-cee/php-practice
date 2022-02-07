<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'book_id', 'title',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
