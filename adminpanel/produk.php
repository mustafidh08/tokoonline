<?php
require 'session.php';
require '../koneksi.php';

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori from produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahProduk = mysqli_num_rows($query);

$queryKategori = mysqli_query($conn, "SELECT * from kategori");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Produk</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<style>
    .text-decoration {
        color: white;
        text-decoration: none;
    }
</style>

<body>
    <?php require 'navbar.php'; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="text-decoration text-muted"><i class="bi bi-house-fill"></i> Home </a>
                </li>

                <li class="breadcrumb-item active" aria-current="page"> Produk </li>
            </ol>
        </nav>

        <!-- tambah categori  -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control mt-1" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori" class="mt-3">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control mt-1" required>
                        <option value="">Pilih Satu</option>
                        <?php
                        while ($data = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?= $data['id']; ?>"><?= $data['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga" class="mt-3">Harga</label>
                    <input type="number" class="form-control mt-1" name="harga" required>
                </div>
                <div>
                    <label for="foto" class="mt-3">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control mt-1">
                </div>
                <div>
                    <label for="detail" class="mt-3">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control mt-1"></textarea>
                </div>
                <div>
                    <label for="stok" class="mt-3">Ketersediaan Stok</label>
                    <select name="stok" id="stok" class="form-control mt-1" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="Habis">habis</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-3" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $stok = htmlspecialchars($_POST['stok']);

                $target_dir = "../img/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                if ($nama == '' || $kategori == '' || $harga == '') {
            ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Nama, Kategori dan Harga wajib diisi!
                    </div>
                    <?php
                } else {
                    if ($nama_file != '') {
                        if ($image_size > 500000) {
                    ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File tidak boleh melebihi 500 kb!
                            </div>
                            <?php
                        } else {
                            if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                            ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    File wajib bertipe jpg atau png atau gif!
                                </div>
                    <?php
                            } else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            }
                        }
                    }
                }

                // query insert to produk table
                $queryTambah = mysqli_query($conn, "INSERT into produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) values ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$stok')");

                if ($queryTambah) {
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Produk Berhasil Tersimpan!
                    </div>

                    <meta http-equiv="refresh" content="0; url=produk.php">

            <?php
                } else {
                    mysqli_error($conn);
                }
            }
            ?>
        </div>

        <div class="mt-3">
            <h2>List Produk</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Ketersediaan Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahProduk == 0) {
                        ?>
                            <tr>
                                <td colspan="6" class="text-center">Data Produk tidak tersedia</td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?= $jumlah; ?></td>
                                    <td><?= $data['nama']; ?></td>
                                    <td><?= $data['nama_kategori']; ?></td>
                                    <td><?= $data['harga']; ?></td>
                                    <td><?= $data['ketersediaan_stok']; ?></td>
                                    <td>
                                        <a href="produk-detail.php?p=<?= $data['id']; ?>" class="btn btn-info"><i class="bi bi-search"></i></a>
                                    </td>
                                </tr>
                        <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>