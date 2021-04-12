<?php
class VideoInfoSection{
    private $con,$video,$userLoggedInObj;
    public function __construct ($con,$video,$userLoggedInObj){
        $this->con = $con;
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }
    public function create(){
        return $this->createPrimaryInfo().$this->createSecondaryInfo();
    }
    public function createPrimaryInfo(){
        $title = $this->video->getTitle();
        $views = $this->video->getViews();
        $videoControls = new VideoControls($this->video,$this->userLoggedInObj);
        $controls = $videoControls->create();
        return "<div class='videoInfo'>
        <h1>$title</h1>
        <div class='buttomSection'>
        <span class='views'>$views</span>
        $controls
        </div>  
        </div>";
    }
    public function createSecondaryInfo(){
        $description = $this->video->getDescription();
        $uploadDate = $this->video->getUploadedDate();
        $uploadedBy = $this->video->getUploadedBy();
        $profileButton = ButtonProvider::createProfilePic($this->con,$uploadedBy);
        $actionButton = "";
        if($uploadedBy == $this->userLoggedInObj->getUsername()){
            $actionButton = ButtonProvider::createEditVideoButton($this->video->getId());
        }else{
            $userToObj = new User($this->con,$uploadedBy);
            $userFrom = new User($this->con,$this->userLoggedInObj->getUsername());
            $actionButton = ButtonProvider::createSubscribeButton($this->con,$userToObj,$userFrom);
        }
        
        return "<div class='secondaryInfo'>
        <div class ='topRow'>
        $profileButton
        </div>

        <div class='uploadInfo'>
            <span class='owner'>
            <a href='profile.php?username='+$uploadedBy>
            $uploadedBy
            </a>
            </span>
            <span class='date'>Published on $uploadDate</span>
        </div>
        $actionButton

        </div>";
    }
}

?>