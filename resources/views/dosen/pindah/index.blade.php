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
                {data   : 'mk',                           name: 'mk'   },
                {data   : 'data_kelas.nama',              name: 'data_kelas.nama', defaultContent: '-'},
                {data   : 'jam_mulai_pindah',             name: 'jam_mulai_pindah' },
                {data   : 'tgl_pindah',                   name: 'tgl_pindah' },
                {data   : 'ket',                       name: 'ket' },
                {data   : 'aksi',                         name: 'aksi'},
            ]
        });

        // $(document).on('click', '#btn-batal', function() {
        //     $('#form-jadwal').hide('slide', {direction:'right'}, 500 , function() {
        //         $('#content-jadwal').show('slide');
        //     });
        // });

        // $(document).on('click', '#tambah', function() {
        //     $('#content-jadwal').hide('slide', {direction:'right'}, 500 , function() {
        //         $('#form-jadwal').show('slide');
        //     });
        //     $('#id_jadwal').val('');
        //     $('#id_mk').selectpicker('val', '');
        //     $('#id_dosen').selectpicker('val', '');
        //     $('#id_kelas').selectpicker('val', '');
        //     $('#hari').selectpicker('val', '');
        //     $('#id_semester').val('');
        //     $('#jam_mulai').val('7:00');
        //     $('#jam_akhir').val('7:00');
        //     $('#btn-submit').data('submit', 'tambah');
        // });

        // $(document).on('click', '.btn-edit-action', function() {
        //     $('#content-jadwal').hide('slide', {direction:'right'}, function() {
        //         $('#form-jadwal').show('slide');
        //     });
        //     $('#id_jadwal').val($(this).data('id'));
        //     $('#id_dosen').selectpicker('val', $(this).data('dosen'));
        //     $('#id_mk').selectpicker('val', $(this).data('mk'));
        //     $('#id_kelas').selectpicker('val', $(this).data('kelas'));
        //     $('#hari').selectpicker('val', $(this).data('hari'));
        //     $('#jam_mulai').val($(this).data('jam_mulai'));
        //     $('#jam_akhir').val($(this).data('jam_akhir'));
        //     $('#id_semester').val($(this).data('semester'));
        //     $('#btn-submit').data('submit', 'ubah');
        // });

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
                   

                    // $('form')[0].reset();
                    $('#pindah-table').DataTable().ajax.reload();
                    
                    $('#myModal').modal('hide');
                    $('.alert-hapus').collapse('show');
                    // $('#status_alert').removeClass('alert-danger');
                    // $('#status_alert').addClass('alert-success');
                    // $('#status_alert').html(data.success);

                    setTimeout(() => {
                        $('.alert-hapus').collapse('hide');
                    }, 3000);


                }


            });


        });

    });
</script>
@endpush