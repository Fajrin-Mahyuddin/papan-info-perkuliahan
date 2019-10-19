@extends('layouts.index')

@section('title', 'Absensi :: Daftar')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
            
                <!-- Konten Kedua -->
                <div class="card">
                    <div class="card-header">
                        <strong>Absensi</strong>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12 mt-3">
                            <!-- Content detail -->
                            <div class="alert alert-success collapse" id="status_alert" role="alert"></div>
                            <table id="absensi-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Dosen</th>
                                        <th>Kelas</th>
                                        <th>Mata Kuliah</th>
                                        <th>Jam Masuk</th>
                                        <th>Tanggal</th>
                                        <th>Durasi</th>
                                        <th>Ket</th>
                                    </tr>
                                </thead>
                            </table>
                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
                <!-- Batas Konten Kedua -->

            </div><!-- /# column -->
        </div>
        <!--  /Traffic 1 -->

        <div class="clearfix"></div>
        
    </div>
    <!-- .animated -->
</div>

@endsection

@push('script')
<script>
jQuery(document).ready(function($) {

    $('#absensi-table').DataTable({
        serverSide  : true,
        processing  : true,
        ajax        : '{{route("absensi.daftar.ajaxData")}}',
        columns     : [
            {data  : 'data_dosen.nama',  name    : 'data_dosen.nama'},
            {data  : 'data_mk.nama',     name    : 'data_mk.nama'},
            {data  : 'data_kelas.nama',  name    : 'data_kelas.nama'},
            {data  : 'jam',       name    : 'jam'},
            {data  : 'tanggal',   name    : 'tanggal'},
            {data  : 'durasi',   name    : 'durasi'},
            {data  : 'ket',       name    : 'ket'}
        ]
        
    });

});
</script>
@endpush