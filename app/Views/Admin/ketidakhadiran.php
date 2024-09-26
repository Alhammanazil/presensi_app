<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>

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
                        <a href="<?= base_url('file_ketidakhadiran/' . $ketidakhadiran['file']) ?>" class="badge bg-primary" target="_blank"><i class="lni lni-eye"></i> Lihat</a>
                    </td>
                    <td>
                        <?php if ($ketidakhadiran['status'] == 'Pending') : ?>
                            <span class="font-weight-bold" style="color:#B8001F"><b><?= $ketidakhadiran['status'] ?></b></span>
                        <?php elseif ($ketidakhadiran['status'] == 'Approved') : ?>
                            <span class="font-weight-bold" style="color:green"><b><?= $ketidakhadiran['status'] ?></b></span>
                        <?php else : ?>
                            <span class="badge bg-danger"><?= $ketidakhadiran['status'] ?></span>
                        <?php endif ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/approved_ketidakhadiran/' . $ketidakhadiran['id']) ?>" class="badge bg-success"><i class="lni lni-checkmark-circle"></i> Approve</a>
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