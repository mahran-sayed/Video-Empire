<?php

class ButtonProvider{
    public static function createButton($text,$imageSrc,$action,$class){
        $image = ($imageSrc == null)?"":"<img src ='$imageSrc'>";
        return "<button class='$class' onclick = '$action'>
        $image
        <span class='text'>$text</span>
        </button>";
    }
    public static function createProfilePic($con,$username){
        $userObj = new User($con,$username);
        $profilePic = $userObj->getProfilePic();
        $link = "profile.php?username=".$username;
        return "<a href='$link'><img src='$profilePic' class='profilePic'></a>";
    }
    public static function createHyperlinkButton($text,$imageSrc,$href,$class){
        $image = ($imageSrc == null)?"":"<img src ='$imageSrc'>";
        return "<a href='$href'>
        <button class='$class'>
        $image
        <span class='text'>$text</span>
        </button></a>";
    }
    public static function createEditVideoButton($video){
        $href = "editVideo.php?videoId=$video";
        $button =ButtonProvider::createHyperlinkButton("EDIT VIDEO",null,$href,"editButton");
        return "<div class='editVideoButtonContainer'>
        $button
        </div>";
    }
    public static function createSubscribeButton($con,$userToObj,$userLoggedInobj){
        $userTo = $userToObj->getUsername();
        $userLoggedIn = $userLoggedInobj->getUsername();
        $isSubscribed = $userLoggedInobj->isSubscribedTo($userTo);
        $buttonText = $isSubscribed? "SUBSCRIBED":"SUBSCRIBE";
        $buttonText .= " ". $userToObj->getSubscriberCount();
        $buttonClass = $isSubscribed?"unsubscribeButton":"subscribeButton";
        $action = "subscribe(\"$userTo\",\"$userLoggedIn\",this);";
        $button = ButtonProvider::createButton($buttonText,null,$action,$buttonClass);
        return "<div class='subscribeButtonContainer'>
        $button
        </div>";
    }
}

?>