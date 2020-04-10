<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: read_news.php
*/
class Authorization
{
    public $digest;
    private $conn;
    private $this;
    private $users_table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
        $this->user_role = "";
        $this->Loggedornot();

    }

    // function to parse the http auth header
    function http_digest_parse($txt)
    {
        // protect against missing data
        $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $data;
    }

   public function Loggedornot()
    {
        $query = "SELECT username,password FROM " . $this->users_table . "";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        $valid_passwords = $result;

        $valid_users = array_keys($valid_passwords);

        $user = $_SERVER['PHP_AUTH_USER'] ?? '';
        $pass = $_SERVER['PHP_AUTH_PW'] ?? '';

        $validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

        if (!$validated) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            die("Not authorized Please contact your APP provider");
        }
        // If arrives here, is a valid user.
        $query = "SELECT * FROM " . $this->users_table . "  WHERE username = '$user'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user);
        $stmt->execute();
        if ($stmt->rowCount()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->user_role  = $row['role'] == '1' ? $row['role'] : '2';
        } else {

        }
    }
}
