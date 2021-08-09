<?php


function set_active($uri, $output = "active")
{
    //dd($uri);
    if (is_array($uri)) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return $output;
            }
        }
    } else {
        if (Route::is($uri)) {
            return $output;
        }
    }
}

function getBranch()
{
   return Session::get('branch');
}
function format_uang($angka){
    $hasil=number_format($angka,0,',','.');
return $hasil;
}

function format_angka($angka){
    $hasil=number_format($angka,0,',','.');
return $hasil;
}
function tanggal_indo($tanggal){
    $hasil=date('d-m-y', strtotime($tanggal));;
return $hasil;
}
function tanggal_english($tanggal){
    $hasil=date('Y-m-d', strtotime($tanggal));;
return $hasil;
}

