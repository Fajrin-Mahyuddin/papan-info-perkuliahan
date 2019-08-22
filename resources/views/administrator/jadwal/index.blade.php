@extends('layouts.index')

@section('title', 'Jadwal :: Daftar')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="form-jadwal" style="display:none">
                    <div class="card-header">
                        <strong>Tambah Dosen</strong>
                    </div>
                    <div class="card-content mt-5">
                        <div class="col-lg-10 offset-md-2">
                            <!-- Content detail -->
                                @include('administrator.jadwal.form')
                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-10 -->

                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>

                <div class="card" id="content-jadwal">
                    <div class="card-header">
                        <strong>Daftar Dosen</strong>
                        <a href="#" id="tambah" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>    

                    </div>
                    <div class="card-content mt-5">
                        
                        <div class="col-lg-12">
                            <!-- Table -->
                                @include('administrator.jadwal.table')
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
                    Jadwal <b></b> akan dihapus ?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-submit" class="btn btn-primary btn-sm" data-submit="">Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Hapus -->

@endsection

@push('script')
<script>
    jQuery(document).ready(function($) {
   
        function capitalize(data) {
            return data.charAt(0).toUpperCase() + data.slice(1)
        }

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
                {data   : 'data_semester.tahun_semester', name: 'data_semester.tahun_semester' },
                {data   : 'status',                       name: 'status'},
                {data   : 'aksi',                         name: 'status'},
            ]
        });

        $(document).on('click', '#btn-batal', function() {
            $('#form-jadwal').hide('slide', {direction:'right'}, 500 , function() {
                $('#content-jadwal').show('slide');
            });
        });

        $(document).on('click', '#tambah', function() {
            $('#content-jadwal').hide('slide', {direction:'right'}, 500 , function() {
                $('#form-jadwal').show('slide');
            });
            $('#id_jadwal').val('');
            $('#id_mk').selectpicker('val', '');
            $('#id_dosen').selectpicker('val', '');
            $('#id_kelas').selectpicker('val', '');
            $('#hari').selectpicker('val', '');
            $('#id_semester').val('');
            $('#jam_mulai').val('7:00');
            $('#jam_akhir').val('7:00');
            $('#btn-submit').data('submit', 'tambah');
        });

        $(document).on('click', '.btn-edit-action', function() {
            $('#content-jadwal').hide('slide', {direction:'right'}, function() {
                $('#form-jadwal').show('slide');
            });
            $('#id_jadwal').val($(this).data('id'));
            $('#id_dosen').selectpicker('val', $(this).data('dosen'));
            $('#id_mk').selectpicker('val', $(this).data('mk'));
            $('#id_kelas').selectpicker('val', $(this).data('kelas'));
            $('#hari').selectpicker('val', $(this).data('hari'));
            $('#jam_mulai').val($(this).data('jam_mulai'));
            $('#jam_akhir').val($(this).data('jam_akhir'));
            $('#id_semester').val($(this).data('semester'));
            $('#btn-submit').data('submit', 'ubah');
        });

        $(document).on('click', '.btn-delete-action', function() {
            $('#content-users').show('slide', function() {
                $('#form-users').hide('slide');
            });
            $('.modal-body b').html($(this).data('mk') + ' - hari ' + $(this).data('hari'));
            $('#myModal').modal('show');
            $('#id_jadwal').val($(this).data('id'));
            $('#btn-submit').data('submit', 'hapus');

        });
        
        $(document).on('click', '#btn-submit', function() {
          
            var id          = $('#id_jadwal').val();
            var id_dosen    = $('#id_dosen').val();
            var id_mk       = $('#id_mk').val();
            var id_semester = $('#id_semester').val();
            var id_kelas    = $('#id_kelas').val();
            var hari        = $('#hari').val();
            var jam_mulai   = $('#jam_mulai').val();
            var jam_akhir   = $('#jam_akhir').val();
            var url         = $('#btn-submit').data('submit'); 

            $.ajax({
                dataType    : 'json',
                type        : 'POST',
                url         : url,
                data        : {
                    id          : id,
                    id_dosen    : id_dosen,
                    id_mk       : id_mk,
                    id_semester : id_semester,
                    id_kelas    : id_kelas,
                    hari        : hari,
                    jam_mulai   : jam_mulai,
                    jam_akhir   : jam_akhir,
                }, 
                success : function(data) {
                    if(data.error) {
                        validateData(data.error); 
                        return false;
                    }

                    if(data.others) {
                        $('#form-jadwal').hide('slide', {direction:'right'}, function() {
                            $('#content-jadwal').show('slide');
                        });
                        $('#status_alert').removeClass('alert-success');
                        $('#status_alert').addClass('alert-danger');
                        $('#status_alert').show('slow');
                        $('#status_alert').html(data.others);
                        setTimeout(() => {
                            $('#status_alert').hide('slow');
                        }, 4000);
                        return false;
                    }

                    $('form')[0].reset();
                    $('#jadwal-table').DataTable().ajax.reload();
                    $('#form-jadwal').hide('slide', {direction:'right'}, function() {
                        $('#content-jadwal').show('slide');
                    });
                    $('#myModal').modal('hide');
                    $('#status_alert').removeClass('alert-danger');
                    $('#status_alert').addClass('alert-success');
                    $('#status_alert').show('slow');
                    $('#status_alert').html(data.success);

                    setTimeout(() => {
                        $('#status_alert').hide('slow');
                    }, 4000);


                }


            });


        });

    });
</script>
@endpush