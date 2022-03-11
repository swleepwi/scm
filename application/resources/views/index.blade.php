@extends('template.headerblanklogin')
@section('section')

<div class="tile_menu">
    <p align="center">
    <br>
    <img src="{{ asset('public') }}/img/logofront.png" alt="Logo" class="logo_front" />
        <ul>
            @foreach(session("erp_module") as $module)            
                @if($module->module->is_ess == 0)
                <li  onclick="window.location='{{ url('/') }}{{$module->module->url}}'">
                    <i class="icon {{$module->module->fa_icon}}"></i>
                    <div class="menu_text" style="text-transform:uppercase">{{$module->module->name}}</div>
                </li>
                @endif
            @endforeach
        </ul>
        <br>
        <div align="right" style="padding-right:45px;">
            <button class="btn btn-mini btn-danger" onclick="logoutApp()"><i class="icon icon-key"></i> &nbsp; Logout</button>
        </div>
        <div class="controls copy_text" align="center">
            <br>
            &copy; 2020 PT. KOREA TELECOM INDONESIA
        </div>  
    </p>
<div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
<script src="{{ asset('public') }}/js/bootstrap.min.js"></script> 
<script>
function logoutApp(){
    bootbox.confirm({
        title: "Confirmation Popup",
        message: "Are you sure want to logout?",
        buttons: {
            cancel: {
                label: '<i class="icon-off"></i> Cancel',
                className: 'btn-mini'
            },
            confirm: {
                label: '<i class="icon-check"></i> Confirm',
                className: 'btn-mini btn-inverse'
            }
        },
        callback: function (result) {
            if(result) {
        event.preventDefault();
        document.getElementById('logout-form').submit();	
            }			
            
        }
    });
}  
</script>
@endsection