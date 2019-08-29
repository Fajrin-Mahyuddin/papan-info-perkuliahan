@extends('layouts.index')

@section('title', 'Jadwal :: Daftar')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="content-jadwal">
                    <div class="card-header">
                        <strong>Jadwal Kuliah</strong>
                    </div>
                    <div class="card-content mt-5">
                        
                        <div class="col-lg-12">
                            <!-- Table -->
                                @include('dosen.jadwal.table')
                            <!-- Batas Table -->                
                        </div>

                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>

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

        $('#jadwal-table').DataTable({
            processing  : true,
            serverSide  : true,
            ajax        : '{{route("dosen.jadwal.daftar.ajax")}}',
            columns     : [
                {data   : 'data_mk.nama',                 name: 'data_mk.nama'   },
                {data   : 'data_kelas.nama',              name: 'data_kelas.nama', defaultContent: '-'},
                {data   : 'hari',                         name: 'hari'},
                {data   : 'jam_mulai',                    name: 'jam_mulai' },
                {data   : 'jam_akhir',                    name: 'jam_akhir' },
                {data   : 'status',                       name: 'status'},
                {data   : 'aksi',                         name: 'status'},
            ]
        });

        
    });
</script>
@endpush