<?php

class VrstaController extends AutorizacijaController
{

    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'vrsta' .
    DIRECTORY_SEPARATOR;
    /*
    public function trazivrsta(){
        header('Content-Type: application/json');
        echo json_encode(Vrsta::traziVrste());
    }

    public function trazi()
    {
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>Vrsta::trazi($_GET['uvjet'])
           ]);
    }
    */
    public function trazi()
    {
        
        if(!isset($_GET['stranica']) || $_GET['stranica']=='0'){
            $stranica=1;
        }else{
            $stranica=$_GET['stranica'];
        }

        $podaci = Vrsta::trazi($_GET['uvjet'],
        $stranica);

        if(count($podaci)===0){
            $stranica--;
            $podaci = Vrsta::trazi($_GET['uvjet'],
            $stranica);
        }

        $this->view->render($this->viewDir . 'index',[
            'podaci'=>$podaci,
            'stranica' => $stranica,
            'uvjet' => $_GET['uvjet'],
            'ukupnoStranica' => Vrsta::ukupnoStranica($_GET['uvjet'])
           ]);
    }

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>Vrsta::trazi('','1'),
            'stranica' => '1',
            'uvjet' => '',
            'ukupnoStranica' => Vrsta::ukupnoStranica('')
           ]);
        
     
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',
            ['istrazivaci'=>Istrazivac::readAll(),
            'poruka'=>'Popunite sve tražene podatke']
        );
    }


    public function dodajnovi()
    {
        Vrsta::create();
        $this->index();
    }

    public function obrisi()
    {
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
            'istrazivaci' => Istrazivac::readAll(),
                'poruka'=>'Promjenite željene podatke']
        );
     
    }

    public function promjeni()
    {
        Vrsta::update();
        header('location: /vrsta/index');
    }

}