<?php

class Check {

    //variable
    private $privilege;
    private $userPrivilage;
    private $admin = 4;

    //constructor
    public function __construct(int $privilege = null){
        $this->privilege = $privilege;
    }

    /***************************/
    /* access                  */
    /***************************/
    public function onlineCheck()
    {
        //user not online
        if ($this->privilege == null){
            header("Location: /index.php"); exit;
        }
    }

    public function getAccess(int $userPrivilage)
    {

        //user do not match privilege level
        if ($this->privilege < $userPrivilage){
            header("Location: /index.php"); exit;
        }

        if ($this->privilege < $this->admin)
        {
            //Initialize database
            require($_SERVER['DOCUMENT_ROOT']."/includes/connection.php");

            //database
            if(!$database->has("forum_thread",[
                "[><]forum" => ["forum_thread.forum_id" => "id"],
                "[><]forum_post" => ["forum_thread.id" => "forum_thread_id"]
            ],[
                "AND" =>["forum_post.forum_thread_id" => $_GET["id"], "forum_post.account_id" => $_SESSION['id']]])) {
                //header("Location: /index.php"); exit;
                echo "<div style='background-color:red'>User access</div>";
            }
        }
    }

    /***************************/
    /* url check               */
    /***************************/
    function checkURL($table, $row, $id) {

        //check id
        if(!preg_match("/^[\p{N}]+$/ui", $id)) {
            //echo "<div style='background-color:red'>Till index.php</div>";
            header("Location: /index.php"); exit;
        }else{
            //Initialize connection to database
            require($_SERVER['DOCUMENT_ROOT']."/includes/connection.php");

            //database id check
            if (!$database->has($table, [
                "AND" => [$row => $id]
            ])) {
                header("Location: /index.php"); exit;
                //echo "<div style='background-color:red'>Till index.php igen</div>";
            }
        }

    }
    
    /***************************/
    /* emptySpace              */
    /***************************/
    function checkEmptySpace($value){

        $value = trim($value);

        return (isset($value) && strlen($value)); 
    }
    
    /***************************/
    /* injection safe          */
    /***************************/
    function safe($value){

        $value = htmlentities(strip_tags(trim($value)));
        
        return $value;
    }
    
    /***************************/
    /* input	               */
    /***************************/
    function checkInput($value, $value2){

        $regex = [
            "letters" => "/^[\p{L}\. ]+$/ui",
            "numbers" => "/^[\p{N} ]+$/ui",
            "letters&numbers" => "/^[\p{L}\p{N} ]+$/ui",
            "title" => "/^[\p{L}\p{N}\.\?\!\-\(\)\+\#\/ ]+$/ui",
            "bbCode" => "/^[\p{L}\p{N}\s\[\]\-\+\&\,\.\;\=\:\!\(\)\?\@\%\+\"\#\/ ]+$/ui",
            "zipCode" => "/^\p{N}{5}+$/ui",
            "phoneNumber" => "/^\p{N}{5,10}+$/ui",
            "civic" => "/^\p{N}{12}+$/ui",
        ];

        $match = preg_match($regex[$value2], $value);
            
        return $match;

    }
    
    /***************************/
    /* locked                  */
    /***************************/
    function checkLocked(){

        require($_SERVER['DOCUMENT_ROOT']."/includes/connection.php"); //Initialize database 
            
        if($database->has("forum_post",
            ["AND" =>["id" => $_GET["id"], "locked" => 1, "creator" => 1]])){
            header("Location: /index.php"); exit;
        }

    }
    
    /***************************/
    /* hidden                  */
    /***************************/
    function setHidden(){
      
        require($_SERVER['DOCUMENT_ROOT']."/includes/connection.php"); //Initialize database

        if(isset($_SESSION['id'])){$value = $_SESSION['id'];}else{$value = null;}
            
        if($database->has("product",
            ["[><]forum_topic" => ["product.id" => "id"]],
            ["AND" =>["product.id" => $_GET["id"], "showProduct" => "0", "account_id[!]" => $value]])){
                //header("Location: /index.php"); exit;
                echo "<div style='background-color:red'>hidden</div>";
        }
    }

} ?>