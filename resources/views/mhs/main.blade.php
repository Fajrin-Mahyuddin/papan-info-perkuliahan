<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Main Page</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png"> -->

    <link rel="stylesheet" href="{{asset('css/normalize.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('css/pe-icon-7-stroke.css')}}">


    <link rel="stylesheet" href="{{asset('css/cs-skin-elastic.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">


</head>

<body class="bg-dark">
    
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <!-- <img class="align-content" src="images/logo.png" alt=""> -->
                    </a>
                </div>
                <div class="alert-mhs alert alert-danger" role="alert" style="display:none">
                <span></span> 
                </div>
                <div class="login-form" id="login-form">
                    <form method="post">
                        @csrf
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas" required class="form-control kelas" placeholder="Kelas">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" required class="form-control password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <select name="ruangan" id="ruangan" required class="form-control ruangan">
                                <option value="">--Pilih Ruangan--</option>
                                @foreach($kelas as $var)
                                <option value="{{$var->id_kelas}}">{{$var->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="checkbox">
                           
                        </div>
                        <button class="btn btn-success btn-submit btn-flat m-b-30 m-t-30">Masuk</button>
                    </form>
                </div>
                <div class="login-form" id="page-validasi" style="display:none; width:800px; margin-left:-100px">
                    <div id="data-page" class="center">
                    </div>
                    <a href="mhs" class="col-md-2 btn btn-sm btn-info"> Batal </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.matchHeight-min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/moment.js')}}"></script>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       

        $('.btn-submit').on('click', function(e) {
            e.preventDefault();
            var kelas = $('input[name="kelas"]').val();
            var password = $('input[name="password"]').val();
            var ruangan = $('.ruangan').val();

            $.ajax({
                dataType    : 'json',
                url			: '{{route("mhs.postLogin")}}',
                type        : 'POST',
                data        : {
                    kelas : kelas,
                    password : password,
                    ruangan : ruangan
                },
                success: function(response) {
                    if(response.errors) {
                        $('.alert-mhs').show('slow');
                        $('.alert-mhs span').html(response.errors);
                        setTimeout(() => {
                            $('.alert-mhs').hide('slow');
                        }, 4000);
                        return false;
                    }
                    $('#login-form').hide('slow');
                    $('#page-validasi').show('slow');
                    $.each(response.data, function(index, value) {

                        if(value.status == 'pindah' && value.data_pindah.ket == 'masuk') {
                            if(value.data_pindah.id_kelas == response.ruangan.id_kelas) {
                                    $('#data-page').append(`<div class="text-validasi"><br>`+response.ruangan.nama+` - `+value.data_mk.nama+` - `+value.data_dosen.nama+`</div><a href="mhs/konfirmasi/`+value.id_jadwal+`" class="col-md-2 btn btn-danger btn-sm"> Konfirmasi </a><hr>`);
                            }
                        } else {
                            if(value.id_kelas == response.ruangan.id_kelas && value.status == 'masuk') {
                                $('#data-page').append(`<div class="text-validasi"><br>`+value.data_kelas.nama+` - `+value.data_mk.nama+` - `+value.data_dosen.nama+`</div><a href="mhs/konfirmasi/`+value.id_jadwal+`" class="col-md-2 col-md-offset-5 btn btn-danger btn-sm"> Konfirmasi </a><hr>`);
                            }                                
                        }
                        
                    });
                }
            });
        });
    });
    </script>
    
</body>
</html>
