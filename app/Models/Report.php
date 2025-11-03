<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Report extends Model
{
      use HasFactory;

    protected $fillable = [
        'reporter',
        'subject',
        'subject_code',
        'room',
        'date',
        'time',
        'category',
        'details',
    ];
}
