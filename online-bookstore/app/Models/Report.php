<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'school_id', 'type', 'generated_at',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
