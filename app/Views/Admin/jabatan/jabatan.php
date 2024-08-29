<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('admin/jabatan/create') ?>" class="btn btn-primary mb-3"><i class="lni lni-circle-plus"></i> Tambah Data</a>

<table id="jabatan" class="table table-hover">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Jabatan</th>
            <th scope="col">Action</th>
        </tr>
    </thead>

    <?php $no = 1;
    foreach ($jabatan as $jab) :  ?>
        <tbody>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $jab['jabatan'] ?></td>
                <td>
                    <a href="<?= base_url('admin/jabatan/edit/' . $jab['id']) ?>" class="btn btn-warning"><i class="lni lni-pencil"></i></a>

                    <a href="<?= base_url('admin/jabatan/delete/' . $jab['id']) ?>" class="btn btn-danger"><i class="lni lni-trash-can"></i></a>
                </td>
            </tr>
        </tbody>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>