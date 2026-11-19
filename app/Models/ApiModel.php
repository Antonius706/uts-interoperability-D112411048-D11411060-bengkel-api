<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class ApiModel extends Model
{
    public $timestamps = true;

    // Semua tanggal created_at / updated_at tampil seperti 05-11-2018 08:40:30
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }
}
