<?php

class Projekt
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from projekt');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from projekt
        where sifra=:sifra');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into projekt 
        (naziv,istrazivac,vrsta) values 
        (:naziv,:istrazivac,:vrsta)');
        $izraz->execute([
            'naziv' => $_POST['naziv'],
            'istrazivac' => $_POST['istrazivac'],
            'vrsta' => $_POST['vrsta'],
        ]);
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from projekt 
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
        $izraz=$veza->prepare('update projekt 
        set naziv=:naziv,istrazivac=:istrazivac,
        vrsta=:vrsta where sifra=:sifra');
        $izraz->execute([
                'naziv' => $_POST['naziv'],
                'istrazivac' => $_POST['istrazivac'],
                'vrsta' => $_POST['vrsta'],
        ]);
    }
}