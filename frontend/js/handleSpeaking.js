
$(document).ready(function() {


  var recognition = new webkitSpeechRecognition();
  var recognizing=false; 
  recognition.continuous = true;
  recognition.lang = "en";
  var url="url('../../files/icons/";
  //recognition.interimResults=true;
 $("#textarea").attr("disabled",true);
 // reset();
  $("#toggleMic").click(function() {
    if (recognizing) {
      recognition.stop();
      recognizing = false;  
      $("#textarea").attr("disabled",true);
      $("#toggleMic").text("Start speaking");
      $('#toggleMic').css("background-image", url+"mikro.png')");
    
    } 
    else {
        recognition.start();
        recognizing = true;
        $("#textarea").attr("disabled",false);
        $("#toggleMic").text("Stop speaking");
        $('#toggleMic').css("background-image", url+"mikroDis.png')");
        
  }});

  recognition.onresult=function (event) {
    
    for (var i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
        $("#textarea").text($("#textarea").val()+event.results[i][0].transcript);
       
      }
    }
  };
});
