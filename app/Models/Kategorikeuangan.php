<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategorikeuangan extends Model
{
    protected $table = 'kategori_keuangan';
    protected $fillable = ['name', 'jenis'];

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'kategori_id');
    }
}
