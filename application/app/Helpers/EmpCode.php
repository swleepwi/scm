<?php 
if (! function_exists('tgl_id')) {
    function tgl_id($tgl)
    {
        $dt = new Carbon($tgl);
        setlocale(LC_TIME, 'IND');
        return $dt->formatLocalized('%d %B %Y');   
    }
}
?>