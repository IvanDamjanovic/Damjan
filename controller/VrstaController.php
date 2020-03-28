<?php

class VrstaController extends AutorizacijaController
{
    public function index()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from vrsta');
        $izraz->execute();
        $rezultati = $izraz->fetchAll();

        $this->view->render('privatno' . 
        DIRECTORY_SEPARATOR . 'vrsta' .
        DIRECTORY_SEPARATOR . 'index',[
            'podaci'=>$rezultati
        ]);
    }
}