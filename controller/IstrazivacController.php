<?php

class IstrazivacController extends AdminController
{

    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'istrazivac' . 
    DIRECTORY_SEPARATOR;
    
    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Istrazivac::readAll()
     ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',
        ['poruka' => 'Popunite sve tražene podatke']
    );
    }

    public function dodajnovi()
    {
        //prvo dođu sve silne kontrole
        Istrazivac::create();
        $this->index();
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Istrazivac::delete()){
            header('location: /istrazivac/index');
        }
        
    }

    public function promjena()
    {
        $istrazivac = Istrazivac::read($_GET['sifra']);
        if(!$istrazivac){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',
        ['istrazivac'=>$istrazivac,
            'poruka'=>'Promjenite željene podatke']
    );
    }

    public function promjeni()
    {
        Istrazivac::update();
        header('location: /istrazivac/index');
    }
}