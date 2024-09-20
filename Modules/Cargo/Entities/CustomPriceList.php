<?php

namespace Modules\Cargo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomPriceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_type',
        'discount_value',
    ];

    public function areas()
    {
        return $this->hasMany(CustomPriceListArea::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    protected static function newFactory()
    {
        return \Modules\Cargo\Database\factories\CustomPriceListFactory::new();
    }
}