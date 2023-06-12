// JavaScript function to generate the daily chart using Chart.js library
function dailyChart(chartID, reportData) {
    const days = Object.keys(reportData);
    const hours = Object.values(reportData);

    const ctx = document.getElementById(chartID).getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: days,
            datasets: [{
                label: 'Charging Hours',
                data: hours,
                backgroundColor: 'rgb(128,0,0, 0.2)',
                borderColor: 'rgba(128, 0, 0, 1)',
                borderWidth: 1
            }]
        },
        options: {
            response: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                title: {
                    display: true,
                }
            }
        }
    });
}

function weeklyChart(chartID, reportData) {
    const weeks = Object.keys(reportData);
    const hours = Object.values(reportData);

    const ctx = document.getElementById(chartID).getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: weeks,
            datasets: [{
                label: 'Charging Hours',
                data: hours,
                backgroundColor: 'rgb(128,0,0, 0.2)',
                borderColor: 'rgba(128, 0, 0, 1)',
                borderWidth: 1
            }]
        },
        options: {
            response: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                title: {
                    display: true,
                }
            }
        }
    });
    
}

function monthlyChart(chartID, reportData) {
    const months = Object.keys(reportData);
    const hours = Object.values(reportData);

    const ctx = document.getElementById(chartID).getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Charging Hours',
                data: hours,
                backgroundColor: 'rgb(128,0,0, 0.2)',
                borderColor: 'rgba(128, 0, 0, 1)',
                borderWidth: 1
            }]
        },
        options: {
            response: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                title: {
                    display: true,
                }
            }
        }
    });
}

function pieChart(chartID, reportData) {
    const labels = Object.keys(reportData);
    const hours = Object.values(reportData);

    const ctx = document.getElementById(chartID).getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: hours,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Color for variable 1
                    'rgba(54, 162, 235, 0.2)', // Color for variable 2
                    'rgba(255, 206, 86, 0.2)'  // Color for variable 3
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Variable Distribution' // Title for the chart
                }
            }
        }
    });
}
