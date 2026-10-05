<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'tenant_id',
        'room_id',
        'start_date',
        'end_date',
        'total_amount',
        'status',
        ];

        protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        ];

        public function tenant()
        {
        return $this->belongsTo(User::class, 'tenant_id');
        }

        public function room()
        {
        return $this->belongsTo(Room::class);
        }

        public function payments()
        {
        return $this->hasMany(Payment::class);
        }

        public function complaints()
        {
        return $this->hasMany(Complaint::class);
        }
}
