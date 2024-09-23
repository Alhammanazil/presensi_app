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

    public function rekap_harian()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, lokasi_presensi.jam_masuk as jam_masuk_kantor');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('lokasi_presensi', 'lokasi_presensi.id = pegawai.lokasi_presensi');
        $builder->where('presensi.tanggal_masuk', date('Y-m-d'));
        return $builder->get()->getResult();
    }

    public function rekap_harian_filter($filter_tanggal)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, lokasi_presensi.jam_masuk as jam_masuk_kantor');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('lokasi_presensi', 'lokasi_presensi.id = pegawai.lokasi_presensi');
        $builder->where('presensi.tanggal_masuk', $filter_tanggal);
        return $builder->get()->getResult();
    }

    public function rekap_bulanan()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, lokasi_presensi.jam_masuk as jam_masuk_kantor');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('lokasi_presensi', 'lokasi_presensi.id = pegawai.lokasi_presensi');
        $builder->where('MONTH(tanggal_masuk)', date('m'));
        $builder->where('YEAR(tanggal_masuk)', date('Y'));
        return $builder->get()->getResult();
    }

    public function rekap_bulanan_filter($filter_bulan, $filter_tahun)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, lokasi_presensi.jam_masuk as jam_masuk_kantor');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('lokasi_presensi', 'lokasi_presensi.id = pegawai.lokasi_presensi');
        $builder->where('MONTH(tanggal_masuk)', $filter_bulan);
        $builder->where('YEAR(tanggal_masuk)', $filter_tahun);
        return $builder->get()->getResult();
    }

    public function rekap_presensi_pegawai()
    {
        $id_pegawai = session()->get('id_pegawai');
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, lokasi_presensi.jam_masuk as jam_masuk_kantor');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('lokasi_presensi', 'lokasi_presensi.id = pegawai.lokasi_presensi');
        $builder->where('id_pegawai', $id_pegawai);
        dd($builder->get()->getResult());
    }
}
