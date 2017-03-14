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

      // var canvases = JSON.parse(returnedData);
      console.log("Canvases: " + canvases + "\n");

      $.each(returnedData, function(key, value) {
        console.log(key + " " + value + "\n");
      }) //end of $.each(returnedData)

    }); // end of $.getJSON
  }); // end of $('.search-box').on('submit' ...
});
