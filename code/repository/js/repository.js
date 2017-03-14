$(function() {

  /*======================
    Search box
  ======================*/
  $('.search-box').on('submit', function(event) {
    event.preventDefault();
    var url = "php/search.php";
    var query = $('#search-box-input').val();
    $.getJSON(url, {query: query}, function(returnedData) {
      var resultHTML = '';

      var canvases = returnedData[0];
      console.log("Canvases: " + JSON.stringify(returnedData) + "\n");

      $.each(canvases, function(key, value) {
        if(key == 'TAlszs4xcc') {
          console.log(key + " " + value + "; TAlszs4xcc " + "\n");
        } else if (key == 'zBwOdAamnN') {
          console.log(key + " " + value + "; zBwOdAamnN " + "\n");
        }
      }) //end of $.each(returnedData)

    }); // end of $.getJSON
  }); // end of $('.search-box').on('submit' ...
});
