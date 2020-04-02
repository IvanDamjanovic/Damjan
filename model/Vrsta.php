<?php

class Vrsta
{

    /*public static function traziVrste()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
            select a.sifra, b.ime,b.email,
            b.oib from polaznik a inner join osoba b
            on a.osoba=b.sifra
            where concat(b.ime,\' \',b.prezime) like :uvjet
            order by b.prezime, b.ime
        ');

        $izraz->execute(['uvjet'=>'%' . $_GET['uvjet'] . '%']);
        return $izraz->fetchAll();
    }*/

    /*public static function ukupnoStranica($uvjet)
    {
        $uvjet='%'.$uvjet.'%';
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select count(a.sifra) from polaznik a 
        inner join osoba b  on a.osoba=b.sifra
        where concat(b.ime, \' \', b.prezime, 
        \' \',ifnull(b.oib,\'\')) like :uvjet 
        ');
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->execute();
        $ukupnoRezultata=$izraz->fetchColumn();
        return ceil($ukupnoRezultata / App::config('rezultataPoStranici'));
    }*/

    /*public static function trazi($uvjet,$stranica)
    {
        $rps = App::config('rezultataPoStranici');

        $od = $stranica * $rps - $rps;


        $uvjet='%'.$uvjet.'%';
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra, a.brojugovora, b.ime, 
        b.prezime, b.oib, b.email, count(c.grupa) as ukupno
        from polaznik a inner join osoba b  on a.osoba=b.sifra
        left join clan c on a.sifra=c.polaznik
        where concat(b.ime, \' \', b.prezime, 
        \' \',ifnull(b.oib,\'\')) like :uvjet 
        group by a.sifra, a.brojugovora, b.ime, 
        b.prezime, b.oib, b.email limit :od,6
        
        ');
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->bindValue('od',$od, PDO::PARAM_INT);
        $izraz->execute();

        return $izraz->fetchAll();
    }*/

    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from vrsta');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from vrsta
        where sifra=:sifra');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz=$veza->prepare('insert into vrsta 
        (ime,kategorija,istrazivac,ugrozenost) values 
        (:ime,:kategorija,:istrazivac,:ugrozenost)');
        $izraz->execute([
            'ime' => $_POST['ime'],
            'kategorija' => $_POST['kategorija'],
            'istrazivac' => $_POST['istrazivac'],
            'ugrozenost' => $_POST['ugrozenost']
        ]); 

        $zadnjaSifra = $veza->lastInsertId();

        
        $izraz=$veza->prepare('insert into vrsta 
        (ime,kategorija) values 
        (:ime,:kategorija)');
        $izraz->execute([
            'ime' => $_POST['ime'],
            'kategorija' => $_POST['kategorija']
        ]); 
        
        
        $veza->commit();
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

        $izraz=$veza->prepare('select ime
            from vrsta  
            where sifra=:sifra');
            $izraz->execute([
                'sifra' => $_POST['sifra']
            ]);

            $sifraime = $izraz->fetchColumn();

        $izraz=$veza->prepare('update vrsta 
        set ime=:ime, kategorija=:kategorija,
        istrazivac=:istrazivac,ugrozenost=:ugrozenost
        where sifra=:sifra');
        $izraz->execute([
            'ime' => $_POST['ime'],
            'kategorija' => $_POST['kategorija'],
            'istrazivac' => $_POST['istrazivac'],
            'ugrozenost' => $_POST['ugrozenost'],
            'sifra' => $sifraime
        ]); 

    
        $izraz=$veza->prepare('update vrsta 
        set ime=:ime
        where sifra=:sifra');
        $izraz->execute([
            'sifra' => $_POST['sifra'],
            'ime' => $_POST['ime']
        ]); 
    
        
        $veza->commit();
    }
}