<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendordetails extends Model
{
    use HasFactory;
    
    protected $table='vendordetails';

    protected $fillable = ['vendor_id','facility1','facility2','facility3','facility4','facility5','facility6','facility7','facility8','facility9','sundaystime','sundayetime','mondaystime','mondayetime','tuesdaystime','tuesdayetime','wednesdaystime','wednesdayetime','thursdaystime','thursdayetime','fridaystime','fridayetime','saturdaystime','saturdayetime','closing_days1','closing_days2','closing_days3','closing_days4','closing_days5','closing_days6','closing_days7','closing_days8','status'];



}
