<!DOCTYPE html>
<html lang="en">
<head>
	<title>Table V02</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="72000" />
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
					<div class="pull-right" style="color: white; font-weight: bold; font-size: 20px; ">{{Carbon\Carbon::parse(now())->formatLocalized('%A, %d %B %Y')}}</div>
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
									Masuk
								</div>
								<div class="cell">
									Keluar
								</div>
								<div class="cell">
									Dosen
								</div>
								<div class="cell">
									Status
								</div>
							</div>
	
					</div> <!--Table -->

					<!-- contoh -->
					<br><br>
					<hr>
					<br><br>
					<div class="table" id="pindah-jadwal" >

							<div class="row header">
								<div class="cell">
									Mata Kuliah
								</div>
								<div class="cell">
									Ruangan
								</div>
								<div class="cell">
									Masuk
								</div>
								<div class="cell">
									Keluar
								</div>
								<div class="cell">
									Dosen
								</div>
								<div class="cell">
									Tanggal
								</div>
								<div class="cell">
									Status
								</div>
							</div>
						
					</div> <!--Table -->
					
					<br>
					<hr>
					<div id="status-kelas" class="pull-right">
						@foreach($kelass as $kelas)
							<span class="badge {{($kelas->status == 'aktif') ? 'badge-success':'badge-danger'}}">{{$kelas->nama}}</span>
						@endforeach
						</div>
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
	<script src="{{asset('frontStyle/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('frontStyle/js/moment.js')}}"></script>
	<script src="{{asset('frontStyle/js/moment-with-locales.js')}}"></script>
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

			function addElementHtml(value) {
				var warna;
				if(value.data_dosen.status == 'nonAktif') { warna = 'nonAktif' }else{ warna = 'aktif' }

				return `<div class="cell" data-title="Full Name">
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
								<span data-id="`+value.id_dosen+`" class="`+value.id_dosen+` fa fa-circle `+warna+`"></span> `+value.data_dosen.nama+`
								</div>
								<div class="cell" data-title="Location" style="color: #e84118">
									`+value.status.toUpperCase()+`
								</div>`;
			}

			function addElementPindah(value, option = null) {
				var warna;
				if(value.data_dosen.status == 'nonAktif') { warna = 'nonAktif' }else{ warna = 'aktif' }
		
				return `<div class="cell" data-title="Full Name">
									`+value.data_mk.nama+`
								</div>
								<div class="cell" data-title="Age">
								`+option.data_kelas.nama+`
								</div>
								<div class="cell" data-title="Location">
								`+option.jam_mulai_pindah+`
								</div>
								<div class="cell" data-title="Location">
								`+option.jam_akhir_pindah+`
								</div>
								<div class="cell">
									<span data-id="`+value.id_dosen+`" class="`+value.id_dosen+` fa fa-circle `+warna+`"></span> `+value.data_dosen.nama+`
								</div>
								<div class="cell" style="width:320px">
									`+moment(option.tgl_pindah).locale('id').format("dddd, DD MMMM YYYY")+`
								</div>
								<div class="cell" data-title="Age" style="color: #e84118">
								`+option.ket.toUpperCase()+`
								</div>`;
			}
				
			$.ajax({
				dataType		: 'json',
				type				: 'GET',
				url					: '{{route("screen.jadwal")}}',
				success: function(response) {
						// console.log(response);
					$.each(response, function(index, value) {
						$('#jadwal').append(`
							<div class="row `+value.id_jadwal+`" data-id="`+value.id_jadwal+`">
								`+addElementHtml(value)+`
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
						console.log(response);
					$.each(response, function(index, value) {
						$('#pindah-jadwal').append(`
							<div class="row `+value.id_pindah+`" data-id="`+value.id_pindah+`">
								`+addElementPindah(value.data_jadwal, value)+`
							</div>
						`);
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
				var id = $('.'+response.data.id_jadwal).data('id');
				// console.log(id);
				if(id) {
					$('.'+id).html(addElementHtml(response.data));
				} else {
						$('#jadwal').append(`
							<div class="row `+response.data.id_jadwal+`" data-id="`+response.data.id_jadwal+`">
									`+addElementHtml(response.data)+`
							</div>
						`);
				}
			});

			var status = pusher.subscribe('channel-status');
			status.bind('event-status', function(response) {
				var id = $('.'+response.data.id_dosen).data('id');
				// console.log(id);
				if(id && (response.data.status == 'aktif')) {
					$('.'+id).removeClass('nonAktif');
					$('.'+id).addClass('aktif');
				} else {
					$('.'+id).removeClass('aktif');
					$('.'+id).addClass('nonAktif');
				}
			});

			var pindah = pusher.subscribe('channel-pindah');
			pindah.bind('event-pindah', function(response) {
				console.log(response.data);
				var id = $('.'+response.data.id_pindah).data('id');
				if(id) {
					$('.'+id).html(addElementPindah(response.data.data_jadwal, response.data));
				} else {
						$('#pindah-jadwal').append(`
							<div class="row `+response.data.id_pindah+`" data-id="`+response.data.id_pindah+`">
									`+addElementPindah(response.data.data_jadwal, response.data)+`
							</div>
						`);
				}
				
			});

			var hapus = pusher.subscribe('channel-hapus');
			hapus.bind('event-hapus', function(response) {
				console.log(response.data);
					$('.'+response.data).remove();
			});


			

		});
	</script>

</body>
</html>