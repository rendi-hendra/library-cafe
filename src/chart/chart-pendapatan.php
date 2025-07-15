<?php
$sql = mysqli_query($conn, "
SELECT DATE(tanggal) AS tanggal, SUM(total) AS total 
FROM transaksi 
GROUP BY DATE(tanggal)
ORDER BY DATE(tanggal)
");

// Simpan ke array
$labels = [];
$totals = [];

while ($row = mysqli_fetch_assoc($sql)) {
    $labels[] = date('j M', strtotime($row['tanggal']));
    $totals[] = (int)$row['total'];
}
?>


<script>
    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + "").replace(",", "").replace(" ", "");
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
            dec = typeof dec_point === "undefined" ? "." : dec_point,
            s = "",
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return "" + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || "").length < prec) {
            s[1] = s[1] || "";
            s[1] += new Array(prec - s[1].length + 1).join("0");
        }
        return s.join(dec);
    }

    const option = {
        chart: {
            height: 300,
            type: 'area'
        },
        series: [{
            name: 'Total Jumlah',
            data: <?= json_encode($totals) ?>,
        }],
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: <?= json_encode($labels) ?>
        },
        yaxis: {
            tickAmount: 4,
            labels: {
                formatter: function(val) {
                    return number_format(val, 0, ',', '.');
                }
            },
            title: {
                text: "Total Pendapatan (Rp)"
            }
        },
        stroke: {
            curve: 'smooth',
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "Rp " + number_format(val, 0, ',', '.');
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return number_format(val, 0, ',', '.');
            }
        }
    }


    var char = new ApexCharts(document.querySelector("#chart-pendapatan"), option);

    char.render();
</script>