<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianItem extends Model
{
    use HasFactory;
     // Relasi ke Pembelian
     public function barang()
     {
         return $this->belongsTo(barang::class);
     }
    
}