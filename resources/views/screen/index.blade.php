<!DOCTYPE html>
<html lang="en">
<head>
	<title>Table V02</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{asset('frontStyle/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('frontStyle/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('frontStyle/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<!-- <link rel="stylesheet" type="text/css" href="{{asset('frontStyle/vendor/animate/animate.css')}}"> -->
<!--===============================================================================================-->
	<!-- <link rel="stylesheet" type="text/css" href="{{asset('frontStyle/vendor/select2/select2.min.css')}}"> -->
<!--===============================================================================================-->
	<!-- <link rel="stylesheet" type="text/css" href="{{asset('frontStyle/vendor/perfect-scrollbar/perfect-scrollbar.css')}}"> -->
<!--===============================================================================================-->
	<!-- <link rel="stylesheet" type="text/css" href="frontStyle/css/util.css"> -->
	<link rel="stylesheet" type="text/css" href="{{asset('frontStyle/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
	
		<div class="container-table100">
			
			<div class="col-md-12">
				<div id="title">
					<span>Jadwal Kuliah S1 Teknik Elektro {{AdminHelper::getSemester()->tahun_semester}} - {{AdminHelper::getSemester()->ket}}</span>
				</div>
				<div class="wrap-table100">
					<div class="pull-right" style="color: white; font-weight: bold; font-size: 20px; ">Senin, 23 Agustus 2019</div>
					<div class="table" id="jadwal">

							<div class="row header">
								<div class="cell">
									Mata Kuliah
								</div>
								<div class="cell">
									Kode MK
								</div>
								<div class="cell">
									Ruangan
								</div>
								<div class="cell">
									Mulai Jam
								</div>
								<div class="cell">
									Berakhir Jam
								</div>
								<div class="cell">
									Dosen
								</div>
								<div class="cell">
									Keterangan
								</div>
							</div>
	
					</div> <!--Table -->

					<!-- contoh -->

					<div class="table" id="pindah-jadwal" style="display:none">

							<div class="row header">
								<div class="cell">
									Mata Kuliah
								</div>
								<div class="cell">
									Kode MK
								</div>
								<div class="cell">
									Ruangan
								</div>
								<div class="cell">
									Mulai Jam
								</div>
								<div class="cell">
									Berakhir Jam
								</div>
								<div class="cell">
									Dosen
								</div>
								<div class="cell">
									Keterangan
								</div>
							</div>
						
					</div> <!--Table -->

					<!-- contoh -->

				</div>
			</div> <!--batas col md 12-->
		</div>
	</div>


	

<!--===============================================================================================-->	
	<script src="{{asset('frontStyle/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('frontStyle/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('frontStyle/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="https://js.pusher.com/5.0/pusher.min.js"></script>

<!--===============================================================================================-->
	<!-- <script src="frontStyle/vendor/select2/select2.min.js"></script> -->
<!--===============================================================================================-->
	<script src="{{asset('frontStyle/js/main.js')}}"></script>

	<script>
		$(document).ready(function() {
			function capitalize(data) {
            return data.charAt(0).toUpperCase() + data.slice(1)
			}
				
			$.ajax({
				dataType		: 'json',
				type				: 'GET',
				url					: '{{route("screen.jadwal")}}',
				success: function(response) {
					$.each(response, function(index, value) {
						$('#jadwal').append(`
								<div class="row `+value.id_jadwal+`">
									<div class="cell" data-title="Full Name">
										`+value.data_mk.nama+`
									</div>
									<div class="cell" data-title="Full Name">
									`+value.data_mk.kode+`
									</div>
									<div class="cell" data-title="Age">
									`+value.data_kelas.nama+`
									</div>
									<div class="cell" data-title="Location">
									`+value.jam_mulai+`
									</div>
									<div class="cell" data-title="Location">
									`+value.jam_akhir+`
									</div>
									<div class="cell">
										<span class="fa fa-circle" style="color: #e84118"></span> `+value.data_dosen.nama+`
									</div>
									<div class="cell" data-title="Location" style="color: #e84118">
										`+value.status.toUpperCase()+`
									</div>
								</div>
						`);
					});
				}
			});

			$.ajax({
				dataType		: 'json',
				type				: 'GET',
				url					: '{{route("screen.jadwal.pindah")}}',
				success: function(response) {
					$.each(response, function(index, value) {
						console.log(value.data_jadwal.data_mk);
						// $('#pindah-jadwal').append(`
						// 		<div class="row `+value.id_jadwal+`">
						// 			<div class="cell" data-title="Full Name">
						// 				`+value.data_mk.nama+`
						// 			</div>
						// 			<div class="cell" data-title="Full Name">
						// 			`+value.data_mk.kode+`
						// 			</div>
						// 			<div class="cell" data-title="Age">
						// 			`+value.data_kelas.nama+`
						// 			</div>
						// 			<div class="cell" data-title="Location">
						// 			`+value.jam_mulai+`
						// 			</div>
						// 			<div class="cell" data-title="Location">
						// 			`+value.jam_akhir+`
						// 			</div>
						// 			<div class="cell">
						// 				<span class="fa fa-circle" style="color: #e84118"></span> `+value.data_dosen.nama+`
						// 			</div>
						// 			<div class="cell" data-title="Location" style="color: #e84118">
						// 				`+value.status.toUpperCase()+`
						// 			</div>
						// 		</div>
						// `);
					});
				}
			});

			// show_jadwal();

			// function show_jadwal() {
			// 	setTimeout(() => {
			// 		$('#jadwal').toggle('slow', function() {
			// 			$('#pindah-jadwal').toggle('slow', show_pindah);
			// 		});
			// 	}, 6000);
			// }

			// function show_pindah() {
			// 	setTimeout(() => {
			// 		$('#pindah-jadwal').toggle('slow', function() {
			// 			$('#jadwal').toggle('slow', show_jadwal);
			// 		});
			// 	}, 6000);
			// }

			// Pusher

			Pusher.logToConsole = true;

			var pusher = new Pusher('1670cfe8b56094b466a8', {
				cluster: 'ap1',
				encrypted: true
			});

			var change = pusher.subscribe('channel-jadwal');
			change.bind('event-jadwal', function(response) {
				console.log(response.data);
				$('#jadwal').append(`
								<div class="row `+response.data.id_jadwal+`">
									<div class="cell" data-title="Full Name">
										`+response.data.data_mk.nama+`
									</div>
									<div class="cell" data-title="Full Name">
									`+response.data.data_mk.kode+`
									</div>
									<div class="cell" data-title="Age">
									`+response.data.data_kelas.nama+`
									</div>
									<div class="cell" data-title="Location">
									`+response.data.jam_mulai+`
									</div>
									<div class="cell" data-title="Location">
									`+response.data.jam_akhir+`
									</div>
									<div class="cell">
										<span class="fa fa-circle" style="color: #e84118"></span> `+response.data.data_dosen.nama+`
									</div>
									<div class="cell" data-title="Location" style="color: #e84118">
										`+response.data.status.toUpperCase()+`
									</div>
								</div>
						`);
			});


		});
	</script>

</body>
</html>