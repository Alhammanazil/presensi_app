<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KetidakhadiranModel;

class Ketidakhadiran extends BaseController
{
    public function index()
    {
        $ketidakhadiranModel = new ketidakhadiranModel();
        $data = [
            'title' => 'Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiranModel->findAll()
        ];
        return view('admin/ketidakhadiran', $data);
    }

    public function approved($id)
    {
        $ketidakhadiranModel = new ketidakhadiranModel();

        $ketidakhadiranModel->update($id, [
            'status' => 'Approved',
        ]);

        session()->setFlashdata('berhasil', 'Status pengajuan diupdate');

        return redirect()->to(base_url('admin/ketidakhadiran'));
    }
}
