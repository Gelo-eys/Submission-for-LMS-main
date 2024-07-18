function showCreationSuccess() {
    alert("Activity created successfully!");
    window.location.href = 'faculty_page_activity.php';
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