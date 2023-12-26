<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedVendor extends Model
{
    use HasFactory;

    protected $table = "featured_vendors";

    protected $fillable = [
        'position',
        'vendor_id',
    ];

    public function getUpdatedAtColumn() {
        return null;
    }

    public $timestamps = false;

    protected $primaryKey = 'vendor_id';
}
