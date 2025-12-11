/**
 * NOCIS Job Application Interface JavaScript
 */

// Mobile Filter Toggle
document.addEventListener('DOMContentLoaded', function() {
    const filterToggle = document.getElementById('filter-toggle');
    const filterSidebar = document.getElementById('filter-sidebar');
    const filterOverlay = document.getElementById('filter-overlay');
    const closeFilterBtn = document.getElementById('close-filter');

    if (filterToggle && filterSidebar) {
        filterToggle.addEventListener('click', function() {
            filterSidebar.classList.add('mobile-open');
            filterOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    if (closeFilterBtn) {
        closeFilterBtn.addEventListener('click', function() {
            filterSidebar.classList.remove('mobile-open');
            filterOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    }

    if (filterOverlay) {
        filterOverlay.addEventListener('click', function() {
            filterSidebar.classList.remove('mobile-open');
            filterOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    }
});

// Back to Top Button
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    }
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Job Card Animations
function animateJobCards() {
    const jobCards = document.querySelectorAll('.job-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, {
        threshold: 0.1
    });

    jobCards.forEach(card => {
        observer.observe(card);
    });
}

// Filter Form Submission with Loading
function setupFilterForm() {
    const filterForm = document.querySelector('form[action*="jobs"]');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            const submitBtn = filterForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            }
        });
    }
}

// Initialize all functions
document.addEventListener('DOMContentLoaded', function() {
    animateJobCards();
    setupFilterForm();

    // Add back to top button if it exists
    const backToTopHTML = `
        <button id="back-to-top" onclick="scrollToTop()" class="fixed bottom-4 right-4 bg-red-500 hover:bg-red-600 text-white w-12 h-12 rounded-full flex items-center justify-center cursor-pointer opacity-0 transition-opacity duration-300 z-50">
            <i class="fas fa-arrow-up"></i>
        </button>
    `;

    document.body.insertAdjacentHTML('beforeend', backToTopHTML);
});

// Job Application Form Validation
function setupApplicationForm() {
    const applicationForm = document.getElementById('application-form');
    if (applicationForm) {
        applicationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Basic validation
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const cv = document.getElementById('cv');

            if (!name.value.trim()) {
                showToast('Please enter your name', 'error');
                return;
            }

            if (!email.value.trim() || !validateEmail(email.value)) {
                showToast('Please enter a valid email address', 'error');
                return;
            }

            if (!cv.files.length) {
                showToast('Please upload your CV', 'error');
                return;
            }

            // Form submission would go here
            showToast('Application submitted successfully!', 'success');
        });
    }
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    const toastId = 'toast-' + Date.now();

    const toastHTML = `
        <div id="${toastId}" class="toast toast-${type} mb-2">
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                <span>${message}</span>
                <button onclick="dismissToast('${toastId}')" class="ml-3 text-sm font-bold">×</button>
            </div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHTML);

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        dismissToast(toastId);
    }, 5000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed top-4 right-4 z-50 space-y-2';
    document.body.appendChild(container);
    return container;
}

function dismissToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }
}

// Job Details Page Tabs
function setupJobTabs() {
    const tabButtons = document.querySelectorAll('[data-tab-button]');
    const tabContents = document.querySelectorAll('[data-tab-content]');

    if (tabButtons.length > 0) {
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.getAttribute('data-tab-button');

                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked button and corresponding content
                button.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Activate first tab by default
        if (tabButtons[0]) {
            tabButtons[0].click();
        }
    }
}

// Initialize application form and tabs
document.addEventListener('DOMContentLoaded', function() {
    setupApplicationForm();
    setupJobTabs();
});

// Copy to Clipboard Functionality
function copyToClipboard(text, elementId) {
    navigator.clipboard.writeText(text).then(() => {
        const button = document.getElementById(elementId);
        if (button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i> Copied!';
            button.classList.add('bg-green-500', 'text-white');
            button.classList.remove('bg-gray-100', 'text-gray-700');

            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-copy"></i> Copy';
                button.classList.remove('bg-green-500', 'text-white');
                button.classList.add('bg-gray-100', 'text-gray-700');
            }, 2000);
        }
    }).catch(err => {
        console.error('Failed to copy: ', err);
    });
}

// Mobile Menu Toggle
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu) {
        mobileMenu.classList.toggle('hidden');
    }
}

// Initialize mobile menu
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
    }
});

// Job Card Favorite Toggle
function toggleFavorite(jobId) {
    const button = document.getElementById(`favorite-${jobId}`);
    if (button) {
        const isFavorited = button.classList.toggle('text-red-500');
        const icon = button.querySelector('i');

        if (isFavorited) {
            icon.classList.remove('far', 'fa-heart');
            icon.classList.add('fas', 'fa-heart');
            showToast('Job saved to favorites!', 'success');
        } else {
            icon.classList.remove('fas', 'fa-heart');
            icon.classList.add('far', 'fa-heart');
            showToast('Job removed from favorites', 'info');
        }
    }
}

// Export functionality for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        toggleMobileMenu,
        scrollToTop,
        showToast,
        copyToClipboard,
        toggleFavorite
    };
}