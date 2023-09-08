<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccessTrack extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject','log_data', 'url', 'table_name', 'ip', 'agent', 'user_id'
    ];
}
