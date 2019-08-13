<?php 

class DataAccess {

    public $id = [];
    public $account_id = [];
    public $forum_id = [];
    public $thread_id = [];
    public $post_id = [];

    public $information = [];

    public $paymentStatus = [];
    public $paymentNumber = [];
    public $paymentFee = [];
    public $paymentDate = [];

    public $privilege;
    public $title = [];
    public $title2 = [];

    public $content = [];
    public $image = [];
    public $difficulty = [];
    public $created = [];
    public $color = [];
    public $count = [];
    public $number;

    public $row2Width = [];
    public $row3Width = [];

    public $errorImage = "/images/svg/circle-minus-plus-glyph.svg";
    public $errorMessage = [];

    public function __construct(int $number = null){
        $this->number = $number;
    }  

    public function count($table, $col, $id){

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');
       
        $count = $database->count($table, [$col => $id]);

        $this->number = $count;
        
    }

    public function getAccount($id){
        
        $path = "/uploads/account/";

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        $queryInformation = $database->select("account",[
            "[><]account_information" => ["account_information_id" => "id"],
            "[><]account_settings" => ["account_settings_id" => "id"],
        ],[ 
            "account_information.firstname",
            "account_information.lastname",
            "account_information.address",
            "account_information.city",
            "account_information.zipCode",
            "account_information.phoneNumber",
            "account_information.email",
            "account.image",
            "account_settings.profile_image(showImage)",
            "account_settings.PhoneNumber(showPhoneNumber)",
            "account_settings.email(showEmail)",
        ],[
            "AND" =>["account.id" => $id]]);
        
        foreach($queryInformation as $output){
            $this->information["firstname"] = $output["firstname"];
            $this->information["lastname"] = $output["lastname"];
            $this->information["address"] = $output["address"];
            $this->information["city"] = $output["city"];
            $this->information["zipCode"] = $output["zipCode"];
            $this->information["phoneNumber"] = $output["phoneNumber"];
            $this->information["email"] = $output["email"];
            $this->information["showImage"] = $output["showImage"];
            $this->information["showPhoneNumber"] = $output["showPhoneNumber"];
            $this->information["showEmail"] = $output["showEmail"];
            $this->information["image"] = $path.$output["image"]; 
        }

        $queryPayment = $database->select("account",[
            "[><]account_payment" => ["id" => "account_id"],
            "[><]system_payment" => ["account_payment.system_payment_id" => "id"],
        ],[
            "account_payment.status",
            "account_payment.date",
            "system_payment.fee", 
            "system_payment.paymentNumber"
        ],["AND" => ["account.id" => $id], 
            "ORDER" => ["account.id" => "ASC"]]);

        foreach($queryPayment as $output){
            $this->paymentStatus[] = $output["status"];
            $this->paymentDate[] = $output["date"];
            $this->paymentFee[] = $output["fee"].":-";
            $this->paymentNumber[] = "#".$output["paymentNumber"];
        }

        if ($this->number == null && $id != null) {
            $count = $database->count("account_payment", [
	        "account_id" => $id
            ]);

            $this->number = $count;
        }

    }

    public function dynamicRow(){
        $rowLimit = 3;
		$row = 0;
		$left = 0;
        

        for($x = 0; $x < $this->number; $x++){

			$row++;
			$left++;

			if($row == $rowLimit){
				$row = 0;	
				$left -= 3;
			}
        }

        for($x = 0; $x < $this->number; $x++){
            //row 2 col
            
            $rows2 = $this->number % 2;
            if($rows2 == 1 && $x == $this->number-1){ 
                $row2Width = "autoWidthm"; 
            }else{ 
                $row2Width = "col-6-12m";
            } 

            //ro 3 col 
            if($left == 1){
                if($x < $this->number-$left){ 
                    $row3Width = "col-4-12"; 
                }else{ 
                    $row3Width = "col-full"; 
                }
            }else if ($left == 2){
                if($x < $this->number-$left){ 
                    $row3Width = "col-4-12"; 
                }else{
                    $row3Width = "col-6-12";
                }
            }else{
                $row3Width = "col-4-12";
            }

            $this->row2Width[] = $row2Width;
            $this->row3Width[] = $row3Width;
        }
        

    }

    public function getEducation(int $id = null){

        $path = "/uploads/language/";

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        if($id != null){

            $query = $database->select("education",
            ["id", "image", "title", "content", "difficulty"],
            ["id" => $id]);

        }else{

            if ($this->number == null) {
                $count = $database->count("education");

                $this->number = $count;
            }

            $query = $database->select("education",
            ["id", "image", "title", "content", "difficulty"],
            ["ORDER" => ["sticked" => "DESC", "title" => "ASC"],
            "LIMIT" => $this->number]);

        }

            foreach($query as $output){
                $this->id[] = $output["id"];
                $this->title[] = $output["title"];
                $this->content[] = $output["content"];
                $this->image[] = $path.$output["image"];
                $this->difficulty[] = $output["difficulty"];
            }
    }

