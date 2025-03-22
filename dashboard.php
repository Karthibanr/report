<?php include 'filters.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
    <!-- jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Chart.js for charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-primary-800 text-white shadow-md">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <h1 class="text-xl font-bold text-white">Dashboard</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="infoButton"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-primary-800 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Info
                    </button>
                    <button id="logoutButton"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="w-full py-6 px-4 sm:px-6 lg:px-8">
        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form id="filterForm" class="filter-container">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4">
                    <?php foreach ($filters as $key => $filter): ?>
                        <div class="filter-item">
                            <label for="<?php echo $key; ?>" class="block text-sm font-medium text-gray-700 mb-1">
                                <?php echo ucfirst($key); ?>
                            </label>
                            <select name="<?php echo $key; ?>" id="<?php echo $key; ?>"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                                <option value="">All <?php echo ucfirst($key); ?></option>
                                <?php foreach ($filter as $value): ?>
                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endforeach; ?>
                    <div class="mt-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
   
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200 mt-6">
                <nav class="-mb-px flex space-x-8 overflow-x-auto">
                    <button
                        class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-primary-500 font-medium text-sm text-primary-600 hover:text-green-600 active"
                        data-tab="completed-students">
                        Course Completion
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-green-600"
                        data-tab="test-scores">
                        Test Scores
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-green-600"
                        data-tab="progression">
                        Score Progression
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-green-600"
                        data-tab="chart">
                        Score Chart
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-green-600"
                        data-tab="passwords">
                        Passwords
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="mt-6">
                <!-- Completed Students Tab -->
                <div id="completed-students" class="tab-content">
                    <div class="overflow-x-auto">
                        <table id="completed-students-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Course</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Completion Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Data will be loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Test Scores Tab -->
                <div id="test-scores" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table id="test-scores-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Test Type</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Score</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Percentile</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Data will be loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Placement Completion Tab -->
                <div id="placement-completion" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table id="placement-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Company</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Position</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Data will be loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Progression Tab -->
                <div id="progression" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table id="progression-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Current Level</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Progress</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Next Milestone</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Data will be loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Chart Tab -->
                <div id="chart" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Student Performance</h3>
                            <canvas id="performanceChart" height="300"></canvas>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Placement Statistics</h3>
                            <canvas id="placementChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                 <!-- Passwords Tab -->
                 <div id="passwords" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <?php include 'displayPassword.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Info Modal -->
    <div id="infoModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Dashboard Information
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    This dashboard provides comprehensive information about student performance, test
                                    scores, placement status, and progression. Use the filters at the top to narrow down
                                    the data based on specific criteria.
                                </p>
                                <p class="text-sm text-gray-500 mt-2">
                                    The tabs allow you to navigate between different views of student data. The charts
                                    tab provides visual representations of key metrics.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="close-modal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutConfirmModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Logout Confirmation
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to logout? Your session will be ended.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmLogout"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Logout
                    </button>
                    <button type="button"
                        class="close-modal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample data (would normally be fetched from a backend API)
        const studentData = {
            "completedStudents": [
                { "id": "STD001", "name": "Jane Smith", "course": "Computer Science", "completionDate": "03/15/2025", "status": "Completed" },
                { "id": "STD002", "name": "John Doe", "course": "Data Science", "completionDate": "02/28/2025", "status": "Completed" },
                { "id": "STD003", "name": "Alex Johnson", "course": "Mathematics", "completionDate": "01/10/2025", "status": "Completed" },
                { "id": "STD004", "name": "Maria Garcia", "course": "Electrical Engineering", "completionDate": "03/05/2025", "status": "Completed" },
                { "id": "STD005", "name": "Robert Williams", "course": "Physics", "completionDate": "02/15/2025", "status": "Completed" }
            ],
            "testScores": [
                { "id": "STD001", "name": "Jane Smith", "testType": "Midterm", "score": 89, "percentile": "92%" },
                { "id": "STD002", "name": "John Doe", "testType": "Final", "score": 95, "percentile": "98%" },
                { "id": "STD003", "name": "Alex Johnson", "testType": "Midterm", "score": 82, "percentile": "84%" },
                { "id": "STD003", "name": "Alex Johnson", "testType": "Final", "score": 88, "percentile": "90%" },
                { "id": "STD004", "name": "Maria Garcia", "testType": "Midterm", "score": 91, "percentile": "94%" }
            ],
            "placementData": [
                { "id": "STD001", "name": "Jane Smith", "company": "Tech Solutions Inc", "position": "Software Engineer", "status": "Completed" },
                { "id": "STD002", "name": "John Doe", "company": "Data Analysts Co", "position": "Data Scientist", "status": "In Progress" },
                { "id": "STD003", "name": "Alex Johnson", "company": "Research Lab", "position": "Research Assistant", "status": "Completed" },
                { "id": "STD004", "name": "Maria Garcia", "company": "Energy Solutions", "position": "Electrical Engineer", "status": "In Progress" },
                { "id": "STD005", "name": "Robert Williams", "company": "Physics Institute", "position": "Research Fellow", "status": "Not Started" }
            ],
            "progressionData": [
                { "id": "STD001", "name": "Jane Smith", "level": "Advanced", "progress": 85, "nextMilestone": "Final Project" },
                { "id": "STD002", "name": "John Doe", "level": "Intermediate", "progress": 60, "nextMilestone": "Advanced Module" },
                { "id": "STD003", "name": "Alex Johnson", "level": "Beginner", "progress": 40, "nextMilestone": "Intermediate Assessment" },
                { "id": "STD004", "name": "Maria Garcia", "level": "Advanced", "progress": 90, "nextMilestone": "Graduation" },
                { "id": "STD005", "name": "Robert Williams", "level": "Intermediate", "progress": 70, "nextMilestone": "Advanced Module" }
            ],
            "chartData": {
                "performance": {
                    "labels": ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                    "data": [75, 82, 79, 85, 88, 90]
                },
                "placement": {
                    "labels": ["Placed", "In Progress", "Not Started"],
                    "data": [65, 25, 10]
                }
            }
        };

        $(document).ready(function () {
            // Load initial data
            loadData(studentData);

            // Tab functionality
            $('.tab-btn').click(function () {
                // Remove active class from all buttons
                $('.tab-btn').removeClass('text-primary-600 border-primary-500').addClass('text-gray-500 border-transparent');
                // Add active class to clicked button
                $(this).addClass('text-primary-600 border-primary-500').removeClass('text-gray-500 border-transparent');

                // Hide all tab contents
                $('.tab-content').addClass('hidden');
                // Show the selected tab content
                $('#' + $(this).data('tab')).removeClass('hidden');

                // If chart tab is selected, initialize charts
                if ($(this).data('tab') === 'chart') {
                    initializeCharts(studentData.chartData);
                }
            });

            // Modal functionality
            $('#infoButton').click(function () {
                $('#infoModal').removeClass('hidden');
            });

            $('#logoutButton').click(function () {
                $('#logoutConfirmModal').removeClass('hidden');
            });

            $('.close-modal').click(function () {
                $('#infoModal, #logoutConfirmModal').addClass('hidden');
            });

            $('#confirmLogout').click(function () {
                // Send logout request
                $.post('logout.php', function () {
                    window.location.href = 'login.php'; // Redirect to login page
                });
            });

            // Filter form submission
            $('#filterForm').on('submit', function (e) {
                e.preventDefault();

                // Get form data
                const formData = {};
                $(this).serializeArray().forEach(item => {
                    if (item.value) formData[item.name] = item.value;
                });

                // In a real application, you would make an AJAX request to get filtered data
                // For this example, we'll just filter the client-side data
                const filteredData = filterData(studentData, formData);
                loadData(filteredData);

                // Update charts if chart tab is visible
                if (!$('#chart').hasClass('hidden')) {
                    initializeCharts(filteredData.chartData);
                }
            });

            // Initialize charts if chart tab is active by default
            if (!$('#chart').hasClass('hidden')) {
                initializeCharts(studentData.chartData);
            }
        });

        // Function to filter data based on form inputs
        function filterData(data, filters) {
            // This is a simplified example. In a real application, 
            // you would implement proper filtering logic

            // For demonstration purposes, we're returning the original data
            // In a real implementation, you would filter each data set based on the filters
            return data;
        }

        // Function to load data into tables
        function loadData(data) {
            // Load completed students data
            loadCompletedStudentsTable(data.completedStudents);

            // Load test scores data
            loadTestScoresTable(data.testScores);

            // Load placement data
            loadPlacementTable(data.placementData);

            // Load progression data
            loadProgressionTable(data.progressionData);
        }

        // Function to load completed students table
        function loadCompletedStudentsTable(data) {
            const tableBody = $('#completed-students-table tbody');
            tableBody.empty();

            data.forEach(student => {
                tableBody.append(`
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${student.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${student.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${student.course}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${student.completionDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            ${student.status}
                        </span>
                    </td>
                </tr>
            `);
            });
        }

        // Function to load test scores table
        function loadTestScoresTable(data) {
            const tableBody = $('#test-scores-table tbody');
            tableBody.empty();

            data.forEach(score => {
                tableBody.append(`
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${score.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${score.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${score.testType}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${score.score}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${score.percentile}</td>
                </tr>
            `);
            });
        }

        // Function to load placement table
        function loadPlacementTable(data) {
            const tableBody = $('#placement-table tbody');
            tableBody.empty();

            data.forEach(placement => {
                const statusClass = placement.status === 'Completed'
                    ? 'bg-green-100 text-green-800'
                    : placement.status === 'In Progress'
                        ? 'bg-yellow-100 text-yellow-800'
                        : 'bg-gray-100 text-gray-800';
                tableBody.append(`
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${placement.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${placement.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${placement.company}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${placement.position}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                            ${placement.status}
                        </span>
                    </td>
                </tr>
            `);
            });
        }

        // Function to load progression table
        function loadProgressionTable(data) {
            const tableBody = $('#progression-table tbody');
            tableBody.empty();

            data.forEach(progression => {
                tableBody.append(`
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${progression.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${progression.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${progression.level}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-primary-600 h-2.5 rounded-full" style="width: ${progression.progress}%"></div>
                        </div>
                        <span class="text-xs text-gray-500">${progression.progress}%</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${progression.nextMilestone}</td>
                </tr>
            `);
            });
        }

        // Function to initialize charts
        function initializeCharts(data) {
            // Performance Chart
            const performanceCtx = document.getElementById('performanceChart').getContext('2d');
            const performanceChart = new Chart(performanceCtx, {
                type: 'line',
                data: {
                    labels: data.performance.labels,
                    datasets: [{
                        label: 'Average Performance Score',
                        data: data.performance.data,
                        backgroundColor: 'rgba(22, 101, 52, 0.2)',
                        borderColor: 'rgba(22, 101, 52, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 50,
                            max: 100
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `Score: ${context.parsed.y}`;
                                }
                            }
                        }
                    }
                }
            });

            // Placement Chart
            const placementCtx = document.getElementById('placementChart').getContext('2d');
            const placementChart = new Chart(placementCtx, {
                type: 'doughnut',
                data: {
                    labels: data.placement.labels,
                    datasets: [{
                        data: data.placement.data,
                        backgroundColor: [
                            'rgba(22, 101, 52, 0.7)',
                            'rgba(250, 204, 21, 0.7)',
                            'rgba(107, 114, 128, 0.7)'
                        ],
                        borderColor: [
                            'rgba(22, 101, 52, 1)',
                            'rgba(250, 204, 21, 1)',
                            'rgba(107, 114, 128, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.label}: ${context.parsed}%`;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>