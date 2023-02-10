<?php

use App\Models\StatusProject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

## ENCRIPT
function enc($v = null)
{
    if (empty($v)) Redirect('');
    $id = str_replace("/", "+258147369+", Crypt::encryptString($v));
    if (!empty($id) && $id != null && $id != '') return $id;
    else Redirect('');
}

## DECRYPT 2
function dec($v = null)
{
    if (empty($v)) Redirect('');
    $id =  Crypt::decryptString(str_replace("+258147369+", "/", $v));
    if (!empty($id) && $id != null && $id != '') return $id;
    else Redirect('');
}

function timestampf($data)
{
    if(empty($data)) return '-';
    else return date("d M Y, H:i:s", strtotime($data));
}

function timef($data = null){
    if(empty($data)) return '-';
    else return date("H:i", strtotime($data));
}

function numberf($data = null){
    if(empty($data)) return '-';
    else return number_format($data,2,".",",");
}
