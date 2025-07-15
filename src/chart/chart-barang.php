<?php
$sql = mysqli_query($conn, "
SELECT b.nama, SUM(td.jumlah) AS total_jumlah
FROM transaksi_detail td
JOIN barang b ON b.id = td.id_barang
GROUP BY b.nama
");

// Simpan ke array
$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($sql)) {
    $labels[] = $row['nama'];
    $data[] = $row['total_jumlah'];
}
?>

<script>
    const options = {
        chart: {
            type: 'bar'
        },
        plotOptions: {
            bar: {
                horizontal: true
            }
        },
        series: [{
            name: 'Total Jumlah',
            data: <?= json_encode($data) ?>,
        }],
        xaxis: {
                categories: <?= json_encode($labels) ?>
            }
    }

    var chart = new ApexCharts(document.querySelector("#chart-barang"), options);

    chart.render();
</script>