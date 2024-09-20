<?php

namespace Modules\Cargo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialPrice extends Model
{
    use HasFactory;
    protected $table = 'client_special_prices';

    protected $fillable = [
        'client_id',
        'from_country_id',
        'from_state_id',
        'from_area_id',
        'to_country_id',
        'to_state_id',
        'to_area_id',
        'shipping_cost',
        'return_cost',
        'tax',
        'insurance',
        'mile_cost',
        'return_mile_cost',
        'discount_percentage',
        'discount_fixed_amount',
    ];

    // علاقة مع جدول العملاء
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // علاقات مع جدول الدول (من وإلى)
    public function fromCountry()
    {
        return $this->belongsTo(Country::class, 'from_country_id');
    }

    public function toCountry()
    {
        return $this->belongsTo(Country::class, 'to_country_id');
    }

    // علاقات مع جدول الولايات (من وإلى)
    public function fromState()
    {
        return $this->belongsTo(State::class, 'from_state_id');
    }

    public function toState()
    {
        return $this->belongsTo(State::class, 'to_state_id');
    }

    // علاقات مع جدول المناطق (من وإلى)
    public function fromArea()
    {
        return $this->belongsTo(Area::class, 'from_area_id');
    }

    public function toArea()
    {
        return $this->belongsTo(Area::class, 'to_area_id');
    }

    protected static function newFactory()
    {
        return \Modules\Cargo\Database\factories\SpecialPriceFactory::new();
    }
}