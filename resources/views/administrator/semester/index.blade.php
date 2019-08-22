@extends('layouts.index')

@section('title', 'Tahun Ajaran :: Daftar')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
            <div class="card">
                    <div class="card-header">
                        <strong>Generate Semester Baru</strong>
                        <a href="#" id="tambah" class="btn-primary btn-sm btn pull-right"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-content mt-5 collapse" id="form-semester">
                        <div class="col-md-10 offset-md-2">
                            <!-- Content detail -->
                                
                                    <div class="col-md-9 text-center">
                                        <h1>TAHUN AJARAN <strong>{{$data->tahun_semester}}({{$data->ket}})</strong></h1>
                                        <hr>
                                        
                                        <div class="row form-group">
                                            <div class="col col-md-8">
                                                <div class="input-group">
                                                    <input type="number" id="tahun_pertama" name="tahun_pertama" placeholder="Tahun 1" class="form-control">
                                                    <div class="input-group-addon">/</div>
                                                    <input type="number" id="tahun_kedua" name="tahun_kedua" placeholder="Tahun 2" class="form-control">
                                                    <input type="hidden" name="id_semester" id="id_semester">
                                                </div>
                                            </div>
                                        
                                            <div class="col col-md-4">
                                                <div class="input-group">
                                                    <!-- <input type="text" id="ket" name="ket" placeholder="Genap/Ganjil" > -->
                                                    <select name="ket" id="ket" class="form-control">
                                                        <option value="">--Pilih--</option>
                                                        <option value="ganjil">Ganjil</option>
                                                        <option value="genap">Genap</option>
                                                    </select>
                                                    <div class="input-group-addon"><i class="fa fa-check-square-o"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" data-submit="" class="btn btn-primary btn-lg btn-submit"><i class="fa fa-refresh"></i> Generate</a>
                                    </div>
                                
                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-10 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
                <!-- Konten Kedua -->
                <div class="card">
                    <div class="card-header">
                        <strong>Daftar Tahun Ajaran</strong>
                    </div>
                    <div class="card-content">
                        <div class="col-lg-12 mt-3">
                            <!-- Content detail -->
                            <div class="alert collapse" id="status_alert" role="alert"></div>
                            <table id="semester-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tahun Ajaran</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                    <div class="card-footer mt-3">
                        <p style="color:#e84118; font-size: 12px;">*Menghapus record <strong>Tahun Ajaran</strong> akan menghapus seluruh data yang berelasi dengan tahun tersebut !</p>
                    </div>
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
                <h5 class="modal-title" id="myModalLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm btn-submit" data-submit="">Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Hapus -->

<!-- Modal Aktif -->
<div class="modal fade" id="myModalAktif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm btn-submit" data-submit="">Aktifkan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Aktif -->

@endsection

@push('script')
<script>
jQuery(document).ready(function($) {
    $('#semester-table').DataTable({
        serverSide  : true,
        processing  : true,
        ajax        : '{{route("semester.daftar.ajax")}}',
        columns     : [
            {data    : 'tahun_semester',   name    : 'tahun_semester'},
            {data    : 'status',           name    : 'status'},
            {data    : 'ket',              name    : 'ket'},
            {data    : 'aksi',             name    : 'aksi'}
        ]
    });

    $('#tambah').on('click', function() {
        $('#form-semester').collapse('toggle');
        $('input').val('');
        $('select').val('');
        $('.btn-submit').data('submit', 'tambah');
    });

    $(document).on('click', '.btn-edit-action', function() {
        $('#form-semester').collapse('show');
        $('#id_semester').val($(this).data('id'));
        $('#ket').val($(this).data('ket'));
        var tahun_semester  = $(this).data('tahun_semester');
        var tahun           = tahun_semester.split('/');
        var tahun_pertama   = tahun[0];
        var tahun_kedua     = tahun[1];
        $('#tahun_pertama').val(tahun_pertama);
        $('#tahun_kedua').val(tahun_kedua);
        $('.btn-submit').data('submit', 'ubah');
    });

    $(document).on('click', '.btn-delete-action', function() {
        $('#form-semester').collapse('hide');
        $('.btn-submit').data('submit', 'hapus');
        $('#myModal').modal('show');
        $('#id_semester').val($(this).data('id'));
        $('.modal-body p').html(' Data <strong>' + $(this).data('tahun_semester') + '</strong> akan dihapus ? ');
    });

    $(document).on('click', '.btn-active-off', function() {
        $('#form-semester').collapse('hide');
        $('#myModalAktif').modal('show');
        $('#id_semester').val($(this).data('id'));
        $('.modal-body p').html(' Data <strong>' + $(this).data('tahun_semester') + '</strong> akan diaktifkan ? ');
        $('.btn-submit').data('submit', 'aktif');
    });
    
    $(document).on('click', '.btn-submit', function() {
        var id_semester   = $('#id_semester').val();
        var tahun_pertama = $('input[name="tahun_pertama"]').val();
        var tahun_kedua   = $('input[name="tahun_kedua"]').val();
        var ket           = $('#ket').val();
        var url           = $('.btn-submit').data('submit');

        $.ajax({
            dataType    : 'json',
            type        : 'POST',
            url         : url,
            data        : {
                id_semester   : id_semester,
                tahun_pertama : tahun_pertama,
                tahun_kedua   : tahun_kedua,
                ket           : ket
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
                    $('#form-semester').collapse('hide');
                    $('.alert-danger').collapse('show');
                    $('.alert-danger').html(data.others);
                    setTimeout(() => {
                        $('.alert-danger').collapse('hide');
                    }, 4000);
                    return false;
                }

                $('#myModal').modal('hide');
                $('#myModalAktif').modal('hide');
                $('input').val('');
                $('select').val('');
                $('#form-semester').collapse('hide');
                $('#semester-table').DataTable().ajax.reload();
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