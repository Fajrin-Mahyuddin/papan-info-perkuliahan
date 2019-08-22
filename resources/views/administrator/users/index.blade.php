@extends('layouts.index')

@section('title', 'Users :: Dosen')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="form-users" style="display:none">
                    <div class="card-header">
                        <strong>Tambah Dosen</strong>
                    </div>
                    <div class="card-content mt-5">
                        <div class="col-lg-10 offset-md-2">
                            <!-- Content detail -->
                                @include('administrator.users.form')
                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-10 -->

                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>

                <div class="card" id="content-users">
                    <div class="card-header">
                        <strong>Daftar Dosen</strong>
                        <a href="#" id="tambah" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>    

                    </div>
                    <div class="card-content mt-5">
                        
                        <div class="col-lg-12">
                            <!-- Table -->
                                @include('administrator.users.table')
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
                    Data <b></b> akan dihapus ?
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

        $('#users-table').DataTable({
            processing  : true,
            serverSide  : true,
            ajax        : '{{route("dosen.daftar.ajax")}}',
            columns     : [
                {data   : 'nama',       name  : 'nama' },
                {data   : 'nip',        name  : 'nip' },
                {data   : 'email',      name  : 'email' },
                {data   : 'jabatan',    name  : 'jabatan' },
                {data   : 'username',   name  : 'username' },
                {data   : 'status',     name  : 'status' },
                {data   : 'aksi',       name  : 'aksi' },
            ]
        });

        $(document).on('click', '#btn-batal', function() {
            $('#content-users').show('slide', function() {
                $('#form-users').hide('slide');
            });
        });

        $(document).on('click', '#tambah', function() {
            $('#content-users').hide('slide', function() {
                $('#form-users').show('slide');
            });
            $('#id_user').val('');
            $('#username').val('');
            $('#nama').val('');
            $('#nip').val('');
            $('#email').val('');
            $('#no_hp').val('');
            $('#jabatan').val('');
            $('#alamat').val('');
            $('#level').val('dosen');
            $('#btn-submit').data('submit', 'tambah');
        });

        $(document).on('click', '.btn-edit-action', function() {
            $('#content-users').hide('slide', function() {
                $('#form-users').show('slide');
            });
            $('#id_user').val($(this).data('id'));
            $('#username').val($(this).data('username'));
            $('#nama').val($(this).data('nama'));
            $('#nip').val($(this).data('nip'));
            $('#email').val($(this).data('email'));
            $('#no_hp').val($(this).data('no_hp'));
            $('#jabatan').val($(this).data('jabatan'));
            $('#alamat').val($(this).data('alamat'));
            $('#level').val($(this).data('level'));
            $('#btn-submit').data('submit', 'ubah');
        });

        $(document).on('click', '.btn-delete-action', function() {
            $('#content-users').show('slide', function() {
                $('#form-users').hide('slide');
            });
            $('.modal-body b').html($(this).data('nama'));
            $('#myModal').modal('show');
            $('#id_user').val($(this).data('id'));
            $('#btn-submit').data('submit', 'hapus');

        });

        $(document).on('click', '#btn-submit', function() {
            console.log('ok');
            var id       = $('#id_user').val();
            var username = $('#username').val();
            var nama     = $('#nama').val();
            var nip      = $('#nip').val();
            var email    = $('#email').val();
            var no_hp    = $('#no_hp').val();
            var alamat   = $('#alamat').val();
            var level    = $('#level').val();
            var jabatan  = $('#jabatan').val();
            var url      = $('#btn-submit').data('submit'); 

            $.ajax({
                dataType    : 'json',
                type        : 'POST',
                url         : url,
                data        : {
                    id          : id,
                    username    : username,
                    email       : email,
                    nama        : nama,
                    nip         : nip,
                    no_hp       : no_hp,
                    alamat      : alamat,
                    jabatan     : jabatan,
                    level       : level,
                }, 
                success : function(data) {
                    if(data.error) {
                        validateData(data.error); 
                        return false;
                    }

                    $('form')[0].reset();
                    $('#users-table').DataTable().ajax.reload();
                    $('#content-users').show('slide', function() {
                        $('#form-users').hide('slide');
                    });
                    $('#myModal').modal('hide');
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