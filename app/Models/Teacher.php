<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Teacher extends Model
{
    use HasFactory, Notifiable;

     protected $fillable = [
        'nip',
        'name',
        'type_id',
        'gender',
        'user_id',
        'created_at',
        'updated_at',
    ];

     public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function presence()
    {
        return $this->belongsTo(Presence::class, 'teacher_id');
    }
}
