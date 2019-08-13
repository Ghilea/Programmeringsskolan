<?php
class Session {

    private $email;
    private $password;

    /***************************/
    /* Construct               */
    /***************************/
    public function __construct(string $email, string $password){
        $this->email = $email;
        $this->password = $password;
    }


    

} ?>