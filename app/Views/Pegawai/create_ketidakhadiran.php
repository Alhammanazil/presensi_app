<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<div class="card col-md-6">
    <div class="card-body">
        <button class="main-btn primary-btn btn-hover my-3" style="padding: 0.3rem 1rem; font-size: 0.9rem;" onclick="location.href='<?= base_url('pegawai/ketidakhadiran') ?>'">Kembali</button>

        <form method="POST" action="<?= base_url('pegawai/ketidakhadiran/store') ?>" enctype="multipart/form-data">

            <?= csrf_field() ?>

            <!-- ambil session -->
            <input type="hidden" value="<?= session()->get('id_pegawai') ?>" name="id_pegawai">

            <!-- Keterangan -->
            <div class="input-style-1 mt-3">
                <label>Keterangan</label>
                <select name="keterangan" class="form-control <?= $validation->hasError('keterangan') ? 'is-invalid' : '' ?>">
                    <option value="">Pilih Keterangan</option>
                    <option value="Izin" <?= set_select('keterangan', 'Izin') ?>>Izin</option>
                    <option value="Sakit" <?= set_select('keterangan', 'Sakit') ?>>Sakit</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('keterangan') ?>
                </div>
            </div>

            <!-- Tanggal -->
            <div class="input-style-1">
                <label>Tanggal</label>
                <input type="date" class="form-control <?= $validation->hasError('tanggal') ? 'is-invalid' : '' ?>" name="tanggal" value="<?= set_value('tanggal') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('tanggal') ?>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="input-style-1">
                <label>Deskripsi</label>
                <textarea name="deskripsi" cols="30" rows="5" placeholder="Masukkan Deskripsi" class="form-control <?= $validation->hasError('deskripsi') ? 'is-invalid' : '' ?>"><?= set_value('deskripsi') ?></textarea>
                <div class="invalid-feedback">
                    <?= $validation->getError('alamat') ?>
                </div>
            </div>

            <!-- File -->
            <div class="input-style-1">
                <label>File Pendukung</label>
                <input type="file" name="file" class="form-control <?= $validation->hasError('file') ? 'is-invalid' : '' ?>" value="<?= set_value('file') ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('file') ?>
                </div>
            </div>

            <button type="submit" class="main-btn primary-btn btn-hover" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Ajukan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>