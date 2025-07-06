<?php
include '../../connectdb.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

function redirectWithToast($type, $message)
{
    $_SESSION['toast'] = [
        'type' => $type,
        'message' => $message
    ];
    header("Location: ../../barang.php");
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
        redirectWithToast('error', 'Yang anda upload bukan gambar!');
    }

    if ($ukuranFile > 2097152) {
        redirectWithToast('error', 'Ukuran gambar terlalu besar!');
    }

    $namaFileBaru = uniqid() . '.' . $format;
    move_uploaded_file($tmpName, '../../img/' . $namaFileBaru);

    return $namaFileBaru;
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
        redirectWithToast('success', 'Barang berhasil diperbarui!');
    } else {
        redirectWithToast('error', 'Gagal memperbarui barang!');
    }
}
