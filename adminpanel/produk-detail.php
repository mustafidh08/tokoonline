<?php
require 'session.php';
require '../koneksi.php';

$id = $_GET['p'];

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori from produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
$data = mysqli_fetch_array($query);

$queryKategori = mysqli_query($conn, "SELECT * from kategori where id != '$data[kategori_id]'");

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
    <title>Produk Detail</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <?php require 'navbar.php'; ?>

    <div class="container mt-5">
        <h2>Detail Produk</h2>

        <div class="col-12 col-md-6 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" value="<?= $data['nama']; ?>" name="nama" id="nama" class="form-control mt-1" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori" class="mt-3">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control mt-1" required>
                        <option value="<?= $data['kategori_id']; ?>"><?= $data['nama_kategori']; ?></option>
                        <?php
                        while ($dataKategori = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?= $dataKategori['id']; ?>"><?= $dataKategori['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga" class="mt-3">Harga</label>
                    <input type="number" value="<?= $data['harga']; ?>" class="form-control mt-1" name="harga" required>
                </div>
                <div>
                    <label for="currentFoto" class="mt-3">Foto produk sekarang</label> <br>
                    <img src="../img/<?= $data['foto']; ?>" width="300" alt="">
                </div>
                <div>
                    <label for="foto" class="mt-3">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control mt-1">
                </div>
                <div>
                    <label for="detail" class="mt-3">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control mt-1">
                        <?= $data['detail']; ?>
                    </textarea>
                </div>
                <div>
                    <label for="stok" class="mt-3">Ketersediaan Stok</label>
                    <select name="stok" id="stok" class="form-control mt-1" required>
                        <option value="<?= $data['ketersediaan_stok']; ?>"><?= $data['ketersediaan_stok']; ?></option>
                        <?php
                        if ($data['ketersediaan_stok'] == 'tersedia') {
                        ?>
                            <option value="Habis">habis</option>
                        <?php
                        } else {
                        ?>
                            <option value="tersedia">Tersedia</option>
                        <?php
                        }
                        ?>

                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-3" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger mt-3" name="hapus">Hapus</button>
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
                        File tidak boleh melebihi 500 kb!
                    </div>
                    <?php
                } else {
                    $queryUpdate = mysqli_query($conn, "UPDATE produk set kategori_id = '$kategori', nama = '$nama', harga = '$harga', detail = '$detail', ketersediaan_stok = '$stok' where id = $id");

                    if ($nama_file != '') {
                        if ($image_size > 90000000000000) {
                    ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File tidak boleh melebihi 50000 kb!
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

                                $queryUpdate = mysqli_query($conn, "UPDATE produk set foto = '$new_name' where id = '$id'");

                                if ($queryUpdate) {
                                ?>
                                    <div class="alert alert-primary mt-3" role="alert">
                                        Produk Berhasil Diupdate!
                                    </div>

                                    <meta http-equiv="refresh" content="2; url=produk.php">

                    <?php
                                } else {
                                    mysqli_error($conn);
                                }
                            }
                        }
                    }
                }
            }

            if (isset($_POST['hapus'])) {
                $queryHapus = mysqli_query($conn, "DELETE from produk where id = '$id'");

                if ($queryHapus) {
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Produk Berhasil Dihapus!
                    </div>

                    <meta http-equiv="refresh" content="0; url=produk.php">

            <?php
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>