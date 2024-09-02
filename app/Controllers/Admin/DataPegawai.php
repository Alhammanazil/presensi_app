<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PegawaiModel;
use App\Models\UserModel;
use App\Models\LokasiPresensiModel;
use App\Models\JabatanModel;

class DataPegawai extends BaseController
{
    public function index()
    {
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Data Pegawai',
            'pegawai' => $pegawaiModel->findAll()
        ];

        return view('admin/data_pegawai/data_pegawai', $data);
    }

    public function detail($id)
    {
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Detail Pegawai',
            'pegawai' => $pegawaiModel->detailPegawai($id)
        ];
        return view('admin/data_pegawai/detail', $data);
    }

    public function create()
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan_model = new JabatanModel();
        $data = [
            'title' => 'Tambah Pegawai',
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan_model->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/data_pegawai/create', $data);
    }

    public function generateNip()
    {
        $pegawaiModel = new PegawaiModel();
        $pegawaiTerakhir = $pegawaiModel->select('nip')->orderBy('id', 'DESC')->first();
        $nipTerakhir = $pegawaiTerakhir ? $pegawaiTerakhir['nip'] : 'PEG-0000';
        $angkaNIP = (int) substr($nipTerakhir, 4);
        $angkaNIP++;
        return 'PEG-' . str_pad($angkaNIP, 4, '0', STR_PAD_LEFT);
    }

    public function store()
    {
        $rules = [
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ],
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin harus diisi'
                ],
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi'
                ],
            ],
            'no_handphone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. Handphone harus diisi'
                ],
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan harus diisi'
                ],
            ],
            'lokasi_presensi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lokasi Presensi harus diisi'
                ],
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|is_image[foto]|max_size[foto,1024]',
                'errors' => [
                    'uploaded' => 'Tidak ada file yang diupload',
                    'max_size' => 'Ukuran foto melebihi 1 MB',
                    'is_image' => 'Jenis file harus berupa gambar'
                ],
            ],
            'username' => [
                'rules' => 'required|alpha_dash|regex_match[/^[a-zA-Z]+$/]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'alpha_dash' => 'Username tidak boleh mengandung spasi',
                    'regex_match' => 'Username tidak boleh mengandung angka atau simbol'
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 8 karakter'
                ],
            ],
            'konfirmasi_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Password harus diisi',
                    'matches' => 'Konfirmasi Password tidak sama dengan Password'
                ],
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role harus diisi'
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $lokasi_presensi = new LokasiPresensiModel();
            $jabatan_model = new JabatanModel();
            $data = [
                'title' => 'Tambah Pegawai',
                'lokasi_presensi' => $lokasi_presensi->findAll(),
                'jabatan' => $jabatan_model->orderBy('jabatan', 'ASC')->findAll(),
                'validation' => \Config\Services::validation()
            ];
            echo view('admin/data_pegawai/create', $data);
        } else {
            $pegawaiModel = new PegawaiModel();
            $nipBaru = $this->generateNip();

            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4) {
                $nama_foto = 'default.png';
            } else {
                $nama_foto = $foto->getRandomName();
                $foto->move('profile', $nama_foto);
            }

            $pegawaiModel->insert([
                'nip' => $nipBaru,
                'nama' => $this->request->getPost('nama'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'alamat' => $this->request->getPost('alamat'),
                'no_handphone' => $this->request->getPost('no_handphone'),
                'jabatan' => $this->request->getPost('jabatan'),
                'lokasi_presensi' => $this->request->getPost('lokasi_presensi'),
                'foto' => $nama_foto,
            ]);

            $id_pegawai = $pegawaiModel->insertID();
            $userModel = new UserModel();
            $userModel->insert([
                'id_pegawai' => $id_pegawai,
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'status' => 'Aktif',
                'role' => $this->request->getPost('role'),
            ]);

            session()->setFlashdata('berhasil', 'Data pegawai tersimpan');
            return redirect()->to(base_url('admin/data_pegawai'));
        }
    }

    public function edit($id)
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan_model = new JabatanModel();
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Edit Data Pegawai',
            'pegawai' => $pegawaiModel->find($id),
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan_model->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/data_pegawai/edit', $data);
    }

    // public function update($id)
    // {
    //     $pegawaiModel = new PegawaiModel();
    //     $rules = [
    //         'nama_lokasi' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Nama Lokasi harus diisi'
    //             ],
    //         ],
    //         'alamat_lokasi' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Alamat Lokasi harus diisi'
    //             ],
    //         ],
    //         'tipe_lokasi' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Tipe Lokasi harus diisi'
    //             ],
    //         ],
    //         'latitude' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Latitude harus diisi'
    //             ],
    //         ],
    //         'longitude' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Longitude harus diisi'
    //             ],
    //         ],
    //         'radius' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Radius harus diisi'
    //             ],
    //         ],
    //         'zona_waktu' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Zona Waktu harus diisi'
    //             ],
    //         ],
    //         'jam_masuk' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Jam Masuk harus diisi'
    //             ],
    //         ],
    //         'jam_pulang' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Jam Pulang harus diisi'
    //             ],
    //         ],
    //     ];

    //     if (!$this->validate($rules)) {
    //         $data = [
    //             'title' => 'Edit Lokasi Presensi',
    //             'lokasi_presensi' => $pegawaiModel->find($id),
    //             'validation' => \Config\Services::validation()
    //         ];
    //         echo view('admin/lokasi_presensi/edit', $data);
    //     } else {
    //         $pegawaiModel = new PegawaiModel();
    //         $pegawaiModel->update($id, [
    //             'nama_lokasi' => $this->request->getPost('nama_lokasi'),
    //             'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
    //             'tipe_lokasi' => $this->request->getPost('tipe_lokasi'),
    //             'latitude' => $this->request->getPost('latitude'),
    //             'longitude' => $this->request->getPost('longitude'),
    //             'radius' => $this->request->getPost('radius'),
    //             'zona_waktu' => $this->request->getPost('zona_waktu'),
    //             'jam_masuk' => $this->request->getPost('jam_masuk'),
    //             'jam_pulang' => $this->request->getPost('jam_pulang')
    //         ]);

    //         session()->setFlashdata('berhasil', 'Data lokasi diupdate');
    //         return redirect()->to(base_url('admin/lokasi_presensi'));
    //     }
    // }

    function delete($id)
    {
        $pegawaiModel = new PegawaiModel();
        $pegawaiModel->delete($id);
        session()->setFlashdata('berhasil', 'Data pegawai dihapus');
        return redirect()->to(base_url('admin/data_pegawai'));
    }
}
