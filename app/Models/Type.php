<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'types';

    protected $fillable = [
        'name',
    ];

    public function teacher()
    {
        return $this->hasMany(Teacher::class, 'type_id');
    }
}
