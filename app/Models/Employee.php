<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'phone_number', 'address'];

    // Define the relationship between Employee and User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
