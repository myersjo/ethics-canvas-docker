$(function() {

  /*======================
    Search box
  ======================*/
  $('.search-box').on('submit', function(event) {
    event.preventDefault();
    var url = "/php/search.php";
    var query = $('#search-box-input').val();
    $.getJSON(url, {query: query}, function(returnedData) {
      var canvases = [];
      var resultHTML = '';

      $.each(returnedData, function(index, value) {
        console.log(index + " " + value);
        // var canvas = {};
        // canvas.name; // from canvas table
        // canvas.username; // from canvas table
        // canvas.tags[]; // from tag_relation table
        // canvases.push(canvas);
      }) //end of $.each(returnedData)

    }); // end of $.getJSON
  }); // end of $('.search-box').on('submit' ...
});
