$(document).ready(function () {

    /****************************/
    /* variable 				*/
    /****************************/
    var getOverlay = $("#getOverlay");
    var overlay = $(".overlay");
    var closeOverlayButton = $(".closeOverlayButton");

    /****************************/
    /* set css 				    */
    /****************************/
    overlay.css("display", "none")

    /****************************/
    /* array 				    */
    /****************************/
    var arrayValue = ["registration", "login", "accountMenu"];

    //click toggle button
    for (var i = 0; i < 3; i++) {
        $("." + arrayValue[i] + 'Toggle').click(createCallback(i));
    }

    /****************************/
    /* function 				*/
    /****************************/

    //open overlay
    function openOverlay() {
        overlay.css("display", "block");
    }

    //close overlay
    function closeOverlay() {
        overlay.css("display", "none");
    }

    //post data
    function postData(value_array) {
        $.post("/pages/" + value_array + ".php", function (data) {
            $("#overlayData").html(data);
        });
    }

    /****************************/
    /* toggle overlay			*/
    /****************************/

    //click toggle button
    function createCallback(i) {
        return function () {

            //toggle
            if (overlay.css("display") == "none") {
                openOverlay(); //open overlay
                postData(arrayValue[i]); //post data
            } else {
                closeOverlay(); //close overlay
            }

        }
    }

    /****************************/
    /* close overlay			*/
    /****************************/

    //close by using close button
    $(closeOverlayButton).click(function () {
        closeOverlay();
    });

    //close account menu by pressing outside the box
    $(document).on('mouseup', function (event) {
        if ((!$(event.target).closest(overlay).length) && (overlay.css("display") == "block")) {
            closeOverlay();
        }
    });

});