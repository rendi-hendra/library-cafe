<?php include '../../connectdb.php'; ?>
<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
?>

<?php
if (isset($_POST['edit'])) {
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $keterangan = $_POST['keterangan'];
    $gambar = $_POST['gambar'];
    $gambarLama = $_POST['gambarLama'];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
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
        $gambar = $namaFileBaru;
    
        move_uploaded_file($tmpName, '../../img/' . $namaFileBaru);    
    }

    $sql = "UPDATE barang SET nama='$nama', harga='$harga', stok='$stok', gambar='$gambar', keterangan='$keterangan' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        unlink('../../img/' . $gambarLama);
        header("Location: ../../barang.php");
    } else {
        echo "gagal";
    }
    exit;
}
?>