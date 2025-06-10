<?php include 'connectdb.php'; ?>
<?php include 'layout/header.php'; ?>

<body>
    <?php include 'layout/layout.php'; ?>

    <div class="container mt-4">
        <h2>Library Cafe Login</h2>
        <form method="POST" action="src/user/user_login.php">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
            <!-- <a href="index.php" class="btn btn-secondary">Kembali</a> -->
        </form>
    </div>
</body>
</html>