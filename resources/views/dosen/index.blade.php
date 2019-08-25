@extends('layouts.index')

@section('title', 'Dosen :: Home')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row">
             <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="box-title">Kesediaan mengajar hari ini {{\Carbon\Carbon::parse(now())->isoFormat('dddd, DD MMMM YYYY')}} </h4>
                    </div>
                    <div class="card-content mt-3">
                        <div class="col-lg-12 col-md-12 text-center">
                            <h4>{{Auth::user()->data_dosen->nama}} - status : 
                                <span class="badge status {{(Auth::user()->data_dosen->status === 'aktif') ? 'badge-success' : 'badge-dark'}}">{{Auth::user()->data_dosen->status}}</span>
                            </h4> 
                            <hr>
                            <a href="#" id="generate" class="btn-primary btn btn-lg">Generate</a>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!-- /Widgets -->
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Jadwal Mengajar {{Auth::user()->data_dosen->nama}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12">
                            <table id="jadwal-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Hari</th>
                                        <th>Kelas</th>
                                        <th>Jam</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic 1 -->

         <!--  Traffic 2 -->
         <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Jadwal mengajar yang di pindahkan</h4>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12">
                            <table id="pindah-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Jam</th>
                                        <th>Tanggal</th>
                                        <th>status</th>
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
    jQuery(document).ready(function($) {
        
        $('#jadwal-table').DataTable({
            processing  : true,
            serverSide  : true,
            ajax        : '{{route("dosen.jadwal.daftar.ajax")}}',
            columns     : [
                {data   : 'data_mk.nama',                 name: 'data_mk.nama'   },
                {data   : 'hari',                         name: 'hari'},
                {data   : 'data_kelas.nama',              name: 'data_kelas.nama', defaultContent: '-'},
                {data   : 'jam_mulai',                    name: 'jam_mulai' },
                {data   : 'status',                       name: 'status'},
            ]
        });
        
        $('#pindah-table').DataTable({
            processing  : true,
            serverSide  : true,
            ajax        : '{{route("dosen.pindah.jadwal.daftar.ajax")}}',
            columns     : [
                {data   : 'mk',                           name: 'mk'   },
                {data   : 'data_kelas.nama',              name: 'data_kelas.nama', defaultContent: '-'},
                {data   : 'jam_mulai_pindah',             name: 'jam_mulai_pindah' },
                {data   : 'tgl_pindah',                   name: 'tgl_pindah' },
                {data   : 'ket',                       name: 'ket' },
            ]
        });

        $('#generate').on('click', function() {
            var status = "";
            $.ajax({
                dataType: 'json',
                type    : 'post',
                url     : 'dosen/generate/status',
                data    :{ 
                    status : status,
                },
                success: function(response) {
                    if(response.data === 'aktif') {
                        $('span.status').removeClass('badge-dark');
                        $('span.status').addClass('badge-success');
                    } else{
                        $('span.status').removeClass('badge-success');
                        $('span.status').addClass('badge-dark');
                    }
                    $('span.status').html(response.data);
                }
            });
        });

    });
</script>
@endpush