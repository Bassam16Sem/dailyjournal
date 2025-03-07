<?php
// Include koneksi database
include 'koneksi.php'; 

// Menangani proses tambah gambar
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = date("Y-m-d H:i:s");
    $gambar = '';

    // Cek apakah ada gambar yang diupload
    if ($_FILES['gambar']['name'] != '') {
        // Upload gambar
        include 'upload_foto.php'; // Fungsi upload gambar
        $cek_upload = upload_foto($_FILES["gambar"]);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message']; // Nama file gambar setelah diupload
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php';
            </script>";
            die;
        }
    }

   // Menyimpan data ke database
$stmt = $conn->prepare("INSERT INTO gallery (judul, deskripsi, gambar, tanggal) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $judul, $deskripsi, $gambar, $tanggal); // Perhatikan parameter "ssss" untuk 4 string
if ($stmt->execute()) {
    echo "<script>
        alert('Data gallery berhasil disimpan.');
        document.location='admin.php?page=gallery';
    </script>";
} else {
    echo "<script>
        alert('Gagal menyimpan data.');
        document.location='admin.php?page=gallery';
    </script>";
}
//->close();
}elseif(isset($_POST['hapus'])){
    $judulhapus = $_POST['judulhapus'];
    $id = $_POST['id'];

    unlink("img/".$judulhapus);
    $stmt = $conn->prepare("DELETE FROM gallery WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Menangani proses update gambar
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_POST['gambar_lama']; // Default gambar lama

    // Cek jika ada gambar baru yang diupload
    if ($_FILES['gambar']['name'] != '') {
        // Hapus gambar lama
        unlink("img/" . $_POST['gambar_lama']);

        // Upload gambar baru
        include 'upload_foto.php'; // Fungsi upload gambar
        $cek_upload = upload_foto($_FILES["gambar"]);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message']; // Nama gambar baru
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=gallery';
            </script>";
            die;
        }
    }

    // Update data ke database
    $stmt = $conn->prepare("UPDATE gallery SET judul=?, deskripsi=?, gambar=? WHERE id=?");
    $stmt->bind_param("sssi", $judul, $deskripsi, $gambar, $id);
    if ($stmt->execute()) {
        echo "<script>
            alert('Data gallery berhasil diperbarui.');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Gagal memperbarui data.');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
}


// Menangani proses delete gambar
if (isset($_POST['hapus'])) {
    // Mengambil ID dan gambar yang ingin dihapus
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    // Cek apakah gambar ada dan bisa dihapus
    if ($gambar != '') {
        $gambar_path = "img/" . $gambar;
        if (file_exists($gambar_path)) {
            unlink($gambar_path); // Hapus file gambar
        }
    }

    // Hapus data dari database
    $stmt = $conn->prepare("DELETE FROM gallery WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>
            alert('Data gallery berhasil dihapus.');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data.');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
}



// Ambil semua data gallery
$sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
$hasil = $conn->query($sql);

// Konfigurasi paginasi
$batas = 4; // Jumlah data per halaman
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1; // Halaman aktif
$offset = ($halaman - 1) * $batas;

// Hitung total data
$sql_total = "SELECT COUNT(*) AS total FROM gallery";
$result_total = $conn->query($sql_total);
$total_data = $result_total->fetch_assoc()['total'];
$total_halaman = ceil($total_data / $batas);

// Ambil data sesuai dengan halaman
$sql = "SELECT * FROM gallery ORDER BY tanggal DESC LIMIT $batas OFFSET $offset";
$hasil = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3">
    <!-- Tombol tambah -->
    <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Add Gambar
    </button>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Gallery</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="gallery.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Gallery -->
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($_GET['halaman'])){
                        $no = ($batas*($_GET['halaman']-1))+1;
                    }else{
                        $no = 1;
                    }
                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row["judul"] ?></td>
                            <td><?= $row["deskripsi"] ?></td>
                            <td><img src="img/<?= $row["gambar"] ?>" width="100"></td>
                            <td>
                                <a href="#" title="Edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                                <a href="#" title="Delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Navigasi Paginasi -->
<nav>
        <ul class="pagination justify-content-center">
            <?php if ($halaman > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=gallery&halaman=<?= $halaman - 1 ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
                <li class="page-item <?= ($halaman == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=gallery&halaman=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($halaman < $total_halaman): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=gallery&halaman=<?= $halaman + 1 ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php
// Modal edit
$hasil->data_seek(0); // Reset pointer setelah loop pertama
while ($row = $hasil->fetch_assoc()) { 
?>
    <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="gallery.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" value="<?= $row['judul'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" required><?= $row['deskripsi'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar">
                            <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">
                            <small>Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<?php
// Modal edit
$hasil->data_seek(0); // Reset pointer setelah loop pertama
while ($row = $hasil->fetch_assoc()) { 
?>
    <div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="gallery.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="judulHapus" value="<?= $row['judul'] ?>">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <p>Apakah anda yakin ingin menghapus gambar ini?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" name="hapus" value="hapus" class="btn btn-success">Iya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
