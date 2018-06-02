<?php 
include"koneksi.php";

@$cek=$_POST['cek'];
$nisn=$_POST['nisn'];
$mtk=$_POST['matematika'];
$fisika=$_POST['fisika'];
$biologi=$_POST['biologi'];
$sejarah=$_POST['sejarah'];
$geografi=$_POST['geografi'];
$bi=$_POST['bi'];

if ($cek=='y') {
	$nilai_ipa=($mtk+$fisika+$biologi);
	$nilai_ips=($bi+$sejarah+$geografi);
	
	$nilai_total=$nilai_ipa+$nilai_ips;

	$persen_ipa=(($nilai_ipa/$nilai_total)*100);
	$persen_ips=(($nilai_ips/$nilai_total)*100);

	if ($nilai_ipa>$nilai_ips) {
		$kata="IPA";
	}else if($nilai_ipa<$nilai_ips){
		$kata="IPS";
	}else{
		$kata="Keduannya";
	}

	include"koneksi.php";
	$tanggal=date('Y-m-d');
	mysqli_query($konek,"INSERT INTO `nilai`( `mtk`, `biologi`, `fisika`, `sejarah`, `geografi`, `bi`, `jurusan`, `tanggal`, `nisn`) 
		VALUES($mtk,
			   $biologi,
			   $fisika,
			   $sejarah,
			   $geografi,
			   $bi,
			   '$kata',
			   '$tanggal',
			   '$nisn')");

}else{
	echo "<script type='text/javascript'>alert('Centang Dulu Sebelum Lanjut');</script>";
	echo "<meta http-equiv='refresh' content='0; URL=http://localhost/SPK-penentu_jurusan/index.php?halaman=input_nilai&nisn=$nisn'/>";

}
?>
<div class="container">
	<div class="col-sm-6">
	Input nilai pada tanggal:<?php echo $tanggal ?>
		<div class="panel panel-info" style="margin-top:20px">
			<div class="panel-heading">Nilai IPA</div>
			<div class="panel-body">
				<table>
					<tr>
						<td>Matematika</td>
						<td>:<?php echo  $mtk;?></td>
					</tr>
					<tr>
						<td>Fisika</td>
						<td>:<?php echo  $fisika;?></td>
					</tr>
					<tr>
						<td>Biologi</td>
						<td>:<?php echo  $biologi;?></td>
					</tr>
					<tr>
						<td>Hasil</td>
						<td>:<?php echo $persen_ipa."%"; ?></td>
					</tr>
				</table>
			</div>
		</div>

		<!-- IPS -->
		<div class="panel panel-info">
			<div class="panel-heading">Nilai IPS</div>
			<div class="panel-body">
				<table>
					<tr>
						<td>Sejarah</td>
						<td>:<?php echo  $sejarah;?></td>
					</tr>
					<tr>
						<td>Geografi</td>
						<td>:<?php echo  $geografi;?></td>
					</tr>
					<tr>
						<td>bahasa Indonesia</td>
						<td>:<?php echo  $bi;?></td>
					</tr>
					<tr>
						<td>Hasil</td>
						<td>:<?php echo $persen_ips."%"; ?></td>
					</tr>
				</table>
			</div>
		</div>
		<!-- hasil -->
		<div class="panel panel-info">
			<div class="panel-body">
				Menurut Kami Anda Disarankan dan Berpeluang Di <?php echo " ".$kata; ?><br/>
				<ul>
					<li>Persentase Di Jurusan IPA:<?php echo $persen_ipa."%"; ?></li>
					<li>Persentase Di Jurusan IPS:<?php echo $persen_ips."%"; ?></li>
					<li>Selisih Presentase       :<?php echo abs($persen_ipa-$persen_ips)."%"; ?></li>
				</ul>
			</div>
		</div>
		Ada yang salah?..<a href="index.php?halaman=input_nilai&nisn=<?php echo $nisn ?>" class="label label-danger">Masukkan Ulang nilai</a>
	</div>
	<div class="col-sm-6">
	<canvas id="myChart"></canvas>
		<script type="text/javascript">
			var ctx = document.getElementById('myChart').getContext('2d');
			var chart = new Chart(ctx, {
    		// The type of chart we want to create
    		type:'bar',

    		// The data for our dataset
    		data: {
        	labels: ["Biologi", "Fisika", "Matematika", "Sejarah", "Geografi", "B.Indonesia"],
	        datasets: [{
	            label: "nilai",
	            backgroundColor: 'rgb(255, 99, 132)',
	            borderColor: 'rgb(255, 99, 132)',
	            data: [<?php echo $biologi ?>, <?php echo $fisika ?>, <?php echo $mtk ?>, 
	            <?php echo $sejarah ?>, <?php echo $geografi ?>, <?php echo $bi ?>],
	        }]
	    	},

	   		 // Configuration options go here
	   	 	options: {}
			});
		</script>
		<hr></hr>
		<canvas id="jurusan"></canvas>
		<script type="text/javascript">
			var ctx = document.getElementById('jurusan').getContext('2d');
			var chart = new Chart(ctx, {
    		// The type of chart we want to create
    		type: 'bar',

    		// The data for our dataset
    		data: {
        	labels: ["IPA","IPS"],
	        datasets: [{
	            label: "Perbandingan",
	            backgroundColor: ['rgb(0, 255, 255)','rgb(54, 162, 235)'],
	            borderColor: 'rgb(255, 99, 132)',
	            data: [<?php echo $persen_ipa ?>,<?php echo $persen_ips; ?>],
	        }]
	    	},

	   		 // Configuration options go here
	   	 	options: {}
			});
		</script>
	</div>
</div>
