@extends('layouts.index')

@section('title', 'Password :: Ganti')

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Traffic 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Ganti Password</strong>
                    </div>
                    <div class="card-content mt-5" id="mk_content">
                        <div class="offset-md-2">
                            <!-- Content detail -->
                            <div class="alert alert-success collapse" id="status_alert" role="alert"></div>

                            <form id="form_mk" action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="old_password" class="form-control-label">Password Lama</label></div>
                                    :<div class="col-12 col-md-5">
                                        <input type="text" class="form-control form-control-sm" required id="old_password" name="old_password" placeholder="Password lama !">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="new_password" class="form-control-label">Password Baru</label></div>
                                    :<div class="col-12 col-md-5">
                                        <input type="password" class="form-control form-control-sm" required id="new_password" name="new_password" placeholder="Password baru !">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="re_password" class="form-control-label">Password Lama</label></div>
                                    :<div class="col-12 col-md-5">
                                        <input type="password" class="form-control form-control-sm" required id="re_password" name="re_password" placeholder="Ulangi password baru !">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-actions form-group">
                                    <a href="#" class="btn btn-primary btn-sm btn_submit"><i class="fa fa-check"></i> Simpan</a>
                                    <a href="#" class="btn btn-danger btn-sm btn_cancel"><i class="fa fa-times"></i> Batal</a>
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
     
    </div>
    <!-- .animated -->
</div>

@endsection

@push('script')
<script>
jQuery(document).ready(function($) {


    $('.btn_submit').on('click', function(e) {
        e.preventDefault();
        var old_password   = $('#old_password').val();
        var new_password    = $('#new_password').val();
        var re_password    = $('#re_password').val();
       
        $.ajax({
            dataType: 'json',
            url: 'update',
            type: 'POST',
            data: {
                old_password   :old_password,
                new_password   :new_password,
                re_password    :re_password
            },
            success: function(data) {
                    if(data.error) {
                        validateData(data.error); 
                        return false;
                    }
                    
                    $('form')[0].reset();

                    $('#status_alert').collapse('show');
                    $('#status_alert').html(data.success);
                    
                    setTimeout(() => {
                        $('#status_alert').collapse('hide');
                    }, 3000);
                
            },

        });

    })


});
</script>
@endpush