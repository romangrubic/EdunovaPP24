<?php

class App
{
    public static function start()
    {
        $ruta = Request::getRuta();
        // echo $ruta;

        $dijelovi = explode(DIRECTORY_SEPARATOR, $ruta);

        // print_r($dijelovi);

        $klasa = '';
        if (!isset($dijelovi[1]) || $dijelovi[1] === '') {
            $klasa = 'Index';
        } else {
            $klasa = ucfirst($dijelovi[1]);
        }

        $klasa .= 'Controller';

        // echo $klasa;

        $metoda = '';
        if (!isset($dijelovi[2]) || $dijelovi[2] === '') {
            $metoda = 'index';
        } else {
            $metoda = $dijelovi[2];
        }

        // echo $klasa . '->' . $metoda . '()';

        if (class_exists($klasa) && method_exists($klasa, $metoda)) {
            // Klasa i metoda postoje, instancirati klasu i pozvati metodu
            $instanca = new $klasa();
            $instanca->$metoda();
        } else {
            // metoda na klasi ne postoji, obavijestiti korisnika
            $view = new View();
            $view->render('error404',[
                'onoceganema'=>$klasa . '->' . $metoda
            ]);
        }

        // $kontroler = new IndexController();
        // $kontroler->index();
    }

    public static function config($kljuc)
    {
        $config = include BP_APP . 'konfiguracija.php';
        return $config[$kljuc];
    }
}
