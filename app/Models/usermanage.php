<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usermanage extends Model
{
    use HasFactory;

    protected $table='usermanages';

    protected $fillable = ['name','email','password','original_password'];

}
