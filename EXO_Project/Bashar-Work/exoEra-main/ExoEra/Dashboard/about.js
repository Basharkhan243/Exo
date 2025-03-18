// Navbar scroll effect
window.addEventListener('scroll', function() {
    const nav = document.querySelector('nav');
    if (window.scrollY > 50) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});

// Mobile menu functionality
function toggleMenu() {
    const mobileNav = document.querySelector('.mobile-nav');
    const hamburger = document.querySelector('.hamburger');
    
    mobileNav.classList.toggle('active');
    hamburger.classList.toggle('active');
    
    if (mobileNav.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }
}

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
    const mobileNav = document.querySelector('.mobile-nav');
    const hamburger = document.querySelector('.hamburger');
    
    if (!e.target.closest('.mobile-nav') && 
        !e.target.closest('.hamburger') && 
        mobileNav.classList.contains('active')) {
        mobileNav.classList.remove('active');
        hamburger.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
});

// Add active class to current nav link
document.addEventListener('DOMContentLoaded', () => {
    const currentLocation = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-links a, .mobile-nav-links a');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentLocation) {
            link.classList.add('active');
        }
    });
});