<?php

class InitRest
{
    public function __construct()
    {
        include 'config/database.php';
        include 'api/classes/Authorization.php';
        $database = new DopamineDB();
        $db = $database->connection();
        $login = new Authorization($db);
        $premissions = $login->user_role;
        include 'api/classes/Router.php';
        $router = new Router();

        //All news
        $router->map('GET', '/news/', function () {
            require_once('api/views/all_news.php');
        });
        //One record
        $router->map('GET', '/news/[i:id]', function ($id) {
            require_once('api/views/news_id.php');
        });
        //Update News ID with admin 
        if($premissions == '1'){
        $router->map('POST', '/news/[i:id]', function ($id) {
            require_once('api/views/news_update.php');
        }, 'News#update');

        //Create Record with admin
        $router->map('POST', '/news/', function () {
            require_once('api/views/create_news.php');
        }, 'News#create');

        //Delete record id with admin
        $router->map('DELETE', '/news/[i:id]', function ($id) {
            require_once('api/views/delete_news.php');
        }, '[delete]');
        }
        //Get Comments
        $router->map('GET', '/news/[i:id]/users/[i:id]/comments/[i:id]', function ($id) {

            require_once('api/views/user_comments.php');
        });

        //Call Method
        $match = $router->match();
        if ($match) {
            call_user_func($match['object'], $match['param']);
        } else {
            //You have no premissions to do that
            header("HTTP/1.1 404 Not Found");
            require 'api/views/error.php';
        }


 
    }
}