    public function getEducationTask(int $id = null){

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        if ($this->number == null && $id != null) {
            $count = $database->count("education_task", [
	        "education_id" => $id
            ]);

            $this->number = $count;
        }

        $query = $database->select("education_task",
        ["id", "title", "content"],
        ["AND" => ["education_id" => $id],
        "ORDER" => ["sticked" => "DESC", "title" => "ASC"],
        "LIMIT" => $this->number]);

        foreach($query as $output){
            $this->id[] = $output["id"];
            $this->title[] = $output["title"];
            $this->content[] = $output["content"];
        }
    }

    public function getEducationTaskView(int $id = null){

        $path = "/uploads/language/";
        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        //count videos
        $count = $database->count("education_video",["education_task_id" => $id, "link[!]" => null]);
        $this->information["video"] = $count;

        //count training
        $count = $database->count("education_training",["education_task_id" => $id]);
        $this->information["training"] = $count;

        //task
        $query = $database->select("education_task",
        ["[><]education" => ["education_task.education_id" => "id"]],
        [
            "education.id",
            "education.title(education_title)",
            "education_task.title", 
            "education_task.content",  
            "education.image"
        ],
        ["AND" => ["education_task.id" => $id]]);

        foreach($query as $output){
            $this->information["id"] = $output["id"];
            $this->information["education_title"] = $output["education_title"];
            $this->information["title"] = $output["title"];
            $this->information["content"] = $output["content"];
            $this->information["image"] = $path.$output["image"];
        }

        //video
        $query2 = $database->select("education_video",[
            "title", "link"
        ],["AND" => ["education_task_id" => $id, "link[!]" => null],
            "ORDER" => ["education_video.sticked" => "DESC", "education_video.title" => "ASC"]]);

        foreach($query2 as $output){
            $this->title[] = $output["title"];
            $this->content[] = $output["link"];
        }

        //training
        $query3 = $database->select("education_training",[
            "title",
        ],["AND" => ["education_task_id" => $id]]);

        foreach($query3 as $output){
            $this->title2[] = $output["title"];
        }
  
    }

    public function getNews(){

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        $query = $database->select("news",
        ["id", "image", "title", "content", "created"],
        ["ORDER" => ["sticked" => "DESC", "title" => "DESC"],
        "LIMIT" => $this->number]);

        foreach($query as $output){
            $this->id[] = $output["id"];
            $this->title[] = $output["title"];
            $this->content[] = $output["content"];
            $this->image[] = $output["image"];
            $this->created[] = $output["created"];
        }
    }

    public function getForum(int $privID = null){

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        if ($this->number == null) {
            $count = $database->count("forum",["forum.system_privilege_id[<=]" => $privID]);

            $this->number = $count;
        }

        $query = $database->select("forum",[
            "[><]system_color" => ["forum.system_color_id" => "id"],
            "[><]system_privilege" => ["forum.system_privilege_id" => "id"]
        ],[
            "forum.id", 
            "forum.title", 
            "forum.content", 
            "system_color.color"
        ],[
            "AND" => ["forum.system_privilege_id[<=]" => $privID],
            "ORDER" => ["forum.id" => "ASC"]]);

        foreach($query as $output){
            $this->id[] = $output["id"];
            $this->title[] = $output["title"];
            $this->content[] = $output["content"];
            $this->color[] = $output["color"];

            $countThread = $database->count("forum_thread", ["forum_id" => $output["id"]]);

            if($countThread != null){
                $this->count[] = $countThread;
            }else{
                $this->count[] = 0;
            }

        }

    }

    public function getTopic(int $start = null, int $perPage = null, $id = null){

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        if ($this->number == null) {
            $count = $database->count("forum_thread",["forum_id" => $id]);

            $this->number = $count;
        }

        $query = $database->select("forum_thread",[
            "[><]forum" => ["forum_thread.forum_id" => "id"],
            "[><]forum_post" => ["id" => "forum_thread_id"]
        ],[
            "forum_post.id(post_id)",
            "forum_thread.id(thread_id)",
            "forum_thread.forum_id",
            "forum_post.title",
            "forum_post_chain"
        ],[
            "AND" =>[
                "forum_thread.forum_id" => $id,
                "forum_post.creator" => 1
            ], 
            "ORDER" => ["forum_post.created" => "DESC"],
            "LIMIT" => [$start, $perPage]]);

        $queryForum = $database->select("forum",["title"],["id" => $id]);

        foreach($queryForum as $output){
            $this->information["title"] = $output["title"];
        }

        foreach($query as $output){
            $this->title[] = $output["title"];
            $this->forum_id[] = $output["forum_id"];
            $this->thread_id[] = $output["thread_id"];
            $this->post_id[] = $output["post_id"];

            $queryCount = $database->count("forum_post", ["forum_thread_id" => $output["thread_id"]]);
 
            if($queryCount != null){
                $this->count[] = $queryCount -1;
            }else{
                $this->count[] = 0;
            }

        }

    }

