<?php
require "koneksi.php";

$nama = htmlspecialchars($_GET['nama']);
$queryProduk = mysqli_query($conn, "SELECT * from produk where nama='$nama'");
$produk = mysqli_fetch_array($queryProduk);

$queryProdukTerkait = mysqli_query($conn, "SELECT * from produk where kategori_id='$produk[kategori_id]' and !id='$produk[id]' limit 4");
$produkTerkait = mysqli_fetch_array($queryProdukTerkait);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk | toLine</title>

    <link rel="stylesheet" href="css/style.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- detail produk -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <img src="img/<?= $produk['foto']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-md-1">
                    <h1><?= $produk['nama']; ?></h1>
                    <p><?= $produk['detail']; ?></p>
                    <p class="fs-4 text-warna">Rp <?= $produk['harga']; ?></p>
                    <p class="fs-5">Status Ketersediaan : <b><?= $produk['ketersediaan_stok']; ?></b></p>
                </div>
            </div>
        </div>
    </div>

    <!-- produk terkait
    <div class="container-fluid py-5 warna3">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>

            <div class="row">
                <?php while ($data = mysqli_fetch_array($queryProdukTerkait)) { ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="produk-detail.php?nama=<?= $data['nama']; ?>">
                            <img src="img/<?= $data['foto']; ?>" class="img-fluid img-thumbnail produk-terkait-img" alt="">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div> -->

    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>