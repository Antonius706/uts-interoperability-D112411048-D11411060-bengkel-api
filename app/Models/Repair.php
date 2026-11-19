<?php

namespace App\Models;

class Repair extends ApiModel
{
    protected $table = 'repairs';

    protected $fillable = [
        'customer_id', 'plate_number', 'vehicle_brand', 'vehicle_model',
        'vehicle_year', 'service_type', 'complaint', 'mechanic_name',
        'cost', 'status', 'repair_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
