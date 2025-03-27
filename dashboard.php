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

    <!-- DataTables with all required extensions -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.1.1/css/scroller.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.1.1/js/dataTables.scroller.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>


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
                <div class="grid grid-cols-1 md:grid-cols-8 gap-3">
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
                    <div class="filter-item">
                        <label for="previousdate" class="block text-sm font-medium text-gray-700 mb-1">
                            Previous Date
                        </label>
                        <select name="previousdate" id="previousDate"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                            <option value="3">Week</option>
                            <option value="1">1 Day</option>
                            <option value="2">3 Day</option>
                            <option value="4">1 Month</option>
                            <option value="5">2 Months</option>
                            <option value="6">3 Months</option>
                            <option value="7">6 Months</option>
                            <option value="8">Year</option>
                        </select>
                    </div>
                    <div class="filter-item flex items-end">
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
                        data-tab="overall-scores">
                        Overall Scores
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-green-600"
                        data-tab="test-scores">
                        Test Scores
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-green-600"
                        data-tab="practice-scores">
                        Practice Scores
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-green-600"
                        data-tab="dispChart">
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
                            <!-- Data will be loaded dynamically -->
                        </table>
                    </div>
                </div>

                <!-- Overall Scores Tab -->
                <div id="overall-scores" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table id="overall-scores-table" class="min-w-full divide-y divide-gray-200">
                            <!-- Data will be loaded dynamically -->
                        </table>
                    </div>
                </div>

                <!-- Test Scores Tab -->
                <div id="test-scores" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table id="test-scores-table" class="min-w-full divide-y divide-gray-200">
                            <!-- Data will be loaded dynamically -->
                        </table>
                    </div>
                </div>

                <!-- Practice Scores Tab -->
                <div id="practice-scores" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table id="practice-scores-table" class="min-w-full divide-y divide-gray-200">
                            <!-- Data will be loaded dynamically -->
                        </table>
                    </div>
                </div>

                <!-- Chart Tab -->
                <div id="dispChart" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <input id="regSearch" type="text" placeholder="Enter Register No..."
                            class="border p-2 rounded w-full mb-4" />
                        <p><strong>Register Number:</strong> <span id="dispRegNo"></span></p>
                        <p><strong>Department:</strong> <span id="dispDept"></span></p>
                        <p><strong>Rank:</strong> <span id="dispRank"></span></p>

                        <div id="progressContainer" class="grid grid-cols-1 gap-6">
                            <!-- Progress bars will be dynamically inserted here -->
                        </div>
                    </div>
                </div>

                <!-- Passwords Tab -->
                <div id="passwords" class="tab-content hidden">
                    <div class="overflow-x-auto">
                        <table id="passwords-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Course Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Assessment Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Password
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quit Password
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Data will be loaded dynamically -->
                            </tbody>
                        </table>
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

    <style>
        table.dataTable th {
            background-color: #d1e7dd !important;
            border-left: 1.5px solid black !important;
            text-align: center !important;
        }

        table.dataTable td {
            border-left: 0.5px solid #ddd !important;
            border-bottom: 1.5px solid #ddd !important;
        }
    </style>

    <script>
        let globalFetchedData = null;
        let courseTotalScores = null;
        // Dashboard Data Renderer
        $(document).ready(function () {
            // Load initial data
            loadPasswordsTable();
            getTotalScores();


            $('.tab-btn').click(function () {
                // Remove active class from all buttons
                $('.tab-btn').removeClass('text-primary-600 border-primary-500').addClass('text-gray-500 border-transparent');
                // Add active class to clicked button
                $(this).addClass('text-primary-600 border-primary-500').removeClass('text-gray-500 border-transparent');

                // Hide all tab contents
                $('.tab-content').addClass('hidden');
                // Show the selected tab content
                const selectedTab = $(this).data('tab');
                $('#' + selectedTab).removeClass('hidden');

                // Check if the tab has a DataTable and adjust column widths
                setTimeout(() => {
                    const tableId = `#${selectedTab}-table`;
                    if ($.fn.DataTable.isDataTable(tableId)) {
                        $(tableId).DataTable().columns.adjust().draw();
                    }
                }, 100); // short delay allows DOM to finish rendering
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
                // Fetch and render data with filters
                filterDataWithCriteria(formData);
            });

            $('#previousDate').on('change', function () {
                const previousDate = $(this).val();
                fetchAndRenderAllData();
            });

            $('#regSearch').on('keypress', function (e) {
                if (e.which === 13) { // Enter key
                    const regNo = $(this).val();
                    renderDetailedProgress(regNo, courseTotalScores);
                }
            });
        });

        function getTotalScores(regNo) {
            $.ajax({
                url: 'fetch_chart.php',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    courseTotalScores = response.course_total;
                    console.log(courseTotalScores);
                    fetchAndRenderAllData();
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', error);
                    showError('Failed to fetch data.');
                    hideLoading();
                }
            });
        }

        function filterDataWithCriteria(criteria) {
            if (!globalFetchedData) return;

            const fieldMapping = {
                'course': 'programming',
                'graduationyear': 'graduation_year',
                // Add other mappings as needed
            };

            function filterRows(rows) {
                return rows.filter(row => {
                    return Object.keys(criteria).every(key => {
                        const searchValue = criteria[key].toLowerCase().trim();

                        // Get the mapped field name if it exists, or use the original
                        const mappedKey = fieldMapping[key.replace(/\s+/g, '').toLowerCase()] || key;

                        // Find matching property in row keys
                        const rowKey = Object.keys(row).find(rk =>
                            rk.replace(/\s+/g, '').toLowerCase() === mappedKey.replace(/\s+/g, '').toLowerCase()
                        );

                        if (!rowKey) return true; // If field not found, don't filter by this key
                        const rowValue = (row[rowKey] || '').toString().toLowerCase();
                        return rowValue === searchValue;
                    });
                });
            }
            const filteredCompletion = {
                headers: globalFetchedData.practice_scores.headers,
                rows: filterRows(globalFetchedData.practice_scores.rows)
            };
            const filteredPractice = {
                headers: globalFetchedData.practice_scores.headers,
                rows: filterRows(globalFetchedData.practice_scores.rows)
            };
            const filteredTest = {
                headers: globalFetchedData.test_scores.headers,
                rows: filterRows(globalFetchedData.test_scores.rows)
            };
            const filteredOverall = globalFetchedData.overall_scores ? {
                headers: globalFetchedData.overall_scores.headers,
                rows: filterRows(globalFetchedData.overall_scores.rows)
            } : null;

            renderCourseCompletionTable(filteredCompletion);
            renderTable('practice-scores', filteredPractice);
            renderTable('test-scores', filteredTest);
            if (filteredOverall) {
                renderTable('overall-scores', filteredOverall);
            }
        }

        function renderCourseCompletionTable(tableData) {
            if (!tableData || !tableData.headers || !tableData.rows) {
                console.error('Invalid data format for course completion table');
                return;
            }

            const tableContainer = $('#completed-students-table');
            tableContainer.empty();

            const tableId = 'course-completion-table';
            const table = $('<table>').attr('id', tableId).addClass('display nowrap w-full border-collapse min-w-max');
            const thead = $('<thead>').addClass('bg-gray-100');
            const tbody = $('<tbody>');

            // Dynamically determine subjects
            const subjects = ['PS', 'DS', 'DB', 'OOP'];

            // First header row - Main categories
            const headerRow1 = $('<tr>');
            headerRow1.append($('<th>').attr('rowspan', 3).addClass('border px-4 py-2 bg-white sticky top-0 z-30').text('Department'));
            headerRow1.append($('<th>').attr('rowspan', 3).addClass('border px-4 py-2 bg-white sticky top-0 z-30').text('Total Students'));
            thead.append(headerRow1);

            // Second header row - Subjects
            const headerRow2 = $('<tr>');
            subjects.forEach(subject => {
                headerRow2.append($('<th>').attr('colspan', 8).addClass('border px-4 py-2').text(subject));
            });
            thead.append(headerRow2);

            // Third header row - Levels
            const headerRow3 = $('<tr>');
            for (let i = 0; i < 4; i++) { // 4 subjects
                for (let j = 1; j <= 8; j++) {
                    headerRow3.append($('<th>').addClass('border px-4 py-2').text(`L${j}`));
                }
            }
            thead.append(headerRow3);

            table.append(thead);

            // Collect department totals and aggregate data
            const departmentTotals = {};
            const departmentCompletedYesterday = {};
            const aggregatedData = {};
            const aggregatedCompletedYesterday = {};

            // Process rows to aggregate data
            tableData.rows.forEach(rowData => {
                const dept = rowData.department || 'Unknown';

                // Count total students per department
                if (!departmentTotals[dept]) {
                    departmentTotals[dept] = 1;
                    departmentCompletedYesterday[dept] = 0;
                } else {
                    departmentTotals[dept]++;
                }

                // Initialize department in aggregatedData if not exists
                if (!aggregatedData[dept]) {
                    aggregatedData[dept] = { department: dept };
                    aggregatedCompletedYesterday[dept] = { department: dept };
                }

                // Process each subject
                subjects.forEach(subject => {
                    // Process each level from L1 to L8
                    for (let level = 1; level <= 8; level++) {
                        const key = `L${level} - Practice - ${subject}`;
                        const diffKey = `${key}_diff`;

                        // Check if student completed the column
                        if (rowData[key] && parseFloat(rowData[key]) > 0) {
                            // Initialize the key if not exists
                            if (!aggregatedData[dept][key]) {
                                aggregatedData[dept][key] = 0;
                                aggregatedCompletedYesterday[dept][key] = 0;
                            }
                            aggregatedData[dept][key]++;

                            // Check if completed in previous day (diff is positive)
                            if (rowData[diffKey] && parseFloat(rowData[diffKey]) > 0) {
                                aggregatedCompletedYesterday[dept][key]++;
                                departmentCompletedYesterday[dept]++;
                            }
                        }
                    }
                });
            });

            // Render rows
            Object.values(aggregatedData).forEach(rowData => {
                const row = $('<tr>').addClass('hover:bg-gray-100');
                const dept = rowData.department;

                // Department column with total students
                const totalStudents = departmentTotals[dept] || 0;
                row.append($('<td>').addClass('border px-4 py-2 sticky left-0 bg-white z-20').text(dept));
                row.append($('<td>').addClass('border px-4 py-2 sticky left-20 bg-white z-20 text-center').text(totalStudents));

                // Subject columns
                subjects.forEach(subject => {
                    // Process each level from L1 to L8
                    for (let level = 1; level <= 8; level++) {
                        const key = `L${level} - Practice - ${subject}`;
                        const value = aggregatedData[dept][key] || 0;
                        const completedYesterday = aggregatedCompletedYesterday[dept][key] || 0;

                        row.append($('<td>').addClass('border px-4 py-2 text-center')
                            .html(completedYesterday > 0
                                ? `${value} <span class="text-sm text-green-600">(+${completedYesterday})</span>`
                                : `${value}`)
                        );
                    }
                });

                tbody.append(row);
            });

            table.append(tbody);

            const scrollContainer = $('<div>').addClass('overflow-x-auto max-w-full');
            scrollContainer.append(table);
            tableContainer.append(scrollContainer);

            // Initialize DataTable with no pagination
            setTimeout(() => {
                $(`#${tableId}`).DataTable({
                    scrollX: true,
                    scrollY: '400px',
                    scrollCollapse: true,
                    paging: false,
                    fixedHeader: {
                        header: true
                    },
                    fixedColumns: {
                        left: 2
                    },
                    autoWidth: false,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'colvis',
                            className: 'bg-primary-600 text-white rounded px-3 py-1 text-sm',
                            text: 'Toggle Columns'
                        },
                        {
                            extend: 'csv',
                            className: 'bg-primary-600 text-white rounded px-3 py-1 text-sm ml-2',
                            text: 'Export CSV'
                        }
                    ],
                    language: {
                        search: "Filter:",
                        info: "Showing _TOTAL_ entries",
                        infoEmpty: "No entries found",
                        infoFiltered: "(filtered from _MAX_ total entries)"
                    },
                    initComplete: function () {
                        $('.dt-buttons').addClass('mb-4');
                        this.api().columns.adjust().draw();
                    }
                });
            }, 100);
            $(window).on('resize', function () {
                dataTable.columns.adjust();
            });
        }

        function fetchAndRenderAllData() {
            // Show loading indicator
            showLoading();
            $previousDate = $('#previousDate').val();
            // Fetch data from server
            $.ajax({
                url: 'fetch_scores.php?previousDate=' + $previousDate,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        globalFetchedData = response.data; // store data globally
                        renderTable('practice-scores', response.data.practice_scores);
                        renderTable('test-scores', response.data.test_scores);
                        renderTable('overall-scores', response.data.overall_scores);
                        // Pass practice_scores instead of course_completion
                        renderCourseCompletionTable(response.data.practice_scores);
                        hideLoading();
                    } else {
                        console.error('Error in API response:', response);
                        showError('Failed to load data. Please try again.');
                        hideLoading();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', error);
                    showError('Error connecting to server. Please check your connection and try again.');
                    hideLoading();
                }
            });
        }

        function getDiffColor(value) {
            // Clamp value between 0 and 10
            const clamped = Math.min(Math.max(value, 0), 10);
            let r, g;
            if (clamped <= 5) {
                // Red to Yellow
                r = 200;
                g = Math.round((clamped / 5) * 200);
            } else {
                // Yellow to Green
                r = Math.round(200 - ((clamped - 5) / 5) * 200);
                g = 200;
            }
            return `rgb(${r}, ${g}, 0)`;
        }

        // Function to render each table with DataTables
        function renderTable(tableId, tableData) {
            if (!tableData || !tableData.headers || !tableData.rows) {
                return;
            }

            const tableContainer = $(`#${tableId}-table`);

            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable(tableContainer)) {
                tableContainer.DataTable().destroy();
            }

            tableContainer.empty();

            // Columns to hide
            const columnsToHide = [
                'institution',
                'department',
                'section',
                'batch',
                'programming',
                'graduation_year'
            ];

            // Process headers to create column definitions that correctly handle diff values
            const renderDiffColumn = function (header) {
                const diffHeader = `${header}_diff`;
                return function (data, type, row) {
                    if (type === 'display') {
                        const diffValue = row[diffHeader];

                        // Type conversion and validation
                        const numericDiffValue = diffValue !== null && diffValue !== undefined
                            ? Number(diffValue)
                            : null;

                        // Render only if we have a meaningful numeric value
                        if (numericDiffValue !== null && !isNaN(numericDiffValue) && numericDiffValue !== 0) {
                            const formattedDiff = numericDiffValue > 0
                                ? `+${numericDiffValue}`
                                : `${numericDiffValue}`;
                            const color = getDiffColor(Math.abs(numericDiffValue));
                            return `${data} <span style="color: ${color}; font-weight: bold;">(${formattedDiff})</span>`;
                        }
                    }
                    return data;
                };
            };

            // Prepare columns and column definitions
            const columns = [];
            const columnDefs = [];

            tableData.headers.forEach((header, index) => {
                if (!header.includes('_diff')) {
                    const diffHeader = `${header}_diff`;

                    const columnDefinition = {
                        data: header,
                        title: formatHeaderText(header),
                        visible: !columnsToHide.includes(header)
                    };

                    // If there's a corresponding diff header, add custom rendering
                    if (tableData.headers.includes(diffHeader)) {
                        columnDefinition.render = renderDiffColumn(header);
                    }

                    columns.push(columnDefinition);
                }
            });

            // Initialize DataTable
            const dataTable = tableContainer.DataTable({
                data: tableData.rows,
                columns: columns,
                responsive: false,
                scrollX: true,
                scrollY: '400px',
                scrollCollapse: true,
                paging: true,
                scroller: true,
                dom: 'Bfrtip',
                deferRender: true,
                buttons: [
                    {
                        extend: 'colvis',
                        className: 'bg-primary-600 text-white rounded px-3 py-1 text-sm',
                        text: 'Toggle Columns'
                    },
                    {
                        extend: 'csv',
                        className: 'bg-primary-600 text-white rounded px-3 py-1 text-sm ml-2',
                        text: 'Export CSV'
                    }
                ],
                language: {
                    search: "Filter:",
                    info: "Showing _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                },
                fixedHeader: true,
                fixedColumns: {
                    leftColumns: 1
                },
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass('hover:bg-green-100'); // Tailwind hover effect for row
                },
                initComplete: function () {
                    $('.dt-buttons').addClass('mb-4');
                    $(`.dataTables_wrapper`).css('overflow-x', 'auto');
                    this.api().columns.adjust().draw();
                }
            });

            // Add custom search input above the table
            const searchContainer = $('<div>').addClass('mb-4 flex items-center');
            const searchLabel = $('<label>').addClass('mr-2 text-sm text-gray-700').text('Search:');
            const searchInput = $('<input>')
                .addClass('border rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500')
                .attr('type', 'search')
                .attr('placeholder', 'Type to filter...');

            searchContainer.append(searchLabel, searchInput);
            tableContainer.before(searchContainer);

            // Bind search input to DataTable
            searchInput.on('keyup', function () {
                dataTable.search(this.value).draw();
            });

            // Ensure columns adjust properly on window resize
            $(window).on('resize', function () {
                dataTable.columns.adjust();
            });
        }

        // Format header text for better readability
        function formatHeaderText(header) {
            // Replace hyphens with spaces, swap words, and capitalize first letter of each word
            return header
                .replace(/_/g, ' ')
                .replace(/-/g, ' ')
                .replace(/Practice/, ' ')
                .replace(/Test/, ' ')
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .reverse() // Swap words by reversing the array
                .join(' ');
        }

        function renderDetailedProgress(regNo, courseTotalScores) {
            const practiceData = globalFetchedData.practice_scores.rows.find(row => row.username === regNo);
            const testData = globalFetchedData.test_scores.rows.find(row => row.username === regNo);
            const overallData = globalFetchedData.overall_scores.rows.find(row => row.username === regNo);

            if (!practiceData || !testData) {
                alert('No data found for this register number');
                return;
            }

            // Display rank & department
            document.getElementById('dispRegNo').innerText = regNo;
            document.getElementById('dispDept').innerText = practiceData.department || "N/A";
            document.getElementById('dispRank').innerText = overallData.overall_rank || "N/A";

            const levels = ["L1", "L2", "L3", "L4", "L5", "L6", "L7", "L8"];
            const subjects = ["PS", "DS", "DB", "OOP"];

            // Create main container
            const progressContainer = document.getElementById('progressContainer');
            progressContainer.innerHTML = ''; // Clear previous content
            progressContainer.className = 'grid grid-cols-1 md:grid-cols-2 gap-6';

            // Practice Scores Section
            const practiceSection = document.createElement('div');
            practiceSection.className = 'bg-white p-6 rounded-lg shadow-md';
            practiceSection.innerHTML = `
        <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Practice Scores</h3>
    `;

            // Test Scores Section
            const testSection = document.createElement('div');
            testSection.className = 'bg-white p-6 rounded-lg shadow-md';
            testSection.innerHTML = `
        <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Test Scores</h3>
    `;

            // Process each subject
            subjects.forEach((subject, index) => {
                // Practice Score Calculation
                const practiceSubjectDetails = createSubjectScoreDetails(
                    subject,
                    'Practice',
                    levels,
                    practiceData,
                    courseTotalScores,
                    ['bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-red-500'][index]
                );
                practiceSection.appendChild(practiceSubjectDetails);

                // Test Score Calculation
                const testSubjectDetails = createSubjectScoreDetails(
                    subject,
                    'Test',
                    levels,
                    testData,
                    courseTotalScores,
                    ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-red-600'][index]
                );
                testSection.appendChild(testSubjectDetails);
            });

            // Append sections to container
            progressContainer.appendChild(practiceSection);
            progressContainer.appendChild(testSection);
        }

        function createSubjectScoreDetails(subject, type, levels, studentData, courseTotalScores, progressColor) {
            // Create subject container
            const subjectContainer = document.createElement('div');
            subjectContainer.className = 'mb-6';

            // Calculate total scores
            const subjectTotalScore = courseTotalScores
                .filter(course => course.course_name.includes(`${type} - ${subject}`))
                .reduce((sum, course) => sum + parseInt(course.total_score), 0);

            const studentSubjectScores = levels.map(level => {
                const score = parseInt(studentData[`${level} - ${type} - ${subject}`] || 0);
                const totalLevelScore = courseTotalScores
                    .find(course => course.course_name === `${level} - ${type} - ${subject}`)?.total_score || 0;
                return { level, score, totalLevelScore };
            });

            const studentScore = studentSubjectScores.reduce((sum, item) => sum + item.score, 0);
            const percentage = subjectTotalScore > 0
                ? ((studentScore / subjectTotalScore) * 100).toFixed(2)
                : 0;

            // Subject header
            const subjectHeader = document.createElement('div');
            subjectHeader.className = 'flex justify-between items-center mb-3';
            subjectHeader.innerHTML = `
        <h4 class="text-lg font-semibold text-gray-700">${subject} ${type}</h4>
        <span class="text-sm font-medium text-gray-600">
            ${studentScore} / ${subjectTotalScore} (${percentage}%)
        </span>
    `;
            subjectContainer.appendChild(subjectHeader);

            // Progress bar
            const progressContainer = document.createElement('div');
            progressContainer.className = 'w-full bg-gray-200 rounded-full h-4 overflow-hidden mb-4';
            const progressBar = document.createElement('div');
            progressBar.className = `h-4 rounded-full ${progressColor} transition-all duration-500 ease-in-out`;
            progressBar.style.width = `${percentage}%`;
            progressContainer.appendChild(progressBar);
            subjectContainer.appendChild(progressContainer);

            // Detailed level scores
            const levelsDetailsContainer = document.createElement('div');
            levelsDetailsContainer.className = 'space-y-2';

            studentSubjectScores.forEach(levelScore => {
                const levelScoreItem = document.createElement('div');
                levelScoreItem.className = 'flex justify-between items-center text-sm';

                const percentage = levelScore.totalLevelScore > 0
                    ? ((levelScore.score / levelScore.totalLevelScore) * 100).toFixed(2)
                    : 0;

                levelScoreItem.innerHTML = `
            <span class="text-gray-600">${levelScore.level}</span>
            <span class="text-gray-800">
                ${levelScore.score} / ${levelScore.totalLevelScore} (${percentage}%)
            </span>
        `;
                levelsDetailsContainer.appendChild(levelScoreItem);
            });

            subjectContainer.appendChild(levelsDetailsContainer);

            return subjectContainer;
        }
        // Function to load passwords table
        function loadPasswordsTable() {
            // Fetch password data from a separate endpoint
            $.ajax({
                url: 'get_passwords.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Check if DataTable already exists and destroy it before reinitializing
                    if ($.fn.DataTable.isDataTable('#passwords-table')) {
                        $('#passwords-table').DataTable().destroy();
                    }

                    // Clear the table body
                    const tableBody = $('#passwords-table tbody');
                    tableBody.empty();

                    // Populate the table with data
                    data.forEach(item => {
                        tableBody.append(`
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.courseName}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.assessmentName}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.Password}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.QuitPassword}</td>
                    </tr>
                `);
                    });

                    // Add a container for the export buttons above the table
                    if ($('#datatable-buttons').length === 0) {
                        $('#passwords-table').before('<div id="datatable-buttons" class="mb-4 flex"></div>');
                    }

                    // Initialize DataTable with export buttons
                    $('#passwords-table').DataTable({
                        dom: '<"flex justify-between items-center mb-4"<"flex-1"f><"flex"B>>rt<"flex justify-between"<"flex-1"i><"flex"p>>',
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'Export to Excel',
                                className: 'px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 mr-2',
                                title: 'Passwords Data',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'pdf',
                                text: 'Export to PDF',
                                className: 'px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500',
                                title: 'Passwords Data',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            }
                        ],
                        pageLength: 25,
                        responsive: true,
                        language: {
                            search: "Search:",
                            lengthMenu: "Show _MENU_ entries",
                            info: "Showing _START_ to _END_ of _TOTAL_ entries",
                            infoEmpty: "Showing 0 to 0 of 0 entries",
                            infoFiltered: "(filtered from _MAX_ total entries)"
                        },
                        // Preserve your Tailwind styling
                        drawCallback: function () {
                            // Ensure Tailwind classes are preserved after DataTable initialization
                            $('#passwords-table thead th').addClass('px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider');
                            $('#passwords-table tbody td').addClass('px-6 py-4 whitespace-nowrap text-sm text-gray-500');
                        }
                    });

                    // Move buttons into custom container for better positioning
                    $('.dt-buttons').appendTo('#datatable-buttons').removeClass('dt-buttons').addClass('flex');
                },
                error: function () {
                    const tableBody = $('#passwords-table tbody');
                    tableBody.html('<tr><td colspan="4" class="px-6 py-4 text-center text-sm text-red-500">Error loading password data</td></tr>');
                }
            });
        }

        // Helper functions for UI feedback
        function showLoading() {
            if ($('.loading-overlay').length === 0) {
                $('body').append(`
            <div class="loading-overlay fixed inset-0 bg-white/70 backdrop-blur-sm z-[9999] flex items-center justify-center">
                <div class="flex flex-col items-center gap-3">
                    <svg class="animate-spin h-10 w-10 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z"></path>
                    </svg>
                    <span class="text-primary-600 text-lg font-semibold">Loading data...</span>
                </div>
            </div>
        `);
            }
        }

        function hideLoading() {
            $('.loading-overlay').remove();
        }


        function showError(message) {
            // Display error message to user
            alert(message);
        }

    </script>
</body>

</html>