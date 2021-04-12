<?php
class videoProcessor{
    private $con;
    private $sizeLimit = 5000000;
    private $allowedTypes = array("mp4","flv","webm","mkv","vob","ogv","ogg","avi","wmv","mov","mpeg","mpg");
    private $ffmpeg;
    private $ffprobe;
    public function __construct($con){
        $this->con = $con;
        $this->ffmpeg = realpath("ffmpeg/bin/ffmpeg.exe");
        $this->ffprobe = realpath("ffmpeg/bin/ffprobe.exe");
    }
    public function upload($videoUploadData){
        $targetDir = "uploads/videos/";
        $videoData = $videoUploadData->videoArray;
        $tempFilePath = $targetDir.uniqid().basename($videoData["name"]);
        $tempFilePath = str_replace(" ","_",$tempFilePath);
        $isValidData = $this->processData($videoData,$tempFilePath);
        if(!$isValidData){
            return false;
        }else{
            if(move_uploaded_file($videoData["tmp_name"],$tempFilePath)){
                $finalPath = $targetDir.uniqid().".mp4";
                if(!$this->insertVideoData($videoUploadData,$finalPath)){
                    echo "Query Failed";
                }else{
                    echo "Added to database";
                }
                if(!$this->convertVideoToMP4($tempFilePath,$finalPath)){
                    echo "Upload failed";
                    return false; 
                }
                if(!$this->deleteFile($tempFilePath)){
                    echo "Upload Failed";
                    return false;
                }
                if(!$this->generateThumbnails($finalPath)){
                    echo "Upload failed - could not generate thumbnails\n";
                    return false;
                    }
            }
        }
        
    }
    private function processData($videoData,$filePath){
        $videoType = pathinfo($filePath,PATHINFO_EXTENSION);
        if(!$this->isValidSize($videoData)){
            echo "File too large. Can't be more than ".$this->sizeLimit." bytes";
            return false;
        }elseif(!$this->isValidType($videoType)){
            echo "Invalid type format";
            return false;
        }elseif($this->fileError($videoData)){
            echo "Error code:". $videoData["error"];
            return false;
        }else{
            return true;
        }
    }
    private function isValidSize($data){
        return $data["size"] <= $this->sizeLimit;
    }
    private function isValidType($type){
        $type = strtolower($type);
        return in_array($type,$this->allowedTypes);
    }
    private function fileError($data){
        return $data["error"] != 0;
    }
    private function insertVideoData($data,$path){
        $query = $this->con->prepare("INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath) VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)");
        return $query->execute(["title"=>$data->title,"uploadedBy"=>$data->uploadedBy,"description"=>$data->description,"privacy"=>$data->privacy,"category"=>$data->category,"filePath"=>$path]);
    }
    public function convertVideoToMP4($tempFilePath,$finalPath){
        $cmd = "$this->ffmpeg -i $tempFilePath $finalPath 2>&1";
        $outputLog = array();
        exec($cmd,$output,$returnCode);

        if($returnCode != 0){
            foreach($outputLog as $line){
                echo $line."<br>";
            }
            return false;
        }
        return true;
    }
    private function deleteFile($filePath){
        if(!unlink($filePath)){
            echo "Couldn't delete the file\n";
            return false;
        }
        return true;
    }
    public function generateThumbnails($filePath){
        $thumbnailSize = "210x118";
        $numThumnails = 3;
        $pathToThumbnail = "uploads/videos/thumbnails";
        $duration = (int)$this->getVideoDuration($filePath);
        $videoId = $this->con->lastInsertId();
        $this->updateDuration($duration,$videoId);
        for($num = 1;$num <= $numThumnails;$num++){
            $imageName = uniqid().".jpg";
            $interval = ($duration * 0.8) / $numThumnails * $num;
            $fullThumbnailPath = "$pathToThumbnail/$videoId-$imageName";
            $cmd = "$this->ffmpeg -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";
            $outputLog = array();
            $selected = ($num==1)?1:0;
            exec($cmd,$output,$returnCode);

            if($returnCode != 0){
                foreach($outputLog as $line){
                    echo $line."<br>";
                }
            }
            $query = $this->con->prepare("INSERT INTO thumbnails(videoid,filepath,selected) VALUES(:videoId,:filePath,:selected)");
            $sql = $query->execute(["videoId"=>$videoId,"filePath"=>$fullThumbnailPath,"selected"=>$selected]);
            if(!$sql){
                echo "Error happened inserting thumbnail";
                return false;
            }

        }
        return true;

         
    }
    private function getVideoDuration($filePath){
        return shell_exec("$this->ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }
    private function updateDuration($duration,$videoId){
        $duration = (int)$duration;
        $hours = floor($duration /3600);
        $minutes = floor(($duration - ($hours*3600))/60);
        $seconds = floor($duration % 60);
        $hours = ($hours<1)?"":$hours.":";
        $minutes = ($minutes<10)?"0".$minutes.":":$minutes.":";
        $seconds = ($seconds<10)?"0".$seconds:$seconds;
        $duration = $hours.$minutes.$seconds;
        $query = $this->con->prepare("UPDATE videos SET duration = ? WHERE id = ?");
        $query->execute([$duration,$videoId]);
    }
    
}




?>