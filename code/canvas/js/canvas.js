/* Contains all the Javascript logic of the canvas and its main features: save, export and share */

$(function() {
    /*This piece of code is for making the column-count and column-gap CSS to work in Firefox*/
    document.getElementById("8-5-col-layout").style.MozColumnCount =
        "5";
    document.getElementById("4-col-layout").style.MozColumnCount =
        "4"; // end of Firefox fix

    $('#share-with-users').hide();

    /* Prevent pressing ENTER on Project Title from submitting the form */
    $('.proj_title').keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });


    /*================================
       Serialize Form to JSON
      ================================*/
    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {

            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    }; // end of $.fn.serializeObject ...
    /*=====================================
        Getting the current date
     =====================================*/
    var fullDate = new Date();
    var twoDigitMonth = fullDate.getMonth() + "";
    if (twoDigitMonth.length == 1) twoDigitMonth = "0" + twoDigitMonth;
    var twoDigitDate = fullDate.getDate() + "";
    if (twoDigitDate.length == 1) twoDigitDate = "0" + twoDigitDate;

    var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" +
        twoDigitDate;
    // set the current date in the date input field
     $('.proj_date').val(currentDate);
    /*========================================
        USER LOGS OUT (dropdown menu)
    ==========================================*/
    $('.user-profile').on('click', '#logout', function() {
        var url = 'php/logout.php';
        $.post(url, function(data, status) {
            if (data == 200) {
                $('.user-profile').hide();
                window.location.href="https://www.ethicscanvas.org";
            }
        });
    });

    /*========================================
     When the page loads, Import the chosen canvas if the user has picked one from the dashbord,
    otherwise load an empty canvas
    ==========================================*/

    // if a canvas is chosen by the user to be loaded
    if (current_canvas_id !== '') {

        // var url = 'json/' + current_canvas_id + '.json';
        var url = 'php/load-canvas.php'
        var params = 'current_canvas_id=' + current_canvas_id;

        var auth = 'php/authorise.php';
        $.get(auth, params, function (returnedVal) {
            if (returnedVal == 200) {
                console.log("authorised true");

                // get the saved ISON object in the sendJSON.text file
                $.getJSON(url, params, function(returnedObj) {

                    //Display the json data in the html

                    var itemListHTML = '';
                    // var returnedJSON = JSON.parse(returnedObj);
                    //iterate through the object
                    $.each(returnedObj, function(key, value) {
                        /* project name and tem field*/
                        if (key === 'field_00[]') {

                            $('.form-header').find('input.proj_title').val(value[
                                0]);
                            $('.form-header').find('input.proj_date').val(value[1]);


                        } // end of if(key === 'field_00[]')
                        else if(key === 'share-with') {
                            if(value.length > 0) {
                                $('input[name=privacy][value=Private').prop('checked', true);
                                $('#share-with-users').show();
                                $('#share-with').val(value);
                            }
                        }
                        else if(key === 'tags') {
                            $('#tags').val(value);
                        }
                        else if (key !== 'new_item') {

                            if ($.type(value) === "array") {
                                $.each(value, function(i, itm) {

                                    /** FIX DUPLICATIONs in the canvas when importing
                                    /*  Importing will override the canvas content
                                    clear the canvas by giving en emty content to the ul list (remove previous list items) */
                                    $('.canvas-form').find('.card').filter('.' +
                                        key.substr(0, 8)).find('ul.item_list').html(
                                        '');

                                    /* Create a list item with each value item
                                    and give it text area with the name attribute as the "key" (right field name) */

                                    itemListHTML +=
                                        '<li class="added_item"><span class="handle glyphicon glyphicon-th"></span><textarea maxlength="100" class="expandable" rows="3" data-limit-rows="true"  data-autoresize  name="' +
                                        key + '">' + itm +
                                        '</textarea><span class="remove glyphicon glyphicon-remove-circle"></span></li>';

                                }); //end of $.each(value ...
                            } // end of if($.type(value)==="array")
                            else { // a single value string
                                itemListHTML +=
                                    '<li class="added_item"><span class="handle glyphicon glyphicon-th"></span><textarea maxlength="100" class="expandable" rows="3" data-limit-rows="true"  data-autoresize  name="' +
                                    key + '">' + value +
                                    '</textarea><span class="remove glyphicon glyphicon-remove-circle"></span></li>';
                            }
                            /* Append the created list items/textatreas to the right field based on the "key"*/
                            /* the str.substr(start,length)
                            is used to remove the [] from the end of the "key"name (for each field. also the name attributes accociated with each fiels) so that we can select the right class (right field) and append the created lists to the right field
                            so field names/key/name attribute will tuen into class names: ex:  field_1[] becomes field_1
                            */
                            // find the field by its class names besed on the current key name
                            // append the created list of item values to that right field

                            $('.canvas-form').find('.card').filter('.' + key.substr(
                                0, 8)).find('ul.item_list').append(itemListHTML);
                            /*$('form').find('.card').filter('.field_1').find('ul.item_list').append(itemListHTML); */
                            /* !! Empty the item list after each count of "key" so that the previous item lists from the other fields (associated with the previous key) don't get added up to the item list of other fields */
                            itemListHTML = '';

                        } //end of   if(key !== ...
                    }); //end of $.each(returnedObj...

                }); // end of $.getJSON
                /*--- fix the heights after importing  ---*/
                fixHeights();
                /*--------------------------------*/

             }
             else {
                console.log("authorised false");
                window.location.href = "../repository/index.php";
            }
        });        

    }



    /*=======================================
       Toggle the introduction text in fields
     =======================================*/
    //$(selector).toggle(speed,easing,callback)
    $('.card').on('click', '.intro-toggle', function() {
        var $TogglingText = $($(this).closest('.card').find('.intro'));
        var $Toggler = $($(this).closest('.card').find('.intro-toggle'));
        $TogglingText.toggle('slow', function() {
            /*Do this when toggling: */
            // the boolean .is(':visible') of the current toggle state
            if ($TogglingText.is(':visible')) {
                // change the text of the toggle
                $Toggler.find('.intro-toggle-text').text('Hide description');
                // change the icon of the toggle
                $Toggler.find('.intro-toggle-icon').switchClass(
                    "glyphicon-plus-sign", "glyphicon-minus-sign", 1000,
                    "easeInOutQuad");
            } else {
                $Toggler.find('.intro-toggle-text').text('Show description');
                $Toggler.find('.intro-toggle-icon').switchClass(
                    "glyphicon-minus-sign", "glyphicon-plus-sign", 1000,
                    "easeInOutQuad");

            }

        }); //end of toggle

    }); //end of click

    /*================================
       Auto expand user input textareas
     ================================*/
    /*Works for textareas already exsting in the html when the page loads -> User input*/
    $.each(jQuery('textarea[data-autoresize]'), function() {
        var offset = this.offsetHeight - this.clientHeight;

        var resizeTextarea = function(el) {
            $(el).css('height', 'auto').css('height', el.scrollHeight +
                offset);
        };
        $(this).on('keyup input', function() {
            resizeTextarea(this);
        }).removeAttr('data-autoresize');
    });
    /*===========================================
       Limiting the number of lines in textareas
      ===========================================*/
    // <textarea data-limit-rows="true" cols="60" rows="8"></textarea>
    $('.card').on('keypress', 'textarea[data-limit-rows=true]', function(
        event) {
        var textarea = $(this),
            text = textarea.val(),
            /* match() -> Searches a string for a match against a regular expression, and returns the matches, as an Array object.*/
            numberOfLines = (text.match(/\n/g) || []).length + 1,
            maxRows = parseInt(textarea.attr('rows'));

        // if the number of lines have reached the max rows
        if (numberOfLines === maxRows) {
            return false;
        }

    });
    /*================================
      Handling user input, ADD items
      A. Add button
      B. Clicking enter
      ================================*/
    /*------------------------------
       add new idea slide effect
    ------------------------------*/
    /* When clicking on "add a new idea", Slide down and show the  input field for adding a new item (from the begining,it is set to display:hidden with CSS).If clicked again, slide it up. After that, set the textarea in automatic focus*/
    $('.card').on('click', 'a.add-idea', function(event) {
        //  stop the default behavior of the link (jumping back to the start of the page)
        event.preventDefault();
        //set the textarea automatically in focus
        $(this).closest('.card').find('.user-input').slideToggle("slow",
            function() {
                //When the toggle animation is complete:
                // set the text area in focus
                $(this).closest('.card').find('.new_item').val('');
                 $(this).closest('.card').find('.chars').text(maxLength);
                $(this).closest('.card').find('.new_item').focus();
            });

    });

    /*----------------------------------------
     Limiting the number of characters to type
    ------------------------------------------*/
    var maxLength = 100;
    $('.card').on('keyup', '.new_item', function() {
        var length = $(this).val().length;
        length = maxLength - length;
        //show the characters remaining only on this field
        $(this).closest('.user-input').find('.chars').text(length);
    });



    /*-------------------------------
        A. When we click the add btn to
         add the item to the list
    ---------------------------------- */
    //event deligation to handle the present and future elements that are dynamically added
    $('.card').on('click', '.add_btn', function() {
        var new_item = $(this).closest('.card').find('.new_item').val();
        var new_item_height = $(this).closest('.card').find('.new_item').height();
        //number of items are in the list
        var fieldItemCount = $(this).closest('.card').find('ul.item_list').find(
            'li').length;
        // new item added, increment the number of items
        fieldItemCount++;
        //add the input value as a textarea item
        /* create a name attribute in the "field_nr[]" format to be able to tag each new item with the right field attr name (based on the field they are added to). This is to format the json file for each group of dynamically added items. We get the name attribute directly from the id attribute of the ul list in each card (the one we pressed the add button in) */
        // if the new item input exist (is not empty), add the item

        if (new_item) {
            var field_attr = $(this).closest('.card').find('ul.item_list').attr(
                'id') + '[]';
            /*The height of the newly added item = the height of the add new idea textarea*/
            $(this).closest('.card').find('ul.item_list').append(
                '<li class="added_item"><span class="handle glyphicon glyphicon-th"></span><textarea maxlength="100" class="expandable" rows="3" data-limit-rows="true" data-autoresize   name="' +
                field_attr + '">' +
                new_item +
                '</textarea><span class="remove glyphicon glyphicon-remove-circle"></span></li>'
            );

            // Fix the heights only after a new item is added
            //  fixHeights();
        } // end of if(new_item){
        //clear the new item the text area value
        $(this).closest('.card').find('.new_item').val('');
        if (email_save_canvas != '') {
          saveCanvas();
        }
        /* When clicking on "add idea",  hide the  input field for adding a new item (slideUp() doesn't work nicely here)*/
        $(this).closest('.card').find('.user-input').hide("fast", function() {
            // Animation complete.
        });

    });

    /*----------------------------------------
       B. Clicking enter in the add idea textarea,
       will add the new item to the card
    -------------------------------------------*/
    //<textarea data-limit-rows="true" ></textarea>
    $('.card').on('keypress', 'textarea[data-limit-rows=true]', function(
        event) {
        var textarea = $(this);
        var text = textarea.val();

        /* The jQuery event.which -->
         Returns which keyboard key was pressed: */
        // if the enter is pressed, event.which === 13
        if (event.which === 13) {
            var new_item = $(this).closest('.card').find('.new_item').val();
            var new_item_height = $(this).closest('.card').find('.new_item').height();
            //number of items are in the list
            var fieldItemCount = $(this).closest('.card').find('ul.item_list')
                .find(
                    'li').length;
            // new item added, increment the number of items
            fieldItemCount++;
            //add the input value as a textarea item
            /* create a name attribute in the "field_nr[]" format to be able to tag each new item with the right field attr name (based on the field they are added to). This is to format the json file for each group of dynamically added items. We get the name attribute directly from the id attribute of the ul list in each card (the one we pressed the add button in) */
            // if the new item input exist (is not empty), add the item

            if (new_item) {
                var field_attr = $(this).closest('.card').find('ul.item_list').attr(
                    'id') + '[]';
                /*The height of the newly added item = the height of the add new idea textarea*/
                $(this).closest('.card').find('ul.item_list').append(
                    '<li class="added_item"><span class="handle glyphicon glyphicon-th"></span><textarea maxlength="100" class="expandable" rows="3" data-limit-rows="true" data-autoresize   name="' + field_attr + '">' + new_item + '</textarea><span class="remove glyphicon glyphicon-remove-circle"></span></li>');
                // Fix the heights only after a new item is added
                //  fixHeights();
            } // end of if(new_item){
            //clear the new item the text area value
            $(this).closest('.card').find('.new_item').val('');
            /* When clicking on "add idea",  hide the  input field for adding a new item (slideUp() doesn't work nicely here)*/
            $(this).closest('.card').find('.user-input').hide("fast",
                function() {
                    // Animation complete.
                });

        }

    });


    /*================================
            Deleting items
    ================================*/
    //  when the cross beside the textarea is clicked (span.remove)
    // remove that list item
    $('.card').on('click', 'span.remove', function() {
        $(this).closest('li').remove();
        if (email_save_canvas != '') {
          saveCanvas();
        }
    });

    /*================================
          Sortable field items
     ================================*/
    //make items sortable in their fields and between fields
    $('.sortable').sortable({
        connectWith: '.connectedList',
        placeholder: "sort-placeholder",
        //  revert: true

        zIndex: 300 //or greater than any other relative/absolute/fixed elements and droppables
    });

    /*================================
        Sorting and Dragging events
     ================================*/

    /*sortstart
     sortover
     sortstop*/
    /**
      every textarea in a item needs to get the right name attribute once they have been dropped in another field (so it ends up in the right place in the json file)
    **/

    /*Dragging starts*/
    $(".sortable").on("sortstart", function(event, ui) {
        // WHEN WE SORT CARDS, $(this) ---> the "begining" ul with the class of .sortable
    });
    /*Dragging ends: item dropped*/
    $(".sortable").on("sortstop", function(event, ui) {
        // get the id of the field ul (to set the name attribute of textareas)
        // # mouseleave is the right event for when we release and leave a card mouseup doesn't work properly in this case
        $('.card').on('mouseleave', 'li', function() {
            //$(selector).attr(attribute,value)
            var fieldAttr = $(this).closest('ul.item_list').attr('id');
            $(this).find('textarea').attr('name', fieldAttr + '[]');
        });

    }); // end of $(".sortable").on("sortstop"...


    /* ===============================================
         SAVING THE CANVAS:
         CLICK ON #EXPORT JSON# form button
      ================================================*/


    /*---------------------------------------------------
       When the user clicks on the SAVE CANVAS button
     ---------------------------------------------------*/
    $('.canvas-form').on('click', '.json_exp', function() {

        /*Prevent the card item list from reseting itself after clicking
        on the export button (submission). Because the type of the button is submit */
        saveCanvas();
        return false;
    }); // end of handling the click on EXPORT button

    function saveCanvas() {
      /* ---------------------------------------------
          A: saving the canvas
          as a registered user
       ----------------------------------------------*/
      //   php variables are retieved in the header of the canvas index.php as js variables -->
      var name_save_canvas = $('.form-header').find('.proj_title').val();
      var date_save_canvas = $('.form-header').find('.proj_date').val();
      var visibility =  $("input[name=privacy]:checked").val();
      var save_canvas_obj = {
          'email_save_canvas': email_save_canvas,
          'name_save_canvas': name_save_canvas,
          'date_save_canvas': date_save_canvas,
          'visibility': visibility
      };

      var save_canvas = $.param(save_canvas_obj);
      /*  Post the JSON stringified object to the php file
      (the php script will save it in a database )*/
      var save_reg_url = "php/save-canvas.php";

      $.post(save_reg_url, {
          save_canvas: save_canvas
      }, function(data, status) {
          //the returned data is successful, is the $canvas_id
          var canvas_id = data;
          // send this canvas_id with the next ajax requestedto the php/canvas.php file and use it as the name of the json file to be saved

          // Give the user feedback that the canvas is saved
          if (data !== 400 || data !== 401) {
              if ($('.imp-exp-btn ').find(".save-canvas-feedback") !== null) {
                  $('.imp-exp-btn ').find(".save-canvas-feedback").remove();


              }
              $('.canvas-form').find('.imp-exp-btn ').append('<div class="save-canvas-feedback"><p><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>Your canvas is saved in your dashbord</p></div>');
              // remove the canvas is saves message as soon as user changes the canvas
              $('.canvas-form').on("change keyup", 'textarea', function() {
                  $('.imp-exp-btn ').find(".save-canvas-feedback").remove();
              });
          } else {

              $('.canvas-form').find('.imp-exp-btn ').append('<div class="save-canvas-feedback-fail"><p>Oh! We could not save your canvas. Please try again or contact us at hello@ethicscanvas.org</p></div>');
          }
          //For the second AJAX request:
          /*#########################################################*/

          /*----------------------------------------
            B: Exporting the form data json to a database
           ----------------------------------------*/

          // $('#result').text(JSON.stringify($('.canvas-form').serializeObject()));


          //Make the JSON object into a JSON string
          var JSONstrObj = JSON.stringify($('.canvas-form').serializeObject());
          var url = "php/canvas.php";
          var share_with = $('#share-with').val();
          var tags = $('#tags').val();
          /*  Post the JSON stringified object to the php file
          (the php script will save it in a database )*/
          //also, send the canvas_id to use as the key
          $.post(url, {
              JSONstrObj: JSONstrObj,
              canvas_id: canvas_id,
              share_with: share_with,
              tags: tags
          }, function(data, status) {
              console.log(
                  'Response from php when sending the form json object: \n' +
                  'data:' + data + '\n status: ' + status);
          }).fail(function(jqXHR) {
              console.log("Error " + jqXHR.status + ' ' + jqXHR.statustext);
          });

          /*########################################################*/

      }).fail(function(jqXHR) {
          console.log("Error " + jqXHR.status + ' ' + jqXHR.statustext);
      });
    }
    /*===========================================
    HANDLING CLICK ON : Privacy Radio Buttons
     ===========================================*/
     $("input[name=privacy]").on("click", function() {
         if ($(this).val() == "Private") {
            $('#share-with-users').slideDown(400);
            $('.tags').css("height","350px")
         } else {
             $('#share-with-users').slideUp();
             $('.tags').css("height","250px")
         }
     });

    /*===========================================
    HANDLING CLICK ON : Share This Canvas BUTTON
     ===========================================*/
    $('.canvas-form').on('click', '.share_canvas', function() {
        $('.share_canvas_email').slideDown(1000, function() {

            // SAVE THE PDF AS file
            $.post('mpdf/canvas-pdf-save.php', function(data, status) {

            }); // save pdf as file

        }); // end of slide down animation
    }); // end of click on share_canvas button

    $('.canvas-form').on('click', '.share_canvas_send', function() {

            var share_email = $('.share_canvas_email').find('input').serialize();
            /*This sends a serialized array share_email to the php file.
              exapmple: the value of this array will be:  share-canvas-email=eternalflame.f%40gmail.com
            */
            $.post('php/share-canvas.php', {
                share_email: share_email
            }, function(data, status) {
                if (data == 200) { // canvas successfully shared
                    $('.canvas-form').find('.imp-exp-btn ').append('<div class="save-canvas-feedback"><p><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>Your canvas has been shared by email</p></div>')
                }
                else {
                   $('.canvas-form').find('.imp-exp-btn ').append('<div class="save-canvas-feedback"><p><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>Your canvas could not be shared by email</p></div>')
                }
            }); // end of post email

            // slide up the .share_canvas_email area

            $('.share_canvas_email').slideUp(); // end of slide up animation
    }); // end of click on "send"


    /*===========================================
      Controlling the height of divs dynamically
     ===========================================*/

    //Call this function after adding a new item and importing
    // $( window ).width(); ->Returns width of browser viewport
    function fixHeights() {

        // --------------------------------------------------
        // Returns width of browser viewport
        var screenSize = $(window).width();
        //the longest card of the group 1 .masonry-layout8-5
        var longest_1 = $('.masonry-layout8-5').height();
        //the longest card of the group 2 .masonry-layout8-5
        var longest_2 = $('.masonry-layout4').height();

        /* --- 5 COL Range ---- */
        if (screenSize >= 1139) {
            // inforcing a fixed height ".height(longest_1/2)" will create some layout issues when we try to add new items the add item area will go outside the box and the heights don't increase naturally

            // card group1:
            // $('.field_05,.field_11, .field_07').css('min-height', longest_1 -
            //     longest_1 * 5 / 100);
            // $('.field_06,.field_08, .field_12').css('min-height', longest_1 +
            //     longest_1 * 5 / 100);
            // $('.field_01, .field_02').css('min-height', longest_1 * 2 +
            //     longest_1 * 1 / 100);
            // // card group 2
            // $('.field_03, .field_09, .field_10, .field_04').css('min-height',
            //     longest_2 * 2 - longest_2 * 20 / 100);

            $('.field_05,.field_11, .field_07').css('min-height', longest_1 -
                longest_1 * 20 / 100);
            $('.field_06,.field_08, .field_12').css('min-height', longest_1 -
                longest_1 * 20 / 100);
            $('.field_01, .field_02').css('min-height', longest_1 + longest_1 * 40 / 100);
            // card group 2
            $('.field_03, .field_09, .field_10, .field_04').css('min-height',
                longest_2 - longest_2 * 10 / 100);
        }
        /*  4 COL Range */
        else if (screenSize >= 977 && screenSize <= 1138) {
            // card group1:
            // row 1
            $('.field_01,.field_06, .field_12,.field_08 ').css('min-height',
                longest_1 + longest_2 * 20 / 100);
            // row 2
            $('.field_05,.field_11, .field_07,.field_02 ').css('min-height',
                longest_1 + longest_2 * 20 / 100);

            // card group 2
            // row 3
            $('.field_03, .field_09, .field_10, .field_04').css('min-height',
                longest_2 * 2 - longest_2 * 20 / 100);

        } else if (screenSize >= 920 && screenSize <= 976) {
            // card group1:
            // row 1
            $('.field_01,.field_06, .field_12,.field_08 ').css('min-height',
                longest_1 + longest_2 * 20 / 100);
            // row 2
            $('.field_05,.field_11, .field_07,.field_02 ').css('min-height',
                longest_1 + longest_2 * 20 / 100);

            // card group 2
            // row 3
            $('.field_03, .field_09, .field_10, .field_04').css('min-height',
                longest_2 * 2 - longest_2 * 20 / 100);
        } else if (screenSize >= 485 && screenSize <= 919) {
            // else if (500 <= screenSize < 920) {

            // card group1:

            $('.field_01,.field_06, .field_12,.field_08 ').css('min-height',
                longest_1 * 80 / 100);

            $('.field_05,.field_11, .field_07,.field_02 ').css('min-height',
                longest_1 * 80 / 100);

            // card group 2

            $('.field_03, .field_09, .field_10, .field_04').css('min-height',
                longest_2 * 80 / 100);

            /* --- 1 COL Range ---- */
        } else {

            // card group1:

            // card group1:

            $('.field_01,.field_06, .field_12,.field_08 ').css('min-height',
                longest_1 * 20 / 100);

            $('.field_05,.field_11, .field_07,.field_02 ').css('min-height',
                longest_1 * 20 / 100);

            // card group 2

            $('.field_03, .field_09, .field_10, .field_04').css('min-height',
                longest_2 * 20 / 100);


        }

    } // end of fixHeights()


}); // end of jQuery code
