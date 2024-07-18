<?php
date_default_timezone_set('Asia/Manila');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pup_lms";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function generateRequirementCode($name) {
    $monthDay = date('md');
    $nameInitials = strtoupper(substr($name, 0, 2));
    return $monthDay . $nameInitials;
}

// Initialize variables
$name = "";
$description = "";
$date_end = "";
$time_end = "";

// Fetch subject_Id for "webdev"
$subject_name = "Introduction to AI";
$sql_subject = "SELECT subject_Id FROM subject WHERE subject_Name = ?";
$stmt_subject = $conn->prepare($sql_subject);
$stmt_subject->bind_param("s", $subject_name);
$stmt_subject->execute();
$result_subject = $stmt_subject->get_result();

if ($result_subject->num_rows > 0) {
    $row_subject = $result_subject->fetch_assoc();
    $subject_id = $row_subject['subject_Id'];
} else {
    die("Error: Subject not found.");
}

$stmt_subject->close();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['activityName'];
    $description = $_POST['activity_desc'];
    $date_end = $_POST['due_Date'];
    $time_end = $_POST['due_Time'];

    $requirementCode = generateRequirementCode($name);
    $date_start = date('Y-m-d');
    $time_start = date('H:i');

    // Insert into submission_requirement with subject_Id
    $sql = "INSERT INTO submission_requirement (requirement_Code, subject_Id, name, description, date_Start, time_Start, date_End, time_End)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $requirementCode, $subject_id, $name, $description, $date_start, $time_start, $date_end, $time_end);

    if ($stmt->execute()) {
        echo '<script>window.onload = function() { alert("Submission created successfully!"); }</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Assessment</title>
    <link rel="stylesheet" href="../../styles/faculty/faculty_creating_submission.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
            <form id="submission-form" action="faculty_creating_submission.php" method="POST">
                <div class="content-block">
                    <h1>Create Submission</h1>
                    <div class="underline"></div>
                    <div class="form-group">
                        <div class="field-block">
                            <label for="activityName"><strong>Activity Name:</strong></label>
                            <input type="text" id="activityName" name="activityName" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field-block">
                            <label for="activity_desc"><strong>Activity Description:</strong></label>
                            <textarea id="activity_desc" name="activity_desc" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field-block half-block">
                            <label for="due_Date"><strong>Due Date:</strong></label>
                            <input type="date" id="due_Date" name="due_Date" required>
                        </div>
                    <div class="form-group">
                        <div class="field-block half-block">
                            <label for="due_Time"><strong>Due Time:</strong></label>
                            <input type="time" id="due_Time" name="due_Time" required>
                        </div>
                    </div>
                </div>
                <div class="one-button-group">
                    <div>
                        <button class="button-type-1 submit" type="submit">Create Submission</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="../../js/faculty/faculty_creating_submission.js"></script>
</html>
