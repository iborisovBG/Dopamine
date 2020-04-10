<?php
class DeleteNews extends News
{
    private $conn;
    private $table_name = "news";
    public $id;
    public $title;
    public $text;
    public $date;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function delete_news()
    {

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
