<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pup_lms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch lectures with subject_ID 'kung ano subject id'
$subject_ID = 'CS101'; // mapapalitan to
$stmt = $conn->prepare("SELECT lecture_ID, name, date FROM upload_lecture WHERE subject_ID = ?");
$stmt->bind_param("s", $subject_ID);
$stmt->execute();
$result = $stmt->get_result();

$lectures = [];
while ($row = $result->fetch_assoc()) {
    $lectures[] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Lectures Page</title>
    <link rel="stylesheet" href="../../styles/faculty/faculty_page_lectures.css">
</head>
<body>
    <!-- Header section containing the navigation bars -->
    <div id="drawer">
        <div class="close-button">
            <img src="../../assets/close.png"/>
            <div>
                <span>PUP eMabini</span>
            </div>
        </div>
        <div>
            <a>Home</a>
        </div>
        <div>
            <a>Dashboard</a>
        </div>
        <div>
            <a>My Courses</a>
        </div>
        <div>
            <a style="text-decoration: none; color: black;" href="../index.php">Assessment</a>
        </div>
    </div>

    <header>
        <div class="top-bar">
            <div class="toggle-hamburger">
                <img src="../../assets/hamburger.png" alt="PUP">
            </div>
            <div class="logo">
                <img src="../../assets/logo.png" alt="PUP">
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li class="toggle-nav"><a href="#">My courses</a></li>
                    <li class="toggle-nav"><a href="../index.php">Assessment</a></li>
                    <li class="more-nav-white">
                        <a id="more-white" class="more">More</a>
                        <ul class="dropdown-menu-white">
                            <li><a href="#">My Courses</a></li>
                            <li><a href="../index.php">Assessment</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <nav class="profile-nav">
                <ul>
                    <li><a href="#"><img src="../../assets/bell.png"/></a></li>
                    <li><a href="#"><img src="../../assets/chat.png"/></a></li>
                    <li>
                        <a id="profile" href="#"><img src="../../assets/profile-picture.png"/></a>
                        <ul class="dropdown-menu-profile">
                            <li><a href="#">Accessibility</a></li>
                            <div class="underline"></div>
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Grades</a></li>
                            <li><a href="#">Calendar</a></li>
                            <li><a href="#">Messages</a></li>
                            <li><a href="#">Private files</a></li>
                            <li><a href="#">Reports</a></li>
                            <div class="underline"></div>
                            <li><a href="#">Preferences</a></li>
                            <div class="underline"></div>
                            <li><a href="#">Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="bottom-bar">
            <ul>
            <li><a href="#">Course</a></li>
                <li class="toggle-nav-red"><a href="faculty_page_lectures.php">Lectures</a></li>
                <li class="toggle-nav-red"><a href="faculty_page_activity.php">Activities</a></li>
                <li class="toggle-nav-red"><a href="#">Interactive Videos</a></li>
                <li class="toggle-nav-red"><a href="#">Participants</a></li>
                <li class="toggle-nav-red"><a href="#">Grades</a></li>
                <li class="toggle-nav-red"><a href="#">Competencies</a></li>
                <li class="more-nav-red">
                    <a id="more-red" class="more_red">More</a>
                    <ul class="dropdown-menu-red">
                        <li><a href="#">Lectures</a></li>
                        <li><a href="#">Activities</a></li>
                        <li><a href="#">Interactive Videos</a></li>
                        <li><a href="#">Participants</a></li>
                        <li><a href="#">Grades</a></li>
                        <li><a href="#">Competencies</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>

    <div class="content-body">
        <div class="body-container">
        <div class="content-block">
                <div class="two-button-group">
                    <div>
                        <label for="lectures"><strong><h2>Lectures</h2></strong></label>
                    </div>
                    <div>
                        <button class="button-type-1 add-button" id="addLectureBtn" type="add" name="add">Add Lecture</button>
                    </div>
                </div>
                <div class="underline"></div>
            </form>

            <?php foreach ($lectures as $lecture): ?>
                <div class="two-button-group">
                    <h2>> <?php echo htmlspecialchars($lecture['name']); ?></h2>
                    <p>Date: <?php echo htmlspecialchars($lecture['date']); ?></p>
                    <button class="button-type-1 edit-button" id="editLectureBtn" type="edit" a href="faculty_edit_lectures.php?lecture_ID=<?php echo urlencode($lecture['lecture_ID']); ?>" class="button">Edit Lecture</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

        <script>
            document.getElementById('addLectureBtn').addEventListener('click', function() {
            window.location.href = 'faculty_upload_lecture.php';
        });

        document.getElementById('editLectureBtn').addEventListener('click', function() {
            window.location.href = 'faculty_edit_lectures.php';
        });
        </script>
</body>
</html>
