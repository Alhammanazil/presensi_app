<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PresensiModel;

class RekapPresensi extends BaseController
{
    public function rekap_harian()
    {
        $presensi_model = new PresensiModel();
        
        $data = [
            'title' => 'Rekap Harian',
            'rekap_harian' => $presensi_model->findAll()
        ];

        return view('admin/rekap_presensi/rekap_harian', $data);
    }
}
