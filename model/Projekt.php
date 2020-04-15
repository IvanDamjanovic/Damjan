<?php

class Projekt
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.sifra, a.naziv, a.brojvrsta, b.naziv as istrazivac, 
            concat(d.ime, \' \', d.prezime) as istrazivac,
            count(e.vrsta) as ukupnovrsta
            from projekt a inner join istrazivac b on a.istrazivac=b.sifra
            left join istrazivac c on a.istrazivac=c.sifra
            left join vrsta d on c.vrsta=d.sifra, 
            concat(d.ime, \' \', d.prezime)
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select *
            from projekt 
            where sifra=:sifra

        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }
    
    public static function ucitajVrste($sifraVrste)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select * from vrsta where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifraVrste]);
        return $izraz->fetchAll();
    }
    
    public static function create($istrazivac)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into projekt 
        (naziv,istrazivac,brojvrsta) values 
        (\'\',:istrazivac,0)');
        $izraz->execute(['istrazivac' => $istrazivac]);  
       return $veza->lastInsertId();

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

    public static function update()
    {
        if($_POST['istrazivac']=='0'){
            $_POST['istrazivac']=null;
       
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update projekt 
        set naziv=:naziv,istrazivac=:istrazivac,
        brojvrsta=:brojvrsta,
         where sifra=:sifra');
        $izraz->execute($_POST);
        }
    
    }

}
