<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'secondName',
        'surname',
        'age',
        'gender'
    ];
}
