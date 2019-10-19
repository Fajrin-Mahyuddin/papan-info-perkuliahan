@extends('layouts.index')

@section('title', 'Mhs :: Home')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row">
             <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="box-title">Status mengajar hari ini - {{Carbon\Carbon::parse(now())->isoFormat('dddd, DD MMMM YYYY')}} </h4>
                    </div>
                    <div class="card-content mt-3">
                        <div class="col-lg-12 col-md-12 text-center">
                            <h4>{{Auth::user()->data_dosen->nama}} - status : 
                                <span class="badge status {{(Auth::user()->data_dosen->status === 'aktif') ? 'badge-success' : 'badge-dark'}}">{{Auth::user()->data_dosen->status}}</span>
                            </h4> 
                            <hr>
                            <a href="{{url('dosen/generate/status')}}" class="btn-primary btn btn-lg"><span class="fa fa-repeat"></span> Generate</a>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!-- /Widgets -->

        <!--  Traffic 3 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Jadwal mengajar hari ini</h4>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12">
                            <table id="jadwal-today" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Ruangan</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>status</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic 3-->

         <!--  Traffic 2 -->
         <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Jadwal mengajar yang dipindahkan hari ini</h4>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12">
                            <table id="pindah-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Ruangan</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic 2-->

        <div class="clearfix"></div>
        
    </div>
    <!-- .animated -->
</div>


@endsection

@push('script')
<script>
    // jQuery(document).ready(function($) {
        
    //     $('#jadwal-today').DataTable({
    //         processing  : true,
    //         serverSide  : true,
    //         ajax        : '{{route("dosen.jadwal.daftar.today")}}',
    //         columns     : [
    //             {data   : 'data_mk.nama',       name: 'data_mk.nama'   },
    //             {data   : 'data_kelas.nama',    name: 'data_kelas.nama', defaultContent: '-'},
    //             {data   : 'jam_mulai',          name: 'jam_mulai' },
    //             {data   : 'jam_akhir',          name: 'jam_akhir' },
    //             {data   : 'status',             name: 'status'},
    //             {data   : 'aksi',               name: 'aksi'},
    //         ],
    //         "rowCallback": function( row, data ) {
    //             if ( data.status == "-") {
    //                $('td:eq(4)', row).html('<span class="badge badge-primary"><span class="fa fa-check"></span></span>');
    //             } else {
    //                $('td:eq(4)', row).html('<span class="badge badge-primary"><span class="fa fa-check"></span> '+data.status+'</span>');
    //             }
  	//         }
    //     });
        
    //     $('#pindah-table').DataTable({
    //         processing  : true,
    //         serverSide  : true,
    //         ajax        : '{{route("dosen.pindah.jadwal.daftar.today")}}',
    //         columns     : [
            
    //             {data   : 'data_jadwal.data_mk.nama',   name: 'data_jadwal.data_mk.nama'   },
    //             {data   : 'data_kelas.nama',            name: 'data_kelas.nama', defaultContent: '-'},
    //             {data   : 'jam_mulai_pindah',           name: 'jam_mulai_pindah' },
    //             {data   : 'jam_akhir_pindah',           name: 'jam_akhir_pindah' },
    //             {data   : 'ket',                        name: 'ket'},
    //             {data   : 'aksi',                       name: 'aksi'},
    //         ],
    //         "rowCallback": function( row, data ) {
    //             if ( data.ket == "-") {
    //                $('td:eq(4)', row).html('<span class="badge badge-primary"><span class="fa fa-check"></span></span>');
    //             } else {
    //                $('td:eq(4)', row).html('<span class="badge badge-primary"><span class="fa fa-check"></span> '+data.ket+'</span>');
    //             }
  	//         }
    //     });

    //     $('#generate').on('click', function() {
    //         var status = "";
    //         $.ajax({
    //             dataType: 'json',
    //             type    : 'post',
    //             url     : 'dosen/generate/status',
    //             data    :{ 
    //                 status : status,
    //             },
    //             success: function(response) {
    //                 if(response.data === 'aktif') {
    //                     $('span.status').removeClass('badge-dark');
    //                     $('span.status').addClass('badge-success');
    //                 } else{
    //                     $('span.status').removeClass('badge-success');
    //                     $('span.status').addClass('badge-dark');
    //                 }
    //                 $('span.status').html(response.data);
    //             }
    //         });
    //     });

    // });
</script>
@endpush