// Toggle sidebar on mobile
const toggleSidebar = () => {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
};

// Handle active menu items
document.querySelectorAll('.sidebar-nav a').forEach(link => {
    link.addEventListener('click', (e) => {
        document.querySelector('.sidebar-nav li.active').classList.remove('active');
        link.parentElement.classList.add('active');
    });
});

// Notifications dropdown
const notificationsToggle = document.querySelector('.notifications');
const notificationsPanel = document.querySelector('.notifications-panel');

notificationsToggle?.addEventListener('click', () => {
    notificationsPanel.classList.toggle('active');
});

// Close notifications panel when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.notifications') && 
        !e.target.closest('.notifications-panel')) {
        notificationsPanel.classList.remove('active');
    }
});

// User profile dropdown
const userProfileToggle = document.querySelector('.user-profile');
userProfileToggle?.addEventListener('click', () => {
    // Add your user profile dropdown logic here
});

// Add mobile menu button if needed
const addMobileMenuButton = () => {
    if (window.innerWidth <= 768) {
        const topNav = document.querySelector('.top-nav');
        if (!document.querySelector('.mobile-menu-btn')) {
            const menuBtn = document.createElement('button');
            menuBtn.className = 'mobile-menu-btn';
            menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            menuBtn.addEventListener('click', toggleSidebar);
            topNav.insertBefore(menuBtn, topNav.firstChild);
        }
    }
};

// Call on load and resize
window.addEventListener('load', addMobileMenuButton);
window.addEventListener('resize', addMobileMenuButton);

// Handle skill actions
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const skillCard = e.target.closest('.skill-card');
    });
});

document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const skillCard = e.target.closest('.skill-card');
        if (confirm('Are you sure you want to delete this skill?')) {
            skillCard.remove();
        }
    });
});

// Add new skill
const addSkillBtn = document.querySelector('.add-skill-btn');
addSkillBtn?.addEventListener('click', () => {
});

// Project details
document.querySelectorAll('.details-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const projectCard = e.target.closest('.project-card');
        // Add your project details view logic here
    });
});

// Profile completion circle animation
function setProgress(percentage) {
    const circle = document.querySelector('.completion-circle .progress');
    const circumference = 220; // 2 * π * radius
    const offset = circumference - (circumference * percentage) / 100;
    circle.style.strokeDashoffset = offset;
}

// Initialize profile completion
document.addEventListener('DOMContentLoaded', () => {
    setProgress(85); // Set to your actual percentage
});

// Update date and time
function updateDateTime() {
    const dateElement = document.querySelector('.current-date');
    const timeElement = document.querySelector('.current-time');
    
    const now = new Date();
    dateElement.textContent = now.toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    timeElement.textContent = now.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
}

setInterval(updateDateTime, 1000);
updateDateTime();

// Animate statistics
function animateNumbers() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    statNumbers.forEach(number => {
        const target = parseInt(number.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60 FPS
        let current = 0;
        
        const updateNumber = () => {
            if (current < target) {
                current += increment;
                number.textContent = Math.round(current);
                requestAnimationFrame(updateNumber);
            } else {
                number.textContent = target;
            }
        };
        
        updateNumber();
    });
}

// Add recent activities
function addRecentActivities() {
    const activityList = document.querySelector('.activity-list');
    const activities = [
        {
            type: 'project',
            text: 'Updated portfolio website design',
            time: '2 hours ago'
        },
        {
            type: 'connection',
            text: 'Connected with Sarah Wilson',
            time: '5 hours ago'
        },
        {
            type: 'skill',
            text: 'Added new skill: React.js',
            time: 'Yesterday'
        }
    ];

    activities.forEach(activity => {
        const activityItem = `
            <div class="activity-item">
                <div class="activity-icon ${activity.type}">
                    <i class="fas fa-${activity.type === 'project' ? 'code-branch' : 
                                     activity.type === 'connection' ? 'user-plus' : 'star'}"></i>
                </div>
                <div class="activity-info">
                    <p>${activity.text}</p>
                    <span>${activity.time}</span>
                </div>
            </div>
        `;
        activityList.insertAdjacentHTML('beforeend', activityItem);
    });
}

// Add upcoming deadlines
function addUpcomingDeadlines() {
    const deadlinesList = document.querySelector('.deadlines-list');
    const deadlines = [
        {
            project: 'E-commerce Website',
            deadline: '2024-02-28',
            progress: 75
        },
        {
            project: 'Mobile App Design',
            deadline: '2024-03-15',
            progress: 45
        }
    ];

    // deadlines.forEach(deadline => {
    //     const deadlineItem = `
    //         <div class="deadline-item">
    //             <div class="deadline-info">
    //                 <h4>${deadline.project}</h4>
    //                 <p>Due: ${new Date(deadline.deadline).toLocaleDateString()}</p>
    //             </div>
    //             <div class="deadline-progress">
    //                 <div class="progress-bar" style="width: ${deadline.progress}%"></div>
    //                 <span>${deadline.progress}%</span>
    //             </div>
    //         </div>
    //     `;
    //     deadlinesList.insertAdjacentHTML('beforeend', deadlineItem);
    // });
}

// Add skills progress
function addSkillsProgress() {
    const skillsList = document.querySelector('.skills-list');
    const skills = [
        { name: 'JavaScript', level: 85 },
        { name: 'React.js', level: 75 },
        { name: 'Node.js', level: 70 }
    ];

    // skills.forEach(skill => {
    //     const skillItem = `
    //         <div class="skill-item">
    //             <div class="skill-info">
    //                 <span>${skill.name}</span>
    //                 <span>${skill.level}%</span>
    //             </div>
    //             <div class="skill-progress">
    //                 <div class="progress-bar" style="width: ${skill.level}%"></div>
    //             </div>
    //         </div>
    //     `;
    //     skillsList.insertAdjacentHTML('beforeend', skillItem);
    // });
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', () => {
    animateNumbers();
    addRecentActivities();
    addUpcomingDeadlines();
    addSkillsProgress();
});

// Quick action buttons
document.querySelectorAll('.action-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const action = btn.dataset.action;
        switch(action) {
            case 'new-project':
                window.location.href = 'new-project.html';
                break;
            case 'edit-profile':
                window.location.href = 'profile.html';
                break;
            case 'messages':
                window.location.href = 'messages.html';
                break;
            case 'settings':
                window.location.href = 'settings.html';
                break;
        }
    });
});

// Navigation handling
document.querySelectorAll('.sidebar-nav a').forEach(link => {
    link.addEventListener('click', (e) => {
        const href = link.getAttribute('href');
        
        // Handle navigation based on href
        switch(href) {
            case '#overview':
                window.location.href = 'dashboard.html';
                break;
            case '#profile':
                window.location.href = 'profile.html';
                break;
            case '#skills':
                window.location.href = 'skills.html';
                break;
            case '#portfolio':
                window.location.href = 'portfolio.html';
                break;
            case '#messages':
                window.location.href = 'messages.html';
                break;
            case '#settings':
                window.location.href = 'settings.html';
                break;
        }
    });
});

// Add active state to current page
document.addEventListener('DOMContentLoaded', () => {
    const currentPage = window.location.pathname.split('/').pop().split('.')[0];
    const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
    
    sidebarLinks.forEach(link => {
        const linkPage = link.getAttribute('href').replace('#', '');
        if (currentPage === linkPage) {
            link.parentElement.classList.add('active');
        }
    });
});

// Logout handling
document.querySelector('.logout-btn')?.addEventListener('click', (e) => {
    e.preventDefault();
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = 'login.html';
    }
});