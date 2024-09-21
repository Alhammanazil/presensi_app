<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<?php
// Ambil tanggal dari filter atau gunakan hari ini jika tidak ada atau kosong
$tanggal = isset($_GET['filter_tanggal']) && !empty($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : date('Y-m-d');

// Fungsi untuk mengkonversi nama bulan dan hari ke bahasa Indonesia
function formatTanggalIndonesia($tanggal)
{
    $hariInggris = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $hariIndonesia = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');

    $bulanInggris = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $bulanIndonesia = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

    $hari = str_replace($hariInggris, $hariIndonesia, date('l', strtotime($tanggal)));
    $bulan = str_replace($bulanInggris, $bulanIndonesia, date('F', strtotime($tanggal)));

    return $hari . ', ' . date('d', strtotime($tanggal)) . ' ' . $bulan . ' ' . date('Y', strtotime($tanggal));
}

$formatted_date = formatTanggalIndonesia($tanggal);
?>

<style>
    table tr {
        min-height: 20px;
        /* Atur tinggi minimum baris */
    }
</style>

<!-- Filter Form -->
<form class="row g-3">
    <div class="col-auto">
        <input type="date" class="form-control" name="filter_tanggal" id="filter_tanggal" value="<?= date('Y-m-d', strtotime($tanggal)) ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3">Filter</button>
    </div>
</form>

<!-- Tanggal yang difilter dengan hari dalam Bahasa Indonesia -->
<div class="filtered-date mb-3">
    <h4 class="text-primary" id="filtered_date">
        <?= $formatted_date ?>
    </h4>
</div>

<!-- Tabel Rekap Harian -->
<table class="table table-hover table-striped table-bordered" style="border-top: 2px solid #dee2e6;">
    <thead>
        <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Nama Pegawai</th>
            <th style="text-align: center;">Tanggal</th>
            <th style="text-align: center;">Jam Masuk</th>
            <th style="text-align: center;">Jam Keluar</th>
            <th style="text-align: center;">Total Jam Kerja</th>
            <th style="text-align: center;">Total Keterlambatan</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($rekap_harian) : ?>
            <?php $no = 1;
            foreach ($rekap_harian as $rekap) : ?>
                <?php
                // Menghitung jumlah jam kerja
                $timestamp_jam_masuk = strtotime($rekap->tanggal_masuk . ' ' . $rekap->jam_masuk);
                $timestamp_jam_keluar = strtotime($rekap->tanggal_keluar . ' ' . $rekap->jam_keluar);
                $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;

                // Konversi jam kerja
                $jam = floor($selisih / 3600);
                $menit = floor(($selisih % 3600) / 60);

                // Menghitung keterlambatan
                $jam_masuk_real = strtotime($rekap->jam_masuk);
                $jam_masuk_kantor = strtotime($rekap->jam_masuk_kantor);
                $keterlambatan = $jam_masuk_real - $jam_masuk_kantor;

                // Konversi keterlambatan
                $jam_terlambat = floor($keterlambatan / 3600);
                $selisih_jam_terlambat = $keterlambatan % 3600;
                $menit_terlambat = floor($selisih_jam_terlambat / 60);
                ?>
                <tr>
                    <td style="vertical-align: middle; text-align: center;"><?= $no++ ?></td>
                    <td style="vertical-align: middle; text-align: center;"><?= $rekap->nama ?></td>
                    <td style="vertical-align: middle; text-align: center;"><?= date('d F Y', strtotime($rekap->tanggal_masuk)) ?></td>
                    <td style="vertical-align: middle; text-align: center;"><?= $rekap->jam_masuk ?></td>
                    <td style="vertical-align: middle; text-align: center;"><?= $rekap->jam_keluar ?></td>
                    <td style="vertical-align: middle; text-align: center;">
                        <?php if ($rekap->jam_keluar == '00:00:00') : ?>
                            0 jam 0 menit
                        <?php else : ?>
                            <?= $jam . ' jam ' . $menit . ' menit' ?>
                        <?php endif ?>
                    </td>
                    <td style="vertical-align: middle; text-align: center;">
                        <?php if ($jam_terlambat < 0 || $rekap->jam_keluar == '00:00:00') : ?>
                            <div style="display: flex; justify-content: center; align-items: center;"><span class="btn btn-success">On Time</span></div>
                        <?php else : ?>
                            <?= $jam_terlambat . ' jam ' . $menit_terlambat . ' menit' ?>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>

<?= $this->endSection() ?>