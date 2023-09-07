
const menuLinks = document.querySelectorAll('.menu-admin');
let index = localStorage.getItem('activeMenuIndex');

if (index !== null) {
    index = parseInt(index, 10);
    if (index >= menuLinks.length || index < 0) {
        index = null;
    }
}

if (index === null) {
    if (menuLinks[0]) {
        menuLinks[0].classList.add('is-active');
    }
} else {
    if (menuLinks[index]) {
        menuLinks[index].classList.add('is-active');
    }
}

menuLinks.forEach((link, index) => {
    link.addEventListener('click', e => {
        const activeButton = document.querySelector('.menu-admin.is-active');
        if (activeButton) {
            activeButton.classList.remove('is-active');
        }
        e.target.classList.add('is-active');
        localStorage.setItem('activeMenuIndex', index);
    });
});
