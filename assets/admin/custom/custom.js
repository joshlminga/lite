/*** NEW CUSTOM FIELD ***/

//Fields
const fieldInput = (num) => {
	let required = (num == 1) ? 'required' : '';
    let fields = `
		<div class="col-md-3 col-sm-12 field-key" num="${num}">
			<div class="form-group">
				<div class="fg-line">
					<label>
						Key Name <small>(Unique Name)</small>
						<a onclick="removeField(this.getAttribute('action'))" action="${num}" class="btn btn-sm btn-danger field-action">
							<i class="fa fa-trash"></i>
						</a>

						<input type="checkbox" name="filter_${num}" value="${num}"><i class="input-helper"></i>Filter
					</label>
					<input type="text" class="form-control" name="customfield_inputs[]" autocomplete="off" value="" required>
				</div>
			</div>
		</div>
    `;

    // CustomField
    return fields;
}

// Reorder Fields
const reorderFieldData = () => {
    // Find all elements with div.field-key class and remove the last one
    let field_key = document.querySelectorAll(".field-key");
	// Loop while set attribute num to new value x, x should start at 1
	let x = 1;
	for (let index = 0; index < field_key.length; index++) {
		field_key[index].setAttribute("num", x);
		// Get a div.field-action inside field_key retrive a.btn-danger
		let field_action = field_key[index].querySelector("label > a.field-action");
		// Set attribute action to x
		field_action.setAttribute("action", x);
		// Get checkbox inside field_key
		let field_checkbox = field_key[index].querySelector("label > input[type=checkbox]");
		// Set value to x
		field_checkbox.value = x;
		// Change checkbox name to filter_x
		field_checkbox.name = "filter_" + x;
		x++;
	}
}

// Add Key
const custom_field = num => fieldInput(num);

//  Remove Field Key
const remove_custom_field = (num = null) => {
    // Find all elements with div.field-key class and remove the last one
    let field_key = document.querySelectorAll(".field-key");
	// If num is null
	if (num == null || num == undefined || num == "") {
		field_key[field_key.length - 1].remove();
	}else{
		// Get attribute num from current field_key
		let current_num = parseInt(field_key[num - 1].getAttribute("num"));
		if(current_num == num){
			// Remove field_key
			field_key[num -1].remove();
			// Reorder
			reorderFieldData();
		}
	}
}

// create function addField
const addField= () => {
    // Select all elements with div.field-key class, count the count of elements and add 1
    let field_key = document.querySelectorAll(".field-key");
    let num = field_key.length + 1;

    // Add Custom Field Key
    let customfield = custom_field(num);

    //Add new autofile inside field_box_area
    let field_box_area = document.querySelector(".field_box_area");
    field_box_area.insertAdjacentHTML('beforeend',customfield);
}

// create function removeField
const removeField = (num = null) => {
    // Find the total elements with div.field-key class, if they are more than 1 remove the element
    let field_key = document.querySelectorAll(".field-key");
    if (field_key.length > 1) {
		// Call function remove_custom_field
		remove_custom_field(num);
    }
}

/*** END NEW CUSTOM FIELD ***/

/*** NEW AUTO FIELD ***/

// AutoField
const autoInput = (num) => {
    let fields = `
        <div class="col-md-4 col-sm-12 col-xs-12 auto-key">
            <div class="form-group">
                <div class="fg-line">
                    <label>Label/Key Unique Name <i class="fa fa-asterisk"></i> </label>
					<input type="text" name="autofield_label[]" class="form-control" value="" placeholder="Label/Key... " required>
                </div>
            </div>
        </div>

		<div class="col-md-7 col-sm-12 col-xs-12 auto-value">
            <div class="form-group">
                <div class="fg-line">
                    <label>Data/Value </label>
                    <textarea name="autofield_value[]" class="form-control auto-size" placeholder="Data/Value... "></textarea>
                </div>
            </div>
        </div>

		<div class="col-md-1 col-sm-12 col-xs-12 auto-action">
            <div class="form-group">
                <div class="fg-line">
					<a onclick="removeAutoData(this.getAttribute('action'))" action="${num}" class="btn btn-sm btn-danger">
						Remove<i class="fa fa-trash"></i>
					</a>
                </div>
            </div>
        </div>
    `;

    // AutoField
    return fields;
}

