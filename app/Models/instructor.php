<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instructor extends Model
{
    use HasFactory;    
	protected $table='instructor';

    protected $fillable = ['instructor_id ','user_name','mobile','password'];
}
