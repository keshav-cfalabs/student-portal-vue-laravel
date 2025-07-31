<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    protected $guarded = [];

    
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function class()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }

}
