<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['adminId'])) {

    header('Location: admin_panel.php');
    exit();
}

if (!isset($_SESSION['userId'])) {

    header('Location: admin_panel.php');
    exit();
}

?>


<?php
include_once 'header.php';
?>

<?php
include_once 'templates/_user_profile.php';
?>

<?php
include_once 'footer.php';
?>

<script>
const buttons = document.querySelectorAll('.btn-profile-update');
const divs = document.querySelectorAll('.row-update-profile');
let activeProfileIndex = localStorage.getItem('activeProfileIndex');


if (activeProfileIndex !== null) {
    activeProfileIndex = parseInt(activeProfileIndex, 10);
    if (activeProfileIndex >= buttons.length || activeProfileIndex < 0) {
        activeProfileIndex = null;
    }
}

if (activeProfileIndex === null) {
    if (buttons[0]) {
        buttons[0].classList.add('is-active');
    }
    if (divs[0]) {
        divs[0].style.display = 'flex';
    }
} else {
    if (buttons[activeProfileIndex]) {
        buttons[activeProfileIndex].classList.add('is-active');
    }
    if (divs[activeProfileIndex]) {
        divs[activeProfileIndex].style.display = 'flex';
    }
}

buttons.forEach((button, index) => {
    button.addEventListener('click', e => {
        const activeButton = document.querySelector('.btn-profile-update.is-active');
        if (activeButton) {
            activeButton.classList.remove('is-active');
        }
        e.target.classList.add('is-active');
        divs.forEach((div, i) => {
            if (i === index) {
                div.style.display = 'flex';
            } else {
                div.style.display = 'none';
            }
        });
        localStorage.setItem('activeProfileIndex', index);
    });
});
</script>