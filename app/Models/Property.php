<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'landlord_id',
        'name',
        'slug',
        'description',
        'address',
        'city',
        'type',
        'rules',
        'thumbnail',
        ];

        public function landlord()
        {
        return $this->belongsTo(User::class, 'landlord_id');
        }

        public function rooms()
        {
        return $this->hasMany(Room::class);
        }
}
