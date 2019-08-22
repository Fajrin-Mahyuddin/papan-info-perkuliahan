<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

  

    <link rel="stylesheet" href="{{asset('css/normalize.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-timepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('css/pe-icon-7-stroke.css')}}">


    <link rel="stylesheet" href="{{asset('css/cs-skin-elastic.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">


</head>

<body>
    <!-- Left Panel -->
    @include('include.left_panel')
    <!-- Left Panel -->

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">

        <!-- Header-->
            @include('include.header')
        <!-- /#header -->

        <!-- Content -->
            @yield('content')
        <!-- /.content -->

        <div class="clearfix"></div>

        <!-- Footer -->
            @include('include.footer')        
        <!-- /.site-footer -->

    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
    <script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script> -->
    <script src="{{asset('js/bootstrap-timepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
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
    
    var link = window.location.pathname;
    var split = link.split('/');
    var active = split[2];
    if(!active) {
        active = 'dasboard';
    }

    $('.'+active).toggleClass('active show');
    $('.'+active).children().toggleClass('show');
    // $('.bs-searchbox input').addClass('input-sm');
    $('.selectpicker').selectpicker();

    $('.timepicker').timepicker({
        showMeridian: false,
        format: 'HH:mm'  
    });

    });
    
    function validateData(data) {
        jQuery.each(data, function(index, val) {
            // var cek = jQuery('#'+index).val();
            jQuery('#'+index).addClass('is-invalid').selectpicker('setStyle');

            setTimeout(() => {
                jQuery('#'+index).removeClass('is-invalid').selectpicker('setStyle');
                jQuery('#'+index).parent().removeClass('is-invalid').selectpicker('setStyle');
            }, 3000);    
        });
        return true;    
    }
    </script>
    @stack('script')
</body>
</html>
