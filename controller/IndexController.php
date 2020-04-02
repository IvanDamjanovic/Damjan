<?php

class IndexController extends Controller
{

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

        if(trim($_POST['email'])==='' || 
        trim($_POST['lozinka'])===''){
            $this->view->render('prijava',[
                'poruka'=>'Pristupni podaci obavezno',
                'email'=>$_POST['email']
            ]);
            return;
        }

        //$veza = new PDO('mysql:host=localhost;dbname=redbook;charset=utf8',
        //'edunova','edunova');

        $veza = DB::getInstanca();

        	    //sql INJECTION PROBLEM
        //$veza->query('select lozinka from operater 
        //              where email=\'' . $_POST['email'] . '\';');
        $izraz = $veza->prepare('select * from istrazivac 
                      where email=:email;');
        $izraz->execute(['email'=>$_POST['email']]);
        //$rezultat=$izraz->fetch(PDO::FETCH_OBJ);
        $rezultat=$izraz->fetch();
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
        $_SESSION['istrazivac']=$rezultat;
        //$this->view->render('privatno' . DIRECTORY_SEPARATOR . 'nadzornaPloca');
        $npc = new NadzornaplocaController();
        $npc->index();
    }

    public function odjava()
    {
        unset($_SESSION['istrazivac']);
        session_destroy();
        $this->index();
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

    public function registracija()
    {
        $this->view->render('registracija');
    }

    public function onama()
    {
        $this->view->render('onama');
    }

    public function json()
    {
        $niz=[];
        $s=new stdClass();
        $s->naziv='istrazivanje';
        $s->sifra=1;
        $niz[]=$s;
        //$this->view->render('onama',$niz);
        echo json_encode($niz);
    }

    public function test()
    {
     echo password_hash('e',PASSWORD_BCRYPT);
      // echo md5('mojaMala'); NE KORISTITI
    }

    public function registrirajnovi()
    {
        //prvo dođu sve silne kontrole
        Istrazivac::registrirajnovi();
        $this->view->render('registracijagotova');
    }

    public function zavrsiregistraciju()
    {
        Istrazivac::zavrsiregistraciju($_GET['id']);
        $this->view->render('prijava');
    }

    public function email()
    {
        $headers = "From: Ivan Damjanović <ivan.damjanovic8@gmail.com>\r\n";
$headers .= "Reply-To: Ivan Damjanović <ivan.damjanovic8@gmail.com>\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail('ivan.damjanovic8@gmail.com','Test','Test poruka <a href="http://redbook.hr/">Red Book</a>', $headers);
        echo 'GOTOV';
    }
}