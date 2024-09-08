<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<div class="card col-md-8">
    <button class="col-2 main-btn primary-btn btn-hover m-3" style="padding: 0.3rem 1rem; font-size: 0.9rem;" onclick="location.href='<?= base_url('admin/data_pegawai') ?>'">Kembali</button>

    <div class="card-body">
        <img style="border-radius: 30px 30px 30px 30px;" width="150px" src="<?= base_url('profile/' . $pegawai['foto']) ?>" alt="">
        <table class="table table-hover">
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?= $pegawai['nip'] ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $pegawai['nama'] ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><?= $pegawai['username'] ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?= $pegawai['jenis_kelamin'] ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $pegawai['alamat'] ?></td>
            </tr>
            <tr>
                <td>No. Handphone</td>
                <td>:</td>
                <td><?= $pegawai['no_handphone'] ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?= $pegawai['jabatan'] ?></td>
            </tr>
            <tr>
                <td>Lokasi Presensi</td>
                <td>:</td>
                <td><?= $pegawai['lokasi_presensi'] ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td><?= $pegawai['status'] ?></td>
            </tr>
            <tr>
                <td>Role</td>
                <td>:</td>
                <td><?= $pegawai['role'] ?></td>
            </tr>
        </table>
    </div>
</div>

<?= $this->endSection() ?>