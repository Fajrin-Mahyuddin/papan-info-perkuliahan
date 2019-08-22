@extends('layouts.index')

@section('title', 'Mata Kuliah :: Daftar')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a data-toggle="collapse" href="#mk_content" aria-expanded="false" class="btn btn-sm btn-primary tambah"><i class="fa fa-plus"></i></a>
                        <strong>Tambah Mata Kuliah</strong>
                    </div>
                    <div class="card-content mt-5 collapse" id="mk_content">
                        <div class="offset-md-2">
                            <!-- Content detail -->
                            <form id="form_mk" action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="kode" class="form-control-label">Kode</label></div>
                                    :<div class="col-12 col-md-5">
                                        <input type="hidden"id="id_mk" name="id_mk">
                                        <input type="text" class="form-control form-control-sm" id="kode" name="kode" placeholder="Kode Mata Kuliah !">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="nama" class="form-control-label">Nama</label></div>
                                    :<div class="col-12 col-md-5">
                                        <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Nama Mata kuliah !">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="sks" class="form-control-label">SKS</label></div>
                                    :<div class="col-12 col-md-5">
                                        <input type="number" class="form-control form-control-sm" id="sks" name="sks" placeholder="Jumlah SKS">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Keterangan</label></div>
                                    :<div class="col col-md-5">
                                        <div class="form-check-inline form-check">
                                            <label for="inline-radio1" class="form-check-label mr-3">
                                                <input type="radio" id="ket" name="ket" value="aktif" class="form-check-input aktif">Aktif
                                            </label>
                                            <label for="inline-radio2" class="form-check-label ">
                                                <input type="radio" id="ket" name="ket" value="nonAktif" class="form-check-input nonAktif">NonAktif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-actions form-group">
                                    <a href="#" class="btn btn-primary btn-sm btn_submit" data-submit=""><i class="fa fa-check"></i> Simpan</a>
                                    <a href="#" class="btn btn-primary btn-sm btn_cancel"><i class="fa fa-check"></i> Batal</a>
                                </div>
                            </form>
                            <!-- <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#smallmodal">
                                Small
                            </button> -->

                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-10 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic 1 -->
        
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
                        <button type="button" class="btn_submit btn btn-primary btn-sm" data-submit="">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Hapus -->

        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Daftar Mata Kuliah</strong>
                    </div>
                    <div class="card-content mt-5">
                        <div class="col-md-12">
                            <!-- Content detail -->
                            <div style="display:none" class="alert alert-success" id="status_alert" role="alert"></div>

                            <table id="mk_table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>SKS</th>
                                        <th>Ket</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-10 -->
                    </div> <!-- /.row -->
                    <div class="card-body"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Traffic 1 -->

        
    </div>
    <!-- .animated -->
</div>

@endsection

@push('script')
<script>
jQuery(document).ready(function($) {

    $('#mk_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{route("mk.daftar.ajaxMk")}}',
        columns: [
            { data: 'kode', name: 'kode' },
            { data: 'nama', name: 'nama' },
            { data: 'sks', name: 'sks' },
            { data: 'ket', name: 'ket' },
            { data: 'aksi', name: 'aksi', orderable:false, searchable:false },
        ]
    });

    $('.btn_cancel').on('click', function() {
        $('.collapse').collapse('hide');
    });



    $('.tambah').on('click', function(e) {
        e.preventDefault();
        $('#id_mk').val('');
        $('#kode').val('');
        $('#nama').val('');
        $('#sks').val('');
        $('.aktif').attr('checked', true);
        $('.btn_submit').data('submit', 'tambah');
    });

    $(document).on('click', '.btn-edit-action', function() {
        $('#mk_content').collapse('show');
        $('#id_mk').val($(this).data('id'));
        $('#kode').val($(this).data('kode'));
        $('#nama').val($(this).data('nama'));
        $('#sks').val($(this).data('sks'));
        $("input[type='radio'][value='"+$(this).data('ket')+"']").prop("checked", true);
        $('.btn_submit').data('submit', 'ubah');
    });

    $(document).on('click', '.btn-delete-action', function() {
        $('#myModal').modal('show');
        var id_mk = $('#id_mk').val($(this).data('id'));
        $('.modal-body b').html($(this).data('nama'));
        $('.btn_submit').data('submit', 'hapus');

    });

    $('.btn_submit').on('click', function(e) {
        e.preventDefault();
        var id_mk   = $('#id_mk').val();
        var kode    = $('#kode').val();
        var nama    = $('#nama').val();
        var sks     = $('#sks').val();
        var ket     = $('input[type="radio"]:checked').val();
        var url     = $('.btn_submit').data('submit');
        
        $.ajax({
            dataType: 'json',
            url: url,
            type: 'POST',
            data: {
                id_mk   :id_mk,
                nama    :nama,
                kode    :kode,
                sks     :sks,
                ket     :ket
            },
            success: function(data) {
                    if(data.error) {
                        validateData(data.error); 
                        return false;
                    }
                    
                    $('form')[0].reset();
                    $('.btn_submit').data('submit', 'tambah');

                    $('#status_alert').show('slow');
                    $('#status_alert').html(data.success);
                    
                    $('#mk_content').collapse('hide');
                    $('#myModal').modal('hide');
                    
                    setTimeout(() => {
                        $('#status_alert').hide('slow');
                    }, 3000);
                    $('#mk_table').DataTable().ajax.reload();
                
            },

        });

    })


});
</script>
@endpush