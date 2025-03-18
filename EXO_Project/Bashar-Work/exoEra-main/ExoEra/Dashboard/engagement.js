document.addEventListener('DOMContentLoaded', () => {
    initializeCharts();
    initializeDateRangePicker();
    initializeCounters();
    loadTransactions();

    // Add click handler for mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }
});

// Initialize Charts
function initializeCharts() {
    // Hourly Transaction Volume Chart
    const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
    new Chart(hourlyCtx, {
        type: 'line',
        data: {
            labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00'],
            datasets: [{
                label: 'Transaction Volume',
                data: [65, 59, 80, 81, 56, 55, 40, 70],
                fill: true,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Payment Methods Distribution Chart
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Views', 'Likes', 'Shares'],
            datasets: [{
                data: [30, 40, 30],
                backgroundColor: ['#22c55e', '#3b82f6', '#f59e0b']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Initialize Date Range Picker
function initializeDateRangePicker() {
    $('#dateRange').daterangepicker({
        startDate: moment().subtract(7, 'days'),
        endDate: moment(),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
}

// Initialize Counters
function initializeCounters() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000;
        const steps = 60;
        const increment = target / steps;
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.round(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString();
            }
        };

        updateCounter();
    });
}

// Load Transactions
async function loadTransactions(page = 1) {
    const filters = getFilters();
    try {
        const response = await fetch('api/transactions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ page, ...filters })
        });
        const data = await response.json();
        renderTransactions(data.transactions);
        updatePagination(data.totalPages, page);
    } catch (error) {
        showToast('Error loading transactions', 'error');
    }
}

// Get Filter Values
function getFilters() {
    return {
        dateRange: $('#dateRange').val(),
        transactionType: $('#transactionType').val(),
        paymentMethod: $('#paymentMethod').val(),
        minAmount: $('#minAmount').val(),
        maxAmount: $('#maxAmount').val()
    };
}

// Apply Filters
function applyFilters() {
    loadTransactions(1);
}

// Reset Filters
function resetFilters() {
    document.querySelectorAll('select').forEach(select => select.value = '');
    document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
    $('#dateRange').data('daterangepicker').setStartDate(moment().subtract(7, 'days'));
    $('#dateRange').data('daterangepicker').setEndDate(moment());
    loadTransactions(1);
}

// Export Transactions
async function exportTransactions(format) {
    const filters = getFilters();
    try {
        const response = await fetch(`api/export-transactions.php?format=${format}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(filters)
        });
        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `transactions_${format}.${format}`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    } catch (error) {
        showToast(`Error exporting transactions as ${format.toUpperCase()}`, 'error');
    }
}

// Show Toast Notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// More transaction management functions...

// Add this function for mobile menu toggle
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}