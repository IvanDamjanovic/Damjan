<?php

class IstrazivacController extends AdminController
{
    public function index()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from istrazivac');
        $izraz->execute();
        $rezultati = $izraz->fetchAll();

        $this->view->render('privatno' . 
     DIRECTORY_SEPARATOR . 'istrazivac' .
     DIRECTORY_SEPARATOR . 'index',[
        'podaci'=>$rezultati
     ]);
    }
}