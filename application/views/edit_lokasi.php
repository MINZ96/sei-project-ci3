<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lokasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Lokasi</h1>
        <?php echo validation_errors(); ?>
        <?php echo form_open('dashboard/edit_lokasi/'.$lokasi->id); ?>
            <div class="form-group">
                <label for="nama_lokasi">Nama Lokasi</label>
                <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi" value="<?php echo $lokasi->namaLokasi; ?>" required>
            </div>
            <div class="form-group">
                <label for="negara">Negara</label>
                <input type="text" class="form-control" id="negara" name="negara" value="<?php echo $lokasi->negara; ?>" required>
            </div>
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?php echo $lokasi->provinsi; ?>" required>
            </div>
            <div class="form-group">
                <label for="kota">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota" value="<?php echo $lokasi->kota; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-secondary">Kembali</a>
        <?php echo form_close(); ?>
    </div>
</body>
</html>