<?php 

class UpdateNews extends News{

    private $conn;
    private $table_name = "news";
    public $id;
    public $title;
    public $text;
    public $date;
  
    public function __construct($db){
        $this->conn = $db;
    }

    function news_update(){

        $query = "SELECT
                  *
                FROM
                    " . $this->table_name . " WHERE id=$this->id";
    
        $stmt = $this->conn->prepare($query);
      
        $stmt->execute();
      
      if($stmt->rowCount()){
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    title = :title,
                    text = :text,
                    date = :date
                WHERE
                    id = :id";
      
        $stmt = $this->conn->prepare($query);
      
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->text=htmlspecialchars(strip_tags($this->text));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->id=htmlspecialchars(strip_tags($this->id));
      
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':id', $this->id);
      
        if($stmt->execute()){
            return true;
        }
        echo "\nPDO::errorInfo():\n";
        print_r($stmt->errorInfo());
        return false;
        }
      
        return false;
    }
    
    

}