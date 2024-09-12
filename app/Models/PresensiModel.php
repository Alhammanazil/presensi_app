<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table            = 'presensi';
    protected $allowedFields    = [
        'id_pegawai',
        'tanggal_masuk',
        'tanggal_keluar',
        'jam_masuk',
        'jam_keluar',
        'foto_masuk',
        'foto_keluar',
    ];
}
