// ==================== SLIDER FUNCTIONALITY ====================
let slideIndex = 1;

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function changeSlide(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    if (n > slides.length) slideIndex = 1;
    if (n < 1) slideIndex = slides.length;

    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));

    if (slides[slideIndex - 1]) {
        slides[slideIndex - 1].classList.add('active');
        slides[slideIndex - 1].classList.add('fade');
    }
    if (dots[slideIndex - 1]) {
        dots[slideIndex - 1].classList.add('active');
    }
}

// Auto slide
let slideTimer = setInterval(() => {
    changeSlide(1);
}, 5000);

// ==================== TAB NAVIGATION ====================
function showEvents(type) {
    const upcomingSection = document.getElementById('upcoming');
    const pastSection = document.getElementById('past');
    const tabButtons = document.querySelectorAll('.tab-btn');

    if (type === 'upcoming') {
        upcomingSection.style.display = 'grid';
        pastSection.style.display = 'none';
        tabButtons[0].classList.add('active');
        tabButtons[1].classList.remove('active');
    } else {
        upcomingSection.style.display = 'none';
        pastSection.style.display = 'grid';
        tabButtons[0].classList.remove('active');
        tabButtons[1].classList.add('active');
    }
}

function showGallery(type) {
    const imagesSection = document.getElementById('images');
    const videosSection = document.getElementById('videos');
    const tabButtons = document.querySelectorAll('.tab-btn');

    if (type === 'images') {
        imagesSection.style.display = 'grid';
        videosSection.style.display = 'none';
        tabButtons[0].classList.add('active');
        tabButtons[1].classList.remove('active');
    } else {
        imagesSection.style.display = 'none';
        videosSection.style.display = 'grid';
        tabButtons[0].classList.remove('active');
        tabButtons[1].classList.add('active');
    }
}

// ==================== GALLERY LIGHTBOX ====================
function openLightbox(event) {
    event.preventDefault();
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    lightboxImage.src = event.target.href;
    lightbox.classList.add('active');
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.remove('active');
}

// Close lightbox when clicking outside the image
document.addEventListener('click', function(event) {
    const lightbox = document.getElementById('lightbox');
    if (event.target === lightbox) {
        closeLightbox();
    }
});

// ==================== PLAYER PROFILE MODAL ====================
const modal = document.getElementById('playerProfileModal');
const closeBtn = document.querySelector('.close');

function openPlayerProfile(playerName) {
    // This would typically fetch data from the server
    modal.classList.add('active');
    document.getElementById('profileName').textContent = playerName;
}

if (closeBtn) {
    closeBtn.onclick = function() {
        modal.classList.remove('active');
    };
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target === modal) {
        modal.classList.remove('active');
    }
};

// ==================== FILTER FUNCTIONALITY ====================
document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('searchPlayer');
    const filterCategory = document.getElementById('filterCategory');
    const filterAgeGroup = document.getElementById('filterAgeGroup');
    const playersContainer = document.getElementById('playersContainer');

    if (searchBox) {
        searchBox.addEventListener('input', filterPlayers);
    }
    if (filterCategory) {
        filterCategory.addEventListener('change', filterPlayers);
    }
    if (filterAgeGroup) {
        filterAgeGroup.addEventListener('change', filterPlayers);
    }

    function filterPlayers() {
        const searchTerm = searchBox ? searchBox.value.toLowerCase() : '';
        const category = filterCategory ? filterCategory.value : '';
        const ageGroup = filterAgeGroup ? filterAgeGroup.value : '';

        const playerCards = document.querySelectorAll('.player-card');

        playerCards.forEach(card => {
            const playerName = card.querySelector('h4').textContent.toLowerCase();
            const playerCategory = card.querySelector('.category')?.textContent || '';
            const playerAgeGroup = card.querySelector('.age-group')?.textContent || '';

            const matchesSearch = playerName.includes(searchTerm);
            const matchesCategory = !category || playerCategory.includes(category);
            const matchesAgeGroup = !ageGroup || playerAgeGroup.includes(ageGroup);

            card.style.display = matchesSearch && matchesCategory && matchesAgeGroup ? 'block' : 'none';
        });
    }
});

// ==================== HAMBURGER MENU ====================
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

if (hamburger) {
    hamburger.addEventListener('click', function() {
        navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        hamburger.classList.toggle('active');
    });
}

// ==================== SMOOTH SCROLLING ====================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href !== '#' && document.querySelector(href)) {
            e.preventDefault();
            document.querySelector(href).scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// ==================== INITIALIZE SLIDER ====================
document.addEventListener('DOMContentLoaded', function() {
    showSlides(slideIndex);
});