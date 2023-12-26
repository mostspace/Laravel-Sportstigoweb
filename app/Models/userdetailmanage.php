<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userdetailmanage extends Model
{
    use HasFactory;

    protected $table='userdetailmanages';

    protected $fillable = ['user_id','name','email'];
}
