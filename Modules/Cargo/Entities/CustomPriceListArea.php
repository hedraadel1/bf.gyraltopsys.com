<?php

namespace Modules\Cargo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomPriceListArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_price_list_id',
        'from_country_id',
        'from_state_id',
        'from_area_id',
        'to_country_id',
        'to_state_id',
        'to_area_id',
        'shipping_cost',
        'return_cost',
    ];

    public function customPriceList()
    {
        return $this->belongsTo(CustomPriceList::class);
    }

    // Define relationships with Country, State, and Area models as needed

    protected static function newFactory()
    {
        return \Modules\Cargo\Database\factories\CustomPriceListAreaFactory::new();
    }
}