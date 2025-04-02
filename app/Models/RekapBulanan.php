<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapBulanan extends Model
{
    protected $table = 'rekapbulanan';
    protected $fillable = ['bulantahun', 'total_masuk', 'total_keluar', 'saldo_akhir'];
}
