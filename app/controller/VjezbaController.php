<?php

class VjezbaController extends Controller
{
    private $viewDir = 'vjezbanje' . DIRECTORY_SEPARATOR;

    public function primjer1()
    {
        echo 'Edunova';
    }

    public function primjer2()
    {
        $sb = rand(2,9);
        $ime='Edunova';
        $o = new stdClass();
        $o->ime='Pero';
        $o->prezime='Perić';
        $niz=[
            'Osijek', 'Zagreb', 'Donji Miholjac'
        ];
        shuffle($niz);

        $this->view->render($this->viewDir . 'ispisParametara',[
            'slucajniBroj'=>$sb,
            'skola'=>$ime,
            'voditelj'=>$o,
            'gradovi'=>$niz
        ]);
    }

    public function primjer3()
    {
        $parniBrojevi=[];
        for($i=1;$i<99;$i++){
            if($i%2===0){
                $parniBrojevi[]=$i;
            }
        }

        $this->view->render($this->viewDir . 'primjer3',[
            'parniBrojevi'=>$parniBrojevi
        ]);
    }
}