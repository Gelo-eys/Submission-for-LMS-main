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

// Initialize variables
$name = "";
$description = "";
$file_path = "";
$lecture_ID = "";

// Process if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        // Delete the lecture from database
        $lecture_ID = $_POST['lecture_ID']; // Assuming lecture_ID is passed via POST

        $stmt = $conn->prepare("DELETE FROM UPLOAD_LECTURE WHERE lecture_ID = ?");
        $stmt->bind_param("s", $lecture_ID);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=true");
            exit();
        } else {
            echo "Error deleting lecture: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Update lecture details in database
        $name = $_POST['name'];
        $description = $_POST['description'];
        $lecture_ID = $_POST['lecture_ID']; // Assuming lecture_ID is passed via POST

        // Validate lecture_ID (you might want to validate against database here)

        $stmt = $conn->prepare("UPDATE upload_lecture SET name = ?, description = ? WHERE lecture_ID = ?");
        $stmt->bind_param("sss", $name, $description, $lecture_ID);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: " . $_SERVER['PHP_SELF'] . "?updated=true");
            exit();
        } else {
            echo "Error updating lecture: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Fetch lecture details based on lecture_ID
if (isset($_GET['lecture_ID'])) {
    $lecture_ID = $_GET['lecture_ID'];

    $stmt = $conn->prepare("SELECT name, description FROM upload_lecture WHERE lecture_ID = ?");
    $stmt->bind_param("s", $lecture_ID);
    $stmt->execute();
    $stmt->bind_result($name, $description);
    $stmt->fetch();

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Edit Lecture</title>
    <link rel="stylesheet" href="../../styles/faculty/faculty_edit_lectures.css">
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="lecture_ID" value="<?php echo htmlspecialchars($lecture_ID); ?>">
                <div class="content-block">
                    <h1>Edit Lecture</h1>
                    <div class="underline"></div>
                    <div class="form-group">
                        <div class="field-block">
                            <label for="lectureName"><strong>Lecture Name:</strong></label>
                            <input type="text" id="lectureName" name="lectureName" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field-block">
                            <label for="lecture_desc"><strong>Lecture Description:</strong></label>
                            <textarea id="lecture_desc" name="lecture_desc" required><?php echo htmlspecialchars($description); ?></textarea>
                        </div>
                    </div>
                    <div class="one-button-group">
                        <div>
                            <button class="button-type-1 update-button" type="submit" name="update">Update Activity</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
<script src="../../js/faculty/faculty_edit_lecture.js"></script>
</html>
