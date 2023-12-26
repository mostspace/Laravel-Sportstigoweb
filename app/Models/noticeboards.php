<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class noticeboards extends Model
{
    use HasFactory;
	protected $fillable = [
        'title',
        'message'
    ];
}
