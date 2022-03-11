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
        <link rel="stylesheet" href="/webfont/webfont.css" />
        <script src="{{ asset('public') }}/js/jquery.min.js"></script>  
        <script src="{{ asset('public') }}/js/jquery.bootstrap-growl.js"></script> 
    </head>

    <body>
        
        <div id="content">
            @yield('section')
        </div>

        <script>
            function logoutApp(){
                bootbox.confirm("Are you sure?", function(result) {
                    if(result){
                        event.preventDefault();
                        document.getElementById('logout-form').submit();	
                    }
                });
            }

            @if(Session::has('notif')) 
                $.bootstrapGrowl("{{ Session::get('notif')['notification'] }}", {
                    type: "{{ Session::get('notif')['type'] }}"
                });
            @endif   
        </script>
    </body>
</html>

