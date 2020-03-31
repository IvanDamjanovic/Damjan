<?php

class IstrazivacController extends AdminController
{

    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'istrazivac' . 
    DIRECTORY_SEPARATOR;
    
    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>istrazivac::read()
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
        Istrazivac::delete();
        //$this->index();
        header('location: /istrazivac/index');
    }
}