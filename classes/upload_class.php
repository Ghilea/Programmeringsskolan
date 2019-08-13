<?php

class Upload {
    
    //image
    private $oldImage;
    private $newImage;
    private $img_normal;
    private $img_thumb;
    private $format;
    private $quality;
    private $width;
    private $height;
    private $newWidth;
    private $newHeight;

    public function image($id, $imageFormat, $imageFile, $path, $maxSize = 200, $quality = 80) {

        // Find format
        $this->format = strtolower(pathinfo($imageFormat, PATHINFO_EXTENSION));

        //random number
        $random = mt_rand();

        $imageName = $id."_".$random.".".$this->format;
        $imageNameSmall = $id."_small_".$random.".".$this->format;

        $this->img_normal = $path.$imageName;
        $this->img_thumb = $path.$imageNameSmall;

		//save orignal sized image file
        move_uploaded_file($imageFile, $this->img_normal);

        //JPEG image
        if(is_file($this->img_normal) && ($this->format == "jpg" OR $this->format == "jpeg")) {
            $this->oldImage = ImageCreateFromJPEG($this->img_normal);
        } else if(is_file($this->img_normal) && $this->format == "png") { //PNG image
            $this->oldImage = ImageCreateFromPNG($this->img_normal);
        } else if(is_file($this->img_normal) && $this->format == "gif") { //GIF image
            $this->oldImage = ImageCreateFromGIF($this->img_normal);
        }

        //get dimensions
        $this->width = imagesx($this->oldImage);
        $this->height = imagesy($this->oldImage);
        
        //Get scale ratio
        $scale = min($maxSize/$this->width, $maxSize/$this->height);

        //Resize
        if($scale < 1) {
 
            //Calculate the new height and width based on the scale
            $this->newWidth = floor($scale * $this->width);
            $this->newHeight = floor($scale * $this->height);

            //Create a new temporary image
            $this->newImage = ImageCreateTrueColor($this->newWidth, $this->newHeight);

            //re-samples image with new size
            ImageCopyResampled($this->newImage, $this->oldImage, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);
            
            //Save JPEG
            if($this->format == "jpg" OR $this->format == "jpeg") {
                imageJPEG($this->newImage, $this->img_thumb, $quality);
            } else if($this->format == "png") { //Save PNG
                imagePNG($this->newImage, $this->img_thumb);  
            } else if($this->format == "gif") { //Save GIF
                imageGIF($this->newImage, $this->img_thumb);
            }

            //return resized image
            $returnValue = $imageNameSmall;

        }else{
            
            //return original sized image
            $returnValue = $imageName;
        }

        return $returnValue;
    }

} ?>