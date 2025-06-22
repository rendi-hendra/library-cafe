<?php
include '../../connectdb.php';

function alertAndRedirect($message)
{
    echo "<script>
        alert('$message');
        document.location.href = '/library-cafe/barang.php';
    </script>";
    exit;
}

function validateAndUploadImage()
{
    $file = $_FILES['gambar'];

    if ($file['error'] === 4) {
        alertAndRedirect('Pilih gambar terlebih dahulu!');
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExtensions)) {
        alertAndRedirect('Yang anda upload bukan gambar!');
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        alertAndRedirect('Ukuran gambar terlalu besar!');
    }

    $newName = uniqid() . '.' . $ext;
    move_uploaded_file($file['tmp_name'], '../../img/' . $newName);

    return $newName;
}

if (isset($_POST['create'])) {
    $gambar = validateAndUploadImage();

    // Menghindari SQL injection
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga      = mysqli_real_escape_string($conn, $_POST['harga']);
    $stok       = mysqli_real_escape_string($conn, $_POST['stok']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "INSERT INTO barang (nama, harga, stok, gambar, keterangan) 
            VALUES ('$nama', '$harga', '$stok', '$gambar', '$keterangan')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../barang.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
