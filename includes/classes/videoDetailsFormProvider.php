<?php

class VideoDetailsProvider {
    private $con;
    public function __construct($con){
        $this->con = $con;
    }
    public function createUploadForm(){
        $fileInput = $this->createFileInput();
        $titleInput = $this->createTitleInput();
        $descriptionInput = $this->createDescriptionInput();
        $privacyInput = $this->createPrivacyInput();
        $categorieInput=$this->createCategories();
        $uploadButton = $this->createUploadButton();
        return "<form method='POST' action='processing.php' enctype='multipart/form-data'>
        $fileInput
        $titleInput
        $descriptionInput
        $privacyInput
        $categorieInput
        $uploadButton
      </form>
      ";
    }
    public function createFileInput(){
        return "<div class='form-group'>
        <label for='fileInput'>Example file input</label>
        <input name = 'fileInput' type='file' class= 'form-control-file' id='fileInput'>
        </div>";
    }
    public function createTitleInput(){
        return "<div class='form-group'>
        <input type='text' placeholder= 'Title' name='titleInput' class='form-control'>
        </div>";
    }
    public function createDescriptionInput(){
        return "<div class='form-group'>
        <textarea name='descriptionInput' class='form-control' placeholder = 'Description.....'  rows='3'></textarea>
        </div>";
    }
    public function createPrivacyInput(){
        return "<div class='form-group'><select class='form-control' name='privacyInput'>
        <option value='0'>Private</option>
        <option value='1'>Public</option>
        </select></div>";
    }
    public function createCategories(){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute([]);
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $html = "<div class='form-group'><select class='form-control' name='categoryInput'>";
        foreach($rows as $row){
            $x = $row["name"];
            $html .= " <option value='$x'>$x</option>";
        }
        $html .= "</select></div>";
        return $html;
    }
    public function createUploadButton(){
        return "<button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>";
    }
}
?>