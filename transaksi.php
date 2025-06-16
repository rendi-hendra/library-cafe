<?php include 'connectdb.php'; ?>
<?php 
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
?>
<?php include 'layout/header.php'; ?>

<body>
    <?php include 'layout/layout.php'; ?>
    <h1>Transaksi</h1>
</body>