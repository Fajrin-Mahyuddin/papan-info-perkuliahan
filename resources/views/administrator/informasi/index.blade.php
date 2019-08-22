@extends('layouts.index')

@section('title', 'Informasi :: Daftar')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
            <div class="card">
                    <div class="card-header">
                        <strong>Tambah Informasi</strong>
                        <a href="#" id="tambah" class="btn-primary btn-sm btn pull-right"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-content mt-5 collapse" id="form-informasi">
                        <div class="col-lg-10 offset-md-2">
                            <!-- Content detail -->
                            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="judul" class="form-control-label">Judul</label></div>
                                    :<div class="col-12 col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="judul" name="judul" placeholder="Judul Informasi">
                                        <input type="hidden" id="id_informasi" name="id_informasi">
                                        <input type="hidden" id="id_semester" name="id_semester">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="nama" class="form-control-label">Isi Informasi</label></div>
                                    :<div class="col-12 col-md-7">
                                        <textarea name="isi_informasi" id="isi_informasi" rows="6" class="form-control form-control-sm" placeholder="Maks. 100 kata"></textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class="form-control-label">Keterangan</label></div>
                                    :<div class="col col-md-7">
                                        <div class="form-check-inline form-check">
                                            <label for="inline-radio1" class="form-check-label mr-3">
                                                <input type="radio" id="ket" name="ket" value="publish" class="form-check-input">Terbitkan
                                            </label>
                                            <label for="inline-radio2" class="form-check-label ">
                                                <input type="radio" id="ket" name="ket" value="unpublish" class="form-check-input">Hanya Simpan
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
                        <strong>Daftar Informasi</strong>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12 mt-3">
                            <!-- Content detail -->
                            <div class="alert alert-success collapse" id="status_alert" role="alert"></div>
                            <table id="informasi-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Judul Informasi</th>
                                        <th>Tahun Ajaran</th>
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
                    Data akan dihapus ?
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
    $('#informasi-table').DataTable({
        serverSide  : true,
        processing  : true,
        ajax        : '{{route("informasi.daftar.ajax")}}',
        columns     : [
            {data  : 'judul',           name    : 'judul'},
            {data  : 'tahun_semester',  name    : 'tahun_semester'},
            {data  : 'ket',             name    : 'ket'},
            {data  : 'aksi',            name    : 'aksi'}
        ]
    });

    $('#btn-cancel').on('click', function() {
        $('#form-informasi').collapse('hide');
    });

    $('#tambah').on('click', function() {
        $('#form-informasi').collapse('show');
        $('#id_informasi').val('');
        $('#judul').val('');
        $('#isi_informasi').val('');
        $('#id_semester').val('');
        $('input[type="radio"][value="publish"]').prop('checked', true);
        $('#btn-submit').data('submit', 'tambah');
    });

    $(document).on('click', '.btn-edit-action', function() {
        $('#form-informasi').collapse('show');
        $('#id_informasi').val($(this).data('id'));
        $('#id_semester').val($(this).data('id_semester'));
        $('#judul').val($(this).data('judul'));
        $('#isi_informasi').val($(this).data('isi_informasi'));
        var val = $(this).data('ket');
        $('input[type="radio"][value="'+val+'"]').prop('checked', true);
        $('#btn-submit').data('submit', 'ubah');
    });

    $(document).on('click', '.btn-delete-action', function() {
        $('#form-informasi').collapse('hide');
        $('#myModal').modal('show');
        $('#id_informasi').val($(this).data('id'));
        $('#btn-submit').data('submit', 'hapus');
    });

    $(document).on('click', '#btn-submit', function() {
        var id_informasi    = $('#id_informasi').val();
        var id_semester     = $('#id_semester').val();
        var judul           = $('#judul').val();
        var isi_informasi   = $('#isi_informasi').val();
        var ket             = $('input[type="radio"]:checked').val();
        var url             = $('#btn-submit').data('submit');

        $.ajax({
            dataType    : 'json',
            type        : 'POST',
            url         : url,
            data        : {
                id_informasi    : id_informasi,
                id_semester     : id_semester,
                judul           : judul,
                isi_informasi   : isi_informasi,
                ket             : ket
            },
            success: function(data) {
                if(data.error) {
                    validateData(data.error);
                    return false;
                }
                if(data.others) {
                    $('#myModal').modal('hide');
                    $('#status_alert').removeClass('alert-success');
                    $('#status_alert').addClass('alert-danger');
                    $('#form-informasi').collapse('hide');
                    $('.alert-danger').collapse('show');
                    $('.alert-danger').html(data.others);
                    setTimeout(() => {
                        $('#status_alert').collapse('hide');
                    }, 4000);
                    return false;
                }

                $('#myModal').modal('hide');
                $('form')[0].reset();
                $('#form-informasi').collapse('hide');
                $('#informasi-table').DataTable().ajax.reload();
                $('#status_alert').removeClass('alert-danger');
                $('#status_alert').addClass('alert-success');
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