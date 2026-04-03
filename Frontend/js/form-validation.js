/* ==================== FORM VALIDATION ==================== */

document.addEventListener('DOMContentLoaded', function() {
    const registrationForm = document.getElementById('playerRegistrationForm');
    
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitRegistrationForm();
        });
    }
});

function submitRegistrationForm() {
    const form = document.getElementById('playerRegistrationForm');
    if (!form) return;

    // Clear previous errors
    clearFormErrors(form);

    // Collect form data
    const name = document.getElementById('name').value.trim();
    const dob = document.getElementById('dob').value;
    const gender = document.getElementById('gender').value;
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();
    const city = document.getElementById('city').value.trim();
    const state = document.getElementById('state').value.trim();
    const pincode = document.getElementById('pincode').value.trim();
    const category = document.getElementById('category').value;
    const ageGroup = document.getElementById('ageGroup').value;
    const experience = document.getElementById('experience').value;
    const agree = document.getElementById('agree').checked;

    // Validation
    const errors = {};

    if (name.length < 3) {
        errors.name = 'Name must be at least 3 characters';
    }

    if (!dob) {
        errors.dob = 'Date of birth is required';
    } else if (!validateAge(dob, 8)) {
        errors.dob = 'You must be at least 8 years old';
    }

    if (!gender) {
        errors.gender = 'Gender is required';
    }

    if (!validateEmail(email)) {
        errors.email = 'Please enter a valid email address';
    }

    if (!validatePhone(phone)) {
        errors.phone = 'Please enter a valid 10-digit phone number';
    }

    if (address.length < 5) {
        errors.address = 'Please enter a valid address';
    }

    if (!city) {
        errors.city = 'City is required';
    }

    if (!state) {
        errors.state = 'State is required';
    }

    if (!pincode) {
        errors.pincode = 'Pincode is required';
    }

    if (!category) {
        errors.category = 'Fencing category is required';
    }

    if (!ageGroup) {
        errors.ageGroup = 'Age group is required';
    }

    if (!experience) {
        errors.experience = 'Experience level is required';
    }

    if (!agree) {
        errors.agree = 'You must agree to the terms and conditions';
    }

    // Show errors if any
    if (Object.keys(errors).length > 0) {
        showFormErrors(form, errors);
        return;
    }

    // Prepare registration data
    const registrationData = {
        name: name,
        date_of_birth: dob,
        gender: gender,
        email: email,
        phone: phone,
        address: address,
        category: ageGroup,
        event_type: category,
        bio: ''
    };

    // Submit to API
    submitRegistration(registrationData);
}

function submitRegistration(data) {
    const form = document.getElementById('playerRegistrationForm');
    if (!form) return;

    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';

    // Check if API client is available
    if (typeof ApiClient === 'undefined') {
        showAlert('Error: API client not loaded', 'danger');
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        return;
    }

    // Call API
    ApiClient.submitRegistration(data)
        .then(response => {
            // Success
            showAlert('✅ Registration submitted successfully! Admin approval is pending.', 'success');
            
            // Reset form
            form.reset();
            clearFormErrors(form);
            
            // Scroll to top
            window.scrollTo(0, 0);
            
            // Redirect after 2 seconds
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 2000);
        })
        .catch(error => {
            // Handle error
            console.error('Registration error:', error);
            
            const errorMsg = error.message || 'An error occurred during registration';
            showAlert('❌ ' + errorMsg, 'danger');
            
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
}

/* ==================== VALIDATION HELPERS ==================== */

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhone(phone) {
    const digits = phone.replace(/\D/g, '');
    return digits.length === 10;
}

function validateAge(birthDate, minAge = 8) {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const month = today.getMonth() - birth.getMonth();
    
    if (month < 0 || (month === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    
    return age >= minAge;
}

function showFormErrors(formElement, errors) {
    // Clear previous errors
    formElement.querySelectorAll('.error-message').forEach(el => el.textContent = '');

    // Show new errors
    for (let [field, message] of Object.entries(errors)) {
        const input = formElement.elements[field];
        if (input) {
            // Find or create error element
            let errorEl = input.parentElement.querySelector('.error-message');
            if (!errorEl) {
                errorEl = document.createElement('span');
                errorEl.className = 'error-message';
                input.parentElement.appendChild(errorEl);
            }
            errorEl.textContent = message;
            
            // Highlight input
            input.style.borderColor = 'var(--danger-color)';
        }
    }
}

function clearFormErrors(formElement) {
    // Clear error messages
    formElement.querySelectorAll('.error-message').forEach(el => {
        el.textContent = '';
    });

    // Clear error styling
    formElement.querySelectorAll('input, select, textarea').forEach(el => {
        el.style.borderColor = 'var(--border-color)';
    });
}

/* ==================== UTILITY FUNCTIONS ==================== */

function showAlert(message, type = 'info') {
    const alertBox = document.createElement('div');
    alertBox.className = `alert alert-${type}`;
    alertBox.textContent = message;
    alertBox.style.marginTop = '1rem';
    alertBox.style.animation = 'slideDown 0.3s ease';

    const form = document.getElementById('playerRegistrationForm');
    if (form) {
        form.parentElement.insertBefore(alertBox, form);
    } else {
        document.body.insertBefore(alertBox, document.body.firstChild);
    }

    // Auto-remove after 5 seconds
    setTimeout(() => {
        alertBox.remove();
    }, 5000);
}

/* ==================== LIGHTBOX FOR GALLERY (if needed) ==================== */

document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('lightbox');
    
    if (lightbox) {
        // Close lightbox on background click
        lightbox.addEventListener('click', function(event) {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });

        // Close lightbox on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLightbox();
            }
        });
    }
});

function openLightbox(imageSrc) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    
    if (lightbox && lightboxImage) {
        lightboxImage.src = imageSrc;
        lightbox.classList.add('active');
    }
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    if (lightbox) {
        lightbox.classList.remove('active');
    }
}
