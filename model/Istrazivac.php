<?php

class Istrazivac
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select sifra,
        ime, prezime, uloga, email from istrazivac where sifra>=1');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select sifra, 
        ime, prezime, uloga, email from istrazivac
        where sifra=:sifra');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into istrazivac
        (email,lozinka,ime,prezime,uloga) values
        (:email,:lozinka,:ime,:prezime,:uloga)');
        unset($_POST['lozinkaponovo']);
        $_POST['lozinka'] = 
            password_hash($_POST['lozinka'],PASSWORD_BCRYPT);
        $izraz->execute($_POST);

        /* NAČIN 2
        $izraz->execute([
            'email' => $_POST['email'],
            'lozinka' => $_POST['lozinka'],
            'ime' => $_POST['ime'],
            'prezime' => $_POST['prezime'],
            'uloga' => $_POST['uloga'],
        ]);
                */
    }

    public static function registrirajnovi()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into istrazivac 
        (email,lozinka,ime,prezime,uloga,sessionid) values 
        (:email,:lozinka,:ime,:prezime,:uloga,:sessionid)');
        unset($_POST['lozinkaponovo']);

        $_POST['lozinka'] = 
             password_hash($_POST['lozinka'],PASSWORD_BCRYPT);
        $_POST['sessionid'] = session_id();
        $_POST['uloga'] = 'istrazivac';
        //print_r($_POST);

        $izraz->execute($_POST);
        $headers = "From: RedBook <ivan.damjanovic8@gmail.com>\r\n";
        $headers .= "Reply-To: RedBook <ivan.damjanovic8@gmail.com>\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($_POST['email'],'Završi registraciju na RedBook',
                '<a href="' . App::config('url') . 
                'index/zavrsiregistraciju?id=' . $_POST['sessionid'] . '">Završi</a>', $headers);
         
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from istrazivac 
            where sifra=:sifra');
            $izraz->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function update(){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update istrazivac 
        set email=:email,ime=:ime,
        prezime=:prezime,uloga=:uloga where sifra=:sifra');
        $izraz->execute($_POST);
    }

    public static function zavrsiregistraciju($id){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update istrazivac 
        set uloga=istrazivac where sessionid=:sessionid');
        $izraz->execute(['sessionid'=>$id]);
    }
}