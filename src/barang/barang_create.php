<?php include '../../connectdb.php'; ?>

<?php
if (isset($_POST['create'])) {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "
        <script>
            alert('Pilih gambar terlebih dahulu!');
            document.location.href = '/library-cafe/barang.php';
        </script>
    ";
        die;
    }

    $extensionFile = ['jpg', 'jpeg', 'png'];
    $format = pathinfo($namaFile, PATHINFO_EXTENSION);

    if (!in_array($format, $extensionFile)) {
        echo "
            <script>
                alert('Yang anda upload bukan gambar!');
                document.location.href = '/library-cafe/barang.php';
            </script>
        ";
        die;
    }

    if ($ukuranFile > 2097152) {
        echo "
            <script>
                alert('Ukuran gambar terlalu besar!');
                document.location.href = '/library-cafe/barang.php';
            </script>
        ";
        die;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $format;

    
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $stok = mysqli_real_escape_string($conn, $_POST['stok']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    
    $sql = "INSERT INTO barang (nama, harga, stok, gambar, keterangan) VALUES ('$nama', '$harga', '$stok', '$namaFileBaru', '$keterangan')";
    move_uploaded_file($tmpName, '../../img/' . $namaFileBaru);

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../barang.php");
        echo "<div class='alert alert-success'>Data berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
