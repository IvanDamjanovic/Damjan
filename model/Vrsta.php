<?php

class Vrsta
{
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
        $izraz=$veza->prepare('insert into vrsta 
        (ime,kategorija,istrazivac,ugrozenost) values 
        (:ime,:kategorija,:istrazivac,:ugrozenost)');
        $izraz->execute($_POST);   
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from vrsta where sifra=:sifra');
            $izraz->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function update(){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update vrsta 
        set ime=:ime,kategorija=:kategorija,
        istrazivac=:istrazivac,ugrozenost=:ugrozenost, 
        where sifra=:sifra');
        $izraz->execute($_POST);
    }
}