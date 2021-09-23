var notificationUploadForm = document.getElementById('Notification_upload');
notificationUploadForm.addEventListener('submit', function(e) {
  e.preventDefault();

  // Progress Bar variables
  var progressBarFillNT = document.querySelector("#progressBar_nt > .progress-bar-fill_nt");
  var progressBarTextNT = progressBarFillNT.querySelector(".progress-bar-text_nt");

  var url = "Notificationuploads.php"
  var year = document.getElementById('year_not');
  var semester = document.getElementById('semester_not');
  var section = document.getElementById('section_not');

  var selectedYear = year.options[year.selectedIndex].value;
  var selectedSemester = semester.options[semester.selectedIndex].value;
  var selectedSection = section.options[section.selectedIndex].value;
  var fileinput = document.getElementById('myfile');
  var file = fileinput.files[0];



  var notFormData = new FormData(notificationUploadForm);
  notFormData.append('year',selectedYear);
  notFormData.append('semester',selectedSemester);
  notFormData.append('section',selectedSection);
  notFormData.append('myfile', file);

  console.log(notFormData);
  console.log("Selected year: "+ selectedYear);
  console.log("Selected Semester: "+ selectedSemester);
  console.log("Selected section: "+ selectedSection);
  console.log("File is " + file);


  var xhr = new XMLHttpRequest();
  xhr.upload.addEventListener("progress", function(e) {
    const percent = e.lengthComputable ? (e.loaded / e.total) * 100:0;
    console.log(percent)
    progressBarFillNT.style.width = percent.toFixed(2) + "%";
    progressBarTextNT.innerHTML = percent.toFixed(2) + "%";
  });

  xhr.onload = function() {
    console.log(xhr.responseText);
  }

  xhr.onerror = function() {
        alert("Error! Upload failed. Can not connect to server.");
  };
  xhr.open('POST',url);
  xhr.send(notFormData);

});


var viewNotifications = document.getElementById('view-notifications');
viewNotifications.addEventListener('click', (e) => {
  var yearmat = document.getElementById('year_not');
  var semestermat = document.getElementById('semester_not');
  var sectionmat = document.getElementById('section_not');

  var selectedYear = yearmat.options[yearmat.selectedIndex].value;
  var selectedSemester = semestermat.options[semestermat.selectedIndex].value;
  var selectedSection = sectionmat.options[sectionmat.selectedIndex].value;

  console.log("Selected year: "+ selectedYear);
  console.log("Selected Semester: "+ selectedSemester);
  console.log("Selected section: "+ selectedSection);

  var urlString = "viewnotifications.php?year="+selectedYear+"&semester="+selectedSemester+"&section="+selectedSection;

  var xhr = new XMLHttpRequest();
  if(selectedYear == "" && selectedSemester == "" && selectedSection == "") {
    document.getElementById('results_notifications').innerHTML = '';
    return;
  }

  else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        document.getElementById("results_notifications").style.display = 'block';
        document.getElementById("results_notifications").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET",urlString,true);
    xmlhttp.send();
  }
});


// TODO: AJAX Delete TimeTables

function deleteNotifications() {


    var year = document.getElementById('year_n').innerText;
    var semester = document.getElementById('semester_n').innerText;
    var section = document.getElementById('section_n').innerText;

    console.log(year);
    console.log(semester);
    console.log(section);

    var urlString = "deletenotifications.php?year="+year+"&semester="+semester+"&section="+section;


    if(year == "" && semester == "" && section == "") {
      document.getElementById('delete_notifications').innerHTML = '';
      return;
    }

    else {
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          document.getElementById('delete_notifications').style.display = 'block';
          document.getElementById("delete_notifications").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("DELETE",urlString,true);
      xmlhttp.send();
    }
}
