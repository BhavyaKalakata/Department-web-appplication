function showTimetables(e) {
  // e.preventDefault();
  var year = document.querySelector('#year_ttable');
  var semester = document.querySelector('#semester_ttable');
  var section = document.querySelector('#section_ttable');

  var selectedYear = year.options[year.selectedIndex].value;
  var selectedSemester = semester.options[semester.selectedIndex].value;
  var selectedSection = section.options[section.selectedIndex].value;

  console.log("Selected year: "+ selectedYear);
  console.log("Selected Semester: "+ selectedSemester);
  console.log("Selected section: "+ selectedSection);

  var urlString = "Timetabledownload.php?year="+selectedYear+"&semester="+selectedSemester+"&section="+selectedSection;

  if(selectedYear == "" && selectedSemester == "" && selectedSection == "") {
    document.querySelector('#showTimetables').innerHTML = '';
    return;
  }

  else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        document.getElementById("showTimetables").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET",urlString,true);
    xmlhttp.send();
  }
}

function downloadTimetable() {
  var url = document.querySelector('#download');

  if(url == "") {
    return;
  }
  else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        alert('Download Success');
      }
    }
  }

  xmlhttp.open("GET",url, true);
  xmlhttp.send();
}




