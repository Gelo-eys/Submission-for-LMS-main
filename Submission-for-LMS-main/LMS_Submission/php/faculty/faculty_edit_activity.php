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

// Initialize variables
$name = "";
$description = "";
$date_end = "";
$time_end = "";
$requirement_code = "";

// Fetch activity details based on requirement_Code
if (isset($_GET['requirement_Code'])) {
    $requirement_code = $_GET['requirement_Code'];

    $stmt = $conn->prepare("SELECT name, description, date_End, time_End FROM submission_requirement WHERE requirement_Code = ?");
    $stmt->bind_param("s", $requirement_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $date_end = $row['date_End'];
        $time_end = $row['time_End'];
    } else {
        die("Error: Activity not found.");
    }

    $stmt->close();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        // Delete the activity from the database
        $requirement_code = $_POST['requirement_Code'];

        $stmt = $conn->prepare("DELETE FROM submission_requirement WHERE requirement_Code = ?");
        $stmt->bind_param("s", $requirement_code);

        if ($stmt->execute()) {
            // Redirect back to the form with a success message
            header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=true");
            exit(); // Ensure that no further code is executed after redirection
        } else {
            echo "Error deleting activity: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Update activity in the database
        $name = $_POST['activityName'];
        $description = $_POST['activity_desc'];
        $date_end = $_POST['due_Date'];
        $time_end = $_POST['due_Time'];
        $requirement_code = $_POST['requirement_Code'];

        $stmt = $conn->prepare("UPDATE submission_requirement SET name = ?, description = ?, date_End = ?, time_End = ? WHERE requirement_Code = ?");
        $stmt->bind_param("sssss", $name, $description, $date_end, $time_end, $requirement_code);

        if ($stmt->execute()) {
            // Redirect back to the form with a success message
            header("Location: " . $_SERVER['PHP_SELF'] . "?requirement_Code=" . urlencode($requirement_code) . "&updated=true");
            exit(); // Ensure that no further code is executed after redirection
        } else {
            echo "Error updating activity: " . $stmt->error;
        }

        $stmt->close();
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Activity</title>
    <link rel="stylesheet" href="../../styles/faculty/faculty_edit_activity.css">
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
            <form id="edit-activity-form" action="faculty_edit_activity.php?requirement_Code=<?php echo urlencode($requirement_code); ?>" method="POST">
                <input type="hidden" name="requirement_Code" value="<?php echo htmlspecialchars($requirement_code); ?>">
                <div class="content-block">
                    <h1>Edit Activity</h1>
                    <div class="underline"></div>
                    <div class="form-group">
                        <div class="field-block">
                            <label for="activityName"><strong>Activity Name:</strong></label>
                            <input type="text" id="activityName" name="activityName" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field-block">
                            <label for="activity_desc"><strong>Activity Description:</strong></label>
                            <textarea id="activity_desc" name="activity_desc" required><?php echo htmlspecialchars($description); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field-block half-block">
                            <label for="due_Date"><strong>Due Date:</strong></label>
                            <input type="date" id="due_Date" name="due_Date" value="<?php echo htmlspecialchars($date_end); ?>" required>
                        </div>
                        <div class="field-block half-block">
                            <label for="due_Time"><strong>Due Time:</strong></label>
                            <input type="time" id="due_Time" name="due_Time" value="<?php echo htmlspecialchars($time_end); ?>" required>
                        </div>
                    </div>
                    <div class="two-button-group">
                        <div>
                            <button class="button-type-1 delete-button" type="submit" name="delete">Delete Activity</button>
                        </div>
                        <div>
                            <button class="button-type-1 update-button" type="submit" name="update">Update Activity</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
<script src="../../js/faculty/faculty_edit_activity.js"></script>
</html>
