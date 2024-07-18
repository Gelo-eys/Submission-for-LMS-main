// Function to show upload success message
function showUploadSuccess() {
    alert("Lecture uploaded successfully!");
    redirectToLecturesPage();
}

// Function to show error message for file type
function showErrorFileType() {
    alert("Sorry, only JPG, JPEG, PNG, GIF, PDF, PPTX, TXT, DOCX, and DOC files are allowed.");
    redirectToLecturesPage();
}

// Function to show error message for file size
function showErrorFileSize() {
    alert("Sorry, your file is too large. Maximum file size is 50 MB.");
    redirectToLecturesPage();
}

//navbar
document.getElementById("more-white").addEventListener("click", function(){
    document.getElementsByClassName("dropdown-menu-white")[0].classList.toggle("toggle-in");
    })

    //navbar
    document.getElementById("more-red").addEventListener("click", function(){
    document.getElementsByClassName("dropdown-menu-red")[0].classList.toggle("toggle-in");
    })

    //profile
    document.getElementById("profile").addEventListener("click", function(){
    document.getElementsByClassName("dropdown-menu-profile")[0].classList.toggle("toggle-in");
    })

    //drawer
    document.getElementsByClassName("toggle-hamburger")[0].addEventListener("click", function(){
    document.getElementById("drawer").classList.toggle("enter-from-left");
    })

    document.getElementsByClassName("close-button")[0].addEventListener("click", function(){
    document.getElementById("drawer").classList.toggle("enter-from-left");
    })