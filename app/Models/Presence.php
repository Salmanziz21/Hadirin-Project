<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'teacher_id',
        'status',
        'date',
        'time',
        'created_at',
        'updated_at',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    //
}
