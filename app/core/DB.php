<?php
// čitati https://phpenthusiast.com/blog/the-singleton-design-pattern-in-php
class DB extends PDO
{
    private static $instanca=null;

    public static function getInstanca()
    {
        if(self::$instanca==null){
            self::$instanca=new self();        
        }
        return self::$instanca;
    }

} 