<?php

class Operater
{
    public static function autoriziraj($email, $lozinka)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
            select * from operater where email=:email
        ');
        $izraz->execute(['email' => $email]);

        $operater = $izraz->fetch();

        if ($operater == null) {
            return null;
        }

        if (password_verify($lozinka, $operater->lozinka)){
            return null;
        }

        // Micemo lozinku iz operatera da ju ne spremimo u SESSION
        unset($operater->lozinka);
        return $operater;
    }
}
