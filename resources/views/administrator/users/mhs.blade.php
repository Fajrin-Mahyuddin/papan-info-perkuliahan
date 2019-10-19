@extends('layouts.index')

@section('title', 'Users :: Mahasiswa')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="form-users" style="display:none">
                    <div class="card-header">
                        <strong>Tambah User</strong>
                    </div>
                    <div class="card-content mt-5">
                        <div class="col-lg-10 offset-md-2">
                            <!-- Content detail -->
                            <div style="display:none" class="alert alert-danger" id="alert-form" role="alert"></div>
                            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="username" class="form-control-label">Username/Kelas</label></div>
                                    :<div class="col-12 col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Username login" class="form-control">
                                        <input type="hidden" id="id_user_validasi" name="id_user_validasi">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="password" class="form-control-label">Password</label></div>
                                    :<div class="col-12 col-md-7">
                                        <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Password pengguna !" class="form-control">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-actions form-group">
                                    <a href="#" id="btn-submit" class="btn btn-sm btn-primary" data-submit=""><i class="fa fa-check"></i> Simpan</a>    
                                    <a href="#" id="btn-batal" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Batal</a>    
                                </div>
                            </form>

                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-10 -->

                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>

                <div class="card" id="content-users">
                    <div class="card-header">
                        <strong>Daftar User</strong>
                        <a href="#" id="tambah" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-content mt-5">
                        <div class="col-lg-12">
                            <!-- Table -->
                            <div style="display:none" class="alert alert-success" id="status_alert" role="alert"></div>
                            <table id="users-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
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
            ajax        : '{{route("mhs.daftar.ajax")}}',
            columns     : [
                {data   : 'nama',       name  : 'nama' },
                {data   : 'ket',        name  : 'ket' },
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
            $('#id_user_validasi').val('');
            $('#username').val('');
            $('#password').val('');
            $('#btn-submit').data('submit', 'tambah');
        });

        $(document).on('click', '.btn-edit-action', function() {
            $('#content-users').hide('slide', function() {
                $('#form-users').show('slide');
            });
            $('#id_user_validasi').val($(this).data('id'));
            $('#username').val($(this).data('nama'));
            $('#btn-submit').data('submit', 'ubah');
        });

        $(document).on('click', '.btn-delete-action', function() {
            $('#content-users').show('slide', function() {
                $('#form-users').hide('slide');
            });
            $('.modal-body b').html($(this).data('nama'));
            $('#myModal').modal('show');
            $('#id_user_validasi').val($(this).data('id'));
            $('#btn-submit').data('submit', 'hapus');
        });

        $(document).on('click', '#btn-submit', function() {
            var id_user_validasi       = $('#id_user_validasi').val();
            var nama = $('#username').val();
            var password = $('#password').val();
            var url      = $('#btn-submit').data('submit'); 

            $.ajax({
                dataType    : 'json',
                type        : 'POST',
                url         : url,
                data        : {
                    id_user_validasi     : id_user_validasi,
                    nama    : nama,
                    password    : password,
                    
                }, 
                success : function(data) {
                    if(data.error) {
                        $('#alert-form').show('slow').html('Gagal !'); 
                        setTimeout(() => {
                            $('#alert-form').hide('slow');
                        }, 4000);
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