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

    <script>
        // Dashboard Data Renderer
        $(document).ready(function () {
            // Load initial data
            loadPasswordsTable();
            fetchAndRenderAllData();

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
                fetchAndRenderAllData(formData);
            });
        });

        // Function to fetch and render all data tables
        function fetchAndRenderAllData(filters = {}) {
            // Show loading indicator
            showLoading();

            // Build query string from filters
            const queryParams = new URLSearchParams();
            Object.entries(filters).forEach(([key, value]) => {
                queryParams.append(key, value);
            });

            const queryString = queryParams.toString() ? '?' + queryParams.toString() : '';

            // Fetch data from server
            $.ajax({
                url: 'fetch_scores.php' + queryString,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Render each table with its respective data
                        renderTable('completed-students', response.data.course_completion);
                        renderTable('practice-scores', response.data.practice_scores);
                        renderTable('test-scores', response.data.test_scores);
                        if (response.data.overall_scores) {
                            renderTable('overall-scores', response.data.overall_scores);
                        }

                        // Hide loading indicator
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

        // Function to render each table with DataTables
        function renderTable(tableId, tableData) {
            if (!tableData || !tableData.headers || !tableData.rows) {
                console.error(`Invalid data format for table ${tableId}`);
                return;
            }

            const tableContainer = $(`#${tableId}-table`);

            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable(tableContainer)) {
                tableContainer.DataTable().destroy();
            }

            tableContainer.empty();

            // Process headers to create column definitions that correctly handle diff values
            const columnDefs = [];
            const baseHeaders = [];

            tableData.headers.forEach(header => {
                if (!header.includes('_diff')) {
                    baseHeaders.push(header);

                    // Check if there's a corresponding diff header
                    const diffHeader = `${header}_diff`;
                    if (tableData.headers.includes(diffHeader)) {
                        columnDefs.push({
                            targets: baseHeaders.length - 1,
                            data: header,
                            title: formatHeaderText(header),
                            render: function (data, type, row) {
                                if (type === 'display') {
                                    const diffValue = row[diffHeader];
                                    if (diffValue !== undefined && diffValue !== null && diffValue !== 0) {
                                        const formattedDiff = diffValue > 0 ? `+${diffValue}` : diffValue;
                                        return `${data} (${formattedDiff})`;
                                    }
                                }
                                return data;
                            }
                        });
                    } else {
                        columnDefs.push({
                            targets: baseHeaders.length - 1,
                            data: header,
                            title: formatHeaderText(header)
                        });
                    }
                }
            });

            // Initialize DataTable with horizontal scrolling and custom rendering
            const dataTable = tableContainer.DataTable({
                data: tableData.rows,
                columns: baseHeaders.map(header => {
                    return { data: header, title: formatHeaderText(header) };
                }),
                columnDefs: columnDefs,
                responsive: false, // Disable responsive to ensure horizontal scrolling works
                scrollX: true,     // Enable horizontal scrolling
                scrollY: '400px',  // Fixed height for vertical scrolling
                scrollCollapse: true,
                paging: true,     // Disable pagination for scrolling
                scroller: true,    // Enable virtual scrolling for performance
                dom: 'Bfrtip',     // Button, filter, processing display elements
                deferRender: true, // Improve performance with large datasets
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
                    // Add custom styling to buttons
                    $('.dt-buttons').addClass('mb-4');

                    // Ensure horizontal scrollbar is visible when needed
                    $(`.dataTables_wrapper`).css('overflow-x', 'auto');

                    // Fix header width issues
                    this.api().columns.adjust();
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
            // Replace hyphens with spaces and capitalize first letter of each word
            return header
                .replace(/_/g, ' ')
                .replace(/-/g, ' ')
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        }

        // Function to load passwords table
        function loadPasswordsTable() {
            // Fetch password data from a separate endpoint
            $.ajax({
                url: 'get_passwords.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    const tableBody = $('#passwords-table tbody');
                    tableBody.empty();

                    data.forEach(item => {
                        tableBody.append(`
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.course_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.assessment_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.password}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.quit_password}</td>
                    </tr>
                `);
                    });
                },
                error: function () {
                    const tableBody = $('#passwords-table tbody');
                    tableBody.html('<tr><td colspan="4" class="px-6 py-4 text-center text-sm text-red-500">Error loading password data</td></tr>');
                }
            });
        }

        // Helper functions for UI feedback
        function showLoading() {
            // Add a loading indicator to the active tab
            $('.tab-content:not(.hidden)').append('<div class="loading-overlay flex items-center justify-center p-4"><span class="text-primary-600">Loading data...</span></div>');
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