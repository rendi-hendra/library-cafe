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
                    <h1 class="text-center">Sign In</h1>
                    <form method="POST" action="src/user/user_login.php" class="mt-5">
                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form1Example13">Email</label>
                            <input type="email" name="email" id="form1Example13" class="form-control form-control-lg" required />
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form1Example23">Password</label>
                            <input type="password" name="password" id="form1Example23" class="form-control form-control-lg" required />
                        </div>

                        <!-- Submit button -->
                        <button type="submit" name="login" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block">Sign in</button>
                    </form>
                    <div>
                        <span>Don't have an account? </span>
                        <a href="index.php">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>