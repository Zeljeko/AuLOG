// JavaScript function to generate the daily chart using Chart.js library
function dailyChart(reportData) {
    const days = Object.keys(reportData);
    const hours = Object.values(reportData);

    const ctx = document.getElementById('dailyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: days,
            datasets: [{
                label: 'Charging Hours',
                data: hours,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            
            response: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Daily'
                }
            }
        }
    });
}

function weeklyChart(reportData) {
    const weeks = Object.keys(reportData);
    const hours = Object.values(reportData);

    const ctx = document.getElementById('weeklyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: weeks,
            datasets: [{
                label: 'Charging Hours',
                data: hours,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            response: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Weekly'
                }
            }
        }
    });
    
}

function monthlyChart(reportData) {
    const months = Object.keys(reportData);
    const hours = Object.values(reportData);

    const ctx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Charging Hours',
                data: hours,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly'
                }
            }
        }
    });
}
