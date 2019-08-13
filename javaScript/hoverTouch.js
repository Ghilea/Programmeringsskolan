$(document).ready(function($){
    
    $('a.taphover').on("touchstart", function (e) {
    "use strict"; //satisfy the code inspectors
    var link = $(this); //preselect the link
		if (link.hasClass('hover')) {
			return true;
		} else {
			link.addClass("hover");
			$('a.taphover').not(this).removeClass("hover");
			e.preventDefault();
			return false; //extra, and to make sure the function has consistent return points
		}
	});

});