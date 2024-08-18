<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Proyek</h1>
        <?php echo validation_errors(); ?>
        <?php echo form_open('dashboard/edit_proyek/' .$proyek->id); ?>
            <div class="form-group">
                <label for="nama_proyek">Nama Proyek</label>
                <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" value="<?php echo isset($proyek->nama_proyek) ? $proyek->nama_proyek : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="client">Client</label>
                <input type="text" class="form-control" id="client" name="client" value="<?php echo isset($proyek->client) ? $proyek->client : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="tgl_mulai">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="<?php echo isset($proyek->tgl_mulai) ? $proyek->tgl_mulai : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="tgl_selesai">Tanggal Selesai</label>
                <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" value="<?php echo isset($proyek->tgl_selesai) ? $proyek->tgl_selesai : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="pimpinan_proyek">Pimpinan Proyek</label>
                <input type="text" class="form-control" id="pimpinan_proyek" name="pimpinan_proyek" value="<?php echo isset($proyek->pimpinan_proyek) ? $proyek->pimpinan_proyek : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo $proyek->keterangan; ?></textarea>
            </div>
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <select multiple class="form-control" id="lokasi" name="lokasi[]" required>
                    <?php 
                    $selected_lokasi = array_column($proyek->lokasi, 'id');
                    foreach ($lokasi_list as $lokasi): 
                    ?>
                        <option value="<?php echo $lokasi->id; ?>" <?php echo in_array($lokasi->id, $selected_lokasi) ? 'selected' : ''; ?>><?php echo $lokasi->namaLokasi; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-secondary">Kembali</a>
        <?php echo form_close(); ?>
    </div>
</body>
</html>