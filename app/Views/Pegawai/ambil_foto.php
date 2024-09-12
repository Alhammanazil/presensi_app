<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ambil Foto</h4>
    </div>
    <div class="card-body">
        <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $id_pegawai ?>">
        <input type="hidden" id="tanggal_masuk" name="tanggal_masuk" value="<?= $tanggal_masuk ?>">
        <input type="hidden" id="jam_masuk" name="jam_masuk" value="<?= $jam_masuk ?>">

        <div class="row">
            <div class="col-md-6">
                <div class="cam-container">
                    <div id="my_camera"></div>
                    <br />
                    <button type="button" class="btn btn-primary" id="ambil-foto" onclick="take_snapshot()">Ambil Foto</button>
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
        let id_pegawai = document.getElementById('id_pegawai').value;
        let tanggal_masuk = document.getElementById('tanggal_masuk').value;
        let jam_masuk = document.getElementById('jam_masuk').value;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                // Redirect to home page after successful save or display a message
                window.location.href = "<?= base_url('pegawai/home') ?>";
            }
        };

        // Send the captured image and form data to the server
        xhttp.open("POST", "<?= base_url('pegawai/presensi_masuk_aksi') ?>", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(
            'foto_masuk=' + encodeURIComponent(capturedImage) +
            '&id_pegawai=' + id_pegawai +
            '&tanggal_masuk=' + tanggal_masuk +
            '&jam_masuk=' + jam_masuk
        );
    }
</script>

<?= $this->endSection() ?>