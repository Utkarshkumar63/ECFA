// ==================== REGISTRATION FORM VALIDATION ====================
const registrationForm = document.getElementById('playerRegistrationForm');

if (registrationForm) {
    registrationForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

        // Validate form
        const isValid = validateRegistrationForm();

        if (isValid) {
            // Submit form
            submitRegistrationForm();
        }
    });
}

function validateRegistrationForm() {
    let isValid = true;

    // Validate Name
    const name = document.getElementById('name');
    if (!name.value.trim()) {
        showError('nameError', 'Name is required');
        isValid = false;
    } else if (name.value.trim().length < 3) {
        showError('nameError', 'Name must be at least 3 characters');
        isValid = false;
    }

    // Validate DOB
    const dob = document.getElementById('dob');
    if (!dob.value) {
        showError('dobError', 'Date of Birth is required');
        isValid = false;
    } else {
        const birthDate = new Date(dob.value);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        if (age < 8) {
            showError('dobError', 'Minimum age required is 8 years');
            isValid = false;
        }
    }

    // Validate Gender
    const gender = document.getElementById('gender');
    if (!gender.value) {
        showError('genderError', 'Please select a gender');
        isValid = false;
    }

    // Validate Email
    const email = document.getElementById('email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value) {
        showError('emailError', 'Email is required');
        isValid = false;
    } else if (!emailRegex.test(email.value)) {
        showError('emailError', 'Please enter a valid email');
        isValid = false;
    }

    // Validate Phone
    const phone = document.getElementById('phone');
    const phoneRegex = /^[0-9]{10}$/;
    if (!phone.value) {
        showError('phoneError', 'Phone number is required');
        isValid = false;
    } else if (!phoneRegex.test(phone.value.replace(/\D/g, ''))) {
        showError('phoneError', 'Please enter a valid 10-digit phone number');
        isValid = false;
    }

    // Validate Address
    const address = document.getElementById('address');
    if (!address.value.trim()) {
        showError('addressError', 'Address is required');
        isValid = false;
    }

    // Validate Category
    const category = document.getElementById('category');
    if (!category.value) {
        showError('categoryError', 'Please select a category');
        isValid = false;
    }

    // Validate Event Type (if exists)
    const eventType = document.getElementById('eventType');
    if (eventType && !eventType.value) {
        showError('eventTypeError', 'Please select an event type');
        isValid = false;
    }

    // Validate Event (if exists)
    const eventId = document.getElementById('eventId');
    if (eventId && !eventId.value) {
        showError('eventError', 'Please select an event');
        isValid = false;
    }

    return isValid;
}

function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
    }
}

function submitRegistrationForm() {
    const name = document.getElementById('name').value;
    const dob = document.getElementById('dob').value;
    const gender = document.getElementById('gender').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;
    const category = document.getElementById('category').value;
    const eventType = document.getElementById('eventType')?.value;
    const eventId = document.getElementById('eventId')?.value;

    const registrationData = {
        name,
        date_of_birth: dob,
        gender,
        email,
        phone,
        address,
        category,
        event_type: eventType || 'Épée',
        event_id: eventId || 1
    };

    // Send to API (requires api-client.js to be loaded)
    if (typeof ApiClient !== 'undefined') {
        ApiClient.submitRegistration(registrationData)
            .then(response => {
                if (response.success) {
                    alert('Registration submitted successfully! Awaiting admin approval.');
                    registrationForm.reset();
                    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                } else {
                    alert('Error: ' + response.message);
                }
            })
            .catch(error => {
                alert('Error submitting registration: ' + error.message);
            });
    } else {
        alert('API client not loaded. Please include api-client.js');
    }
}

// ==================== MODAL FUNCTIONALITY ====================
const modal = document.getElementById('playerModal');
const closeBtn = document.querySelector('.close-btn');

function openPlayerModal(playerName) {
    modal.classList.add('active');
    document.getElementById('modalPlayerName').textContent = playerName;
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

// ==================== LIGHTBOX FUNCTIONALITY ====================
function openLightbox(imageSrc) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    lightboxImage.src = imageSrc;
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