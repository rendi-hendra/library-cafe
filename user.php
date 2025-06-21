<?php include 'connectdb.php'; ?>
<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);
?>

<?php include 'layout/header.php'; ?>

<body>
    <?php include 'layout/layout.php'; ?>
    <div class="container mt-5">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $no = 1;
            echo "<table class='table table-bordered text-center'>";
            echo "<thead class='table-dark'><tr><th>No</th><th>Nama</th><th>email</th></th><th>Aksi</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
            <td>$no</td>
            <td>" . $row['nama'] . "</td>
            <td>" . $row['email'] . "</td>
            <td>
                <a href='user_form.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                <button class='btn btn-danger btn-delete btn-sm' data-id=" . $row['id'] . ">Hapus</button>
            </td>
        </tr>";
            $no++;
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>Tidak ada data.</div>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const userId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Yakin mau hapus?',
                    text: "Data akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `src/user/user_delete.php?id=${userId}`;
                    }
                });
            });
        });
    </script>
</body>