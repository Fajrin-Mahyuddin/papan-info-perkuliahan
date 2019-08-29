@extends('layouts.index')

@section('title', 'Jadwal Pindah:: Daftar')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="content-pindah">
                    <div class="card-header">
                        <strong>Daftar Jadwal Pindah</strong>
                    </div>
                    <div class="card-content mt-5">
                        
                        <div class="col-md-12">
                            <!-- Table -->
                                @include('dosen.pindah.table')
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

<!-- Modal Hapus -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <input type="hidden" id="id_pindah" value="">
                    <input type="hidden" id="id_jadwal" value="">
                    Jadwal Pindah <b></b> akan dihapus ?
                </p>
            </div>
            <div class="modal-footer">
                <button id="btn-submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Hapus -->

@endsection

@push('script')
<script>
    jQuery(document).ready(function($) {

        $('#pindah-table').DataTable({
            processing  : true,
            serverSide  : true,
            ajax        : '{{route("dosen.pindah.jadwal.daftar.ajax")}}',
            columns     : [
                {data   : 'data_mk.nama',                     name: 'data_mk.nama'   },
                {data   : 'data_pindah.data_kelas.nama',      name: 'data_pindah.data_kelas.nama', defaultContent: '-'},
                {data   : 'data_pindah.jam_mulai_pindah',     name: 'data_pindah.jam_mulai_pindah' },
                {data   : 'data_pindah.jam_akhir_pindah',     name: 'data_pindah.jam_akhir_pindah' },
                {data   : 'tgl_pindah',                       name: 'tgl_pindah' },
                {data   : 'data_pindah.ket',                  name: 'data_pindah.ket' },
                {data   : 'aksi',                             name: 'aksi'},
            ]
        });

        $(document).on('click', '.btn-delete-action', function() {
            $('.modal-body b').html($(this).data('nama'));
            $('#myModal').modal('show');
            $('#id_pindah').val($(this).data('id'));
            $('#id_jadwal').val($(this).data('id_jadwal'));
            $('#btn-submit').data('submit', 'hapus');
        });
        
        $(document).on('click', '#btn-submit', function() {
          
            var id          = $('#id_pindah').val();
            var id_jadwal   = $('#id_jadwal').val();
           
            $.ajax({
                dataType    : 'json',
                type        : 'POST',
                url         : 'daftar/hapus',
                data        : {
                    id          : id,
                    id_jadwal   : id_jadwal,
                }, 
                success : function(data) {

                    $('#pindah-table').DataTable().ajax.reload();
                    
                    $('#myModal').modal('hide');
                    $('.alert-hapus').collapse('show');

                    setTimeout(() => {
                        $('.alert-hapus').collapse('hide');
                    }, 3000);


                }


            });


        });

    });
</script>
@endpush