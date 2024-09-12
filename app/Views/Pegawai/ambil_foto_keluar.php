<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ambil Foto</h4>
    </div>
    <div class="card-body">
        <input type="hidden" id="tanggal_keluar" name="tanggal_keluar" value="<?= $tanggal_keluar ?>">
        <input type="hidden" id="jam_keluar" name="jam_keluar" value="<?= $jam_keluar ?>">

        <div class="row">
            <div class="col-md-6">
                <div class="cam-container">
                    <div id="my_camera"></div>
                    <br />
                    <button type="button" class="btn btn-danger" id="ambil-foto-keluar" onclick="take_snapshot()">Ambil Foto</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="preview-container">
                    <div id="results">Your captured image will appear here...</div>
                </div>
            </div>
        </div>

        <!-- Initially hidden Save Photo button -->
        <div id="simpan-foto-container" style="display: none;">
            <button type="button" class="btn btn-success my-3" id="simpan-foto" onclick="simpan_foto()">Simpan Foto</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" crossorigin="anonymous"></script>

<script>
    let capturedImage = ''; // To store the captured image

    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#my_camera');

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            capturedImage = data_uri; // Store the captured image for later
            document.getElementById('simpan-foto-container').style.display = 'block'; // Show Save button
        });
    }

    function simpan_foto() {
        let tanggal_keluar = document.getElementById('tanggal_keluar').value;
        let jam_keluar = document.getElementById('jam_keluar').value;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                window.location.href = "<?= base_url('pegawai/home') ?>";
            }
        };

        // Send the captured image and form data to the server
        xhttp.open("POST", "<?= base_url('pegawai/presensi_keluar_aksi/' . $id_presensi) ?>", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(
            'foto_keluar=' + encodeURIComponent(capturedImage) +
            '&tanggal_keluar=' + tanggal_keluar +
            '&jam_keluar=' + jam_keluar
        );
    }
</script>

<?= $this->endSection() ?>