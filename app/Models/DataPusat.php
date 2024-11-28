<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPusat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'merek',
        'foto',
        'stok',
    ];

    public $timestamps = true;

    public function barangmasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }
    public function barangkeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class);
    }
}
