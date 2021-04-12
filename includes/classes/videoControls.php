<?php
class VideoControls{
    private $con,$video,$userLoggedInObj;
    public function __construct ($video,$userLoggedInObj){
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }
    public function create(){
        $likeBtn = $this->createLikeButton();
        $dilikeBtn = $this->createDislikeButton();
        return "<div class='controls'>
        $likeBtn
        $dilikeBtn
        </div>";
    }
    public function createLikeButton(){
        $text = $this->video->getLikes();
        $imageSrc = "assets/images/icons/thumb-up.png";
        $videoId = $this->video->getId();
        $action = "likeVideo(this,$videoId)";
        $class="likeButton";
        if($this->video->wasLikedBy()){
            $imageSrc = "assets/images/icons/thumb-up-active.png";
        }
        return ButtonProvider::createButton($text,$imageSrc,$action,$class);
    }
    public function createDislikeButton(){
        $text = $this->video->getDislikes();
        $imageSrc = "assets/images/icons/thumb-down.png";
        $videoId = $this->video->getId();
        $action = "dislikeVideo(this,$videoId)";
        $class="dislikeButton";
        if($this->video->wasDislikedBy()){
            $imageSrc = "assets/images/icons/thumb-down-active.png";
        }

        return ButtonProvider::createButton($text,$imageSrc,$action,$class);
    }
}

?>