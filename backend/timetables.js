
var tTableUploadForm = document.getElementById('ttableupload');
tTableUploadForm.addEventListener('submit', function(e) {
  e.preventDefault();

    // Progress Bar variables
    var progressBarFillTM = document.querySelector("#progressBar_tm > .progress-bar-fill_tm");
    var progressBarTextTM = progressBarFillTM.querySelector(".progress-bar-text_tm");

  var url = "Timetableupload.php";
  var year = document.getElementById('year_ttable');
  var semester = document.getElementById('semester_ttable');
  var section = document.getElementById('section_ttable');

  var selectedYear = year.options[year.selectedIndex].value;
  var selectedSemester = semester.options[semester.selectedIndex].value;
  var selectedSection = section.options[section.selectedIndex].value;
  var fileinput = document.getElementById('myfile');
  var file = fileinput.files[0];

  var progressBar = document.getElementById("progressBar");

  var formData = new FormData(tTableUploadForm);
  formData.append('year',selectedYear);
  formData.append('semester',selectedSemester);
  formData.append('section',selectedSection);
  formData.append('myfile', file);

  console.log(formData);
  console.log("Selected year: "+ selectedYear);
  console.log("Selected Semester: "+ selectedSemester);
  console.log("Selected section: "+ selectedSection);


  var xhr = new XMLHttpRequest();
  xhr.upload.addEventListener("progress", function(e) {
    const percent = e.lengthComputable ? (e.loaded / e.total) * 100:0;
    console.log(percent)
    progressBarFillTM.style.width = percent.toFixed(2) + "%";
    progressBarTextTM.innerHTML = percent.toFixed(2) + "%";
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


var viewTimetables = document.getElementById('view-timetables');
viewTimetables.addEventListener('click', (e) => {
  var year = document.getElementById('year_ttable');
  var semester = document.getElementById('semester_ttable');
  var section = document.getElementById('section_ttable');

  var selectedYear = year.options[year.selectedIndex].value;
  var selectedSemester = semester.options[semester.selectedIndex].value;
  var selectedSection = section.options[section.selectedIndex].value;

  console.log("Selected year: "+ selectedYear);
  console.log("Selected Semester: "+ selectedSemester);
  console.log("Selected section: "+ selectedSection);

  var urlString = "viewtimetables.php?year="+selectedYear+"&semester="+selectedSemester+"&section="+selectedSection;

  var xhr = new XMLHttpRequest();
  if(selectedYear == "" && selectedSemester == "" && selectedSection == "") {
    document.getElementById('results_ttables').innerHTML = '';
    return;
  }

  else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        document.getElementById('results_ttables').style.display = 'block';
        document.getElementById("results_ttables").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET",urlString,true);
    xmlhttp.send();
  }
});


// TODO: AJAX Delete TimeTables

function deletetimetables() {


    var year = document.getElementById('year_t').innerText;
    var semester = document.getElementById('semester_t').innerText;
    var section = document.getElementById('section_t').innerText;

    console.log(year);
    console.log(semester);
    console.log(section);

    var urlString = "deletetimetables.php?year="+year+"&semester="+semester+"&section="+section;


    if(year == "" && semester == "" && section == "") {
      document.getElementById('delete_ttables').innerHTML = '';
      return;
    }

    else {
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          document.getElementById('delete_ttables').style.display = 'block';
          document.getElementById("delete_ttables").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("DELETE",urlString,true);
      xmlhttp.send();
    }
}
