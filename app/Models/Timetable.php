<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    // ✅ Explicitly tell Laravel the table name
    protected $table = 'timetable';

    // (optional) if you don’t use timestamps in this table
    public $timestamps = false;

    protected $fillable = [
        'subject',
        'subject_number',
        'subject_code',
        'subject_students',
        'room',
        'exam_date',
        'exam_start_time',
        'exam_end_time',
        'students',
        'invigilators',
    ];
}
