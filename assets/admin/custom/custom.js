// Duplicate -> Custom Fields childrens 
var i = 0; //Increment
function duplicateData(idName) {
 	var original = document.getElementById(idName);
	var clone = original.cloneNode(true);
	clone.id = idName + ++i;
	(original.parentNode.appendChild(clone)).insertAfter($("#"+idName));
}

// Remove Added Custom Fields
function removeData(className) {
	if ($('.'+className).length > 1) {
	   $('.'+className+':last').remove();
	}
}

$(document).ready(function(){

    // Categories
    var cat_url = $('#categorySELECT').val();
    $('#categories').on("change",function () {
        var categoryId = $(this).find('option:selected').val();
        $.ajax({
            url: cat_url,
            type: "POST",
            data: "categoryNAME="+categoryId,
            success: function (response) {
                console.log(response);
                $("#sub_category").html(response);
            },
        });
    }); 
});


