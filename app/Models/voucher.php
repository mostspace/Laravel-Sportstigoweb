<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
    use HasFactory;
	protected $fillable = [
        'voucher_code',
        'voucher_date',
        'voucher_from_date',
        'voucher_to_date',
        'voucher_is_expired_date',
        'voucher_total_usage',
        'voucher_discount',
        'voucher_applicable'
    ];
}
