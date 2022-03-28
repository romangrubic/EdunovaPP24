<?php

class GrupaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'grupa' . DIRECTORY_SEPARATOR;

    private $poruka;
    private $entitet;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'entiteti' => Grupa::read()
           ]);
    }

    public function novi()
    {
        header('location:' . App::config('url').'grupa/promjena/' . 
        Grupa::create([
            'naziv'=>'Nova grupa',
            'smjer'=>Smjer::read()[0]->sifra,
            'predavac'=>null,
            'datumpocetka'=>null]
            )
        );
    }

    public function odustani($sifra)
    {
        if(Grupa::odustajanje($sifra)){
            Grupa::delete($sifra);
        }
        header('location:' . App::config('url').'grupa/index');

    }


    public function promjena($sifra)
    {
        $this->entitet = Grupa::readOne($sifra);
        $this->view->render($this->viewDir . 'promjena',[
            'poruka'=>'Promjenite podatke',
            'e'=>$this->entitet,
            'smjerovi'=>Smjer::read(),
            'predavaci'=>Predavac::read(),
            'css'=>'<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">',
            'javascript'=>'<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
            <script src="' . App::config('url') . 'public/js/detaljiGrupe.js"></script>'
        ]);
    }


    public function brisanje($sifra)
    {
        Grupa::delete($sifra);
        header('location:' . App::config('url').'grupa/index');
    }
}