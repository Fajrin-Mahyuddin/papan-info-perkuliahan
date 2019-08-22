@extends('layouts.index')

@section('title', 'Jadwal Pindah :: Tambah')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="form-pindah">
                    <div class="card-header">
                        <strong>Buat Jadwal Pindah</strong>
                    </div>
                    <div class="card-content mt-5">
                        <div class="col-lg-10 offset-md-2">
                            <!-- Content detail -->
                            <form action="{{url('admin/pindah/jadwal/daftar/ubah')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                               @csrf
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="id_kelas" class="form-control-label">Kelas</label></div>
                                    :<div class="col-12 col-md-7">
                                    
                                        <select name="id_kelas" id="id_kelas" data-style="btn-primary" class="form-control form-control-sm selectpicker">
                                            @if($data->id_kelas !== null)
                                            <option value="{{$data->id_kelas}}">{{$data->data_kelas->nama}}</option>
                                            @else
                                            <option value="">--Pilih--</option>
                                            @endif
                                            @foreach($kelas as $val)
                                                <option value="{{$val->id_kelas}}">{{$val->nama}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="id_jadwal" value="{{$data->id_jadwal}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="jam_mulai_pindah" class="form-control-label">Jam Mulai</label></div>
                                    :<div class="col-12 col-md-7">
                                        <input type="text" class="form-control form-control-sm timepicker" id="jam_mulai_pindah" name="jam_mulai_pindah" value="--:--">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="jam_akhir_pindah" class="form-control-label">Jam Akhir</label></div>
                                    :<div class="col-12 col-md-7">
                                        <input type="text" class="form-control form-control-sm timepicker" id="jam_akhir_pindah" name="jam_akhir_pindah" value="--:--">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="tgl_pindah" class="form-control-label">Tanggal</label></div>
                                    :<div class="col-12 col-md-7">
                                        <input type="date" class="form-control form-control-sm" id="tgl_pindah" name="tgl_pindah" value="2019-09-06">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-actions form-group">
                                    <button type="submit" id="btn-submit" class="btn btn-sm btn-primary" data-submit=""><i class="fa fa-sign-out"></i> Pindahkan</button>    
                                    <a href="{{url('admin/jadwal/daftar')}}" id="btn-submit" class="btn btn-sm btn-danger" data-submit=""><i class="fa fa-times"></i> Batal</a>     
                                </div>
                            </form>

                            <!-- Batas Content detail -->
                        </div> <!-- /.col-lg-10 -->
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
   

        // $('#jadwal-table').DataTable({
        //     processing  : true,
        //     serverSide  : true,
        //     ajax        : '{{route("jadwal.daftar.ajax")}}',
        //     columns     : [
        //         {data   : 'data_mk.nama',                 name: 'data_mk.nama'   },
        //         {data   : 'data_dosen.nama',              name: 'data_dosen.nama', defaultContent: '-'},
        //         {data   : 'hari',                         name: 'hari'},
        //         {data   : 'data_kelas.nama',              name: 'data_kelas.nama', defaultContent: '-'},
        //         {data   : 'jam_mulai',                    name: 'jam_mulai' },
        //         {data   : 'data_semester.tahun_semester', name: 'data_semester.tahun_semester' },
        //         {data   : 'status',                       name: 'status'},
        //         {data   : 'aksi',                         name: 'status'},
        //     ]
        // });

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