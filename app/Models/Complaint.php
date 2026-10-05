<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'rental_id',
        'room_id',
        'tenant_id',
        'title',
        'description',
        'photo',
        'status',
        ];

        public function rental()
        {
        return $this->belongsTo(Rental::class);
        }

        public function room()
        {
        return $this->belongsTo(Room::class);
        }

        public function tenant()
        {
        return $this->belongsTo(User::class, 'tenant_id');
        }
}
