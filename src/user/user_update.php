<?php include '../../connectdb.php'; ?>

<?php
if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    $sql = "UPDATE user SET nama='$nama', email='$email' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../user.php");
    } else {
        echo "gagal";
    }
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>