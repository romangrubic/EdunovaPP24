<?php

class PredavacController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'predavac' . DIRECTORY_SEPARATOR;

    private $poruka;
    private $predavac;

    public function __construct()
    {
        parent::__construct();
        $this->predavac = new stdClass();
        $this->predavac->sifra = 0;
        $this->predavac->ime = '';
        $this->predavac->prezime = '';
        $this->predavac->oib = '';
        $this->predavac->email = '';        
        $this->predavac->iban = '';        
    }
    public function index()
    {
        $this->view->render($this->viewDir . 'index', [
            'predavaci'=>Predavac::read()
        ]);
    }

    public function detalji($sifra=0)
    {
        if($sifra==0){
            $this->view->render($this->viewDir . 'detalji', [
                'predavac'=>$this->predavac,
                'poruka'=>'Unesite trazene podatke',
                'akcija'=>'Dodaj novi.'
            ]);
        }else{
            $this->view->render($this->viewDir . 'detalji', [
                'predavac'=>Predavac::readOne($sifra),
                'poruka'=>'Unesite trazene podatke',
                'akcija'=>'Promijenite podatke.'
            ]);
        }
    }

    public function akcija()
    {
        if($_POST['sifra']==0){
            if($this->kontrolaOIB($_POST['oib'])){
                Predavac::create($_POST);
            }else{
                $this->view->render($this->viewDir . 'detalji', [
                    'predavac'=>(object)$_POST,
                    'poruka'=>'Neispravan OIB',
                    'akcija'=>'Dodaj novi.'
                ]);
                return;
            }
        }else{
            // Prvo kontrole
            Predavac::update($_POST);
        }
        header('location:' . App::config('url').'predavac/index');
    }

    public function brisanje($sifra)
    {
        Predavac::delete($sifra);
        header('location:' . App::config('url') . 'predavac/index');
    }

    private function kontrolaOIB($oib) {

        if (strlen($oib) != 11 || !is_numeric($oib)) {
            return false;
        }

        $a = 10;

        for ($i = 0; $i < 10; $i++) {

            $a += (int)$oib[$i];
            $a %= 10;

            if ( $a == 0 ) { $a = 10; }

            $a *= 2;
            $a %= 11;

        }

        $kontrolni = 11 - $a;

        if ( $kontrolni == 10 ) { $kontrolni = 0; }

        return $kontrolni == intval(substr($oib, 10, 1), 10);
    }
}