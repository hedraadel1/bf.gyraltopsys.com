<?php

namespace Modules\Cargo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];
    protected $table = 'states';

    protected static function newFactory()
    {
        return \Modules\Cargo\Database\factories\StateFactory::new();
    }
    
        public function areas()
    {
        return $this->hasMany(Area::class); 
    }
}
