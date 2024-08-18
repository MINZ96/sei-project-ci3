<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Dashboard</h1>
        <!-- Tambahkan ini setelah tag <h1>Dashboard</h1> -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        
        <h2>Proyek</h2>
        <a href="<?php echo site_url('dashboard/add_proyek'); ?>" class="btn btn-primary mb-3">Tambah Proyek</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Client</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Pimpinan Proyek</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proyek_list as $proyek): ?>
                <tr>
                    <td><?php echo $proyek->namaProyek; ?></td>
                    <td><?php echo $proyek->client; ?></td>
                    <td><?php echo $proyek->tglMulai; ?></td>
                    <td><?php echo $proyek->tglSelesai; ?></td>
                    <td><?php echo $proyek->pimpinanProyek; ?></td>
                    <?php if (isset($proyek->lokasi) && is_array($proyek->lokasi)): ?>
                        <?php foreach ($proyek->lokasi as $lokasi): ?>
                            <td><?php echo $lokasi->namaLokasi; ?></td>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <td>
                        <a href="<?php echo site_url('dashboard/edit_proyek/'.$proyek->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?php echo site_url('dashboard/delete_proyek/'.$proyek->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Lokasi</h2>
        <a href="<?php echo site_url('dashboard/add_lokasi'); ?>" class="btn btn-primary mb-3">Tambah Lokasi</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Lokasi</th>
                    <th>Negara</th>
                    <th>Provinsi</th>
                    <th>Kota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lokasi_list as $lokasi): ?>
                <tr>
                    <td><?php echo $lokasi->namaLokasi; ?></td>
                    <td><?php echo $lokasi->negara; ?></td>
                    <td><?php echo $lokasi->provinsi; ?></td>
                    <td><?php echo $lokasi->kota; ?></td>
                    <td>
                        <a href="<?php echo site_url('dashboard/edit_lokasi/'.$lokasi->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?php echo site_url('dashboard/delete_lokasi/'.$lokasi->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>