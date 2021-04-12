<?php
class videoUploadData{
    public $videoArray,$title,$description,$privacy,$category,$uploadedBy;
    public function __construct($videoArray,$title,$description,$privacy,$category,$uploadedBy){
        $this->videoArray = $videoArray;
        $this->title = $title;
        $this->privacy = $privacy;
        $this->category = $category;
        $this->description = $description;
        $this->uploadedBy = $uploadedBy;
    }
}

?>