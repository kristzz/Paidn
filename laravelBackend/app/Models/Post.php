<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'title',
        'jobDesc',
        'profession',
        'country',
        'location',
        'salaryRangeLowest',
        'salaryRangeHighest',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'user_id', 'user_id');
    }
}
