
var syllabusUploadForm = document.getElementById('syl_upload');
syllabusUploadForm.addEventListener('submit', function(e) {
  e.preventDefault();

  // Progress Bar variables
  var progressBarFillSL = document.querySelector("#progressBar_sl > .progress-bar-fill_sl");
  var progressBarTextSL = progressBarFillSL.querySelector(".progress-bar-text_sl");

  var url = "Syllabusupload.php"
  var year = document.getElementById('year_syl');
  var semester = document.getElementById('semester_syl');

  var selectedYear = year.options[year.selectedIndex].value;
  var selectedSemester = semester.options[semester.selectedIndex].value;
  var fileinput = document.getElementById('myfile');
  var file = fileinput.files[0];

  var progressBar = document.getElementById("progressBar");

  var formData = new FormData(syllabusUploadForm);
  formData.append('year',selectedYear);
  formData.append('semester',selectedSemester);
  formData.append('myfile', file);

  console.log(formData);
  console.log("Selected year: "+ selectedYear);
  console.log("Selected Semester: "+ selectedSemester);


  var xhr = new XMLHttpRequest();
  xhr.upload.addEventListener("progress", function(e) {
    const percent = e.lengthComputable ? (e.loaded / e.total) * 100:0;
    console.log(percent)
    progressBarFillSL.style.width = percent.toFixed(2) + "%";
    progressBarTextSL.innerHTML = percent.toFixed(2) + "%";
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


var viewSyllabus = document.getElementById('view-syllabus');
viewSyllabus.addEventListener('click', (e) => {
  var year = document.getElementById('year_syl');
  var semester = document.getElementById('semester_syl');
  

  var selectedYear = year.options[year.selectedIndex].value;
  var selectedSemester = semester.options[semester.selectedIndex].value;
 

  console.log("Selected year: "+ selectedYear);
  console.log("Selected Semester: "+ selectedSemester);
  

  var urlString = "viewsyllabus.php?year="+selectedYear+"&semester="+selectedSemester;
  var xhr = new XMLHttpRequest();
  if(selectedYear == "" && selectedSemester == "") {
    document.getElementById('results_syllabus').innerHTML = '';
    return;
  }

  else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        document.getElementById('results_syllabus').style.display = 'block';
        document.getElementById("results_syllabus").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET",urlString,true);
    xmlhttp.send();
  }
});


// TODO: AJAX Delete TimeTables

function deleteSyllabus() {

    var year = document.getElementById('year_s').innerText;
    var semester = document.getElementById('semester_s').innerText;


    console.log(year);
    console.log(semester);

    var urlString = "deletesyllabus.php?year="+year+"&semester="+semester;


    if(year == "" && semester == "") {
      document.getElementById('delete_syllabus').innerHTML = '';
      return;
    }

    else {
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          document.getElementById('delete_syllabus').style.display = 'block';
          document.getElementById("delete_syllabus").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("DELETE",urlString,true);
      xmlhttp.send();
    }
}
