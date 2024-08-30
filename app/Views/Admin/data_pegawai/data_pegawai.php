<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('admin/data_pegawai/create') ?>" class="btn btn-primary mb-3"><i class="lni lni-circle-plus"></i> Tambah Data</a>

<table id="jabatan" class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">NIP</th>
            <th scope="col">Nama</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Lokasi Presensi</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $no = 1;
        foreach ($pegawai as $peg) :  ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $peg['nip'] ?></td>
                <td><?= $peg['nama'] ?></td>
                <td><?= $peg['jabatan'] ?></td>
                <td><?= $peg['lokasi_presensi'] ?></td>

                <td>
                    <a href="<?= base_url('admin/data_pegawai/detail/' . $peg['id']) ?>" class="badge bg-info"><i class="lni lni-eye"></i></a>

                    <a href="<?= base_url('admin/data_pegawai/edit/' . $peg['id']) ?>" class="badge bg-warning"><i class="lni lni-pencil"></i></a>

                    <a href="<?= base_url('admin/data_pegawai/delete/' . $peg['id']) ?>" class="badge bg-danger tombol-hapus"><i class="lni lni-trash-can"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>