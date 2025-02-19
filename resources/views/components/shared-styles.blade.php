<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #858796;
        --success-color: #1cc88a;
    }

    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-family: 'Figtree', sans-serif;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .btn {
        border-radius: 50px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    .btn-gradient {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--success-color) 100%);
        border: none;
        color: white;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        color: white;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #e0e0e0;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        border-color: #4e73df;
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 50px;
    }

    /* Dark Mode Styles */
    .dark-mode {
        background: linear-gradient(135deg, #1a1c23 0%, #242631 100%);
        color: #fff;
    }

    .dark-mode .card {
        background-color: #2c3040;
        border-color: #363a4f;
    }

    .dark-mode .form-control,
    .dark-mode .form-select {
        background-color: #363a4f;
        border-color: #4a4f6b;
        color: #fff;
    }

    .dark-mode .table {
        color: #fff;
        background-color: #2c3040;
    }

    .dark-mode .table td,
    .dark-mode .table th {
        border-color: #363a4f;
    }

    /* Animation Classes */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    .slide-up {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Theme Transition Styles */
    body, .card, .navbar, .form-control, .form-select, .table, 
    .btn, .badge, .chart-container, #calendar {
        transition: all 0.3s ease-in-out;
    }

    /* Dark Mode Calendar Overrides */
    .dark-mode #calendar {
        background-color: #2c3040;
        border-color: #363a4f;
    }

    .dark-mode .fc-theme-standard td,
    .dark-mode .fc-theme-standard th {
        border-color: #363a4f;
    }

    .dark-mode .fc-toolbar-title,
    .dark-mode .fc-daygrid-day-number,
    .dark-mode .fc-col-header-cell-cushion {
        color: #fff;
    }

    .dark-mode .fc-button-primary {
        background-color: #363a4f !important;
        border-color: #4a4f6b !important;
    }

    .dark-mode .fc-button-active {
        background-color: #4e73df !important;
    }

    /* Dark Mode Chart Overrides */
    .dark-mode .chart-container {
        background-color: #2c3040;
        border-color: #363a4f;
    }
</style>
