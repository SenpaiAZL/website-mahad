<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pengumuman</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Tambah Data Pengumuman
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="judulPengumuman">Judul Pengumuman</label>
                        <input type="text" class="form-control" id="judulPengumuman" placeholder="Masukkan Judul Pengumuman">
                    </div>
                    <div class="form-group">
                        <label for="jenisPengumuman">Jenis Pengumuman</label>
                        <div>
                            <button type="button" class="btn btn-outline-primary">Internal</button>
                            <button type="button" class="btn btn-outline-secondary">Eksternal</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="isiPengumuman">Isi Pengumuman</label>
                        <textarea class="form-control" id="isiPengumuman" rows="5"></textarea>
                    </div>
                    <button type="button" class="btn btn-secondary">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>