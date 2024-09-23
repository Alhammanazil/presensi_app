<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;
use App\Models\PegawaiModel;
use App\Models\PresensiModel;

class Home extends BaseController
{
    public function index()
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $pegawai_model = new PegawaiModel();
        $presensi_model = new PresensiModel();
        $id_pegawai = session()->get('id_pegawai');
        $pegawai = $pegawai_model->where('id', $id_pegawai)->first();

        // Set up DateTime dengan Zona Waktu Jakarta
        $zone = new \DateTimeZone('Asia/Jakarta');
        $date = new \DateTime('now', $zone);
        $formattedDate = $date->format('Y-m-d');

        $cek_presensi = $presensi_model->where('id_pegawai', $id_pegawai)
            ->where('tanggal_masuk', $formattedDate)
            ->countAllResults();

        $cek_presensi_keluar = $presensi_model->where('id_pegawai', $id_pegawai)
            ->where('tanggal_keluar', $formattedDate)
            ->countAllResults();

        $data = [
            'title' => 'Home',
            'lokasi_presensi' => $lokasi_presensi->where('id', $pegawai['lokasi_presensi'])->first(),
            'cek_presensi' => $cek_presensi,
            'cek_presensi_keluar' => $cek_presensi_keluar,
            'ambil_presensi_masuk' => $presensi_model->where('id_pegawai', $id_pegawai)
                ->where('tanggal_masuk', $formattedDate)
                ->first()
        ];

        return view('pegawai/home', $data);
    }


    public function presensi_masuk()
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $id_pegawai = session()->get('id_pegawai');

        $latitude_kantor = $this->request->getPost('latitude_kantor');
        $longitude_kantor = $this->request->getPost('longitude_kantor');

        $latitude_pegawai = $this->request->getPost('latitude_pegawai');
        $longitude_pegawai = $this->request->getPost('longitude_pegawai');

        $radius = $this->request->getPost('radius');

        $jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) * cos(deg2rad($longitude_pegawai - $longitude_kantor));

        $jarak = acos($jarak);
        $jarak = rad2deg($jarak);
        $mil = $jarak * 60 * 1.1515;
        $km = $mil * 1.609344;
        $jarak_meter = floor($km * 1000);

        if ($jarak_meter > $radius) {
            session()->setFlashdata('gagal', 'Anda diluar jangkauan');
            return redirect()->to(base_url('pegawai/home'));
        } else {
            $data = [
                'title' => 'Ambil Foto Selfie',
                'id_pegawai' => $this->request->getPost('id_pegawai'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
                'jam_masuk' => $this->request->getPost('jam_masuk'),
            ];
            return view('pegawai/ambil_foto', $data);
        }
    }

    public function presensi_masuk_aksi()
    {
        $request = \Config\Services::request();
        $id_pegawai = $request->getPost('id_pegawai');
        $tanggal_masuk = $request->getPost('tanggal_masuk');
        $jam_masuk = $request->getPost('jam_masuk');
        $foto_masuk = $request->getPost('foto_masuk');

        // Hapus metadata base64 dari data gambar dan decode
        $foto_masuk = str_replace('data:image/jpeg;base64,', '', $foto_masuk);
        $foto_masuk = base64_decode($foto_masuk);

        // Buat nama file dan simpan gambar ke direktori uploads
        $nama_foto = $id_pegawai . '_' . time() . '.jpg';
        $foto_dir = WRITEPATH . 'uploads/' . $nama_foto;

        // Simpan gambar ke direktori
        file_put_contents($foto_dir, $foto_masuk);

        // Ganti backslash dengan forward slash
        $foto_dir = str_replace('\\', '/', $foto_dir);

        // Simpan data ke dalam database
        $presensi_model = new PresensiModel();
        $presensi_model->insert([
            'id_pegawai' => $id_pegawai,
            'jam_masuk' => $jam_masuk,
            'tanggal_masuk' => $tanggal_masuk,
            'foto_masuk' => $nama_foto, // Simpan nama file saja, bukan jalur lengkapnya
        ]);

        session()->setFlashdata('berhasil', 'Presensi masuk tersimpan');
        return redirect()->to(base_url('pegawai/home'));
    }


    public function presensi_keluar($id)
    {
        $latitude_kantor = $this->request->getPost('latitude_kantor');
        $longitude_kantor = $this->request->getPost('longitude_kantor');

        $latitude_pegawai = $this->request->getPost('latitude_pegawai');
        $longitude_pegawai = $this->request->getPost('longitude_pegawai');

        $radius = $this->request->getPost('radius');

        $jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) * cos(deg2rad($longitude_pegawai - $longitude_kantor));

        $jarak = acos($jarak);
        $jarak = rad2deg($jarak);
        $mil = $jarak * 60 * 1.1515;
        $km = $mil * 1.609344;
        $jarak_meter = floor($km * 1000);

        if ($jarak_meter > $radius) {
            session()->setFlashdata('gagal', 'Anda diluar jangkauan');
            return redirect()->to(base_url('pegawai/home'));
        } else {
            $data = [
                'title' => 'Ambil Foto Selfie',
                'id_presensi' => $id,
                'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
                'jam_keluar' => $this->request->getPost('jam_keluar'),
            ];
            return view('pegawai/ambil_foto_keluar', $data);
        }
    }

    public function presensi_keluar_aksi($id)
    {
        $request = \Config\Services::request();
        $tanggal_keluar = $request->getPost('tanggal_keluar');
        $jam_keluar = $request->getPost('jam_keluar');
        $foto_keluar = $request->getPost('foto_keluar');

        // Hapus metadata base64 dari data gambar dan decode
        $foto_keluar = str_replace('data:image/jpeg;base64,', '', $foto_keluar);
        $foto_keluar = base64_decode($foto_keluar);

        // Buat nama file dan simpan gambar ke direktori uploads
        $nama_foto = $id . '_' . time() . '.jpg';
        $foto_dir = WRITEPATH . 'uploads/' . $nama_foto;

        // Simpan gambar ke direktori
        file_put_contents($foto_dir, $foto_keluar);

        // Ganti backslash dengan forward slash
        $foto_dir = str_replace('\\', '/', $foto_dir);

        // Simpan data ke dalam database
        $presensi_model = new PresensiModel();
        $presensi_model->update($id, [
            'jam_keluar' => $jam_keluar,
            'tanggal_keluar' => $tanggal_keluar,
            'foto_keluar' => $nama_foto
        ]);

        session()->setFlashdata('berhasil', 'Presensi keluar tersimpan');
        return redirect()->to(base_url('pegawai/home'));
    }
}
