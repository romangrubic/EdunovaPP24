<?php

class LoginController extends Controller
{
    public function loginView($poruka, $email)
    {
        $this->view->render('login',[
            'poruka'=>$poruka,
            'email'=>$email
        ]);
    }

    public function index()
    {
        $this->loginView('Popunite email i lozinku.', '');
    }

    public function autoriziraj()
    {
        if(!isset($_POST['email']) || !isset($_POST['lozinka'])){
            $this->index();
            return;
        }

        if(strlen(trim($_POST['email']))===0){
            $this->loginView('Email obavezan.','');
            return;
        }

        if(strlen(trim($_POST['lozinka']))===0){
            $this->loginView('Lozinka obavezna.',$_POST['email']);
            return;
        }

        echo 'Uspjesno ste ulogirani!';
    }
}