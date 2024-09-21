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
        $filter_tanggal = $this->request->getVar('filter_tanggal');

        if ($filter_tanggal) {
            $rekap_harian = $presensi_model->rekap_harian_filter($filter_tanggal);
        } else {
            $rekap_harian = $presensi_model->rekap_harian();
        }

        $data = [
            'title' => 'Rekap Harian',
            'tanggal' => $filter_tanggal,
            'rekap_harian' => $rekap_harian
        ];

        return view('admin/rekap_presensi/rekap_harian', $data);
    }
}
