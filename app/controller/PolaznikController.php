<?php

class PolaznikController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'polaznik' . DIRECTORY_SEPARATOR;

    private $poruka;
    private $polaznik;

    public function __construct()
    {
        parent::__construct();
        $this->polaznik = new stdClass();
        $this->polaznik->sifra = 0;
        $this->polaznik->ime = '';
        $this->polaznik->prezime = '';
        $this->polaznik->oib = '';
        $this->polaznik->email = '';        
        $this->polaznik->brojugovora = '';        
    }
    public function index()
    {
        if(!isset($_GET['stranica'])){
            $stranica = 1;
        }else{
            $stranica = (int)$_GET['stranica'];
        }
        if($stranica == 0){
            $stranica = 1;
        }

        if(!isset($_GET['uvjet'])){
            $uvjet = '';
        }else{
            $uvjet = $_GET['uvjet'];
        }

        $up = Polaznik::ukupnoPolaznika($uvjet);
        $ukupnoStranica = ceil($up / App::config('rps'));

        if($stranica>$ukupnoStranica){
            $stranica = $ukupnoStranica;
        }

        $this->view->render($this->viewDir . 'index', [
            'polaznici'=>Polaznik::read($stranica, $uvjet),
            'uvjet'=>$uvjet,
            'stranica'=>$stranica,
            'ukupnoStranica'=>$ukupnoStranica
        ]);
    }

    public function detalji($sifra=0)
    {
        if($sifra==0){
            $this->view->render($this->viewDir . 'detalji', [
                'polaznik'=>$this->polaznik,
                'poruka'=>'Unesite trazene podatke',
                'akcija'=>'Dodaj novi.'
            ]);
        }else{
            $this->view->render($this->viewDir . 'detalji', [
                'polaznik'=>Polaznik::readOne($sifra),
                'poruka'=>'Unesite trazene podatke',
                'akcija'=>'Promijenite podatke.'
            ]);
        }
    }

    public function akcija()
    {
        if($_POST['sifra']==0){
            if($this->kontrolaOIB($_POST['oib'])){
                Polaznik::create($_POST);
            }else{
                $this->view->render($this->viewDir . 'detalji', [
                    'polaznik'=>(object)$_POST,
                    'poruka'=>'Neispravan OIB',
                    'akcija'=>'Dodaj novi.'
                ]);
                return;
            }
        }else{
            // Prvo kontrole
            Polaznik::update($_POST);
        }
        header('location:' . App::config('url').'polaznik/index');
    }

    public function brisanje($sifra)
    {
        Polaznik::delete($sifra);
        header('location:' . App::config('url') . 'polaznik/index');
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