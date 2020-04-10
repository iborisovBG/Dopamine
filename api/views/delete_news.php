<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: delete_news.php
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/classes/News.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/controllers/DeleteNews.php';

//create connection
$database = new DopamineDB();
$db = $database->connection();

$news = new DeleteNews($db);

// get news id
$data = json_decode(file_get_contents("php://input"));

$url = $_SERVER['REQUEST_URI'];

$url_arr = explode('/', $url);
//get the id to edit it
$id = intval(end($url_arr));

if (empty($id)) {
  echo json_encode(array("message" => "No providet details"));
  exit();
}
// 
$news->id = $id;

//delete it
if ($news->delete_news()) {

  //  200 ok
  http_response_code(200);

  // tell the user
  echo json_encode(array("message" => "{success}"));
}

// if not ok
else {

  // 503 unavailable
  http_response_code(503);

  //response not ok
  echo json_encode(array(
    "success" => false,
    "error" => array(
      "message" => "Unable to update this news id.",
      "details" => array(
        $id
      ),
      "code" => 3
    )
  ));
}
