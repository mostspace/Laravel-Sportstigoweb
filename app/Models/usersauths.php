<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersauths extends Model
{
    use HasFactory;  

	protected $fillable = [
        'mobile',
        'opt'
    ];	
}
