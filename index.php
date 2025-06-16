<?php include 'connectdb.php'; ?>
<?php
session_start();

if (isset($_SESSION["login"])) {
    header("Location: user.php");
    exit;
}
?>
<?php include 'layout/header.php'; ?>

<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="./public/draw2.svg"
                        class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <h1 class="text-center">Sign Up</h1>
                    <form method="POST" action="src/user/user_register.php" class="mt-5">
                        <!-- Nama input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-lg" required />
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" required />
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg" required />
                        </div>

                        <!-- Submit button -->
                        <button type="submit" name="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block">Sign up</button>
                    </form>
                    <div>
                        <span>Already have an account? </span>
                        <a href="login.php">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>