    public function getForumPost(int $start = null, int $perPage = null, $id = null){

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        $queryForum = $database->select("forum_thread",[
            "[><]forum" => ["forum_id" => "id"],
            "[><]forum_post" => ["id" => "forum_thread_id"]
        ],[
            "forum.title(title)",
            "forum_post.title(threadTitle)",
            "forum_id"
        ],["AND" =>["forum_thread.id" => $id]]);

        $query = $database->select("forum_thread",[
            "[><]forum" => ["forum_thread.forum_id" => "id"],
            "[><]forum_post" => ["id" => "forum_thread_id"],
            "[><]account" => ["forum_thread.account_id" => "id"],
            "[><]account_information" => ["account.account_information_id" => "id"],
            "[><]account_settings" => ["account.account_settings_id" => "id"]
        ],[
            "forum_thread.id",
            "forum.id(forum_id)",
            "forum_post.id(post_id)",
            "forum_post.title", 
            "forum_post.content",
            "forum_post.created",
            "forum_post.locked",
            "account_information.firstname",
            "account_information.lastname",
            "account_settings.profile_image",
            "account.image",
            "forum_thread.account_id"
        ],["AND" => ["forum_post.forum_thread_id" => $id], 
        "ORDER" => ["forum_post.created" => "ASC"], 
        "LIMIT" => [$start, $perPage]]);

        foreach($queryForum as $output){
            $this->information["forum_id"] = $output["forum_id"];
            $this->information["title"] = $output["title"];
            $this->information["threadTitle"] = $output["threadTitle"];
        }

        foreach($query as $output){
            $this->firstname[] = $output["firstname"];
            $this->lastname[] = $output["lastname"];
            $this->id[] = $output["id"];
            $this->account_id[] = $output["account_id"];
            $this->post_id[] = $output["post_id"];
            $this->forum_id[] = $output["forum_id"];
            $this->title[] = $output["title"];
            $this->content[] = $output["content"];
            $this->created[] = $output["created"];
            $this->image[] = "/uploads/account/".$output["image"];
        }

        $queryCount = $database->count("forum_post", ["forum_thread_id" => $id]);
 
        if($queryCount != null){
            $this->number = $queryCount;
        }else{
            $this->number = 0;
        }

    }

    public function login($email, $password){

        $error = false;

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        $query = $database->select("account",[
            "[><]account_information" => ["account_information_id" => "id"],
            "[>]system_gender" => ["account_information.system_gender_id" => "id"],
            "[><]account_settings" => ["account_settings_id" => "id"],
            "[>]system_privilege" => ["account_settings.system_privilege_id" => "id"]
        ],[
            "account.id", "account_information.email", "password", "suspended", "system_privilege_id"
        ]);

        $myCheck = new Check();

        $check = [
		["name" => "email", "regex" => "bbCode", "error" => "errorEmail"],
		["name" => "password", "regex" => "bbCode", "error" => "errorPassword"]
    ];

        //check input field
        foreach($check as $output) {

            //empty space
            if(!$myCheck->checkEmptySpace(${$output["name"]})){

                $error = true;
                $this->errorMessage[$output["error"]] = "Du måste skriva in något i fältet";
            }

        }
        
        //check database
        foreach($query as $output){

            if(!$error){

                if($output["suspended"] == 1){

                    $this->errorMessage["errorAll"] = 'Användarkontot är avstängd.';

                }
                else if($output["email"] == $myCheck->safe($email) && (password_verify($myCheck->safe($password), $output['password']))){
                   
                    $this->id["id"] = $output["id"];
                    $this->privilege = $output["system_privilege_id"];

                    //add login status
                    $database->update("account_settings",
                    ["status" => 1],["id" => $output["id"]]);

                }else{

                    $this->errorMessage["errorAll"] = 'E-postadressen eller lösenordet är fel.';

                }

            }
            
        }

    }

    public function logout($id){

        require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php');

        $database->update("account_settings",
        ["status" => null],["id" => $id]);

        
    }

}

?>