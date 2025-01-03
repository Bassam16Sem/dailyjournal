<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
       body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            border-radius: 10px;
            background: #1e3c72;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #2a5298;
        }
        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .form-control {
            padding-left: 40px;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card bg-light p-4">
                    <h2 class="text-center text-dark mb-4">Login</h2>
                    <form action="" method="POST">
                        <div class="form-group position-relative mb-3">
                            <i class="bi bi-person-circle"></i>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group position-relative mb-4">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Include Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        </form>
    </div>
    <?php
// Memulai session atau melanjutkan session yang sudah ada
session_start();

// Menyertakan code dari file koneksi
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Mengenkripsi password dengan MD5

    // Prepared statement
    $stmt = $conn->prepare("SELECT username, role FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);

    // Eksekusi query
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah ada data yang cocok
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Simpan username dan role ke dalam session
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Arahkan ke halaman berdasarkan role
        if ($row['role'] == 'admin') {
            header("Location: admin.php");
        } elseif ($row['role'] == 'user') {
            header("Location: index.php");
        }
    } else {
        // Jika login gagal
        header("Location: login.php?error=invalid");
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
<?php
