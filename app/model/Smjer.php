<?php

class Smjer
{
    // CRUD

    // Create

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
}