<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="POST" action="<?= base_url('admin/data_pegawai/update/' . $pegawai['id'] . '') ?>" enctype="multipart/form-data">

            <!-- Nama Pegawai -->
            <div class="input-style-1">
                <label>Nama</label>
                <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" name="nama" placeholder="Nama Lengkap" value="<?= $pegawai['nama'] ?>" />

                <div class="invalid-feedback">
                    <?= $validation->getError('nama') ?>
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="input-style-1">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control <?= $validation->hasError('jenis_kelamin') ? 'is-invalid' : '' ?>">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option <?php if ($pegawai['jenis_kelamin'] == 'Laki-laki') {
                                echo 'selected';
                            } ?> value="Laki-laki">Laki-laki</option>
                    <option <?php if ($pegawai['jenis_kelamin'] == 'Perempuan') {
                                echo 'selected';
                            } ?> value="Perempuan">Perempuan</option>
                </select>

                <div class="invalid-feedback">
                    <?= $validation->getError('jenis_kelamin') ?>
                </div>
            </div>

            <!-- Alamat -->
            <div class="input-style-1">
                <label>Alamat</label>
                <textarea name="alamat" name="alamat" cols="30" rows="5" placeholder="Masukkan Alamat" class="form-control <?= $validation->hasError('alamat') ? 'is-invalid' : '' ?>"></textarea>

                <div class="invalid-feedback">
                    <?= $validation->getError('alamat') ?>
                </div>
            </div>

            <!-- No. Handphone -->
            <div class="input-style-1">
                <label>No. Handphone</label>
                <input type="telp" name="no_handphone" cols="30" rows="5" placeholder="Masukkan nomor hp" class="form-control <?= $validation->hasError('no_handphone') ? 'is-invalid' : '' ?>"></input>

                <div class="invalid-feedback">
                    <?= $validation->getError('no_handphone') ?>
                </div>
            </div>

            <!-- Jabatan -->
            <div class="input-style-1">
                <label>Jabatan</label>
                <select name="jabatan" class="form-control <?= $validation->hasError('jabatan') ? 'is-invalid' : '' ?>">
                    <option value="">Pilih Jabatan</option>
                    <?php foreach ($jabatan as $jab) : ?>
                        <option value="<?= $jab['id'] ?>"><?= $jab['jabatan'] ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="invalid-feedback">
                    <?= $validation->getError('jabatan') ?>
                </div>
            </div>

            <!-- Lokasi Presensi -->
            <div class="input-style-1">
                <label>Lokasi Presensi</label>
                <select name="lokasi_presensi" class="form-control <?= $validation->hasError('lokasi_presensi') ? 'is-invalid' : '' ?>">
                    <option value="">Pilih Lokasi Presensi</option>
                    <?php foreach ($lokasi_presensi as $lok) : ?>
                        <option value="<?= $lok['id'] ?>"><?= $lok['nama_lokasi'] ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="invalid-feedback">
                    <?= $validation->getError('lokasi_presensi') ?>
                </div>
            </div>

            <!-- Foto -->
            <div class="input-style-1">
                <label>Foto</label>
                <input type="file" class="form-control <?= $validation->hasError('foto') ? 'is-invalid' : '' ?>" name="foto" />

                <div class="invalid-feedback">
                    <?= $validation->getError('foto') ?>
                </div>
            </div>

            <!-- Username -->
            <div class="input-style-1">
                <label>Username</label>
                <input type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>" name="username" placeholder="Masukkan Username" />

                <div class="invalid-feedback">
                    <?= $validation->getError('username') ?>
                </div>
            </div>

            <!-- Password -->
            <div class="input-style-1">
                <label>Password</label>
                <input type="password" class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>" name="password" placeholder="Masukkan Password" />

                <div class="invalid-feedback">
                    <?= $validation->getError('password') ?>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="input-style-1">
                <label>Konfirmasi Password</label>
                <input type="password" class="form-control <?= $validation->hasError('konfirmasi_password') ? 'is-invalid' : '' ?>" name="konfirmasi_password" placeholder="Konfirmasi Password" />

                <div class="invalid-feedback">
                    <?= $validation->getError('konfirmasi_password') ?>
                </div>
            </div>

            <!-- Role -->
            <div class="input-style-1">
                <label>Role</label>
                <select name="role" class="form-control <?= $validation->hasError('role') ? 'is-invalid' : '' ?>">
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="pegawai">Pegawai</option>
                </select>

                <div class="invalid-feedback">
                    <?= $validation->getError('role') ?>
                </div>
            </div>

            <button type="submit" class="main-btn primary-btn btn-hover" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Simpan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>