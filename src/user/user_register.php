<?php include '../../connectdb.php'; ?>

<?php
if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$hash')";
    if (mysqli_query($conn, $sql)) {
        header("Location: ../../login.php");
        echo "<div class='alert alert-success'>Data berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
