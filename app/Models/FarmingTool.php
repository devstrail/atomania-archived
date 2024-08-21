<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmingTool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'farmType',
        'farmActivity',
        'description',
        'cost',
        'costType',
        'vendor_id'
    ];

    public static function validations() : array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'farmType' => 'required|string|max:255',
            'farmActivity' => 'required|string|max:255',
            'description' => 'string|max:1000',
            'cost' => 'required|numeric',
            'costType' => 'required|string|max:255',
            'vendor_id' => 'required|numeric'
        ];
    }

    public function vendorUser()
    {
        return $this->belongsTo(VendorUser::class);
    }
}
