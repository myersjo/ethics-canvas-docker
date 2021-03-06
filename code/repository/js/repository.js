$(function() {

  /*======================
    Search box submit
  ======================*/
  $('.search-box').on('submit', function(event) {
    event.preventDefault();
    var url = "php/search.php";
    var query = $('#search-box-input').val();
    $.getJSON(url, {query: query}, function(returnedData) {
      var resultHTML = '';

      var canvases = returnedData[0];

      $('#content-heading').text("Search Results");

      $.each(canvases, function(key, value) {
        resultHTML += '<div class="col-md-4 col-sm-6"><div class="canvas-gallery-item panel panel-default" id="'+ key +'"><div class="panel-heading"><h4><i class="fa fa-fw fa-th"></i>' + value["canvas_name"] + '</h4></div><div class="panel-body"><h5>Tags:</h5><p">';
        $.each(value["tags"], function(i, tag) {
          resultHTML += ' ' + tag + ' ';
        });
        resultHTML += '</p><a href="#" class="btn btn-default">View</a></div></div></div>';
      }) //end of $.each(returnedData)
      if (resultHTML.length <= 1) { // No Results
        resultHTML += '<div class="col-md-12"><h4>No results found!</h4><p>Try a different keyword or leave the search field blank to show all canvases. </p></div>';
        $('body').find('#canvases-row').empty().prepend(resultHTML);
      } else { // Display results
        $('#content-heading').val("Search Results");
        $('body').find('#canvases-row').empty().append(resultHTML);
        colors();
      }
    }); // end of $.getJSON
  }); // end of $('.search-box').on('submit' ...

  /*========================
    Search box autocomplete
  ==========================*/
//   $('#search-box-input').autocomplete({
//     source: "php/auto-complete.php",
//     delay: 300,
//     minLength: 2
//   });
  /*========================================
        USER LOGS OUT (dropdown menu)
    ==========================================*/
    $('#logout').on('click', function() {
        var url = '../canvas/php/logout.php';
        $.post(url, function(data, status) {
            if (data == 200) {
                $('#logged-in-dropdown').hide();
                window.location.href="../index.html";
            }
        });
    });

    /*=============================================
     Handling click on a canvas 
    ===============================================*/
    $('#canvases-row').on('click', '.panel', function(event) {
        event.stopPropagation();
        //The id of the canvas that the user clicked on to load
        var canvas_ID = $(this).attr('id');
        var url = '../canvas/php/utils.php';
        $.post(url, {
            canvas_ID: canvas_ID
        }, function(data, status) {
            if (data == 200) {
                window.location.href = "../canvas/index.php?id=" + canvas_ID;

            }
        });
    });

});



function choose(arg){
    document.getElementById("search-box-input").value=arg;
}
    
function colors(){
var colors = ['#A281D0','#84ADE5','#28BCA4','#ACD682','#899AE0'];
var searchCanvas = document.getElementById("canvases-row").getElementsByClassName('panel panel-default');
var searchHeader = document.getElementById("canvases-row").getElementsByClassName('panel-heading');
var j=0;
for(var i =0; i < searchCanvas.length; i++) {
    if(j==colors.length)
        j=0;
    searchCanvas[i].style.backgroundColor = colors[j];
    searchHeader[i].style.backgroundColor = colors[j];
    j++;
    }
}
colors();