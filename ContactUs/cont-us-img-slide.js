let items = document.querySelectorAll('.slider-container .image-slider .item');
let next = document.getElementById('next');
let prev = document.getElementById('prev');
let thumbnails = document.querySelectorAll('.thumbnail .item');

// Config parameters
let itemActive = 0;

// Click event for 'Next'
next.onclick = function() {
    itemActive = (itemActive + 1) % items.length;
    updateSlider();
}

// Click event for 'Previous'
prev.onclick = function() {
    itemActive = (itemActive - 1 + items.length) % items.length;
    updateSlider();
}

// Auto-run slider
let refreshInterval = setInterval(() => {
    next.click();
}, 5000);

function updateSlider() {
    // Move the slider by changing transform property
    document.querySelector('.slider-container .image-slider').style.transform = `translateX(-${itemActive * 100}%)`;

    // Remove active class from old thumbnail
    const oldActiveThumbnail = document.querySelector('.thumbnail .item.active');
    if (oldActiveThumbnail) {
        oldActiveThumbnail.classList.remove('active');
    }

    // Add active class to new thumbnail
    thumbnails[itemActive].classList.add('active');

    // Clear the auto run timer and restart it
    clearInterval(refreshInterval);
    refreshInterval = setInterval(() => {
        next.click();
    }, 5000);
}

// Thumbnail click event
thumbnails.forEach((thumbnail, index) => {
    thumbnail.addEventListener('click', () => {
        itemActive = index;
        updateSlider();
    });
});