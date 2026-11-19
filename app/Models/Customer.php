<?php

namespace App\Models;

class Customer extends ApiModel
{
    protected $table = 'customers';

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'city', 'postal_code',
        'gender', 'birth_date', 'occupation', 'membership', 'notes',
    ];

    // 1 pelanggan punya banyak riwayat servis
    public function repairs()
    {
        return $this->hasMany(Repair::class, 'customer_id');
    }
}
