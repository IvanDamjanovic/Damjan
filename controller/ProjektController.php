<?php

class ProjektController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'projekt' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Projekt::readAll(),
         'istrazivac' => Istrazivac::readAll(),
         'javascript'=>'<script src="' . APP::config('url') . 
         'public/js/grupa/index.js"></script>'
     ]);
     

    }

    public function novi()
    {
        if(!isset($_POST['istrazivac']) || 
        $_POST['istrazivac']=='0'){
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Projekt::readAll(),
                'istrazivac' => Istrazivac::readAll(),
                'alertPoruka'=>'Morate odabrati istraživača'
            ]);
            return;
        }

        $sifraNovogProjekta=Projekt::create($_POST['istrazivac']);
        $projekt = Projekt::read($sifraNovogProjekta);
        $this->detalji($projekt);

        //$this->detalji(Grupa::read(Grupa::create($_POST['smjer'])));
       
    }

    public function promjena()
    {
        $projekt = Projekt::read($_GET['sifra']);
        if(!$projekt){
            $this->index();
            exit;
        }
        $this->detalji($projekt);
         
     
    }

    public function promjeni()
    {
        //cijeli niz kontrola
        Projekt::update();
        $this->index();
       //print_r($_POST);
    }

    public function obrisi()
    {
        //cijeli niz kontrola
        if(Projekt::delete()){
            header('location: /projekt/index');
        }
    }

    private function detalji($projekt)
    {
        $projekt->vrste=Projekt::ucitajprojektrste($projekt->sifra);
        $this->view->render($this->viewDir . 'detalji',[
            'projekt'=>$projekt,
            'istrazivaci' => Istrazivac::readAll(),
            'css' => '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">',
            'jsLib' => '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>',
            'javascript'=>'<script src="' . APP::config('url') . 
                'public/js/grupa/detalji.js"></script>'
            ]);  
    }

    public function vrste(){
        echo 'hello s servera s ' . $_GET['sifra'];
    }
   
}