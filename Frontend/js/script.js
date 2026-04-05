/* ==================== NAVIGATION ==================== */
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('ecfa-nav-toggle');
    const panel = document.getElementById('ecfa-nav-panel');

    if (toggle && panel) {
        toggle.addEventListener('click', function () {
            panel.classList.toggle('hidden');
            const expanded = !panel.classList.contains('hidden');
            toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });

        panel.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth < 768) {
                    panel.classList.add('hidden');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        });
    }

    var lightbox = document.getElementById('lightbox');
    if (lightbox) {
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
    }

    checkAdminStatus();
});

function checkAdminStatus() {
    const token = localStorage.getItem('ecfa_token');
    const adminLoginLink = document.querySelector('[data-ecfa-admin-link]');

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
        localStorage.removeItem('ecfa_token');
        localStorage.removeItem('admin_user');
    }
}

/* ==================== MODAL FUNCTIONALITY ==================== */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

document.addEventListener('click', function (event) {
    document.querySelectorAll('[data-ecfa-modal]').forEach(function (modal) {
        if (event.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});

document.addEventListener('click', function (event) {
    if (event.target.classList.contains('close-btn')) {
        const modal = event.target.closest('[data-ecfa-modal]');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
});

/* ==================== LIGHTBOX ==================== */
function openLightbox(imageSrc) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');

    if (lightbox && lightboxImage) {
        lightboxImage.src = imageSrc;
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex', 'items-center', 'justify-center');
        document.body.classList.add('overflow-hidden');
    }
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    if (lightbox) {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex', 'items-center', 'justify-center');
        document.body.classList.remove('overflow-hidden');
    }
}

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeLightbox();
    }
});

/* ==================== DATA LOADING ==================== */
function showLoading(element) {
    element.innerHTML =
        '<div class="flex flex-col items-center justify-center gap-3 py-16 text-slate-500">' +
        '<div class="h-10 w-10 animate-spin rounded-full border-2 border-blue-600 border-t-transparent"></div>' +
        '<p class="text-sm font-medium">Loading...</p></div>';
}

function showError(element, message) {
    message = message || 'Failed to load data';
    element.innerHTML =
        '<div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-center text-sm font-medium text-red-800">' +
        message +
        '</div>';
}

function emptyStateMessage(element, message) {
    message = message || 'No data available';
    element.innerHTML =
        '<div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-center text-sm font-medium text-slate-600">' +
        message +
        '</div>';
}

/* ==================== ALERT SYSTEM ==================== */
function showAlert(message, type) {
    type = type || 'info';
    var styles = {
        info: 'border-blue-200 bg-blue-50 text-blue-900',
        success: 'border-emerald-200 bg-emerald-50 text-emerald-900',
        danger: 'border-red-200 bg-red-50 text-red-900',
    };
    var style = styles[type] || styles.info;
    var alertBox = document.createElement('div');
    alertBox.className =
        'fixed right-4 top-20 z-[200] max-w-sm rounded-xl border px-4 py-3 text-sm font-medium shadow-lg ' + style;
    alertBox.textContent = message;
    document.body.appendChild(alertBox);

    setTimeout(function () {
        alertBox.remove();
    }, 5000);
}

/* ==================== FORM UTILITIES ==================== */
function getFormData(formElement) {
    var formData = new FormData(formElement);
    var data = {};

    for (var pair of formData.entries()) {
        var key = pair[0];
        var value = pair[1];
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
    formElement.querySelectorAll('.error-message').forEach(function (el) {
        el.remove();
    });
}

function showFormErrors(formElement, errors) {
    formElement.querySelectorAll('.error-message').forEach(function (el) {
        el.remove();
    });

    for (var field in errors) {
        if (!Object.prototype.hasOwnProperty.call(errors, field)) continue;
        var message = errors[field];
        var input = formElement.elements[field];
        if (input) {
            var errorElement = document.createElement('span');
            errorElement.className = 'error-message mt-1 block text-sm text-red-600';
            errorElement.textContent = Array.isArray(message) ? message[0] : message;
            input.parentElement.appendChild(errorElement);
            input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
        }
    }
}

function clearFormErrors(formElement) {
    formElement.querySelectorAll('.error-message').forEach(function (el) {
        el.remove();
    });
    formElement.querySelectorAll('input, select, textarea').forEach(function (el) {
        el.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
    });
}

/* ==================== PAGINATION ==================== */
function createPagination(currentPage, totalPages, onPageChange) {
    return (
        '<div class="mt-8 flex flex-wrap items-center justify-center gap-2">' +
        (currentPage > 1
            ? '<button type="button" onclick="onPageChange(' +
              (currentPage - 1) +
              ')" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Previous</button>'
            : '') +
        '<span class="flex items-center px-3 py-2 text-sm text-slate-600">Page ' +
        currentPage +
        ' of ' +
        totalPages +
        '</span>' +
        (currentPage < totalPages
            ? '<button type="button" onclick="onPageChange(' +
              (currentPage + 1) +
              ')" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Next</button>'
            : '') +
        '</div>'
    );
}

/* ==================== DATE FORMATTING ==================== */
function formatDate(dateString) {
    var date = new Date(dateString);
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

function formatDateTime(dateString) {
    var date = new Date(dateString);
    var options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return date.toLocaleDateString('en-US', options);
}

/* ==================== SEARCH/FILTER ==================== */
function debounce(func, delay) {
    var timeoutId;
    return function () {
        var args = arguments;
        var ctx = this;
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function () {
            func.apply(ctx, args);
        }, delay);
    };
}

function filterArray(array, searchTerm, searchFields) {
    if (!searchTerm.trim()) return array;

    var term = searchTerm.toLowerCase();
    return array.filter(function (item) {
        return searchFields.some(function (field) {
            var value = item[field];
            return value && value.toString().toLowerCase().includes(term);
        });
    });
}

/* ==================== VALIDATION ==================== */
function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validatePhone(phone) {
    return /^[0-9]{10}$/.test(phone.replace(/\D/g, ''));
}

function validateAge(birthDate, minAge) {
    minAge = minAge || 8;
    var today = new Date();
    var birth = new Date(birthDate);
    var age = today.getFullYear() - birth.getFullYear();
    var monthDiff = today.getMonth() - birth.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }

    return age >= minAge;
}

/* ==================== EXPORT DATA ==================== */
function exportToCSV(data, filename) {
    filename = filename || 'export.csv';
    if (!data || data.length === 0) {
        alert('No data to export');
        return;
    }

    var headers = Object.keys(data[0]);
    var csv = [
        headers.join(','),
        ...data.map(function (row) {
            return headers
                .map(function (header) {
                    var value = row[header];
                    var escaped = String(value || '').replace(/"/g, '""');
                    return escaped.includes(',') ? '"' + escaped + '"' : escaped;
                })
                .join(',');
        }),
    ].join('\n');

    var blob = new Blob([csv], { type: 'text/csv' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

function initializePage() {
    console.log('Page initialized');
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializePage);
} else {
    initializePage();
}
