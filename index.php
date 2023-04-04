<?php
require "koneksi.php";
$queryProduk = mysqli_query($conn, "SELECT id, nama, harga, foto, detail from produk limit 6");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | toLine</title>

    <link rel="stylesheet" href="css/style.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1 class="fw-bold">toLine</h1>
            <h3>Mau cari apa?</h3>
            <div class="col-md-8 offset-md-2">
                <form action="produk.php" method="get">
                    <div class="input-group my-4">
                        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Masukan Nama Barang" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn text-white btn-primary">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- highlighted kategori -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori Populer</h3>

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-camera d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=kamera">Kamera</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-baju d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=baju">Baju</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-sepatu d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=sepatu">Sepatu</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- tentang kami -->
    <div class="container-fluid warna4 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius corporis voluptates enim sit quos? Eius corrupti in consequuntur doloremque ullam quidem non ducimus numquam est reprehenderit nesciunt suscipit, laborum quaerat, dolorum aperiam. In quis aut aliquid odio praesentium, quibusdam dignissimos quos aperiam dicta ab earum, officiis, deserunt accusantium vero delectus illum voluptate. Impedit, labore soluta quaerat eligendi debitis odio molestiae. Nulla repellat doloremque officia suscipit iusto eveniet ullam autem, veritatis excepturi eligendi placeat eos sapiente quibusdam maiores sequi nihil qui.</p>
        </div>
    </div>

    <!-- produk -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>

            <div class="row mt-5">
                <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="img-box">
                                <img src="img/<?= $data['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $data['nama']; ?></h5>
                                <p class="card-text text-truncate"><?= $data['detail']; ?></p>
                                <p class="card-text text-harga fw-bold"><?= $data['harga']; ?></p>
                                <a href="produk-detail.php?nama=<?= $data['nama']; ?>" class="btn btn-primary text-white">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a href="produk.php" class="btn btn-outline-primary mt-3 px-3 py-2">Lihat Selebihnya</a>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>