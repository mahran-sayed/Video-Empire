<?php 
class User{
    private $con;
    private $sqlData;
    public function __construct($con,$userLoggedIn){
        $this->con = $con;
        $query = $this->con->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$userLoggedIn]);
        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getUsername(){
        return $this->sqlData["username"];
    }
    public function getFirstName(){
        return $this->sqlData["firstName"];
    } 
    public function getLastName(){
        return $this->sqlData["lastName"];
    }
    public function getEmail(){
        return $this->sqlData["email"];
    }
    public function getProfilePic(){
        return $this->sqlData["profilePic"];
    }
    public function getSignupDate(){
        return $this->sqlData["signupDate"];
    }
    public function isSubscribedTo($userTo){
        $query =$this->con->prepare("SELECT * FROM subscribers WHERE userTo = ? AND userFrom = ?");
        $query->execute([$userTo,$this->getUsername()]);
        return $query->rowCount() > 0;

    }
    public function getSubscriberCount(){
        return 5;
    }
}

?> 