// Reorder Fields
const reorderAutoData = () => {
    // Find all elements with div.auto_box class and remove the last one
    let auto_box = document.querySelectorAll(".auto_box");
	// Loop while set attribute num to new value x, x should start at 1
	let x = 1;
	for (let index = 0; index < auto_box.length; index++) {
		auto_box[index].setAttribute("num", x);
		// Get a div.auto-action inside auto_box retrive a.btn-danger
		let auto_action = auto_box[index].querySelector(".auto-action a");
		// Set attribute action to x
		auto_action.setAttribute("action", x);
		x++;
	}

}

// Add Label & Value
const auto_field = (num) => {
    let autofield = `
        <div class="row auto_box" num="${num}">
            ${autoInput(num)}
        </div>
    `;

    // Label & Value
    return autofield;
}

//  Remove Label & Value
const remove_auto_field = (num = null) => {
    // Find all elements with div.auto_box class and remove the last one
    let auto_box = document.querySelectorAll(".auto_box");
	// If num is null
	if (num == null || num == undefined || num == "") {
		auto_box[auto_box.length - 1].remove();
	}else{
		// Get attribute num from current auto_box
		let current_num = parseInt(auto_box[num - 1].getAttribute("num"));
		if(current_num == num){
			// Remove auto_field
			auto_box[num -1].remove();
			// Reorder
			reorderAutoData();
		}
	}
}

// create function addAutoData
const addAutoData = () => {
    // Select all elements with div.auto_box class, count the count of elements and add 1
    let auto_box = document.querySelectorAll(".auto_box");
    let num = auto_box.length + 1;

    // Add Lable & Answer
    let autofield = auto_field(num);

    //Add new autofile inside auto_box_area
    let auto_box_area = document.querySelector(".auto_box_area");
    auto_box_area.insertAdjacentHTML('beforeend',autofield);
}

// create function removeAutoData
const removeAutoData = (num = null) => {
    // Find the total elements with div.auto_box class, if they are more than 1 remove the element
    let auto_box = document.querySelectorAll(".auto_box");
    if (auto_box.length > 0) {
		// Call function remove_auto_field
		remove_auto_field(num);
    }
}

/*** END NEW AUTO FIELD ***/

/*** ROUTE FIELD ***/
const routeInput = (num) => {
    let fields = `
        <div class="col-md-4 col-sm-12 col-xs-12 auto-key">
            <div class="form-group">
                <div class="fg-line">
					<input type="text" name="route[]" class="form-control" value="" placeholder="example/(:any)" required>
                </div>
            </div>
        </div>

		<div class="col-md-7 col-sm-12 col-xs-12 auto-value">
            <div class="form-group">
                <div class="fg-line">
					<input type="text" name="controller[]" class="form-control" value="" placeholder="Folder/ControllerName/Method/$1" required>
                </div>
            </div>
        </div>

		<div class="col-md-1 col-sm-12 col-xs-12 auto-action">
            <div class="form-group">
                <div class="fg-line">
					<a onclick="removeRoute(this.getAttribute('action'))" action="${num}" class="btn btn-sm btn-danger">
						<i class="fa fa-trash"></i>
					</a>
                </div>
            </div>
        </div>
    `;

    // AutoField
    return fields;
}

// Add Route & Controller
const route_field = (num) => {
    let autofield = `
        <div class="row auto_box" num="${num}">
            ${routeInput(num)}
        </div>
    `;

    // Label & Value
    return autofield;
}

