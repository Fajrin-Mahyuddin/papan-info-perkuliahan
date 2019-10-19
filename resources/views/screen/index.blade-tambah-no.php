<!DOCTYPE html>
<html lang="en">
<head>
	<title>Information Board</title>
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
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

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
				<div style="color: white; font-weight: bold; font-size: 20px; ">{{Carbon\Carbon::parse(now())->formatLocalized('%A, %d %B %Y')}}</div>
				<div class="wrap-table100">
					<div class="table jadwal-slide" id="jadwal">
							<div class="row header">
								<div class="cell">
									No
								</div>
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
					<div class="table jadwal-next" id="next-jadwal" style="display:none">
							<div class="row header">
								<div class="cell">
									No
								</div>
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

					<div class="table pindah-slide" id="pindah-jadwal" style="display:none">
							<div class="row header">
								<div class="cell">
									No
								</div>
								<div class="cell">
									Mata Kuliah Pindah
								</div>
								<div class="cell">
									Dari Ruangan
								</div>
								<div class="cell">
									Ke Ruangan
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
					</div> 
					<!--Table -->
					
					<!-- contoh -->
				
				</div>
				<hr>
					<div id="status-kelas">
						@foreach($kelass as $kelas)
							<span class="badge {{$kelas->kode}} {{($kelas->status == 'aktif') ? 'badge-success':'badge-danger'}}" data-kode="{{$kelas->kode}}">{{$kelas->nama}}</span>
						@endforeach
						</div>
					<br>
			</div> <!--batas col md 12-->
				<div class="text-berjalan">
					<marquee behavior="scrool" direction="left" class="info">
						@foreach($informasi as $info)
							<span class="{{$info->id_informasi}}" data-id="{{$info->id_informasi}}">{{$info->judul}} - {{$info->isi_informasi}} <i class="fa fa-circle"></i></span>
						@endforeach
					</marquee>
				</div>
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
	<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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

			function addElementHtml(value, index) {
				var warna;
				if(value.data_dosen.status == 'nonAktif') { warna = 'nonAktif' }else{ warna = 'aktif' }

				return `<div class="cell no" data-title="Full Name">
									`+index+`
								</div>
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
								<span data-id="`+value.id_dosen+`" class="`+value.id_dosen+` fa fa-circle `+warna+`"></span> `+value.data_dosen.nama+`
								</div>
								<div class="cell" data-title="Location" style="color: #e84118">
									`+value.status.toUpperCase()+`
								</div>`;
			}

			function addElementPindah(value, option = null, index) {
				var warna;
				if(value.data_dosen.status == 'nonAktif') { warna = 'nonAktif' }else{ warna = 'aktif' }
		
				return `<div class="cell no_pindah" data-title="Full Name">
									`+index+`
								</div>
								<div class="cell" data-title="Full Name">
									`+value.data_mk.nama+`
								</div>
								<div class="cell" data-title="Age">
								`+value.data_kelas.nama+`
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
						var no = index + 1;
						if(index < 20) {
						$('#jadwal').append(`
							<div class="row `+value.id_jadwal+`" data-id="`+value.id_jadwal+`" data-no="`+index+`">
								`+addElementHtml(value, no)+`
							</div>
						`);
						} else {
							$('#next-jadwal').append(`
							<div class="row `+value.id_jadwal+`" data-id="`+value.id_jadwal+`" data-no="`+index+`">
								`+addElementHtml(value, no)+`
							</div>
						`);
						}
					});
				}
			});

			$.ajax({
				dataType		: 'json',
				type				: 'GET',
				url					: '{{route("screen.jadwal.pindah")}}',
				success: function(response) {
					$.each(response, function(index, value) {
						var index = index + 1;
						$('#pindah-jadwal').append(`
							<div class="row `+value.kode_pindah+`" data-id="`+value.kode_pindah+`">
								`+addElementPindah(value.data_jadwal, value, index)+`
							</div>
						`);
					});
				}
			});
			
		
			show_jadwal();

			function show_jadwal() {
				setTimeout(() => {
					$('.jadwal-slide').hide('slow', function() {
						$('.jadwal-next').show('slow', show_next);
					});
				}, 9000);
			}

			function show_next() {
				setTimeout(() => {
					$('.jadwal-next').hide('slow', function() {
						$('.pindah-slide').show('slow', show_pindah);
					});
				}, 9000);
			}

			function show_pindah() {
				setTimeout(() => {
					$('.pindah-slide').hide('slow', function() {
						$('.jadwal-slide').show('slow', show_jadwal);
					});
				}, 9000);
			}

			// Pusher

			Pusher.logToConsole = true;

			var pusher = new Pusher('1670cfe8b56094b466a8', {
				cluster: 'ap1',
				encrypted: true
			});

			var change = pusher.subscribe('channel-jadwal');
			change.bind('event-jadwal', function(response) {
				var id = $('.'+response.data.id_jadwal).data('id');
				var newNo = $('.'+response.data.id_jadwal).data('no');
				if(id) {
					$('.'+id).html(addElementHtml(response.data, newNo));
				} else {
						var no = $('.no').last().html();
						no++;
						$('#next-jadwal').append(`
							<div class="row `+response.data.id_jadwal+`" data-id="`+response.data.id_jadwal+`">
									`+addElementHtml(response.data, no)+`
							</div>
						`);
				}
			});

			var pindah = pusher.subscribe('channel-pindah');
			pindah.bind('event-pindah', function(response) {
				var id = $('.'+response.data.kode_pindah).data('id');
				if(id) {
					$('.'+id).html(addElementPindah(response.data.data_jadwal, response.data));
				} else {
					var no = $('.no-pindah').last().html();
					no++;
						$('#pindah-jadwal').append(`
							<div class="row `+response.data.kode_pindah+`" data-id="`+response.data.kode_pindah+`">
									`+addElementPindah(response.data.data_jadwal, response.data, no)+`
							</div>
						`);
				}
				
			});

			var status = pusher.subscribe('channel-status');
			status.bind('event-status', function(response) {
			
				if(response.data.tipe === 'dosen') {
					var dosen = $('.cell > .'+response.data.dosen.id_dosen).data('id');
					if(dosen && (response.data.dosen.status == 'aktif')) {
						$('.cell > .'+dosen).removeClass('nonAktif');
						$('.cell > .'+dosen).addClass('aktif');
					} else {
						$('.cell > .'+dosen).removeClass('aktif');
						$('.cell > .'+dosen).addClass('nonAktif');
					}
				} else if(response.data.tipe === 'kelas') {
					var kelas = $('#status-kelas > .'+response.data.kelas.kode).data('kode');
					if(kelas && (response.data.kelas.status == 'aktif')) {
						$('#status-kelas > .'+kelas).removeClass('badge-danger');
						$('#status-kelas > .'+kelas).addClass('badge-success');
					} else {
						$('#status-kelas > .'+kelas).removeClass('badge-success');
						$('#status-kelas > .'+kelas).addClass('badge-danger');
					}
				}
			});

			var info = pusher.subscribe('channel-info');
			info.bind('event-info', function(response) {
					
				if(response.data.tipe === 'ubah') {
					var id = $('.info > span.'+response.data.info.id_informasi).data('id');
					if(id) {
						$('.info > span.'+response.data.info.id_informasi).html(response.data.info.judul+' - '+response.data.info.isi_informasi+' <i class="fa fa-circle"></i>');
					} else {
						$('.info').append(`<span class="`+response.data.info.id_informasi+`" data-id=="`+response.data.info.id_informasi+`">`+response.data.info.judul+` - `+response.data.info.isi_informasi+` <i class="fa fa-circle"></i></span>`);
					}
				} else {
					$('.info > span.'+response.data.info).remove();
				}
			});
			
			var hapus = pusher.subscribe('channel-hapus');
			hapus.bind('event-hapus', function(response) {
					$('.'+response.data).remove();
			});


			

		});
	</script>

</body>
</html>