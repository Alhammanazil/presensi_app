<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="btn btn-primary mb-3"><i class="lni lni-circle-plus"></i> Ajukan</a>

<table id="jabatan" class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">File</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>

    <?php if (@$ketidakhadiran) : ?>
        <tbody>
            <?php $no = 1;
            foreach ($ketidakhadiran as $ketidakhadiran) :  ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $ketidakhadiran['tanggal'] ?></td>
                    <td><?= $ketidakhadiran['keterangan'] ?></td>
                    <td><?= $ketidakhadiran['deskripsi'] ?></td>
                    <td>
                        <a href="<?= base_url('file_ketidakhadiran/' . $ketidakhadiran['file']) ?>" class="badge bg-success" target="_blank"><i class="lni lni-eye"></i> Detail</a>
                    </td>
                    <td><?= $ketidakhadiran['status'] ?></td>
                    <td>
                        <a href="<?= base_url('pegawai/ketidakhadiran/edit/' . $ketidakhadiran['id']) ?>" class="badge bg-warning"><i class="lni lni-pencil"></i></a>

                        <a href="<?= base_url('pegawai/ketidakhadiran/delete/' . $ketidakhadiran['id']) ?>" class="badge bg-danger tombol-hapus"><i class="lni lni-trash-can"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php else : ?>
        <tbody>
            <tr>
                <td colspan="7" class="text-center">Data tidak ditemukan</td>
            </tr>
        </tbody>
    <?php endif; ?>
</table>

<?= $this->endSection() ?>