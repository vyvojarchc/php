<?php

class Database {

    private static $instance = null;

    public static function getInstance(){
        if(null == self::$instance){
            try {
                //pripojeni k DB
                self::$instance = new PDO('mysql:host=134.209.226.86:3306;dbname=68092f6e6c42adf121bf125b', '68092f6e6c42adf121bf125b', 'fb367dae1dc7');
                //hlaseni chyb DB
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return self::$instance;

            } catch (PDOException $e){
                //odchytime vyjimku a vypiseme chybu pripojeni
                echo 'Error: '.$e->getMessage();
                return false;
            }
        }

        return self::$instance;

    }
}

?>