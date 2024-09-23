<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<?php
// Ambil tanggal dari filter atau gunakan hari ini jika tidak ada atau kosong
$tanggal = isset($_GET['filter_tanggal']) && !empty($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : date('Y-m-d');

// Fungsi untuk mengkonversi nama bulan dan hari ke bahasa Indonesia
function formatTanggalIndonesia($tanggal)
{
    $bulanInggris = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $bulanIndonesia = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

    $bulan = str_replace($bulanInggris, $bulanIndonesia, date('F', strtotime($tanggal)));

    return $bulan . ' ' . date('Y', strtotime($tanggal));
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
        <select class="form-select" name="filter_bulan">
            <option value="">Pilih Bulan</option>
            <option value="01" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '01' ? 'selected' : '' ?>>Januari</option>
            <option value="02" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '02' ? 'selected' : '' ?>>Februari</option>
            <option value="03" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '03' ? 'selected' : '' ?>>Maret</option>
            <option value="04" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '04' ? 'selected' : '' ?>>April</option>
            <option value="05" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '05' ? 'selected' : '' ?>>Mei</option>
            <option value="06" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '06' ? 'selected' : '' ?>>Juni</option>
            <option value="07" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '07' ? 'selected' : '' ?>>Juli</option>
            <option value="08" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '08' ? 'selected' : '' ?>>Agustus</option>
            <option value="09" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '09' ? 'selected' : '' ?>>September</option>
            <option value="10" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '10' ? 'selected' : '' ?>>Oktober</option>
            <option value="11" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '11' ? 'selected' : '' ?>>November</option>
            <option value="12" <?= isset($_GET['filter_bulan']) && $_GET['filter_bulan'] == '12' ? 'selected' : '' ?>>Desember</option>
        </select>
    </div>

    <div class="col-auto">
        <select class="form-select" name="filter_tahun">
            <option value="">Pilih Tahun</option>
            <?php
            $year = date('Y');
            for ($i = 2020; $i <= $year; $i++) {
                $selected = isset($_GET['filter_tahun']) && $_GET['filter_tahun'] == $i ? 'selected' : '';
                echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
            }
            ?>
        </select>
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
        <?php if ($rekap_bulanan) : ?>
            <?php $no = 1;
            foreach ($rekap_bulanan as $rekap) : ?>
                <?php
                // Cek validitas jam masuk dan jam keluar
                if ($rekap->jam_masuk != '00:00:00' && $rekap->jam_keluar != '00:00:00') {
                    // Menghitung jumlah jam kerja
                    $timestamp_jam_masuk = strtotime($rekap->tanggal_masuk . ' ' . $rekap->jam_masuk);
                    $timestamp_jam_keluar = strtotime($rekap->tanggal_keluar . ' ' . $rekap->jam_keluar);
                    $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;

                    // Konversi jam kerja
                    $jam = floor($selisih / 3600);
                    $menit = floor(($selisih % 3600) / 60);
                } else {
                    $jam = 0;
                    $menit = 0;
                }

                // Menghitung keterlambatan
                $jam_masuk_real = strtotime($rekap->jam_masuk);
                $jam_masuk_kantor = strtotime($rekap->jam_masuk_kantor);
                $keterlambatan = $jam_masuk_real - $jam_masuk_kantor;

                // Cegah keterlambatan negatif
                if ($keterlambatan > 0) {
                    // Konversi keterlambatan
                    $jam_terlambat = floor($keterlambatan / 3600);
                    $selisih_jam_terlambat = $keterlambatan % 3600;
                    $menit_terlambat = floor($selisih_jam_terlambat / 60);
                } else {
                    $jam_terlambat = 0;
                    $menit_terlambat = 0;
                }
                ?>
                <tr>
                    <td style="vertical-align: middle; text-align: center;"><?= $no++ ?></td>
                    <td style="vertical-align: middle; text-align: center;"><?= $rekap->nama ?></td>
                    <td style="vertical-align: middle; text-align: center;"><?= date('d F Y', strtotime($rekap->tanggal_masuk)) ?></td>
                    <td style="vertical-align: middle; text-align: center;"><?= $rekap->jam_masuk ?></td>
                    <td style="vertical-align: middle; text-align: center;"><?= $rekap->jam_keluar ?></td>
                    <td style="vertical-align: middle; text-align: center;">
                        <?= $jam . ' jam ' . $menit . ' menit' ?>
                    </td>
                    <td style="vertical-align: middle; text-align: center;">
                        <?php if ($jam_terlambat == 0 && $menit_terlambat == 0) : ?>
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