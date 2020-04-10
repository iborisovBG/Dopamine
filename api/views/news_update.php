<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: news_update.php
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once $_SERVER['DOCUMENT_ROOT'].'/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/classes/News.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/controllers/NewsUpdate.php';

//make connection
$database = new DopamineDB();
$db = $database->connection();
  
//news object
$news = new UpdateNews($db);
  
//get data
$data = json_decode(file_get_contents("php://input"));
  
$url = $_SERVER['REQUEST_URI'];

$url_arr = explode('/', $url);
//get the id to edit it
$id = intval(end($url_arr));
//if data is empty
if(
    !empty($data->title) &&
    !empty($data->date) &&
    !empty($data->text) 
){
//set the data
$news->id = $id;
$news->title = $data->title;
$news->text = $data->text;
$news->date = $data->date;
  
//update this news id
if($news->news_update()){
    //if response is ok
    http_response_code(200);
  
    //response
    echo json_encode(array("message" => "success."));
}
  

//response unable
else{
    // response not found
http_response_code(503);
    //response not exist
echo json_encode(array(
"success" => false,
"error" => array(
"message" => "Unable to update this news id.",
"details" => array( $data
),
"code" => 3
)
));
}
}else{
    // response not found
http_response_code(503);
     //response not exist
echo json_encode(array(
"success" => false,
"error" => array(
"message" => "Unable to update this news id.",
"details" => array( $data
),
"code" => 3
)
));
}
