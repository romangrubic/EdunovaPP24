<?php

class JavascriptController extends Controller
{
    public function index()
    {
       $this->view->render('javascript',[
           'javascript'=>'<script src="' . App::config('url') . 'public/js/osnoveJS.js"></script>'
       ]);
    }   
} 