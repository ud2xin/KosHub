<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'rental_id',
        'invoice_number',
        'amount',
        'status',
        'payment_channel',
        'paid_at',
        'snap_token',
        ];

        protected $casts = [
        'paid_at' => 'datetime',
        ];

        public function rental()
        {
        return $this->belongsTo(Rental::class);
        }
}
