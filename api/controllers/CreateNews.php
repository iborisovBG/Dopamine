<?php
class CreateNews extends News
{

    private $conn;
    private $table_name = "news";
    public $title;
    public $text;
    public $date;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->id = '';
        $this->id ='';
    }

    function create_news()
    {

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                title=:title, text=:text, date=:date";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->text = htmlspecialchars(strip_tags($this->text));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":text", $this->text);

        if ($stmt->execute()){

          //  $this->id = $this->conn->lastInsertId(); // return value is an integer
          $this->id = htmlspecialchars(strip_tags($this->conn->lastInsertId()));;
         return true;
        }
        return false;
    }
}
