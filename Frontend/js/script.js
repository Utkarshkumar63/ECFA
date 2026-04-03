/* ==================== NAVIGATION ==================== */
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-menu a');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }
    
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navMenu.classList.remove('active');
            
            // Mark active navigation item
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Set active nav based on current page
    setActiveNavigation();
    
    // Check admin login status
    checkAdminStatus();
});

function setActiveNavigation() {
    const navLinks = document.querySelectorAll('.nav-menu a');
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'index.html')) {
            link.classList.add('active');
        }
    });
}

/* ==================== ADMIN AUTHENTICATION ==================== */
function checkAdminStatus() {
    const token = localStorage.getItem('ecfa_token');
    const adminLoginLink = document.querySelector('.admin-login a');
    
    if (token && adminLoginLink) {
        adminLoginLink.href = 'admin-dashboard.html';
        adminLoginLink.textContent = 'Admin Panel';
    }
}

async function logout() {
    try {
        await ApiClient.logout();
        localStorage.removeItem('ecfa_token');
        localStorage.removeItem('admin_user');
        alert('Logged out successfully!');
        window.location.href = 'admin-login.html';
    } catch (error) {
        alert('Error logging out');
        // Force logout even if API fails
        localStorage.removeItem('ecfa_token');
        localStorage.removeItem('admin_user');
    }
}

/* ==================== MODAL FUNCTIONALITY ==================== */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.classList.remove('active');
        }
    });
});

// Modal close buttons
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('close-btn')) {
        const modal = event.target.closest('.modal');
        if (modal) {
            modal.classList.remove('active');
        }
    }
});

/* ==================== LIGHTBOX FUNCTIONALITY ==================== */
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

// Lightbox keyboard navigation
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeLightbox();
    }
});

/* ==================== DATA LOADING ==================== */
function showLoading(element) {
    element.innerHTML = '<div class="loading"></div><p>Loading...</p>';
}

function showError(element, message = 'Failed to load data') {
    element.innerHTML = `<div class="alert alert-danger">${message}</div>`;
}

function emptyStateMessage(element, message = 'No data available') {
    element.innerHTML = `<div class="alert alert-info">${message}</div>`;
}

/* ==================== ALERT SYSTEM ==================== */
function showAlert(message, type = 'info') {
    const alertBox = document.createElement('div');
    alertBox.className = `alert alert-${type}`;
    alertBox.textContent = message;
    alertBox.style.animation = 'slideDown 0.3s ease';
    
    const container = document.querySelector('.container') || document.body;
    container.insertBefore(alertBox, container.firstChild);
    
    // Auto-remove alert after 5 seconds
    setTimeout(() => {
        alertBox.remove();
    }, 5000);
}

/* ==================== FORM UTILITIES ==================== */
function getFormData(formElement) {
    const formData = new FormData(formElement);
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        if (data[key]) {
            if (!Array.isArray(data[key])) {
                data[key] = [data[key]];
            }
            data[key].push(value);
        } else {
            data[key] = value;
        }
    }
    
    return data;
}

function resetForm(formElement) {
    formElement.reset();
    formElement.querySelectorAll('.error-message').forEach(el => el.remove());
}

function showFormErrors(formElement, errors) {
    // Clear previous errors
    formElement.querySelectorAll('.error-message').forEach(el => el.remove());
    
    // Show new errors
    for (let [field, message] of Object.entries(errors)) {
        const input = formElement.elements[field];
        if (input) {
            const errorElement = document.createElement('span');
            errorElement.className = 'error-message';
            errorElement.textContent = Array.isArray(message) ? message[0] : message;
            input.parentElement.appendChild(errorElement);
            input.style.borderColor = 'var(--danger-color)';
        }
    }
}

function clearFormErrors(formElement) {
    formElement.querySelectorAll('.error-message').forEach(el => el.remove());
    formElement.querySelectorAll('input, select, textarea').forEach(el => {
        el.style.borderColor = 'var(--border-color)';
    });
}

/* ==================== PAGINATION ==================== */
function createPagination(currentPage, totalPages, onPageChange) {
    const html = `
        <div class="pagination" style="text-align: center; margin-top: 2rem; gap: 0.5rem; display: flex; justify-content: center; flex-wrap: wrap;">
            ${currentPage > 1 ? `<button onclick="onPageChange(${currentPage - 1})" class="btn btn-secondary">Previous</button>` : ''}
            <span style="display: flex; align-items: center; padding: 0.5rem 1rem;">Page ${currentPage} of ${totalPages}</span>
            ${currentPage < totalPages ? `<button onclick="onPageChange(${currentPage + 1})" class="btn btn-secondary">Next</button>` : ''}
        </div>
    `;
    return html;
}

/* ==================== DATE FORMATTING ==================== */
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

function formatDateTime(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return date.toLocaleDateString('en-US', options);
}

/* ==================== SEARCH/FILTER ==================== */
function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func(...args), delay);
    };
}

function filterArray(array, searchTerm, searchFields) {
    if (!searchTerm.trim()) return array;
    
    const term = searchTerm.toLowerCase();
    return array.filter(item => 
        searchFields.some(field => {
            const value = item[field];
            return value && value.toString().toLowerCase().includes(term);
        })
    );
}

/* ==================== VALIDATION ==================== */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhone(phone) {
    const re = /^[0-9]{10}$/;
    return re.test(phone.replace(/\D/g, ''));
}

function validateAge(birthDate, minAge = 8) {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    
    return age >= minAge;
}

/* ==================== EXPORT DATA ==================== */
function exportToCSV(data, filename = 'export.csv') {
    if (!data || data.length === 0) {
        alert('No data to export');
        return;
    }
    
    const headers = Object.keys(data[0]);
    const csv = [
        headers.join(','),
        ...data.map(row => 
            headers.map(header => {
                const value = row[header];
                // Escape quotes and wrap in quotes if contains comma
                const escaped = String(value || '').replace(/"/g, '""');
                return escaped.includes(',') ? `"${escaped}"` : escaped;
            }).join(',')
        )
    ].join('\n');
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

/* ==================== INITIALIZE PAGE ==================== */
function initializePage() {
    // This function can be called from individual pages
    // to perform common initialization tasks
    console.log('Page initialized');
}

// Call on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializePage);
} else {
    initializePage();
}
