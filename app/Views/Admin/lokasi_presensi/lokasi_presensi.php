<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('admin/lokasi_presensi/create') ?>" class="btn btn-primary mb-3"><i class="lni lni-circle-plus"></i> Tambah Data</a>

<table id="jabatan" class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Lokasi</th>
            <th scope="col">Alamat Lokasi</th>
            <th scope="col">Tipe Lokasi</th>
            <th scope="col">Action</th>
        </tr>
    </thead>

    <tbody>
        <?php $no = 1;
        foreach ($lokasi_presensi as $lok) :  ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $lok['nama_lokasi'] ?></td>
                <td><?= $lok['alamat_lokasi'] ?></td>
                <td><?= $lok['tipe_lokasi'] ?></td>
                <td>
                    <a href="<?= base_url('admin/lokasi_presensi/detail/' . $lok['id']) ?>" class="badge bg-info"><i class="lni lni-eye"></i></a>

                    <a href="<?= base_url('admin/lokasi_presensi/edit/' . $lok['id']) ?>" class="badge bg-warning"><i class="lni lni-pencil"></i></a>

                    <a href="<?= base_url('admin/lokasi_presensi/delete/' . $lok['id']) ?>" class="badge bg-danger tombol-hapus"><i class="lni lni-trash-can"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>