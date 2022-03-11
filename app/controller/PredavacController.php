<?php

class PredavacController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'predavac' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index', [
            'predavaci'=>Predavac::read()
        ]);
    }

    public function brisanje($sifra)
    {
        Predavac::delete($sifra);
        header('location:' . App::config('url') . 'predavac/index');
    }

}