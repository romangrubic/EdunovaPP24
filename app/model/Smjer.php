<?php

class Smjer
{
    // CRUD

    // Create
    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

        insert into smjer (naziv,trajanje, cijena, certificiran)
         values (:naziv,:trajanje,:cijena,:certificiran);

        ');
        $izraz->execute($parametri);
    }

    // Read
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

        select a.sifra, a.naziv, a.trajanje, a.cijena , a.certificiran, count(b.sifra) as grupa
        from smjer a 
        left join grupa b
        on a.sifra =b.smjer
        group by a.sifra, a.naziv, a.trajanje, a.cijena , a.certificiran;

        ');
        $izraz->execute();

        return $izraz->fetchAll();
    }
    
    // Update
    
    // Delete
    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

        delete from smjer where sifra=:sifra;

        ');
        $izraz->execute(['sifra'=>$sifra]);
    }
}