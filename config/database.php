<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: database.php
*/
class DopamineDB{
    private $host = "localhost";
    private $db_name = "dopamine";
    private $username = "dopamine";
    private $password = "dopamine@2020";
    public $conn;
  
    // get the database connection
    public function connection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>