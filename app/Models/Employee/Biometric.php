<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biometric extends Model
{
    use HasFactory;
    // Define fillable attributes to prevent mass-assignment vulnerabilities
    protected $fillable = [
        'employee_id',
        'hand_type',
        'finger_type',
        'img',
    ];
}
