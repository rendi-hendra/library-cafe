<?php include 'connectdb.php'; ?>
<?php 
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
?>
<?php include 'layout/header.php'; ?>

<?php
$id = $_GET['id'];
$sql = "SELECT id, nama, email FROM user WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<body>
    <?php include 'layout/layout.php'; ?>
    <div class="container mt-4">
        <h2>Library Cafe Login</h2>
        <form method="POST" action="src/user/user_update.php?id=<?php echo $id; ?>">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?php echo $row['nama'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $row['email'] ?>" required>
            </div>
             <input type="submit" name="update" value="Update" class="btn btn-success">
        </form>
    </div>
</body>

</html>