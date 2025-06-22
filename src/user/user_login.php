<?php include '../../connectdb.php'; ?>

<?php
session_start();

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row['id'];
            if ($row['role'] === 'admin') {
                $_SESSION["admin"] = true;
            }
            header("Location: ../../barang.php");
            exit;
        } else {
            echo "
                <script>
                    alert('Email Atau Password Anda Salah!');
                    document.location.href = '/library-cafe/login.php';
                </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Email Atau Password Anda Salah!');
            document.location.href = '/library-cafe/login.php';
        </script>
    ";
    }
}
