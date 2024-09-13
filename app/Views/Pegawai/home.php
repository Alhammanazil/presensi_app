<?= $this->extend('/pegawai/layout.php') ?>

<?= $this->section('content') ?>

<style>
    .parent-clock {
        display: grid;
        grid-template-columns: auto auto auto auto auto;
        font-size: 30px;
        font-weight: bold;
        justify-content: center;
    }

    #map {
        height: 300px;
    }
</style>

<?php
// Pengecekan zona waktu satu kali di awal
if (isset($lokasi_presensi['zona_waktu'])) {
    switch ($lokasi_presensi['zona_waktu']) {
        case 'WIB':
            date_default_timezone_set('Asia/Jakarta');
            break;
        case 'WITA':
            date_default_timezone_set('Asia/Makassar');
            break;
        case 'WIT':
            date_default_timezone_set('Asia/Jayapura');
            break;
    }
}
?>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">Presensi Masuk</div>
            <?php if ($cek_presensi < 1) : ?>
                <div class="card-body text-center">
                    <div class="fw-bold"><?= date('d F Y') ?></div>
                    <div class="parent-clock">
                        <div id="jam-masuk"></div>
                        <div>:</div>
                        <div id="menit-masuk"></div>
                        <div>:</div>
                        <div id="detik-masuk"></div>
                    </div>
                    <form method="POST" action="<?= base_url('pegawai/presensi_masuk') ?>">
                        <!-- LatLong Kantor -->
                        <?php if (isset($lokasi_presensi['latitude'])) : ?>
                            <input type="hidden" name="latitude_kantor" value="<?= $lokasi_presensi['latitude'] ?>">
                        <?php endif; ?>
                        <?php if (isset($lokasi_presensi['longitude'])) : ?>
                            <input type="hidden" name="longitude_kantor" value="<?= $lokasi_presensi['longitude'] ?>">
                        <?php endif; ?>

                        <!-- Radius -->
                        <?php if (isset($lokasi_presensi['radius'])) : ?>
                            <input type="hidden" name="radius" value="<?= $lokasi_presensi['radius'] ?>">
                        <?php endif; ?>

                        <!-- LatLong Pegawai -->
                        <input type="hidden" name="latitude_pegawai" id="latitude_pegawai">
                        <input type="hidden" name="longitude_pegawai" id="longitude_pegawai">

                        <input type="hidden" name="tanggal_masuk" value="<?= date('Y-m-d') ?>">
                        <input type="hidden" name="jam_masuk" value="<?= date('H:i:s') ?>">
                        <input type="hidden" name="id_pegawai" value="<?= session()->get('id_pegawai') ?>">
                        <button class="btn btn-primary mt-3">
                            Masuk
                        </button>
                    </form>
                </div>
            <?php else : ?>
                <div class="fw-bold text-center mt-2"><?= date('d F Y') ?></div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <i style="font-size: 75px;" class="lni lni-checkmark-circle text-success"></i>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">Presensi Keluar</div>
            <?php if ($cek_presensi_keluar < 1) : ?>
                <div class="card-body text-center">
                    <div class="fw-bold"><?= date('d F Y') ?></div>
                    <div class="parent-clock">
                        <div id="jam-keluar"></div>
                        <div>:</div>
                        <div id="menit-keluar"></div>
                        <div>:</div>
                        <div id="detik-keluar"></div>
                    </div>
                    <?php if (isset($ambil_presensi_masuk['id'])) : ?>
                        <form method="POST" action="<?= base_url('pegawai/presensi_keluar/' . $ambil_presensi_masuk['id']) ?>">
                            <!-- LatLong Kantor -->
                            <?php if (isset($lokasi_presensi['latitude'])) : ?>
                                <input type="hidden" name="latitude_kantor" value="<?= $lokasi_presensi['latitude'] ?>">
                            <?php endif; ?>
                            <?php if (isset($lokasi_presensi['longitude'])) : ?>
                                <input type="hidden" name="longitude_kantor" value="<?= $lokasi_presensi['longitude'] ?>">
                            <?php endif; ?>

                            <!-- Radius -->
                            <?php if (isset($lokasi_presensi['radius'])) : ?>
                                <input type="hidden" name="radius" value="<?= $lokasi_presensi['radius'] ?>">
                            <?php endif; ?>

                            <!-- LatLong Pegawai -->
                            <input type="hidden" name="latitude_pegawai" id="latitude_pegawai">
                            <input type="hidden" name="longitude_pegawai" id="longitude_pegawai">

                            <input type="hidden" name="tanggal_keluar" value="<?= date('Y-m-d') ?>">
                            <input type="hidden" name="jam_keluar" value="<?= date('H:i:s') ?>">

                            <button class="btn btn-danger mt-3">
                                Keluar
                            </button>
                        </form>
                    <?php else : ?>

                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="fw-bold text-center mt-2"><?= date('d F Y') ?></div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <i style="font-size: 75px;" class="lni lni-checkmark-circle text-success"></i>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

<div id="map"></div>

<script>
    // Waktu Masuk
    window.setInterval("waktuMasuk()", 1000);

    function waktuMasuk() {
        const waktu = new Date();
        document.getElementById("jam-masuk").innerHTML = formatWaktu(waktu.getHours());
        document.getElementById("menit-masuk").innerHTML = formatWaktu(waktu.getMinutes());
        document.getElementById("detik-masuk").innerHTML = formatWaktu(waktu.getSeconds());
    }

    function formatWaktu(waktu) {
        return waktu < 10 ? "0" + waktu : waktu;
    }

    // Waktu Keluar
    window.setInterval("waktuKeluar()", 1000);

    function waktuKeluar() {
        const waktu = new Date();
        document.getElementById("jam-keluar").innerHTML = formatWaktu(waktu.getHours());
        document.getElementById("menit-keluar").innerHTML = formatWaktu(waktu.getMinutes());
        document.getElementById("detik-keluar").innerHTML = formatWaktu(waktu.getSeconds());
    }

    // Geolocation
    getLocation();

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Browser tidak mendukung geolocation");
        }
    }

    function showPosition(position) {

        var latitude_pegawai = position.coords.latitude;
        var longitude_pegawai = position.coords.longitude;
        document.getElementById("latitude_pegawai").value = latitude_pegawai;
        document.getElementById("longitude_pegawai").value = longitude_pegawai;

        initMap(latitude_pegawai, longitude_pegawai);
    }

    // Map - Leaflet
    function initMap(latitude_pegawai, longitude_pegawai) {
        var map = L.map('map').setView([<?= $lokasi_presensi['latitude'] ?>, <?= $lokasi_presensi['longitude'] ?>], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var circle = L.circle([latitude_pegawai, longitude_pegawai], {
            color: '#00ff00',
            fillColor: '#00ff00',
            fillOpacity: 0.5,
            radius: 100
        }).addTo(map);

        var greenIcon = L.icon({
            iconUrl: '<?= base_url('assets/images/gedung.png') ?>',
            shadowUrl: '<?= base_url('assets/images/gedung.png') ?>',

            iconSize: [50, 64], // size of the icon
            shadowSize: [50, 64], // size of the shadow
            iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
            shadowAnchor: [22, 94], // the same for the shadow
            popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        L.marker([<?= $lokasi_presensi['latitude'] ?>, <?= $lokasi_presensi['longitude'] ?>], {
            icon: greenIcon
        }).addTo(map);

        marker.bindPopup("Lokasi Kantor.").openPopup();
        circle.bindPopup("Lokasi Sekarang.").openPopup();
    }
</script>

<?= $this->endSection() ?>