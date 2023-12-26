<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rightsmapping extends Model
{
    use HasFactory; 

	protected $table='rightsmapping';

    protected $fillable = ['userid','modulename','muduledesc','route','checkstatus'];   
}
