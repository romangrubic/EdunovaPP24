<?php

class SmjerController extends AutorizacijaController
{
    // Putanja do phtml datoteke
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'smjer' . DIRECTORY_SEPARATOR;

    private $nf;
    private $poruka;
    private $smjer;

    public function __construct()
    {
        parent::__construct();
        $this->nf = new \NumberFormatter("hr-HR", \NumberFormatter::DECIMAL);
        $this->nf->setPattern('#,##0.00 kn');
        $this->smjer = new stdClass();
        $this->smjer->naziv = '';
        $this->smjer->trajanje = 130;
        $this->smjer->cijena = 1.00;
        $this->smjer->certificiran = false;        
    }

    public function index()
    {
        $smjerovi = Smjer::read();

        foreach($smjerovi as $smjer){
            $smjer->cijena=$this->nf->format($smjer->cijena);
        }

        $this->view->render($this->viewDir . 'index',[
            'smjerovi'=>$smjerovi,
            'css'=> '<link rel="stylesheet" href="' . App::config('url') . 'public/css/smjerindex.css">'
        ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',[
            'poruka' => '',
            'smjer' => $this->smjer
        ]);
    }

    public function dodajNovi()
    {
        $this->smjer = (object)$_POST;

        if($this->smjer->certificiran == '1'){
            $this->smjer->certificiran = true;
        } else {
            $this->smjer->certificiran = false;
        }

        if($this->kontrolaNaziv()
        && $this->kontrolaTrajanje()
        && $this->kontrolaCijena()){
            Smjer::create($_POST);
            $this->index();
        }else{
            $this->view->render($this->viewDir . 'novi', [
                'poruka' => $this->poruka,
                'smjer' => $this->smjer
            ]);
        }
        
    }

    // Kontrole ispravnosti za formu
    private function kontrolaNaziv()
    {
        if(strlen($this->smjer->naziv)===0){
            $this->poruka = 'Naziv obavezan.';
            return false;
        }
        if(strlen($this->smjer->naziv)>50){
            $this->poruka = 'Naziv ne smije biti dulji od 50 znakova.';
            return false;
        }
        return true;
    }

    private function kontrolaTrajanje()
    {
        if(strlen(trim($this->smjer->trajanje)) === 0){
            $this->poruka = 'Trajanje obavezno.';
            return false;
        }

        $broj = (int) trim($this->smjer->trajanje);
        if($broj <= 0){
            $this->poruka = 'Trajanje mora biti cijeli broj veci od 0, unijeli ste ' . $this->smjer->trajanje;
            $this->smjer->trajanje = '';
            return false;
        }
        return true;
    }

    private function kontrolaCijena()
    {
        if(strlen(trim($this->smjer->cijena)) > 0){
            $broj = (float) trim($this->smjer->cijena);
            if($broj <= 0){
                $this->poruka = 'Ako unosite cijenu mora biti decimalni broj veci od 0, unijeli ste ' . $this->smjer->cijena;
                $this->smjer->cijena = 1.00;
            return false;
            }
        }
        return true;
    }

    public function brisanje($sifra)
    {
        Smjer::delete($sifra);
        $this->index();
    }
}