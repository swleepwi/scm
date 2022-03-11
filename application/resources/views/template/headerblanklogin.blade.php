<!DOCTYPE html>
<html lang="en">
    
    <head>
        <title>Parkland - SCM System</title>
        <link rel="shortcut icon" href="{{ asset('public') }}/img/favicon.png" /><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('public') }}/css/bootstrap.min.css" />
        <link rel="stylesheet" href="{{ asset('public') }}/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="{{ asset('public') }}/css/matrix-login.css" />
        <link href="{{ asset('public') }}/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('public') }}/webfont/webfont.css" />
        <script src="{{ asset('public') }}/js/jquery.min.js"></script> 
        <script src="{{ asset('public') }}/js/jquery.ui.custom.js"></script>
        <script src="{{ asset('public') }}/plugins/bootbox/bootbox.min.js"></script>
        <script src="{{ asset('public') }}/plugins/bootbox/bootbox.locales.min.js"></script>
        <script src="{{ asset('public') }}/js/iziModal.min.js"></script>
        <script src="{{ asset('public') }}/js/jquery.bootstrap-growl.js"></script> 
        <meta http-equiv="refresh" content="3600">
    </head>

    <body>
        
        <div id="content">
            @yield('section')
        </div>
        
        <script src="{{ asset('public') }}/js/jquery.idle.js"></script>
        <script>
            
            $(document).idle({
                onIdle: function(){
                    window.location="{{url('/')}}";
                    //alert('You have no activity more than 5 minutes ago, the system will logout');
                },
                idle: 300000
            });

            @if(Session::has('notif')) 
                $.bootstrapGrowl("{{ Session::get('notif')['notification'] }}", {
                    type: "{{ Session::get('notif')['type'] }}",offset: {from: 'top', amount: 250},align: 'center'
                });
            @endif   
        </script>
    </body>
</html>
