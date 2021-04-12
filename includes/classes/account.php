<?php
class Account{
    private $con ="";
    private $errorArray =array();
    public function __construct($con){
        $this->con = $con;
    }
    public function login($uname,$pw){
        $pw = hash("sha512",$pw);
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:uname and password=:pw");
        $query->bindParam(":uname",$uname);
        $query->bindParam(":pw",$pw);
        $query->execute();
        if($query->rowCount() == 1){
            return true;
        }else{
            array_push($this->errorArray,constants::$failedLogin);
        }
    }
    public function register($fname,$lname,$uname,$em1,$em2,$pw1,$pw2){
        $this->validateFirstName($fname);
        $this->validateLasttName($lname);
        $this->validateUsername($uname);
        $this->validateEmail($em1,$em2);
        $this->validatePassword($pw1,$pw2);
        
        if(empty($this->errorArray)){
            $this->insertNewUser($fname,$lname,$uname,$em1,$pw1);
        }else{
            return false;
        }


    }
    private function insertNewUser($fname,$lname,$uname,$em1,$pw1){
        $pw = hash("sha512",$pw1);
        $profilePic = "assets/images/profilePictures/default.png";

        $query = $this->con->prepare("INSERT INTO users(firstName, lastName, username, email, password, profilePic) VALUES(:fname,:lname,:uname,:email,:password,:profilePic)");
        $query->bindParam(":fname",$fname);
        $query->bindParam(":lname",$lname);
        $query->bindParam(":uname",$uname);
        $query->bindParam(":email",$em1);
        $query->bindParam(":password",$pw);
        $query->bindParam(":profilePic",$profilePic);
        $query->execute();
        return true;

    }
    private function validateFirstName($fname){
        if(strlen($fname) <5 || strlen($fname)>25){
            array_push($this->errorArray,constants::$firstNameCharacters);
        }
    }
    private function validateLasttName($lname){
        if(strlen($lname) <5 || strlen($lname)>25){
            array_push($this->errorArray,constants::$lastNameCharacters);
        }
    }
    private function validateUsername($uname){
        if(strlen($uname) <5 || strlen($uname)>25){
            array_push($this->errorArray,constants::$usernameCharacters);
        }
        $query = $this->con->prepare("SELECT username FROM users WHERE username=?");
        $query->execute([$uname]);
        if($query->rowCount()>0){
            array_push($this->errorArray,constants::$usernameToken);
        }
    }
    private function validateEmail($em1,$em2){
        if($em1 != $em2){
            array_push($this->errorArray,constants::$emailNoMatch);

        }elseif(!filter_var($em1,FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray,constants::$emailNotValid);
        
        }else{
            $query = $this->con->prepare("SELECT email FROM users WHERE email=?");
            $query->execute([$em1]);
            if($query->rowCount()>0){
                array_push($this->errorArray,constants::$emailToken);
            }
        }
        
    }
    private function validatePassword($pw1,$pw2){
        if($pw1 != $pw2){
            array_push($this->errorArray,constants::$passwordNoMatch);

        }elseif(!preg_match("/[a-zA-Z0-9]/",$pw1)){
            array_push($this->errorArray,constants::$passwordNotValid);
        }elseif(strlen($pw1) <5 || strlen($pw1)>25){
            array_push($this->errorArray,constants::$passwordCharacters);
        }

        
    }
    
    public function getError($error){
        if(in_array($error,$this->errorArray)){
            echo "<span class='errorMessage'>$error</span>";
        }
    }
}

?>