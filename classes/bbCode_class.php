<?php
class BBCode {
    
    public $bbCode;
    public $bbCodeMenu;
    private $newText;
    private $button;
    private $ellipsisText;
    
    /***************************/
    /* bbcode                  */
    /***************************/
    public function ellipsis($text, $maxLength = 100){
        
        $bbArray = [
            "/\[b\](.*?)\[\/b\]/is" => "<b>$1</b>",
            "/\[i\](.*?)\[\/i\]/is" => "<i>$1</i>",
            "/\[u\](.*?)\[\/u\]/is" => "<u>$1</u>" ,
            "/\[s\](.*?)\[\/s\]/is" => "<s>$1</s>",
            "/\[left\](.*?)\[\/left\]/is" => "<p class='txtLeft'>$1</p>",
            "/\[center\](.*?)\[\/center\]/is" => "<p class='txtCenter'>$1</p>",
            "/\[right\](.*?)\[\/right\]/is" => "<p class='txtRight'>$1</p>",
            "/\[img\](.*?)\[\/img\]/is" => "<img class='imageBBCode' src='$1' alt='$1'>",
            "/\[url=(.*?)\](.*?)\[\/url\]/is" => "<a href='$1'>$2</a>" 
        ];
        
        $newText = nl2br(preg_replace(array_keys($bbArray), array_values($bbArray), strip_tags(htmlentities($text))));

        if (strlen($newText) > $maxLength)
        {
            $lastPos = ($maxLength - 3) - strlen($newText);
            $newText = substr($text, 0, strrpos($newText, ' ', $lastPos)) . '...';
        }

        $this->ellipsisText = $newText;

        return $this->ellipsisText;
    }

    function useBBCode($value){

        $bbArray = [
            "/\[b\](.*?)\[\/b\]/is" => "<b>$1</b>",
            "/\[i\](.*?)\[\/i\]/is" => "<i>$1</i>",
            "/\[u\](.*?)\[\/u\]/is" => "<u>$1</u>" ,
            "/\[s\](.*?)\[\/s\]/is" => "<s>$1</s>",
            "/\[left\](.*?)\[\/left\]/is" => "<p class='txtLeft'>$1</p>",
            "/\[center\](.*?)\[\/center\]/is" => "<p class='txtCenter'>$1</p>",
            "/\[right\](.*?)\[\/right\]/is" => "<p class='txtRight'>$1</p>",
            "/\[img\](.*?)\[\/img\]/is" => "<img class='imageBBCode' src='$1' alt='$1'>",
            "/\[url=(.*?)\](.*?)\[\/url\]/is" => "<a href='$1'>$2</a>" 
        ];
        
        $this->newText = nl2br(preg_replace(array_keys($bbArray), array_values($bbArray), strip_tags(htmlentities($value))));
        
        return $this->newText;
    }

    /***************************/
    /* bbCodeMenu	           */
    /***************************/
    function bbCodeMenu(){
        
        $buttonArray = [
            [
                "css" => "b", 
                "title" => "Fet text", 
                "link" => "/images/svg/text_bold.svg"
            ],[
                "css" => "i", 
                "title" => "Kursiv text", 
                "link" => "/images/svg/text_italic.svg"
            ],[
                "css" => "u", 
                "title" => "Understrucken text", 
                "link" => "/images/svg/text_underline.svg"
            ],[
                "css" => "s",
                "title" => "Överstrucken text", 
                "link" => "/images/svg/text_strikethrough.svg"
            ],[
                "css" => "left", 
                "title" => "Vänsterställd text", 
                "link" => "/images/svg/text_align_left.svg"
            ],[
                "css" => "center", 
                "title" => "Centrerad text", 
                "link" => "/images/svg/text_align-justify.svg"
            ],[
                "css" => "right", 
                "title" => "Högerställd text", 
                "link" => "/images/svg/text_align_right.svg"
            ],[
                "css" => "url", 
                "title" => "Infoga länk", 
                "link" => "/images/svg/text_link.svg"
            ],[
                "css" => "img", 
                "title" => "Länka bild", 
                "link" => "/images/svg/device-camera-capture-photo-glyph.svg"
            ]
        ];

        foreach($buttonArray as $output){ 		        
            
            $this->button .= '
                <div class="bbCode" id="'.$output["css"].'" title="'.$output["title"].'">
                    <img src="'.$output["link"].'" alt="">
                </div>';
        }

        return $this->button;
    
    }  

} ?>