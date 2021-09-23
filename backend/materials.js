var matUploadForm = document.getElementById('Matupload');
matUploadForm.addEventListener('submit', function(e) {
  e.preventDefault();

  // Progress Bar variables
  var progressBarFill = document.querySelector("#progressBar > .progress-bar-fill");
  var progressBarText = progressBarFill.querySelector(".progress-bar-text");

  var url = "Matuploads.php"
  var year = document.getElementById('year_mat');
  var semester = document.getElementById('semester_mat');
  var section = document.getElementById('section_mat');

  var selectedYear = year.options[year.selectedIndex].value;
  var selectedSemester = semester.options[semester.selectedIndex].value;
  var selectedSection = section.options[section.selectedIndex].value;
  var fileinput = document.getElementById('myfile');
  var file = fileinput.files[0];



  var matFormData = new FormData(matUploadForm);
  matFormData.append('year',selectedYear);
  matFormData.append('semester',selectedSemester);
  matFormData.append('section',selectedSection);
  matFormData.append('myfile', file);

  console.log(matFormData);
  console.log("Selected year: "+ selectedYear);
  console.log("Selected Semester: "+ selectedSemester);
  console.log("Selected section: "+ selectedSection);


  var xhr = new XMLHttpRequest();
  xhr.upload.addEventListener("progress", function(e) {
    const percent = e.lengthComputable ? (e.loaded / e.total) * 100:0;
    console.log(percent)
    progressBarFill.style.width = percent.toFixed(2) + "%";
    progressBarText.innerHTML = percent.toFixed(2) + "%";
  });

  xhr.onload = function() {
    console.log(xhr.responseText);
  }

  xhr.onerror = function() {
        alert("Error! Upload failed. Can not connect to server.");
  };
  xhr.open('POST',url);
  xhr.send(matFormData);

});


var viewMaterials = document.getElementById('view-materials');
viewMaterials.addEventListener('click', (e) => {
  var yearmat = document.getElementById('year_mat');
  var semestermat = document.getElementById('semester_mat');
  var sectionmat = document.getElementById('section_mat');

  var selectedYear = yearmat.options[yearmat.selectedIndex].value;
  var selectedSemester = semestermat.options[semestermat.selectedIndex].value;
  var selectedSection = sectionmat.options[sectionmat.selectedIndex].value;

  console.log("Selected year: "+ selectedYear);
  console.log("Selected Semester: "+ selectedSemester);
  console.log("Selected section: "+ selectedSection);

  var urlString = "viewmaterials.php?year="+selectedYear+"&semester="+selectedSemester+"&section="+selectedSection;

  var xhr = new XMLHttpRequest();
  if(selectedYear == "" && selectedSemester == "" && selectedSection == "") {
    document.getElementById('results_materials').innerHTML = '';
    return;
  }

  else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        document.getElementById("results_materials").style.display = 'block';
        document.getElementById("results_materials").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET",urlString,true);
    xmlhttp.send();
  }
});


// TODO: AJAX Delete TimeTables

function deleteMaterials() {


    var year = document.getElementById('year_m').innerText;
    var semester = document.getElementById('semester_m').innerText;
    var section = document.getElementById('section_m').innerText;

    console.log(year);
    console.log(semester);
    console.log(section);

    var urlString = "deletematerials.php?year="+year+"&semester="+semester+"&section="+section;


    if(year == "" && semester == "" && section == "") {
      document.getElementById('delete_materials').innerHTML = '';
      return;
    }

    else {
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          document.getElementById('delete_materials').style.display = 'block';
          document.getElementById("delete_materials").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("DELETE",urlString,true);
      xmlhttp.send();
    }
}