// create function addAutoData
const addRoute = () => {
    // Select all elements with div.auto_box class, count the count of elements and add 1
    let auto_box = document.querySelectorAll(".auto_box");
    let num = auto_box.length + 1;

    // Add Lable & Answer
    let autofield = route_field(num);

    //Add new autofile inside auto_box_area
    let auto_box_area = document.querySelector(".auto_box_area");
    auto_box_area.insertAdjacentHTML('beforeend',autofield);
}

// create function removeAutoData
const removeRoute = (num = null) => {
    // Find the total elements with div.auto_box class, if they are more than 1 remove the element
    let auto_box = document.querySelectorAll(".auto_box");
    if (auto_box.length > 0) {
		// Call function remove_auto_field
		remove_auto_field(num);
    }
}

/*** END ROUTE FIELD ***/

/*** HELPERS FIELD ***/
const helperInput = (num) => {
    let fields = `

		<div class="form-group">
			<div class="fg-line">
				<label>
					Entry Value
					<a onclick="removeHelper(this.getAttribute('action'))" action="${num}" class="btn btn-sm btn-danger field-action">
						<i class="fa fa-trash"></i>
					</a>
				</label>
				<input type="text" class="form-control" name="general_key[]" autocomplete="off" value="">
			</div>
		</div>

    `;

    // AutoField
    return fields;
}

// Add Helper
const helper_field = (num) => {
    let autofield = `
		<div class="col-md-3 col-sm-12 field-key" num="${num}">
            ${helperInput(num)}
        </div>
    `;

    // Label & Value
    return autofield;
}

// create function addAutoData
const addHelper = () => {
    // Select all elements with div.field-key class, count the count of elements and add 1
    let auto_box = document.querySelectorAll(".field-key");
    let num = auto_box.length + 1;

    // Add Lable & Answer
    let autofield = helper_field(num);

    //Add new autofile inside helper_box_area
    let auto_box_area = document.querySelector(".helper_box_area");
    auto_box_area.insertAdjacentHTML('beforeend',autofield);
}

// create function removeAutoData
const removeHelper = (num = null) => {
    // Find the total elements with div.auto_box class, if they are more than 1 remove the element
    let field_key = document.querySelectorAll(".field-key");
    if (field_key.length > 0) {
		// If num is null
		if (num == null || num == undefined || num == "") {
			field_key[field_key.length - 1].remove();
		}else{
			// Get attribute num from current field_key
			let current_num = parseInt(field_key[num - 1].getAttribute("num"));
			if(current_num == num){
				// Remove field_key
				field_key[num -1].remove();
				// -> reorder
    			let field_keyload = document.querySelectorAll(".field-key");
				// Loop while set attribute num to new value x, x should start at 1
				let x = 1;
				for (let index = 0; index < field_keyload.length; index++) {
					console.log('index', x);
					field_keyload[index].setAttribute("num", x);
					// Get a div.field-action inside field_key retrive a.btn-danger
					let field_action = field_keyload[index].querySelector("label > a.field-action");
					// Set attribute action to x
					field_action.setAttribute("action", x);
					x++;
				}
			}
		}
    }
}
/*** END HELPERS FIELD ***/

$(document).ready(function(){

    var selected = $('#usePost').val();
    if (selected == 'video') {
        $('#dataImage').hide();
        $('#dataVideo').show();
    }else{
        $('#dataVideo').hide();
        $('#dataImage').show();
    }

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

    $('#usePost').on("change",function () {
        var usePost = $(this).find('option:selected').val();
        if (usePost == 'video') {
            $('#dataImage').hide();
            $('#dataImage').fadeOut("slow");
            $('#dataVideo').show();
        }else{
            $('#dataVideo').hide();
            $('#dataVideo').fadeOut("slow");
            $('#dataImage').show();
        }
    }); 


});

//On Post Publish Time Change


