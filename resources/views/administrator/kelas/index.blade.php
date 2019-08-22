@extends('layouts.index')

@section('title', 'Kelas :: Daftar')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
            <div class="card">
                    <div class="card-header">
                        <strong>Tambah Kelas</strong>
                        <a href="#" id="tambah" class="btn-primary btn-sm btn pull-right"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-content mt-5 collapse" id="form-kelas">
                        <div class="col-lg-10 offset-md-2">
                            <!-- Content detail -->
                            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="kode" class="form-control-label">Kode</label></div>
                                    :<div class="col-12 col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="kode" name="kode" placeholder="Kode Kelas !" class="form-control">
                                        <input type="hidden" id="id_kelas" name="id_kelas">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="nama" class="form-control-label">Nama</label></div>
                                    :<div class="col-12 col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Nama Kelas !" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Keterangan</label></div>
                                    :<div class="col col-md-7">
                                        <div class="form-check-inline form-check">
                                            <label for="inline-radio1" class="form-check-label mr-3">
                                                <input type="radio" id="ket" name="ket" value="aktif" class="form-check-input">Aktif
                                            </label>
                                            <label for="inline-radio2" class="form-check-label ">
                                                <input type="radio" id="ket" name="ket" value="nonAktif" class="form-check-input">NonAktif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-actions form-group">
                                    <a href="#" id="btn-submit" data-submit="" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Simpan</a>
                                    <a href="#" id="btn-cancel"class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Batal</a>
                                </div>
                            </form>
                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-10 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
                <!-- Konten Kedua -->
                <div class="card">
                    <div class="card-header">
                        <strong>Daftar Kelas</strong>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12 mt-3">
                            <!-- Content detail -->
                            <div class="alert alert-success collapse" id="status_alert" role="alert"></div>
                            <table id="kelas-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Ket</th>
                                        <th>Aksi</th>
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
    $('#kelas-table').DataTable({
        serverSide  : true,
        processing  : true,
        ajax        : '{{route("kelas.daftar.ajax")}}',
        columns     : [
            {data    : 'kode',   name    : 'kode'},
            {data    : 'nama',   name    : 'nama'},
            {data    : 'status',  name    : 'status'},
            {data    : 'ket',    name    : 'ket'},
            {data    : 'aksi',   name    : 'aksi'}
        ]
    });

    $('#btn-cancel').on('click', function() {
        $('#form-kelas').collapse('hide');
    });

    $('#tambah').on('click', function() {
        $('#form-kelas').collapse('show');
        $('#id_kelas').val('');
        $('#kode').val('');
        $('#nama').val('');
        $('input[type="radio"][value="aktif"]').prop('checked', true);
        $('#btn-submit').data('submit', 'tambah');
    });

    $(document).on('click', '.btn-edit-action', function() {
        $('#form-kelas').collapse('show');
        $('#id_kelas').val($(this).data('id'));
        $('#kode').val($(this).data('kode'));
        $('#nama').val($(this).data('nama'));
        var val = $(this).data('ket');
        $('input[type="radio"][value="'+val+'"]').prop('checked', true);
        $('#btn-submit').data('submit', 'ubah');
    });

    $(document).on('click', '.btn-delete-action', function() {
        $('#form-kelas').collapse('hide');
        $('#myModal').modal('show');
        $('#id_kelas').val($(this).data('id'));
        $('.modal-body b').html($(this).data('nama'));
        $('#btn-submit').data('submit', 'hapus');
    });

    $(document).on('click', '#btn-submit', function() {
        var id_kelas = $('#id_kelas').val();
        var kode     = $('#kode').val();
        var nama     = $('#nama').val();
        var ket      = $('input[type="radio"]:checked').val();
        var url      = $('#btn-submit').data('submit');

        $.ajax({
            dataType    : 'json',
            type        : 'POST',
            url         : url,
            data        : {
                id_kelas    : id_kelas,
                kode        : kode,
                nama        : nama,
                ket         : ket,
            },
            success: function(data) {
                if(data.error) {
                    validateData(data.error);
                    return false;
                }

                $('#myModal').modal('hide');
                $('form')[0].reset();
                $('#form-kelas').collapse('hide');
                $('#kelas-table').DataTable().ajax.reload()
                $('#status_alert').collapse('show');
                $('#status_alert').html(data.success);
                setTimeout(() => {
                    $('#status_alert').collapse('hide');
                }, 4000);
            }
        });

    });

});
</script>
@endpush