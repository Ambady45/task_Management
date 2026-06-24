<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'owner_id',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('responsibility')->withTimestamps();
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
