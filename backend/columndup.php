<?php
  session_start();

  if($_SESSION['Username'] == "") {
    header('location:login.html');
  }

 ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: "Lato", sans-serif;
}

.sidenav {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 160px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}

.content_container {
  margin:auto 20px;
  width: 100%;
  height: 100%;
}

.form_content {
  width: 80%;
  height: 30%;
  margin:40px;
}

.result_container {
  width: 80%;
  height: 65%;
  margin: 40px;
}

.result_container {
  width: 80%;
  height: 5%;
  margin: 40px;
}

.progress-bar
{
  height:35px;
  width:250px;
  border:2px solid darkblue;
}
.progress-bar-fill
{
  height:100%;
  width:0%;
  background: lightblue;
  display:flex;
  align-items: center;

  transition: width 0.25s;
}
.progress-bar-text
{
  margin-left:10px;
    font-weight: bold;

}

.username {
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  position:fixed;
  bottom: 10px;
  left:10px;
}

</style>
</head>
<body>

<div class="sidenav">
  <a href="#" id="matlink">Materials</a>
  <a href="#" id="ttablelink">Time Tables</a>
  <a href="#" id="not_link">Notifications</a>
  <a href="#" id="syl_link">Syllabus</a>
  <a href="#" id="eventlink">Events</a>
  <div class="username">
    <a href="#">Hi <br /><?php echo $_SESSION['Username']; ?></a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<div class="main">
  <div class="content_container">
      <div class="form_content" id="material_window" style="display:none;">
        <h2>Materials window</h2>
        <form id="Matupload" method="post" enctype="multipart/form-data">
          <label for="year">Select year:</label>
          <select name="year[]" id="year_mat">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        <label for="semester">Select Semester:</label>
            <select name="semester[]" id="semester_mat">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
          <label for="section">Select Section: </label>
            <select name="section[]" id="section_mat">
              <option value="A">A</option>
              <option value="B">B</option>
            </select><br /><br />
            <label>Upload File</label>
            <input type="file" name="myfile"><br><br>
            <input type="submit" name="mat-file-upload" value="Click Here to Upload">
            <input type="submit" name="view-materials" id="view-materials" value="View Uploaded Materials">
        </form><br /><br />
        <div class="progress-bar" id="progressBar">
          <div class="progress-bar-fill">
            <span class="progress-bar-text">0%</span>
          </div>
        </div>
      </div>
      <div class="delete_container" id="delete_materials" style="display:block;"></div>

      <div class="result_container" id="results_materials" style="display:none;">
          <h2>Fetched Output Will be Shown Here</h2>
      </div>

    <!-- Timetables window -->
      <div class="form_content" id="timetables_window" style="display:none;">
        <h2>Timetables window</h2>
        <form id="ttableupload" method="post" enctype="multipart/form-data">
          <label for="year">Select year:</label>
          <select name="year[]" id="year_ttable">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        <label for="semester">Select Semester:</label>
            <select name="semester[]" id="semester_ttable">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
          <label for="section">Select Section: </label>
            <select name="section[]" id="section_ttable">
              <option value="A">A</option>
              <option value="B">B</option>
            </select><br /><br />
            <label>Upload File</label>
            <input type="file" name="myfile" id="myfile"><br><br>
            <input type="submit" name="file-upload" value="Click Here to Upload">
            <input type="submit" name="view-timetables" id="view-timetables" value="View Uploaded Time Tables">
        </form><br>
        <div class="progress-bar" id="progressBar_tm">
          <div class="progress-bar-fill_tm">
            <span class="progress-bar-text_tm">0%</span>
          </div>
        </div>
      </div>


      <div class="delete_container" id="delete_ttables" style="display:block;"></div>

      <div class="result_container" id="results_ttables" style="display:none;">
          <h2>Fetched Output Will be Shown Here</h2>
      </div>

      <!-- eventwindow -->
      <div class="form_content" id="events_window" style="display:none;">
        <h2>Events window</h2>
        <form id="eventsupload" method="post" enctype="multipart/form-data">
          <label for="events">Select Type Of Event:</label>
          <select name="events[]" id="events">
            <option value="Internal">Internal</option>
            <option value="External">External</option>
            <option value="Organizing">Organizing</option>
          </select>
            <label>Upload File</label>
            <input type="file" name="myfile" id="myfile"><br><br>
            <input type="submit" name="file-upload" value="Click Here to Upload">
            <input type="submit" name="view-events" id="view-events" value="View Events">
        </form><br>
        <div class="progress-bar" id="progressBar_ev">
          <div class="progress-bar-fill_ev">
            <span class="progress-bar-text_ev">0%</span>
          </div>
        </div>
      </div>


      <div class="delete_container" id="delete_events" style="display:block;"></div>

      <div class="result_container" id="results_events" style="display:none;">
          <h2>Fetched Output Will be Shown Here</h2>
      </div>

      <!-- syllabus div -->
      <div class="form_content" id="syllabus_window" style="display:none;">
        <h2>Syllabus window</h2>
        <form id="syl_upload" method="post" enctype="multipart/form-data">
          <label for="year">Select year:</label>
          <select name="year[]" id="year_syl">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        <label for="semester">Select Semester:</label>
            <select name="semester[]" id="semester_syl">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select><br /><br />
            <label>Upload File</label>
            <input type="file" name="myfile"><br><br>
            <input type="submit" name="syl-file-upload" value="Click Here to Upload">
            <input type="submit" name="view-syllabus" id="view-syllabus" value="View Uploaded Syllabus Files">
        </form><br /><br />
        <div class="progress-bar" id="progressBar_sl">
          <div class="progress-bar-fill_sl">
            <span class="progress-bar-text_sl">0%</span>
          </div>
        </div>
      </div>
      <div class="delete_container" id="delete_syllabus" style="display:block;"></div>

      <div class="result_container" id="results_syllabus" style="display:none;">
          <h2>Fetched Output Will be Shown Here</h2>
      </div>


    <!-- notifications window -->
      <div class="form_content" id="notification_window" style="display:none;">
        <h2>Nofifications window</h2>
        <form id="Notification_upload" method="post" enctype="multipart/form-data">
          <label for="year">Select year:</label>
          <select name="year[]" id="year_not">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        <label for="semester">Select Semester:</label>
            <select name="semester[]" id="semester_not">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
          <label for="section">Select Section: </label>
            <select name="section[]" id="section_not">
              <option value="A">A</option>
              <option value="B">B</option>
            </select><br /><br />
            <label>Upload File</label>
            <input type="file" name="myfile"><br><br>
            <input type="submit" name="not-file-upload" value="Click Here to Upload">
            <input type="submit" name="view-notifications" id="view-notifications" value="View Uploaded Notificationss">
        </form><br /><br />
        <div class="progress-bar" id="progressBar_nt">
          <div class="progress-bar-fill_nt">
            <span class="progress-bar-text_nt">0%</span>
          </div>
        </div>
      </div>
      <div class="delete_container" id="delete_notifications" style="display:block;"></div>

      <div class="result_container" id="results_notifications" style="display:none;">
          <h2>Fetched Output Will be Shown Here</h2>
      </div>

