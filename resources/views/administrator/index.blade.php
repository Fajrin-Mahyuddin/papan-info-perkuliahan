@extends('layouts.index')

@section('title', 'Administrator :: Home')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="pe-7s-study"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    @if(AdminHelper::getSemester())
                                        <div class="stat-text">{{AdminHelper::getSemester()->tahun_semester}}</div>
                                        <div class="stat-heading">{{AdminHelper::getSemester()->ket}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-2">
                                <i class="pe-7s-server"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{$kelas}}</span></div>
                                    <div class="stat-heading">Jumlah Kelas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-3">
                                <i class="pe-7s-notebook"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{$mk}}</span></div>
                                    <div class="stat-heading">Mata Kuliah</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-4">
                                <i class="pe-7s-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{$dosen}}</span></div>
                                    <div class="stat-heading">Dosen Terdaftar</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Widgets -->
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Selamat Datang {{Auth::user()->data_dosen->nama}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12">
                            <table id="jadwal-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Dosen</th>
                                        <th>Hari</th>
                                        <th>Kelas</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
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
                        <h4 class="box-title">Jadwal yang dipindahkan </h4>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12">
                            <table id="pindah-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Dosen</th>
                                        <th>Kelas</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
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
            ajax        : '{{route("jadwal.daftar.ajax")}}',
            columns     : [
                {data   : 'data_mk.nama',                 name: 'data_mk.nama'   },
                {data   : 'data_dosen.nama',              name: 'data_dosen.nama', defaultContent: '-'},
                {data   : 'hari',                         name: 'hari'},
                {data   : 'data_kelas.nama',              name: 'data_kelas.nama', defaultContent: '-'},
                {data   : 'jam_mulai',                    name: 'jam_mulai' },
                {data   : 'jam_akhir',                    name: 'jam_akhir' },
                {data   : 'status',                       name: 'status'},
            ],
            'rowCallback':function(row, data) {
                if(data.status === '-') {
                    $('td:eq(6)',row).html('<span class="badge badge-primary"><span class="fa fa-check"></span></span>')
                } else {
                    $('td:eq(6)',row).html('<span class="badge badge-primary">'+data.status+'</span>')
                }
            }
        });
        
        $('#pindah-table').DataTable({
            processing  : true,
            serverSide  : true,
            ajax        : '{{route("pindah.jadwal.daftar.ajax")}}',
            columns     : [
                {data   : 'mk',                           name: 'mk'   },
                {data   : 'dosen',                        name: '-'},
                {data   : 'data_kelas.nama',              name: 'data_kelas.nama', defaultContent: '-'},
                {data   : 'jam_mulai_pindah',             name: 'jam_mulai_pindah' },
                {data   : 'jam_akhir_pindah',             name: 'jam_akhir_pindah' },
                {data   : 'tgl_pindah',                   name: 'tgl_pindah' },
                {data   : 'ket',                       name: 'ket' },
            ],
            'rowCallback':function(row, data) {
                if(data.ket === '-') {
                    $('td:eq(6)',row).html('<span class="badge badge-primary"><span class="fa fa-check"></span></span>')
                } else {
                    $('td:eq(6)',row).html('<span class="badge badge-primary">'+data.ket+'</span>')
                }
            }
        });
    });
</script>
@endpush