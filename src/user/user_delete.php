<?php
include '../../connectdb.php';
$id = $_GET['id'];
$sql = "DELETE FROM user WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    echo "Data berhasil dihapus.";
    header("Location: ../../user.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
