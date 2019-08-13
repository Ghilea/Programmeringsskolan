$(document).ready(function(){

    /***************************/
    /* function                */
    /***************************/ 
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#upImage').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
     
     /***************************/
     /* on upload               */
     /***************************/    
     $("#imageInput").change(function(){
        readURL(this);
     });

});