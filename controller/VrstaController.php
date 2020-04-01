<?php

class VrstaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'vrsta' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Vrsta::readAll()
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
        Vrsta::create();
        $this->index();
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Vrsta::delete()){
            header('location: /vrsta/index');
        }
        
    }

    public function promjena()
    {
        $vrsta = Vrsta::read($_GET['sifra']);
        if(!$vrsta){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',
            ['vrsta'=>$vrsta,
                'poruka'=>'Promjenite željene podatke']
        );
     
    }

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        Vrsta::update();
        header('location: /vrsta/index');
    }
}