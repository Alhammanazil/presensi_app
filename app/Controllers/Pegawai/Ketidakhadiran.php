<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ketidakhadiranModel;

class Ketidakhadiran extends BaseController
{
    function __construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
        $ketidakhadiranModel = new ketidakhadiranModel();
        $id_pegawai = session()->get('id_pegawai');
        $data = [
            'title' => 'Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiranModel->where('id_pegawai', $id_pegawai)->findAll()
        ];
        return view('pegawai/ketidakhadiran', $data);
    }

    public function create()
    {
        $ketidakhadiranModel = new ketidakhadiranModel();
        $data = [
            'title' => 'Ajukan Ketidakhadiran',
            'validation' => \Config\Services::validation()
        ];
        return view('pegawai/create_ketidakhadiran', $data);
    }

    public function store()
    {
        $rules = [
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan harus diisi'
                ],
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi'
                ],
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi harus diisi'
                ],
            ],
            'file' => [
                'rules' => 'uploaded[file]|max_size[file,1024]|mime_in[file,image/jpg,image/jpeg,image/png, application/pdf, application/docx]',
                'errors' => [
                    'uploaded' => 'File harus diisi',
                    'max_size' => 'Maksimal ukuran file 1MB',
                    'mime_in' => 'File harus berformat pdf, docx, jpg, jpeg, png'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Ajukan Ketidakhadiran',
                'validation' => \Config\Services::validation()
            ];
            return view('pegawai/create_ketidakhadiran', $data);
        } else {
            $ketidakhadiranModel = new ketidakhadiranModel();

            $file = $this->request->getFile('file');
            if ($file->getError() == 4) {
                $nama_file = 'default.png';
            } else {
                $nama_file = $file->getRandomName();
                $file->move('file_ketidakhadiran', $nama_file);
            }

            $ketidakhadiranModel->insert([
                'id_pegawai' => $this->request->getPost('id_pegawai'),
                'keterangan' => $this->request->getPost('keterangan'),
                'tanggal' => $this->request->getPost('tanggal'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'file' => $nama_file,
                'status' => 'Menunggu'
            ]);

            session()->setFlashdata('berhasil', 'Data berhasil diajukan');
            return redirect()->to(base_url('pegawai/ketidakhadiran'));
        }
    }
}
