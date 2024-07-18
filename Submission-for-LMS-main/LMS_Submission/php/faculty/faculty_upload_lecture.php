<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Upload Lecture</title>
    <link rel="stylesheet" href="../../styles/faculty/faculty_upload_lecture.css">
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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="content-block">
                    <h1>Upload Lecture</h1>
                    <!-- For Lecture Name -->
                    <div class="form-group">
                        <div class="field-block">
                            <label for="lectureName"><strong>Lecture Name:</strong></label>
                            <input type="text" id="lectureName" name="lectureName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="field-block">
                            <label for="lecture_desc"><strong>Lecture Description:</strong></label>
                            <input type="text" id="lecture_desc" name="lecture_desc" required>
                        </div>
                    </div>
                    <!-- For the File Upload-->
                    <div class="form-group">
                        <div class="field-block">
                            <input type="file" class="file_path textbox" name="file_path" required>
                        </div>
                    </div>

                    <div class="one-button-group">
                        <div>
                            <button class="button-type-1" type="submit">Add Lecture</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../../js/faculty/faculty_upload_lectures.js"></script>
</body>
</html>

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

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve subject_ID for subject_Name = 'webdev' (napapalitan)
        $subject_Name = "Introduction to AI";
        $stmt = $conn->prepare("SELECT subject_ID FROM subject WHERE subject_Name = ?");
        $stmt->bind_param("s", $subject_Name);
        $stmt->execute();
        $stmt->bind_result($subject_ID);
        $stmt->fetch();
        $stmt->close();

        if (!$subject_ID) {
            die("Subject not found.");
        }

        // Validate and process file upload
        if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../../php/faculty/uploads/"; // Directory where files will be stored
            $target_file = $target_dir . basename($_FILES["file_path"]["name"]);
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file type and size (modify as needed)
            $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf", "pptx", "txt", "docx", "doc");
            $max_file_size = 50 * 1024 * 1024; // 50 MB (modify as needed)

            if (!in_array($file_type, $allowed_types)) {
                echo '<script>window.onload = function() { showErrorFileType(); }</script>';
            } elseif ($_FILES["file_path"]["size"] > $max_file_size) {
                echo '<script>window.onload = function() { showErrorFileSize(); }</script>';
            } else {
                // Move uploaded file to desired directory
                if (move_uploaded_file($_FILES["file_path"]["tmp_name"], $target_file)) {

                    // File upload success, now insert data into database
                    $name = $_POST['lectureName'];
                    $description = $_POST['lecture_desc'];
                    $file_path = $target_file; // Store the file path in database

                    $date = date('Y-m-d');
                    $time = date('H:i:s');

                    // Generate lecture_ID (adjust as per your requirement)
                    $month = date('m');
                    $day = date('d');
                    $name_initials = strtoupper(substr($name, 0, 2));
                    $lecture_ID = $month . $day . $name_initials;

                    // Insert data into database
                    $stmt = $conn->prepare("INSERT INTO upload_lecture (lecture_ID, subject_ID, name, description, date, time, file_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssss", $lecture_ID, $subject_ID, $name, $description, $date, $time, $file_path);

                    if ($stmt->execute()) {
                        echo '<script>window.onload = function() { showUploadSuccess(); }</script>';
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            echo "Error uploading file: " . $_FILES["file_path"]["error"];
        }
    }

    $conn->close();
    ?>

