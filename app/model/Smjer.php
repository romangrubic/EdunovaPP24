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

            select * from smjer

        ');
        $izraz->execute();

        return $izraz->fetchAll();
    }
    // Update

    // Delete
}