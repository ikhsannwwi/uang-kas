<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class kas extends Model
{
    use HasFactory;

    protected $table = 'kas';

    protected $fillable = [
        'user_kode',
        'pemasukan_pengeluaran',
        'tanggal',
        'keterangan',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_kode', 'kode');
    }
}
