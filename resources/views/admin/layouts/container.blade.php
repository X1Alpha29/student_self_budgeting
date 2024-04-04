<div class="container mt-4">
    <div class="row">
        <!-- Summary Widget Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title fw-normal"><i class="fas fa-wallet me-2"></i>Total Expenses:</h6> <!-- Changed class to fw-normal -->
                            <p class="card-text fw-bold" id="monthlyExpensesTotal">Loading...</p>
                        </div>
                        <i class="fas fa-money-bill-wave fa-2x text-primary"></i>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title fw-normal"><i class="fas fa-tag me-2"></i>Most Used Category:</h6> <!-- Changed class to fw-normal -->
                            <p class="card-text fw-bold" id="mostUsedCategory">Loading...</p>
                        </div>
                        <i class="fas fa-chart-bar fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Upcoming Direct Debits Widget Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title fw-normal"><i class="fas fa-calendar-check me-2"></i>Upcoming Direct Debits:</h6>
                            <p class="card-text fw-bold" id="upcomingDirectDebitsCount">Loading...</p>
                        </div>
                        <i class="fas fa-calendar-alt fa-2x text-warning"></i>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title fw-normal"><i class="fas fa-clock me-2"></i>Next Direct Debit Date:</h6>
                            <p class="card-text fw-bold" id="nextDirectDebitDate">Loading...</p>
                        </div>
                        <i class="fas fa-hourglass-start fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title fw-normal"><i class="fas fa-exclamation-circle me-2"></i>Debts Within the Month:</h6>
                            <p class="card-text fw-bold" id="debtsWithinMonth">Loading...</p>
                        </div>
                        <i class="fas fa-handshake fa-2x text-danger"></i>
                    </div>
                    <hr>
                    <div>
                        <p class="card-text" id="nextDebtsWithinMonth">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Monthly Expenses by Category Chart -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <canvas id="monthlyExpensesByCategoryChart" width="300" height="200"></canvas>
                </div>
                <div class="card-footer">
                    Current Month: {{ \Carbon\Carbon::now()->format('F Y') }}
                </div>
            </div>
        </div>

        <!-- Weekly Expenses by Category Chart -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <canvas id="weeklyExpensesByCategoryChart" width="600" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body" style="position: relative; height: 300px;">
                    <canvas id="expenseCategoriesDoughnutChart" height="300"></canvas>
                </div>
                <div class="card-footer">
                    Current Month: {{ \Carbon\Carbon::now()->format('F Y') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fetch monthly expenses total
        fetchMonthlyExpensesTotal();

        // Fetch monthly expenses by category data
        fetchMonthlyExpensesByCategoryData();

        // Fetch weekly expenses by category data
        fetchWeeklyExpensesByCategoryData();

        fetchSummaryData();

        fetchUpcomingDirectDebitsSummary();
        // Fetch debts within the month
        fetchDebtsWithinMonth();

        // Fetch expense categories for doughnut chart
        fetchExpenseCategoriesForDoughnutChart();
    });

    function fetchSummaryData() {
        fetch("{{ route('monthly-expenses-summary') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('monthlyExpensesTotal').innerText = '£' + data.total; // Add £ sign
                document.getElementById('mostUsedCategory').innerText = data.most_used_category;
            })
            .catch(error => console.error('Error fetching monthly expenses summary:', error));
    }

    function fetchMonthlyExpensesTotal() {
        fetch("{{ route('monthly-expenses-total') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('monthlyExpensesTotal').innerText = '£' + data.total; // Add £ sign
            })
            .catch(error => console.error('Error fetching monthly expenses total:', error));
    }

    function fetchMonthlyExpensesByCategoryData() {
        fetch("{{ route('monthly-expenses-by-category') }}")
            .then(response => response.json())
            .then(data => {
                renderMonthlyExpensesByCategoryChart(data);
            })
            .catch(error => console.error('Error fetching monthly expenses by category data:', error));
    }

    function renderMonthlyExpensesByCategoryChart(data) {
        // Extract category labels and expenses data
        var categories = data.map(item => item.category);
        var expenses = data.map(item => item.total_amount);

        // Monthly Expenses by Category Data
        var monthlyExpensesByCategoryData = {
            labels: categories,
            datasets: [{
                label: 'Monthly Expenses',
                data: expenses,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Render Monthly Expenses by Category Chart as a bar chart
        var ctxMonthly = document.getElementById('monthlyExpensesByCategoryChart').getContext('2d');
        var monthlyExpensesByCategoryChart = new Chart(ctxMonthly, {
            type: 'bar',
            data: monthlyExpensesByCategoryData,
            options: {
                scales: {
                    x: {
                        grid: {
                            display: false // Remove x-axis grid lines
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)', // Set color of horizontal dotted lines
                            borderColor: 'transparent', // Hide y-axis grid lines
                            borderDash: [5, 5], // Set the border dash pattern (5 pixels on, 5 pixels off)
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                return '£' + value; // Add £ sign to y-axis ticks
                            }
                        }
                    }
                }
            }
        });
    }

    function fetchWeeklyExpensesByCategoryData() {
        fetch("{{ route('weekly-expenses-by-category') }}")
            .then(response => response.json())
            .then(data => {
                renderWeeklyExpensesByCategoryChart(data);
            })
            .catch(error => console.error('Error fetching weekly expenses by category data:', error));
    }

    function renderWeeklyExpensesByCategoryChart(data) {
        // Extract category labels and expenses data
        var categories = data.map(item => item.category);
        var expenses = data.map(item => item.total_amount);

        // Weekly Expenses by Category Data
        var weeklyExpensesByCategoryData = {
            labels: categories,
            datasets: [{
                label: 'Weekly Expenses',
                data: expenses,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        // Render Weekly Expenses by Category Chart as a bar chart
        var ctx = document.getElementById('weeklyExpensesByCategoryChart').getContext('2d');
        var weeklyExpensesByCategoryChart = new Chart(ctx, {
            type: 'bar', // Change chart type to 'bar'
            data: weeklyExpensesByCategoryData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return '£' + value; // Add £ sign to y-axis ticks
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)', // Set color of horizontal dotted lines
                            borderColor: 'transparent', // Hide y-axis grid lines
                            borderDash: [5, 5], // Set the border dash pattern (5 pixels on, 5 pixels off)
                        }
                    }
                }
            }
        });
    }

    function fetchUpcomingDirectDebitsSummary() {
        fetch("{{ route('upcoming-direct-debits') }}") // Ensure this route is correctly defined
            .then(response => response.json())
            .then(data => {
                document.getElementById('upcomingDirectDebitsCount').innerText = `${data.length} direct debit(s) this month`;

                if (data.length > 0) {
                    // Format the date to a readable string
                    const nextDirectDebitDate = new Date(data[0].reoccurance_date).toLocaleDateString('en-GB', {
                        year: 'numeric', month: 'long', day: 'numeric'
                    });
                    // Display both the name and the date of the next direct debit
                    document.getElementById('nextDirectDebitDate').innerText = `${data[0].name} on ${nextDirectDebitDate}`;
                } else {
                    document.getElementById('nextDirectDebitDate').innerText = 'No upcoming direct debits';
                }
            })
            .catch(error => console.error('Error fetching upcoming direct debits summary:', error));
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Existing fetch calls...
        fetchUpcomingDirectDebitsSummary(); // Fetch and display the summary of upcoming direct debits
    });

    function fetchDebtsWithinMonth() {
        fetch("{{ route('debts-within-month') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('debtsWithinMonth').innerText = `${data.length} debt(s) within the month`;

                if (data.length > 0) {
                    // Iterate through each debt and format the due date
                    let nextDebtInfo = "";
                    data.forEach(debt => {
                        // Check if the due_date is a valid date
                        const dueDate = new Date(debt.payback_deadline);
                        if (!isNaN(dueDate)) {
                            nextDebtInfo += `${debt.name} due on ${dueDate.toLocaleDateString('en-GB', {
                                year: 'numeric', month: 'long', day: 'numeric'
                            })}\n`;
                        } else {
                            nextDebtInfo += `${debt.name} due on Invalid Date\n`;
                        }
                    });
                    // Display the list of debts due within the month
                    document.getElementById('nextDebtsWithinMonth').innerText = nextDebtInfo;
                } else {
                    document.getElementById('nextDebtsWithinMonth').innerText = 'No debts due within the month';
                }
            })
            .catch(error => console.error('Error fetching debts within the month:', error));
    }

    document.addEventListener("DOMContentLoaded", function() {
        fetchDebtsWithinMonth(); // Fetch and display the debts due within the month
    });


    document.addEventListener("DOMContentLoaded", function() {
    fetchExpenseCategoriesForDoughnutChart();
});

function fetchExpenseCategoriesForDoughnutChart() {
    fetch("{{ route('expense-categories-for-doughnut-chart') }}")
        .then(response => response.json())
        .then(data => {
            renderDoughnutChart(data);
        })
        .catch(error => console.error('Error fetching expense categories for doughnut chart:', error));
}

function renderDoughnutChart(data) {
    var labels = data.map(item => item.category);
    var amounts = data.map(item => item.total_amount);

    var doughnutChartData = {
        labels: labels,
        datasets: [{
            data: amounts,
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                // Add more colors if needed
            ],
            borderColor: 'rgba(255, 255, 255, 1)',
            borderWidth: 1
        }]
    };

    var ctx = document.getElementById('expenseCategoriesDoughnutChart').getContext('2d');
    var expenseCategoriesDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: doughnutChartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom'
            }
        }
    });
}


</script>



