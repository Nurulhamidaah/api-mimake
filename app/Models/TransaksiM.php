<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiM extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'id_barang',
        'tanggal_jual',
        'pembeli',
        'nama_barang',
        'qty',
    ];
}
