<?php
include '../../connectdb.php';
session_start();

function redirectWithToast($type, $message)
{
    $_SESSION['toast'] = [
        'type' => $type,
        'message' => $message
    ];
    header("Location: ../../barang.php");
    exit;
}

function validateAndUploadImage()
{
    $file = $_FILES['gambar'];

    if ($file['error'] === 4) {
        redirectWithToast('error', 'Pilih gambar terlebih dahulu!');
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExtensions)) {
        redirectWithToast('error', 'Yang anda upload bukan gambar!');
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        redirectWithToast('error', 'Ukuran gambar terlalu besar!');
    }

    $newName = uniqid() . '.' . $ext;
    move_uploaded_file($file['tmp_name'], '../../img/' . $newName);

    return $newName;
}

if (isset($_POST['create'])) {
    $gambar = validateAndUploadImage();

    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga      = mysqli_real_escape_string($conn, $_POST['harga']);
    $stok       = mysqli_real_escape_string($conn, $_POST['stok']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "INSERT INTO barang (nama, harga, stok, gambar, keterangan) 
            VALUES ('$nama', '$harga', '$stok', '$gambar', '$keterangan')";

    if (mysqli_query($conn, $sql)) {
        redirectWithToast('success', 'Barang berhasil ditambahkan!');
    } else {
        redirectWithToast('error', 'Gagal menambahkan barang!');
    }
}
