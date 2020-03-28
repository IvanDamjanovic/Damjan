<?php

class AutorizacijaController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['istrazivac'])){
            $this->view->render('prijava',[
                'poruka'=>'Morate se prijaviti',
                'email'=>''
            ]);
            exit;
        }
    }

}