<?php
include "koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Daily Journal</title>
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      .hero-section {
        background-color: #eee5cb;
        padding: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .hero-text {
        max-width: 60%;
      }
      .profile-photo {
        object-fit: cover;
        width: 150px;
        height: 150px;
      }

        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
        }
        .text-section {
            padding: 3rem 1rem;
        }
        .text-section h2 {
            font-weight: bold;
            color: #333;
        }
        .schedule-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .schedule-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        .schedule-card .card-title {
            font-size: 1.5rem;
            color: #6a11cb;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .schedule-card p {
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .schedule-card i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #6a11cb;
        }
    </style>

  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#home">My Daily Journal</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#home"style="color: black;">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#article"style="color: black;">Article</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#gallery"style="color: black;">Gallery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#jadwal"style="color: black;">Jadwal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#profile"style="color: black;">Profile</a>
          </li>
          <li class="nav-item">
    <a class="nav-link" href="login.php"style="color: black;">Logout</a>
</li>
        </ul>
      </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
      <div class="hero-text">
        <h1>Create Memories, Save Memories, Everyday</h1>
        <p>Mencatat semua kegiatan sehari-hari yang ada tanpa terkecuali</p>
      </div>
        <img src="Gambar/Sakura.jpg" alt="Hero Image" width="200" height="300">
    </div>
    </section>

    <!-- Carousel Section -->
    <section id="carouselSection" class="my-5">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li
            data-target="#carouselExampleIndicators"
            data-slide-to="0"
            class="active"
          ></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img
              src="Gambar/background.jpg"
              class="d-block w-100"
              alt="Slide 1"
            />
          </div>
          <div class="carousel-item">
            <img
              src="Gambar/background.jpg"
              class="d-block w-100"
              alt="Slide 2"
            />
          </div>
          <div class="carousel-item">
            <img
              src="Gambar/background.jpg"
              class="d-block w-100"
              alt="Slide 3"
            />
          </div>
        </div>
        <a
          class="carousel-control-prev"
          href="#carouselExampleIndicators"
          role="button"
          data-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a
          class="carousel-control-next"
          href="#carouselExampleIndicators"
          role="button"
          data-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </section>

     <!-- article begin -->
     <section id="article" class="text-section container">
        <div class="container">
        <h2 class="text-center mb-5">Article</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                <?php
                $sql = "SELECT * FROM article ORDER BY tanggal DESC";
                $hasil = $conn->query($sql); 

                while($row = $hasil->fetch_assoc()){
                ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="..." />
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row["judul"]?></h5>
                                    <p class="card-text">
                                    <?= $row["isi"]?>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-body-secondary">
                                    <?= $row["tanggal"]?>
                                    </small>
                                </div>
                        </div>
                    </div>
                    <?php
                }
                ?> 
            </div>
        </div>
    </section>
    <!-- article end -->

    <!-- Gallery Section -->
    <section id="gallery" class="text-section container">
    <h2 class="text-center mb-5">Gallery</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
        $hasil = $conn->query($sql); 

        while($row = $hasil->fetch_assoc()){
        ?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4"> <!-- Responsif dan ada spasi antar item -->
      <div class="card h-80">
                <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="..." />
                <div class="card-body">
                    <h5 class="card-title"><?= $row["judul"]?></h5>
                    <p class="card-text">
                    <?= $row["deskripsi"]?>
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-body-secondary">
                        <?= $row["tanggal"]?>
                    </small>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</section>

    <!-- Jadwal Section -->
    <section id="jadwal" class="text-section container">
        <h2 class="text-center mb-5">Jadwal Kuliah</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card schedule-card text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-day"></i>
                        <h5 class="card-title">Senin</h5>
                        <p>09:30 - 12:00<br><strong>Logika Informatika</strong><br>Ruang H.3.4</p>
                        <p>12:30 - 14:10<br><strong>Basis Data</strong><br>Ruang H.3.1</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card schedule-card text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-day"></i>
                        <h5 class="card-title">Selasa</h5>
                        <p>09:30 - 12:00<br><strong>Sistem Informasi</strong><br>Ruang H.4.2</p>
                        <p>12:30 - 15:00<br><strong>Pemrograman Berbasis Web</strong><br>Ruang D.2.J</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card schedule-card text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-day"></i>
                        <h5 class="card-title">Rabu</h5>
                        <p>09:30 - 12:00<br><strong>Probabilitas & Statistik</strong><br>Ruang H.4.8</p>
                        <p>12:00 - 15:00<br><strong>Rekayasa Perangkat Lunak</strong><br>Ruang H.4.5</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card schedule-card text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-day"></i>
                        <h5 class="card-title">Kamis</h5>
                        <p>09:30 - 12:00<br><strong>Basis Data</strong><br>Ruang D.3.M</p>
                        <p>12:30 - 15:00<br><strong>Sistem Informasi</strong><br>Ruang H.4.8</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
            <div class="card schedule-card text-center"style="min-height: 255px;">
                    <div class="card-body">
                        <i class="fas fa-calendar-day"></i>
                        <h5 class="card-title">Jumat</h5>
                        <p>09:30 - 12:00<br><strong>Kecerdasan Buatan</strong><br>H.5.10</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card schedule-card text-center"style="min-height: 255px;">
                    <div class="card-body">
                        <i class="fas fa-calendar-day"></i>
                        <h5 class="card-title">Sabtu</h5>
                        <p><strong>Tidak ada jadwal</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<br>
<section id="profile" class="text-section container">
  <h2 class="text-center mb-5">Profil Mahasiswa</h2>
  <div class="row align-items-center">
    <div class="col-md-4 text-center mb-4 mb-md-0">
    <img
    src="gambar/bassam.png"
    alt="Foto Mahasiswa"
    class="profile-photo img-fluid rounded-circle"
    style="width: 170px; height: 170px;"
    />  
    </div>
    <div class="col-md-8">
      <table class="table table-borderless">
        <tbody>
          <tr>
            <th scope="row">Nama</th>
            <td>Ahmad Zuhdi Bassam Nuris</td>
          </tr>
          <tr>
            <th scope="row">NIM</th>
            <td>A11.2023.15282</td>
          </tr>
          <tr>
            <th scope="row">Program Studi</th>
            <td>Teknik Informatika</td>
          </tr>
          <tr>
            <th scope="row">Email</th>
            <td>bassamnuris@gmail.com</td>
          </tr>
          <tr>
            <th scope="row">Telepon</th>
            <td>085284161308</td>
          </tr>
          <tr>
            <th scope="row">Alamat</th>
            <td>Lemah Gempal</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>




