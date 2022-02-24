<?php

// Lokalne postavke
if($_SERVER['SERVER_ADDR']==='127.0.0.1'){
    $url='http://edunovaapp.xyz/';
    $dev=true;
    $baza=[
        'server'=>'localhost',
        'baza'=>'edunovapp24',
        'korisnik'=>'edunova',
        'lozinka'=>'edunova'
    ];
// Postavke za server
} else {
    $url='https://polaznik32.edunova.hr/';
    $dev=false;
    $baza=[
        'server'=>'localhost',
        'baza'=>'eter_shop',
        'korisnik'=>'eter_edunova',
        'lozinka'=>'#~er6FxNU{#_'
    ];
}

return [
    'dev'=>$dev,
    'url'=>$url,
    'naslovApp'=>'Edunova APP',
    'baza'=>$baza
];

