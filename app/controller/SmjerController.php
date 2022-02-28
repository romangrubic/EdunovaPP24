<?php

class SmjerController extends AutorizacijaController
{
    // Putanja do phtml datoteke
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'smjer' . DIRECTORY_SEPARATOR;

    private $nf;

    public function __construct()
    {
        parent::__construct();
        $this->nf = new \NumberFormatter("hr-HR", \NumberFormatter::DECIMAL);
        $this->nf->setPattern('#,##0.00 kn');
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
}