//Hide And Show the Current Link Button
function changeCUR(arg) {

    //check argument passed
    if(arg == 'change'){

        //Show Save and Cancel Button
        $('.curr-hide-btn').removeClass('curr-hide');

        //Show shorten URL without Post ID
        $('#current-link-label').removeClass('curr-hide');

        //Show Edit Input
        $('#edit-current-link').removeClass('curr-hide');

        //End Slash
        $('.end-slash').removeClass('curr-hide');

        //Hide Change Button
        $('#change-btn').hide();

        //Hide Current Link
        $('#current-link').hide();
    }
    else if(arg == 'save'){

        //default Label Link
        var currentURL = $('#current-link-label').text();

        //Current Entered Post ID
        var currentPOSTID = $('#edit-current-link').val();

        //Correct URL
        var correctURL = currentPOSTID.replace(/\s+/g, '-').toLowerCase();

        //Update links
        var newLink = currentURL.trim()+correctURL.trim();

        //Hide Save and Cancel Button
        $('.curr-hide-btn').addClass('curr-hide');

        //Hide shorten URL without Post ID
        $('#current-link-label').addClass('curr-hide');

        //Hide Edit Input
        $('#edit-current-link').addClass('curr-hide');

        //End Slash
        $('.end-slash').addClass('curr-hide');

        //Show Change Button
        $('#change-btn').show();

        //New Link to Database
        $('#set-current-link').val(correctURL);

        //change or update the link
        $('#current-link').text(newLink);

        //Show Current Link
        $('#current-link').show();
    }
    else if(arg == 'cancel'){

        //Cancel Action
        btnlinkCAN();
    }
    else{

        //Cancel Action
        btnlinkCAN();
    }

}

// On Current Link Change CLICK CANCEL
function btnlinkCAN() {

    //Hide Save and Cancel Button
    $('.curr-hide-btn').addClass('curr-hide');

    //Hide shorten URL without Post ID
    $('#current-link-label').addClass('curr-hide');

    //Hide Edit Box
    $('#edit-current-link').addClass('curr-hide');

    //End Slash
    $('.end-slash').addClass('curr-hide');

    //Show Change Button
    $('#change-btn').show();

    //Show Current Link
    $('#current-link').show();

    var oldLink = $('#old-url-link').val();
    $('#current-link').text(oldLink);

    var oldURL = $('#old-url').val();
    $('#set-current-link').val(oldURL);

}

//On Post Publish Time Change
$("#post-schedule").change(function () {

    //Check if Checked
    if($(this).prop("checked") == true){

        //Hide Calender
        $('#post-date').addClass('curr-hide');
        $('#post-date').removeClass('fg-line');

        //Change Text
        $('#post-time').text('Post Now');

    }else{

        //Show Calender
        $('#post-date').removeClass('curr-hide');
        $('#post-date').addClass('fg-line');

        //Change Text
        $('#post-time').text('Post On Date');
    }
});

/*
* Auto Complete Data  
*/
function autocomplete(inp, arr) {

    /*the autocomplete function takes two arguments, the text field element and an array of possible autocompleted values:*/
    var currentFocus;

    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {

        var a, b, i, val = this.value;

        /*close any already open lists of autocompleted values*/
        closeAllLists();

        if (!val) { return false;}
        currentFocus = -1;

        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");

        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);

        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {

            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {

                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");

                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);

                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {

                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;

                    /*close the list of autocompleted values,(or any other open lists of autocompleted values:*/
                    closeAllLists();
                });

                a.appendChild(b);
            }
        }
    });

    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {

        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {

            /*If the arrow DOWN key is pressed, increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);

        } else if (e.keyCode == 38) { //up

            /*If the arrow UP key is pressed,decrease the currentFocus variable:*/
            currentFocus--;

            /*and and make the current item more visible:*/
            addActive(x);

        } else if (e.keyCode == 13) {

            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {

                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {

        /*a function to classify an item as "active":*/
        if (!x) return false;

        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);

        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {

        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }

    }
        
    function closeAllLists(elmnt) {

        /*close all autocomplete lists in the document,except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {

        closeAllLists(e.target);
    });
}

/*An array containing all the country names in the world:*/
//var autocompleteData = $('#dataToAutoComplete').val().split(',');

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
//autocomplete(document.getElementById("autoCompleteField"), autocompleteData);

