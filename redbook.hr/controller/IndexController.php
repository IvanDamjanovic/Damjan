<?php

class IndexController
{

    private $view;

    public function __construct()
    {
        $this->view = new View();
    }


    public function prijava()
    {
        $this->view->render('prijava',[
            'poruka'=>'Unesite pristupne podatke',
            'email'=>''
        ]);
    }


    public function autorizacija()
    {
        if(!isset($_POST['email']) || 
        !isset($_POST['lozinka'])){
            $this->view->render('prijava',[
                'poruka'=>'Nisu postavljeni pristupni podaci',
                'email' =>''
            ]);
            return;
        }

        $veza = new PDO('mysql:host=localhost;dbname=crvenaknjiga;charset=utf8',
        'edunova','edunova');
        //sql INJECTION PROBLEM
        //$veza->query('select lozinka from operater 
        //              where email=\'' . $_POST['email'] . '\';');

        $izraz = $veza->prepare('select * from operater
                        where email=:email;');
        $izraz->execute(['email'=>$_POST['email']]);
        $rezultat=$izraz->fetch(PDO::FETCH_OBJ);

        if($rezultat==null){
            $this->view->render('prijava',[
                'poruka'=>'Ne postojeći korisnik',
                'email'=>$_POST['email']
            ]);
            return;
        }

        if(!password_verify($_POST['lozinka'],$rezultat->lozinka)){
            $this->view->render('prijava',[
                'poruka'=>'Neispravna kombinacija email i lozinka',
                'email'=>$_POST['email']
            ]);
            return;
        }

        unset($rezultat->lozinka);
        $_SESSION['operater']=$rezultat;
        $this->view->render('privatno' . DIRECTORY_SEPARATOR . 'nadzornaPloca');
    }

    
    public function index()
    {
        $poruka='hello iz kontrolera';
        $kod=22;

       
        $this->view->render('pocetna',[
            'p'=>$poruka,
            'k'=>$kod]
        );


    }
    public function onama()
    {
        $this->view->render('onama');
    }

    public function json()
    {
        $niz=[];
        $s=new stdClass();
        $s->naziv='Popis ugroženih vrsta';
        $s->sifra=1;
        $niz[]=$s;
        //$this->view->render('onama',$niz);
        echo json_encode($niz);
    }
}