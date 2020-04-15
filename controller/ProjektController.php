<?php

class ProjektController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'projekt' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Projekt::readAll()
     ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',
            ['poruka'=>'Popunite sve tražene podatke']
        );
    }

    public function dodajnovi()
    {
        //prvo dođu sve silne kontrole
        Projekt::create();
        $this->index();
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Projekt::delete()){
            header('location: /projekt/index');
        }
        
    }

    public function promjena()
    {
        $projekt = Projekt::read($_GET['sifra']);
        if(!$projekt){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',
            ['projekt'=>$projekt,
                'poruka'=>'Promjenite željene podatke']
        );
     
    }

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        Projekt::update();
        header('location: /projekt/index');
    }
}