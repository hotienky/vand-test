<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityHistory extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    public $timestamps = false;
    protected $table = 'activity_histories';

    protected $fillable = [
        'request_id',
        'name',
        'payload',
        'user_id',
        'created_at'
    ];
    protected $casts = [
        'payload' => 'object',
    ];
}
