<?php

class Contact {

    //objekt DB pripojeni
    protected static $Conn;

    //ORM promenne
    protected $id;
    protected $name;
    protected $surname;
    protected $email;
    protected $phone;
    protected $mobile;
    protected $address;

    //contruktor - pripojeni k DB
    public function __construct(){

        //ziska objekt pro pripojeni k DB
        self::$Conn = Database::getInstance();

    }

    //Load - nacte jeden radek z databaze
    public static function Load($intId){

        //ziska objekt pro pripojeni k DB
        self::$Conn = Database::getInstance();

        //statement - dotaz nad DB
        $stmt = self::$Conn->prepare('SELECT * FROM contact WHERE id = :id');
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Contact');
        //provedeme pripraveny dotaz
        $stmt->execute(array(':id'=>$intId));

        return  $stmt->fetch();
    }

    //LoadAll - nacte vsechny radky z tabulky
    public static function LoadAll(){

        //ziska objekt pro pripojeni k DB
        self::$Conn = Database::getInstance();

        //pole pro objekty
        $arrObjects = array();

        $stmt = self::$Conn->query('SELECT * FROM contact');
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Contact');

        while($Contact = $stmt->fetch()){

            array_push($arrObjects, $Contact);
        }

        return $arrObjects;
    }

    public function Delete() {
        //maze instanci
        $stmt = self::$Conn->prepare('DELETE FROM contact WHERE id=:id');
        $stmt->execute(array(':id'=>$this->id));

    }


    //Save - ulozeni instance objektu do DB
    public function Save(){
        try {

            if($this->id){
                //update existujiciho radku v db
                $stmt = self::$Conn->prepare('UPDATE contact SET name=:name, surname=:surname, email=:email, phone=:phone, mobile=:mobile, address=:address WHERE id=:id');
                $stmt->execute(array(
                    ':id' => $this->id,
                    ':name' => $this->name,
                    ':surname' => $this->surname,
                    ':email' => $this->email,
                    ':phone' => $this->phone,
                    ':mobile' => $this->mobil,
                    ':address' => $this->address
                ));

            } else {

                $stmt = self::$Conn->prepare('INSERT INTO contact (name, surname, email, phone, mobile, address) VALUES (:name,:surname,:email,:phone,:mobile,:address)');
                $stmt->execute(array(
                    ':name' => $this->name,
                    ':surname' => $this->surname,
                    ':email' => $this->email,
                    ':phone' => $this->phone,
                    ':mobile' => $this->mobil,
                    ':address' => $this->address
                ));
            }

            return self::$Conn->lastInsertId();

        } catch (PDOException $e){

            echo 'Error: '.$e->getMessage();
        }

    }

    //getter - ziskani vlastnosti objektu
    public function __get($strName){

        switch ($strName) {
    
            case 'Name':
                return $this->name;
                break;

            case 'Surname':
                return $this->surname;
                break;

            case 'Email':
                return $this->email;
                break;
        }
    }

    //setter - nastaveni vlastnosti objektu
    public function __set($strName, $mixValue){

        switch($strName){

            case 'Name':
                $this->name = $mixValue;
                break;

            case 'Surname':
                $this->surname = $mixValue;
                break;

            case 'Email':
                $this->email = $mixValue;
                break;
        }

    }


}
