<?php

class App
{
    public static function start()
    {
        $ruta = Request::getRuta();
        // echo $ruta;

        $dijelovi = explode(DIRECTORY_SEPARATOR, $ruta);

        // echo $dijelovi

        $klasa = '';
        if (!isset($dijelovi[1]) || $dijelovi[1] === '') {
            $klasa = 'Index';
        } else {
            $klasa = ucfirst($dijelovi[1]);
        }

        $klasa .= 'Controller';

        // echo $klasa;

        if (!isset($dijelovi[2]) || $dijelovi[2] === '') {
            $metoda = 'index';
        } else {
            $metoda = $dijelovi;
        }

        // echo $klasa . '->' . $metoda . '()';

        if (class_exists($klasa) && method_exists($klasa, $metoda)) {
            // Klasa i metoda postoje, instancirati klasu i pozvati metodu
            $instanca = new $klasa();
            $instanca->$metoda();
        } else {
            // metoda na klasi ne postoji, obavijestiti korisnika
            echo $klasa . '->' . $metoda . '() ne postoji. 404stranica.';
        }

        // $kontroler = new IndexController();
        // $kontroler->index();
    }
}
