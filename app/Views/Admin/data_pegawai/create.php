<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<div class="card col-md-6">
    <div class="card-body">
        <button class="main-btn primary-btn btn-hover my-3" style="padding: 0.3rem 1rem; font-size: 0.9rem;" onclick="location.href='<?= base_url('admin/data_pegawai') ?>'">Kembali</button>

        <form method="POST" action="<?= base_url('admin/data_pegawai/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Nama Pegawai -->
            <div class="input-style-1">
                <label>Nama</label>
                <input type="text" class="form-control <?= $validation->hasError('nama') ? 'is-invalid' : '' ?>" name="nama" placeholder="Nama Lengkap" value="<?= set_value('nama') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('nama') ?>
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="input-style-1">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control <?= $validation->hasError('jenis_kelamin') ? 'is-invalid' : '' ?>">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" <?= set_select('jenis_kelamin', 'Laki-laki') ?>>Laki-laki</option>
                    <option value="Perempuan" <?= set_select('jenis_kelamin', 'Perempuan') ?>>Perempuan</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('jenis_kelamin') ?>
                </div>
            </div>

            <!-- Alamat -->
            <div class="input-style-1">
                <label>Alamat</label>
                <textarea name="alamat" cols="30" rows="5" placeholder="Masukkan Alamat" class="form-control <?= $validation->hasError('alamat') ? 'is-invalid' : '' ?>"><?= set_value('alamat') ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('alamat') ?>
                </div>
            </div>

            <!-- No. Handphone -->
            <div class="input-style-1">
                <label>No. Handphone</label>
                <input type="telp" name="no_handphone" placeholder="Masukkan nomor hp" class="form-control <?= $validation->hasError('no_handphone') ? 'is-invalid' : '' ?>" value="<?= set_value('no_handphone') ?>" />
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
                        <option value="<?= $jab['id'] ?>" <?= set_select('jabatan', $jab['id']) ?>><?= $jab['jabatan'] ?></option>
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
                        <option value="<?= $lok['id'] ?>" <?= set_select('lokasi_presensi', $lok['id']) ?>><?= $lok['nama_lokasi'] ?></option>
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
                <input type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>" name="username" placeholder="Masukkan Username" value="<?= set_value('username') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('username') ?>
                </div>
            </div>

            <!-- Password -->
            <div class="input-style-1">
                <label>Password</label>
                <input type="password" class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>" name="password" placeholder="Masukkan Password" value="<?= set_value('password') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('password') ?>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="input-style-1">
                <label>Konfirmasi Password</label>
                <input type="password" class="form-control <?= $validation->hasError('konfirmasi_password') ? 'is-invalid' : '' ?>" name="konfirmasi_password" placeholder="Konfirmasi Password" value="<?= set_value('konfirmasi_password') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('konfirmasi_password') ?>
                </div>
            </div>

            <!-- Role -->
            <div class="input-style-1">
                <label>Role</label>
                <select name="role" class="form-control <?= $validation->hasError('role') ? 'is-invalid' : '' ?>">
                    <option value="">Pilih Role</option>
                    <option value="admin" <?= set_select('role', 'admin') ?>>Admin</option>
                    <option value="pegawai" <?= set_select('role', 'pegawai') ?>>Pegawai</option>
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