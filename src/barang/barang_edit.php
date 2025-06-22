<?php
include '../../connectdb.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

function uploadGambar($gambarLama)
{
    if ($_FILES['gambar']['error'] === 4) {
        return $gambarLama;
    }

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    $format = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    if (!in_array($format, $allowed)) {
        alertAndRedirect('Yang anda upload bukan gambar!');
    }

    if ($ukuranFile > 2097152) {
        alertAndRedirect('Ukuran gambar terlalu besar!');
    }

    $namaFileBaru = uniqid() . '.' . $format;
    move_uploaded_file($tmpName, '../../img/' . $namaFileBaru);

    return $namaFileBaru;
}

function alertAndRedirect($message)
{
    echo "<script>
        alert('$message');
        document.location.href = '/library-cafe/barang.php';
    </script>";
    exit;
}

if (isset($_POST['update'])) {
    $id = (int) $_GET['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $keterangan = $_POST['keterangan'];
    $gambarLama = $_POST['gambarLama'];

    $gambar = uploadGambar($gambarLama);

    $sql = "UPDATE barang SET 
                nama = '$nama', 
                harga = '$harga', 
                stok = '$stok', 
                gambar = '$gambar', 
                keterangan = '$keterangan' 
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        if ($gambar !== $gambarLama) {
            @unlink('../../img/' . $gambarLama);
        }
        header("Location: ../../barang.php");
        exit;
    } else {
        echo "Gagal update data!";
    }
}
?>
