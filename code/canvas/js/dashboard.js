/* Contains all the logic of the user dashboard, such as create canvas, remove one or logout */

$(function() {

    /*================================
       REGISTER USER HAS LOGGED IN:
       Load their canvases
      ================================*/

    // "loggedin_user_email" is the email of the user who's logged in. It is retrieved from the php script on top of the in the dashbord.php file and stored as a js variable in the js script the in the header of the dashboard.php file

    /* ---------------------------------------------------------
    An AJAX request to post the user's email to the server to
    load their saved canvases
    -----------------------------------------------------------*/

    /*If the user has no canvases it returns []. This is an example of what two canvases returned:
    [{"canvas_id":"6RnpIt9d9W","user_id":"hello@arturocalvo.com","canvas_name":"Test ARTURO 2","canvas_date":"2016-07-16"},{"canvas_id":"E4YoiRJgSB","user_id":"hello@arturocalvo.com","canvas_name":"Test ARTURO 1","canvas_date":"2016-07-16"}]*/

    var url = "load_user_canvases.php";
    $.post(url, {
        loggedin_user_email: loggedin_user_email
    }, function(data, status) {
        //the data is a string holding array of json
        //concert the string to array of json to be able to loop it
        var canvasArray = jQuery.parseJSON(data);
        var canvas_color_index; //the color of the canvas in the gallery ( is designed in dashbord.css, and assiged here with jQuery)
        $.each(canvasArray, function(index, canvasItem) {
            /*   canvas gallery elements would be dynamically created by jQuery
                  <div user-canvas-gallery>
                <!-- The canvases are added inside this div using jQurty-->
                  <div class="canvas-gallery-item col-md-4 col-sm-6 text-center">
                      <div  class="col-md-12 test1">
                        <h3>Canvas Title</h3>
                        <p>created: <span>2016/09/14</span></p>
                      </div>
                   </div>

                   <!-- next .canvas-gallery-item ....-->

                   <div>
                  */

            if (index < 5) {
                canvas_color_index = index;
            } else {
                canvas_color_index = index % 5;
            }

            var canvasGalleryHTML = '<div class="canvas-gallery-item col-md-4 col-sm-6 text-center" id="' + canvasItem.canvas_id + '"><div  class="col-md-12 color' + canvas_color_index + '"><h4>Canvas Title:</h4><h3>' + canvasItem.canvas_name + '</h3><p>created: </p><p>' + canvasItem.canvas_date + '</p></div><button type="button" class="remove-canvas"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Remove</button></div>';
            //the added divs are appended to the outer gallery div .user-canvas-gallery
            $('.user-dashboard').find('.user-canvas-gallery').append(canvasGalleryHTML);
        }); // end of $.each loop for the user canvas data

        //if the AJAX request fails
    }).fail(function(jqXHR) {
        console.log("Error " + jqXHR.status + ' ' + jqXHR.statustext);
    }); // end of AJAX request t post the user's email

    /*=============================================
     Handling click on the log out button
    ===============================================*/
    $('.user-dashboard').on('click', '.dashbord-logout-btn', function(event) {
       var url = "logout.php";
       $.post(url, function(data, status) {
           if (data == 200) {
             // go to the landing page
               window.location.href = "../../index.html";

           }
       });

    });
    /*=============================================
     Handling click on each canvas in the gallery
    ===============================================*/
    $('.user-dashboard').on('click', '.canvas-gallery-item', function(event) {
        event.stopPropagation();
        //The id of the canvas that the user clicked on to load
        var canvas_ID = $(this).attr('id');
        $.post('utils.php', {
            canvas_ID: canvas_ID
        }, function(data, status) {
            if (data == 200) {
                window.location.href = "../index.php";

            }
        });

        // window.location.href='../index.php';

    }); //end of 'click' on '.canvas-gallery-item'

    /*=============================================
     Handling the click on "remove" btn for each
     canvas in the gallery
    ===============================================*/
    // .remove-canvas
    $('.user-dashboard').on('click', '.remove-canvas', function(event) {
        event.stopPropagation();
        //get the serialized canvas id for this element (given to the element as it's id attribute by the time of creation)
        var remove_canvas_ID = $(this).closest('.canvas-gallery-item').attr('id');
        $(this).closest('.canvas-gallery-item').remove();
        // Also tell the back end to remove this from the database
        var url = 'remove-canvas.php';
        $.post(url, {
            remove_canvas_ID: remove_canvas_ID
        }, function(data, status) {
            console.log("response from remove-canvas.php: --DATA: " + data + " --STATUS:" + status);
        }); //end of ajax post


    }); // end of 'click', '.remove-canvas'

}); // end of dashbord.js file
