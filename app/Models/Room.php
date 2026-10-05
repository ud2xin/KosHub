<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'property_id',
        'room_number',
        'type',
        'price',
        'status',
        'facilities',
        ];

        public function property()
        {
        return $this->belongsTo(Property::class);
        }

        public function rentals()
        {
        return $this->hasMany(Rental::class);
        }

        public function complaints()
        {
        return $this->hasMany(Complaint::class);
        }
}
