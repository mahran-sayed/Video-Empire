<?php
class Video{
    private $con;
    private $sqlData;
    private $userLoggedIn;
    public function __construct($con,$userLoggedIn,$input){
        $this->con = $con;
        $this->userLoggedIn = $userLoggedIn;
        if(is_array($input)){
            $this->sqlData = $input;
        }else{
            $query = $this->con->prepare("SELECT * FROM videos WHERE id = ?");
            $query->execute([$input]);
            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }

        
        
    }
    public function getId(){
        return $this->sqlData["id"];
    }
    public function getTitle(){
        return $this->sqlData["title"];
    }
    public function getDescription(){
        return $this->sqlData["description"];
    }
    public function getCategory(){
        return $this->sqlData["category"];
    }
    public function getUploadedBy(){
        return $this->sqlData["uploadedBy"];
    }
    public function getFilePath(){
        return $this->sqlData["filePath"];
    }
    public function getUploadedDate(){
        $date = $this->sqlData["uploadDate"];
        return date("M d, Y",strtotime($date));
    }
    public function getViews(){
        return $this->sqlData["views"];
    }
    public function getDuration(){
        return $this->sqlData["duration"];
    }
    public function incrementViews(){
        $query = $this->con->prepare("UPDATE videos SET views = views + 1 WHERE id=?");
        $query->execute([$this->getId()]);
        $this->sqlData["views"] = $this->sqlData["views"] + 1;

    }
    public function getLikes(){
        $query = $this->con->prepare("SELECT count(*) as count FROM likes WHERE videoId = ?");
        $query->execute([$this->getId()]);
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];

    }
    public function getDislikes(){
        $query = $this->con->prepare("SELECT count(*) as count FROM dislikes WHERE videoId = ?");
        $query->execute([$this->getId()]);
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];
    }
    public function like(){
        
        $query = $this->con->prepare("SELECT * FROM likes WHERE videoId=? AND username = ?");
        $query->execute([$this->getId(),$this->userLoggedIn->getUsername()]);
        if($query->rowCount()>0){
            $query = $this->con->prepare("DELETE FROM likes WHERE videoId=? AND username = ?");
            $query->execute([$this->getId(),$this->userLoggedIn->getUsername()]);
            $result = array(
                "likes"=>-1,
                "dislikes"=>0
            );
            return json_encode($result);

        }else{
            $query = $this->con->prepare("DELETE FROM dislikes WHERE videoId=? AND username = ?");
            $query->execute([$this->getId(),$this->userLoggedIn->getUsername()]);
            $count = $query->rowCount();
            $query = $this->con->prepare("INSERT INTO likes(videoId,username) VALUES(?,?)");
            $query->execute([$this->getId(),$this->userLoggedIn->getUsername()]);
            
            $result = array(
                "likes"=>1,
                "dislikes"=>0 - $count
            );
            return json_encode($result);
        }
    }
    public function dislike(){
        
        $query = $this->con->prepare("SELECT * FROM dislikes WHERE videoId=? AND username = ?");
        $query->execute([$this->getId(),$this->userLoggedIn->getUsername()]);
        if($query->rowCount()>0){
            $query = $this->con->prepare("DELETE FROM dislikes WHERE videoId=? AND username = ?");
            $query->execute([$this->getId(),$this->userLoggedIn->getUsername()]);
            $result = array(
                "likes"=>0,
                "dislikes"=>-1
            );
            return json_encode($result);

        }else{
            $query = $this->con->prepare("DELETE FROM likes WHERE videoId=? AND username = ?");
            $query->execute([$this->getId(),$this->userLoggedIn->getUsername()]);
            $count = $query->rowCount();
            $query = $this->con->prepare("INSERT INTO dislikes(videoId,username) VALUES(?,?)");
            $query->execute([$this->getId(),$this->userLoggedIn->getUsername()]);
            
            $result = array(
                "likes"=>0 -$count,
                "dislikes"=>1
            );
            return json_encode($result);
        }
    }
    public function wasLikedBy(){
        $query = $this->con->prepare("SELECT * FROM likes WHERE videoId=? AND username = ?");
        $query->execute([$this->getId(),$this->userLoggedIn]);
        return $query->rowCount()>0;
    }
    public function wasDislikedBy(){
        $query = $this->con->prepare("SELECT * FROM dislikes WHERE videoId=? AND username = ?");
        $query->execute([$this->getId(),$this->userLoggedIn]);
        return $query->rowCount()>0;
    }
    
    

}

?>