<head>
	<link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
</head>
<?php

include('config.php');
include('fungsi.php');


// menghitung perangkingan
$jmlKriteria 	= getJumlahKriteria();
$jmlAlternatif	= getJumlahAlternatif();
$nilai			= array();

// mendapatkan nilai tiap alternatif
for ($x=0; $x <= ($jmlAlternatif-1); $x++) {
	// inisialisasi
	$nilai[$x] = 0;

	for ($y=0; $y <= ($jmlKriteria-1); $y++) {
		$id_alternatif 	= getAlternatifID($x);
		$id_kriteria	= getKriteriaID($y);

		$pv_alternatif	= getAlternatifPV($id_alternatif,$id_kriteria);
		$pv_kriteria	= getKriteriaPV($id_kriteria);

		$nilai[$x]	 	+= ($pv_alternatif * $pv_kriteria);
	}
}

// update nilai ranking
for ($i=0; $i <= ($jmlAlternatif-1); $i++) { 
	$id_alternatif = getAlternatifID($i);
	$query = "INSERT INTO ranking VALUES ($id_alternatif,$nilai[$i]) ON DUPLICATE KEY UPDATE nilai=$nilai[$i]";
	$result = mysqli_query($koneksi,$query);
	if (!$result) {
		echo "Gagal mengupdate ranking";
		exit();
	}
}

include('navbar.php');

?>

<section class="content container mt-5">
	<h2 class="ui header">Perangkingan</h2>
	<section class="ranking">
		<table class="ui celled blue table">
			<thead>
				<tr>
					<th style="width:100px;">Peringkat</th>
					<th>Alternatif</th>
					<th>Nilai</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$keterangan[0] = "Dibandingkan dengan alternatif lain, Iphone memiliki kekurangan pada harga yang mahal namun memiliki kelebihan pada sistem operasi, spesifikasi, purna jual dan fitur tambahan sehingga menempatkannya pada ranking";
					$keterangan[1] = "Dibandingkan dengan alternatif lain, Samsung memiliki kekurangan pada harga yang mahal, sistem operasi, purna jual dan fitur tambahan namun memiliki kelebihan pada spesifikasi sehingga menempatkannya pada ranking";
					$keterangan[2] = "Dibandingkan dengan alternatif lain, Oppo memiliki kekurangan pada spesifikasi, harganya yang mahal, sistem operasi,  dan fitur tambahan namun memiliki kelebihan pada purna jual sehingga menempatkannya pada ranking";
					$keterangan[3] = "Dibandingkan dengan alternatif lain, Vivo memiliki kekurangan pada harganya yang mahal, spesifikasi, purna jual dan fitur tambahan namun memiliki kelebihan pada sistem operasi sehingga menempatkannya pada ranking";
					$keterangan[4] = "Dibandingkan dengan alternatif lain, Xiaomi memiliki kekurangan pada harganya yang mahal namun memiliki kelebihan pada sistem operasi, spesifikasi, purna jual dan fitur tambahan sehingga menempatkannya pada ranking";

					$query  = "SELECT id,nama,id_alternatif,nilai FROM alternatif,ranking WHERE alternatif.id = ranking.id_alternatif ORDER BY nilai DESC";
					$result = mysqli_query($koneksi, $query);

					$i = 0;
					while ($row = mysqli_fetch_array($result)) {
						$i++;
						$labels[] = $row['nama'];
						$data[] = (round($row['nilai'], 2)/1) *100;
					?>
					<tr>
						<?php if ($i == 1) {
							echo "<td><div>1</div></td>";
						} else {
							echo "<td>".$i."</td>";
						}
						// var_dump($keterangan)
						?>

						<td><?php echo $row['nama'] ?></td>
						<td><?php echo round($row['nilai'],2) ?></td>
						<td><?php echo $keterangan[$i-1]." ".$i ?></td>
					</tr>

					<?php	
					}
					$chartData = json_encode(['labels' => $labels, 'data' => $data]);
				?>
			</tbody>
		</table>

		<div class="canvas-chart">
			<h5>Chart Perangkingan</h5>
			<canvas id="myChart"></canvas>
		</div>
	</section>
</section>

<script>
        async function fetchChartData() {
			const data = <?php echo $chartData; ?>;
			const chartData = {
                labels: data?.labels,
                datasets: [{
                    data: data?.data,
                    borderWidth: 1
                }]
            };
            const ctx = document.getElementById('myChart').getContext('2d');
			
            const myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartData.labels,
                    datasets: chartData.datasets
                },
                options: {
					plugins: {
						legend: {
							display: false
						},
						tooltip: {
							enabled: false
						},
						datalabels: {
							color: 'black',
							formatter: function (value, context) {
								return context.chart.data.labels[context.dataIndex] +' '+context.dataset.data[context.dataIndex].toFixed(0)+"%";
							},
						},
					},
					
                },
				plugins: [ChartDataLabels]
            });
        }

        fetchChartData();
    </script>