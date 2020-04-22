<?php

class Vrsta
{

    public static function traziVrste()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

        select a.sifra, a.ime, a.kategorija, a.ugrozenost, 
        concat(b.ime, \' \', b.prezime) as istrazivac
        from vrsta a inner join 
        istrazivac b on a.istrazivac=b.sifra 

        ');

        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function ukupnoStranica($uvjet)
    {
        $uvjet='%'.$uvjet.'%';
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

        select * from vrsta 

        ');
        //$izraz->bindParam('uvjet',$uvjet);
        $izraz->execute();
        $ukupnoRezultata=$izraz->fetchColumn();
        return ceil($ukupnoRezultata / App::config('rezultataPoStranici'));
    }

    public static function trazi($uvjet,$stranica)
    {
        $rps = App::config('rezultataPoStranici');

        $od = $stranica * $rps - $rps;


        $uvjet='%'.$uvjet.'%';
        $veza = DB::getInstanca();
        //odrediti broj prikaza na jednoj stranici
        $izraz = $veza->prepare('
        
        select a.sifra, a.ime, a.kategorija, a.ugrozenost, 
        concat(b.ime, \' \', b.prezime) as istrazivac
        from vrsta a inner join 
        istrazivac b on a.istrazivac=b.sifra 

        ');
        //$izraz->bindParam('uvjet',$uvjet);
        //$izraz->bindValue('od',$od, PDO::PARAM_INT);
        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

        select a.sifra, a.ime, a.kategorija, a.ugrozenost, 
        concat(b.ime, \' \', b.prezime) as istrazivac
        from vrsta a inner join 
        istrazivac b on a.istrazivac=b.sifra

        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select * from vrsta
        where sifra=:sifra
        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();

        $izraz=$veza->prepare('insert into vrsta 
        (ime,kategorija,istrazivac,ugrozenost) values 
        (:ime,:kategorija,:istrazivac,:ugrozenost)');
        $izraz->execute([
            'ime' => $_POST['ime'],
            'kategorija' => $_POST['kategorija'],
            'istrazivac' => $_POST['istrazivac'],
            'ugrozenost' => $_POST['ugrozenost']
        ]); 

    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $veza->beginTransaction();
            $izraz=$veza->prepare('select ime
            from vrsta  
            where sifra=:sifra');
            $izraz->execute($_GET);

            $sifraime = $izraz->fetchColumn();

            $izraz=$veza->prepare('delete from vrsta 
            where sifra=:sifra');
            $izraz->execute($_GET);


            $izraz=$veza->prepare('delete from ime 
            where sifra=:sifra');
            $izraz->execute(['sifra'=>$sifraime]);


            $veza->commit();
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function update(){
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz=$veza->prepare('
        select * from vrsta
        where sifra=:sifra
        ');
            $izraz->execute([
                'sifra' => $_POST['sifra']
            ]);

            $sifravrsta = $izraz->fetchColumn();
        
        
        $izraz=$veza->prepare('update vrsta 
        set ime=:ime, kategorija=:kategorija
        where sifra=:sifra');
        $izraz->execute([
            'ime' => $_POST['ime'],
            'kategorija' => $_POST['kategorija'],
            'sifra' => $sifravrsta
        ]); 

        $izraz=$veza->prepare('update vrsta 
        set istrazivac=:istrazivac, ugrozenost=:ugrozenost
        where sifra=:sifra');
        $izraz->execute([
            'sifra' => $_POST['sifra'],
            'istrazivac' => $_POST['istrazivac'],
            'ugrozenost' => $_POST['ugrozenost']
        ]); 
    
        
        $veza->commit();



    }
}