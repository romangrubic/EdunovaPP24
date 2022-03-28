<?php

class Grupa
{

    public static function odustajanje($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select count(*) from grupa 
            where sifra=:parametar
            and naziv=\'Nova grupa\'
            and predavac is null
            and datumpocetka is null
            and smjer=(select sifra from smjer order by certificiran desc, naziv limit 1);
        
        '); 
        $izraz->execute(['parametar'=>$kljuc]);
        return $izraz->fetchColumn()==1 ? true : false;
    }


    public static function readOne($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select * from grupa where sifra=:parametar;
        
        '); 
        $izraz->execute(['parametar'=>$kljuc]);
        $grupa= $izraz->fetch();
        
        $izraz = $veza->prepare('
        
            select b.sifra, c.ime, c.prezime
            from clan a
            inner join polaznik b on a.polaznik =b.sifra 
            inner join osoba c on b.osoba =c.sifra 
            where a.grupa = :parametar;
        
        '); 
        $izraz->execute(['parametar'=>$grupa->sifra]);
        $grupa->polaznici=$izraz->fetchAll();
        return $grupa;
    }

    // CRUD

    //R - Read
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.sifra, a.naziv, b.naziv as smjer, 
            concat(d.ime, \' \', d.prezime) as predavac,
            a.datumpocetka, count(e.polaznik) as polaznika
            from grupa a inner join smjer b on 
            a.smjer=b.sifra
            left join predavac c on a.predavac =c.sifra 
            left join osoba d on c.osoba =d.sifra
            left join clan e on a.sifra=e.grupa 
            group by a.sifra, a.naziv, b.naziv, 
            concat(d.ime, \' \', d.prezime), a.datumpocetka;
        
        
        '); 
        $izraz->execute();
        return $izraz->fetchAll();
    }

    //C - Create
    // $parametri su asocijativni niz - tako mi odgovara
    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            insert into grupa (naziv,smjer,predavac,datumpocetka)
            values (:naziv,:smjer,:predavac,:datumpocetka);
        
        '); 
        $izraz->execute($parametri);
        return $veza->lastInsertId();
    }


    //U - Update
    public static function update($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            update grupa set 
                naziv=:naziv,
                smjer=:smjer,
                predavac=:predavac,
                datumpocetka=:datumpocetka
                where sifra=:sifra;
        
        '); 
        $izraz->execute($parametri);

    }

    //D - Delete
    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            delete from grupa where sifra=:sifra;
        
        '); 
        $izraz->execute(['sifra'=>$sifra]);

    }
} 