</div>



<script type="text/javascript">
  var matWindow = document.getElementById('material_window');
  var twindow = document.getElementById('timetables_window');
  var eventWindow = document.getElementById('events_window');
  var sylWindow = document.getElementById('syllabus_window');
  var notificationWindow = document.getElementById('notification_window')
  var matLink = document.getElementById('matlink');
  var tLink = document.getElementById('ttablelink');
  var eventLink = document.getElementById('eventlink');
  var sylLink = document.getElementById('syl_link');
  var notificationLink = document.getElementById('not_link');

  matLink.addEventListener('click', function(e) {
    if(matWindow.style.display == 'none') {
      matWindow.style.display = 'block';
      twindow.style.display = 'none';
      eventWindow.style.display = 'none';
      sylWindow.style.display = 'none';
      notificationWindow.style.display = 'none';
    }
    else {
      matWindow.style.display = 'none';
      twindow.style.display = 'none';
      eventWindow.style.display = 'none';
      sylWindow.style.display = 'none';
      notificationWindow.style.display = 'none';
    }
  })

  tLink.addEventListener('click', function(e) {
    if(twindow.style.display == 'none') {
      twindow.style.display = 'block';
      matWindow.style.display = 'none';
      eventWindow.style.display = 'none';
      sylWindow.style.display = 'none';
      notificationWindow.style.display = 'none';
    }
    else {
      twindow.style.display = 'none';
      matWindow.style.display = 'none';
      eventWindow.style.display = 'none';
      sylWindow.style.display = 'none';
      notificationWindow.style.display = 'none';
    }
  })

eventLink.addEventListener('click', function(e) {
    if(eventWindow.style.display == 'none') {
      eventWindow.style.display = 'block';
      matWindow.style.display = 'none';
      twindow.style.display = 'none';
      sylWindow.style.display = 'none';
      notificationWindow.style.display = 'none';
    }
    else {
      eventWindow.style.display = 'none';
      matWindow.style.display = 'none';
      twindow.style.display = 'none';
      sylWindow.style.display = 'none';
      notificationWindow.style.display = 'none';
    }
  })

  sylLink.addEventListener('click', function(e) {
    if(sylWindow.style.display == 'none') {
      sylWindow.style.display = 'block';
      twindow.style.display = 'none';
      eventWindow.style.display = 'none';
      matWindow.style.display = 'none';
      notificationWindow.style.display = 'none';
    }
    else {
      sylWindow.style.display = 'none';
      twindow.style.display = 'none';
      eventWindow.style.display = 'none';
      matWindow.style.display = 'none';
      notificationWindow.style.display = 'none';
    }
  })

notificationLink.addEventListener('click', function(e) {
    if(notificationWindow.style.display == 'none') {
      notificationWindow.style.display = 'block';
      twindow.style.display = 'none';
      eventWindow.style.display = 'none';
      matWindow.style.display = 'none';
      sylWindow.style.display = 'none';
    }
    else {
      notificationWindow.style.display = 'none';
      twindow.style.display = 'none';
      eventWindow.style.display = 'none';
      matWindow.style.display = 'none';
      sylWindow.style.display = 'none';
    }
  })

 
</script>
<script type="text/javascript" src="materials.js"></script>
<script type="text/javascript" src="timetables.js"></script>
<script type="text/javascript" src="events.js"></script>
<script type="text/javascript" src="syllabus.js"></script>
<script type="text/javascript" src="notifications.js"></script>



</body>
</html>
