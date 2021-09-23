
var eventsUploadForm = document.getElementById('eventsupload');
eventsUploadForm.addEventListener('submit', function(e) {
  e.preventDefault();

  // Progress Bar variables
  var progressBarFillEV = document.querySelector("#progressBar_ev > .progress-bar-fill_ev");
  var progressBarTextEV = progressBarFillEV.querySelector(".progress-bar-text_ev");

  var url = "eventupload.php"
  var event = document.getElementById('events');

  var selectedEvent = event.options[event.selectedIndex].value;
  var fileinput = document.getElementById('myfile');
  var file = fileinput.files[0];

  var progressBar = document.getElementById("progressBar");

  var formData = new FormData(eventsUploadForm);
  formData.append('event',selectedEvent);
  formData.append('myfile', file);

  console.log(formData);
  console.log("Selected year: "+ selectedEvent);


  var xhr = new XMLHttpRequest();
  xhr.upload.addEventListener("progress", function(e) {
    const percent = e.lengthComputable ? (e.loaded / e.total) * 100:0;
    console.log(percent)
    progressBarFillEV.style.width = percent.toFixed(2) + "%";
    progressBarTextEV.innerHTML = percent.toFixed(2) + "%";
  });

  xhr.onload = function() {
    console.log(xhr.responseText);
  }

  xhr.onerror = function() {
        alert("Error! Upload failed. Can not connect to server.");
  };
  progressBar.value = 0;
  xhr.open('POST',url);
  xhr.send(formData);

})



























var viewEvents = document.getElementById('view-events');
viewEvents.addEventListener('click', (e) => {
  var event = document.getElementById('events');
  
  var selectedEvent = event.options[event.selectedIndex].value;
 

  console.log("Selected year: "+ selectedEvent);


  var urlString = "viewevents.php?events="+selectedEvent;

  var xhr = new XMLHttpRequest();
  if(selectedEvent == "") {
    document.getElementById('results_events').innerHTML = '';
    return;
  }

  else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        document.getElementById("results_events").style.display = 'block';
        document.getElementById("results_events").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET",urlString,true);
    xmlhttp.send();
  }
});


// TODO: AJAX Delete TimeTables

function deleteEvents() {


    var eventType = document.getElementById('typeof_t').innerText;
   

    console.log(eventType);
   

    var urlString = "deleteevents.php?event_type="+eventType;

    if(eventType == "") {
      document.getElementById('delete_events').innerHTML = '';
      return;
    }

    else {
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          document.getElementById('delete_events').style.display = 'block';
          document.getElementById("delete_events").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("DELETE",urlString,true);
      xmlhttp.send();
    }
}
