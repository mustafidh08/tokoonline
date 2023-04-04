<?php
require "koneksi.php";

$queryKategori = mysqli_query($conn, "SELECT * from kategori");

// get produk by nama produk/keyword
if (isset($_GET['keyword'])) {
    $queryProduk = mysqli_query($conn, "SELECT * from produk where nama like '%$_GET[keyword]%'");
}

// get produk by kategori
else if (isset($_GET['kategori'])) {
    $queryGetKategoriId = mysqli_query($conn, "SELECT id from kategori where nama='$_GET[kategori]'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);
    $queryProduk = mysqli_query($conn, "SELECT * from produk where kategori_id='$kategoriId[id]'");
}

// get produk default
else {
    $queryProduk = mysqli_query($conn, "SELECT * from produk");
}

$countData = mysqli_num_rows($queryProduk);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk | toLine</title>

    <link rel="stylesheet" href="css/style.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center fw-bold">Produk</h1>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3 class="mb-3">Kategori</h3>
                <ul class="list-group">
                    <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                        <a class="no-decoration" href="produk.php?kategori=<?= $kategori['nama']; ?>">
                            <li class="list-group-item"><?= $kategori['nama']; ?></li>
                        </a>
                    <?php }  ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">
                    <?php if ($countData < 1) {
                    ?>
                        <h4 class="text-center my-5 fw-bold">Produk yang anda cari tidak tersedia!</h4>
                    <?php
                    } ?>

                    <?php while ($produk = mysqli_fetch_array($queryProduk)) {

                    ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="img-box">
                                    <img src="img/<?= $produk['foto']; ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $produk['nama']; ?></h5>
                                    <p class="card-text text-truncate"><?= $produk['detail']; ?></p>
                                    <p class="card-text text-harga fw-bold">Rp. <?= $produk['harga']; ?></p>
                                    <a href="produk-detail.php?nama=<?= $produk['nama']; ?>" class="btn btn-primary text-white">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>