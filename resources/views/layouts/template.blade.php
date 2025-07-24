<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark" id="theme-root">
<head>
    <!-- Required meta tags  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="application-name" content="Bubblemart">
    <meta name="apple-mobile-web-app-title" content="Bubblemart">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-icon" href="{{ asset('template-assets/img/logo-512.png') }}">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name', 'Bubblemart') }} - Gift Delivery Service</title>
    <meta name="description" content="Delivering happiness to your loved ones with our curated selection of gifts from the best brands and stores.">
    <link rel="icon" type="image/png" href="{{ asset('template-assets/img/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarala:wght@400;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            /* Bubblemart Color Palette */
            --main-color: #004953; /* Deep Teal - Main Brand Color */
            --accent-green: #00A86B; /* Green - Success/Positive */
            --accent-light-green: #A8E4A0; /* Light Green - Secondary */
            --accent-orange: #FCA488; /* Orange - Warning/Highlight */
            --accent-red: #F94943; /* Red - Error/Alert */
            
            /* Theme Variables - Dark Mode (Default) - Keep Original */
            --bg-primary: #000; /* Template's theme-black bg-1 */
            --bg-secondary: rgb(34, 33, 36); /* Template's theme-black bg-2 */
            --bg-card: rgba(27, 25, 25, 0.18); /* Template's theme-black bs-dd-bg */
            --bg-surface: #1b1d25;
            --border-color: #333; /* Darker border for black theme */
            --text-primary: #ffffff;
            --text-secondary: #adb5bd;
            --text-muted: #6c757d;
            --accent-color: var(--main-color); /* Main teal color */
            --accent-hover: #005a66; /* Slightly lighter teal for hover */
            --gradient-bg: linear-gradient(135deg, #0a0b10 0%, #09090cb3 100%); /* Custom dark gradient */
            --shadow-color: rgba(0, 0, 0, 0.3);
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Light Theme Variables */
        [data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-card: #ffffff;
            --bg-surface: #ffffff;
            --border-color: #dee2e6;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --text-muted: #adb5bd;
            --accent-color: var(--main-color);
            --accent-hover: #005a66;
            --gradient-bg: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            --shadow-color: rgba(0, 0, 0, 0.1);
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Dark Theme Variables - Keep Original Dark Theme */
        [data-theme="dark"] {
            --bg-primary: #000; /* Template's theme-black bg-1 */
            --bg-secondary: rgb(34, 33, 36); /* Template's theme-black bg-2 */
            --bg-card: rgba(27, 25, 25, 0.18); /* Template's theme-black bs-dd-bg */
            --bg-surface: #1b1d25;
            --border-color: #333; /* Darker border for black theme */
            --text-primary: #ffffff;
            --text-secondary: #adb5bd;
            --text-muted: #6c757d;
            --accent-color: var(--main-color); /* Main teal color */
            --accent-hover: #005a66; /* Slightly lighter teal for hover */
            --gradient-bg: linear-gradient(135deg, #0a0b10 0%, #09090cb3 100%); /* Custom dark gradient */
            --shadow-color: rgba(0, 0, 0, 0.3);
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Apply Sarala font to entire page */
        * {
            font-family: 'Sarala', 'Montserrat', sans-serif !important;
        }

        body {
            font-family: 'Sarala', 'Montserrat', sans-serif !important;
        }

        /* Override template's bg-r-gradient class */
        body.bg-r-gradient {
            background: var(--dark-gradient) !important;
        }

        /* Override template's main-bg classes */
        body.main-bg {
            background: var(--dark-gradient) !important;
        }

        /* Theme-aware body styles */
        body {
            background: var(--gradient-bg) !important;
            color: var(--text-primary) !important;
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Override template's theme classes */
        body.theme-dark {
            background: var(--gradient-bg) !important;
        }

        /* Force theme-black background - Keep Original Dark Theme */
        body[data-bs-theme="dark"] {
            --adminuiux-bg-1: #000 !important;
            --adminuiux-bg-2: #1b1d25 !important;
            --adminuiux-theme-1: #ffffff !important;
            --adminuiux-theme-1-rgb: 255, 255, 255 !important;
            --adminuiux-theme-1-text: #000000 !important;
            --bs-dd-bg: #222 !important;
            background: var(--gradient-bg) !important;
        }

        /* Header */
        .navbar {
            background: var(--bg-primary) !important;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .navbar-brand {
            color: var(--text-primary) !important;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link {
            color: var(--text-secondary) !important;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--accent-color) !important;
        }

        /* Ensure dark theme navbar stays original */
        [data-theme="dark"] .navbar {
            background: #000 !important;
            border-bottom: 1px solid #333;
        }

        [data-theme="dark"] .navbar-brand {
            color: #ffffff !important;
        }

        [data-theme="dark"] .navbar-nav .nav-link {
            color: #adb5bd !important;
        }

        [data-theme="dark"] .navbar-nav .nav-link:hover,
        [data-theme="dark"] .navbar-nav .nav-link.active {
            color: var(--main-color) !important;
        }

        /* Cards */
        .card {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .card-header {
            background: var(--bg-surface) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        /* Template-specific card classes */
        .adminuiux-card {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .adminuiux-card:hover {
            border-color: var(--accent-color) !important;
            box-shadow: var(--card-shadow) !important;
        }

        .adminuiux-card .card-body {
            background: var(--bg-card) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .adminuiux-card .card-header {
            background: var(--bg-surface) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .adminuiux-card .card-title {
            color: var(--text-primary) !important;
            transition: color 0.3s ease;
        }

        .adminuiux-card .card-text {
            color: var(--text-secondary) !important;
            transition: color 0.3s ease;
        }

        /* Ensure dark theme cards stay original */
        [data-theme="dark"] .adminuiux-card {
            background: rgba(27, 25, 25, 0.18) !important;
            border: 1px solid #333 !important;
            color: #ffffff !important;
        }

        [data-theme="dark"] .adminuiux-card:hover {
            border-color: var(--main-color) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
        }

        [data-theme="dark"] .adminuiux-card .card-body {
            background: rgba(27, 25, 25, 0.18) !important;
            color: #ffffff !important;
        }

        [data-theme="dark"] .adminuiux-card .card-header {
            background: rgb(34, 33, 36) !important;
            border-bottom: 1px solid #333 !important;
            color: #ffffff !important;
        }

        [data-theme="dark"] .adminuiux-card .card-title {
            color: #ffffff !important;
        }

        [data-theme="dark"] .adminuiux-card .card-text {
            color: #adb5bd !important;
        }

        /* Buttons */
        .btn-primary {
            background: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--accent-hover) !important;
            border-color: var(--accent-hover) !important;
        }

        .btn-outline-primary {
            color: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--accent-color) !important;
            color: var(--text-primary) !important;
        }

        .btn-theme {
            background: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .btn-theme:hover {
            background: var(--accent-hover) !important;
            border-color: var(--accent-hover) !important;
        }

        /* Forms */
        .form-control {
            background: var(--bg-surface) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .form-control:focus {
            background: var(--bg-surface) !important;
            border-color: var(--accent-color) !important;
            color: var(--text-primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 73, 83, 0.25) !important;
        }

        /* Theme Toggle Button */
        #theme-toggle {
            transition: all 0.3s ease;
        }

        #theme-toggle:hover {
            transform: scale(1.1);
        }

        .theme-icon {
            transition: transform 0.3s ease;
        }

        [data-theme="light"] .theme-icon {
            transform: rotate(180deg);
        }

        /* Additional theme-aware styles */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .text-secondary {
            color: var(--text-secondary) !important;
        }

        .bg-light {
            background: var(--bg-secondary) !important;
        }

        .border {
            border-color: var(--border-color) !important;
        }

        /* Dropdown styles */
        .dropdown-menu {
            background: var(--bg-surface) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .dropdown-item {
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dropdown-item:hover {
            background: var(--bg-secondary) !important;
            color: var(--accent-color) !important;
        }

        .dropdown-divider {
            border-color: var(--border-color) !important;
        }
            color: var(--text-primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 73, 83, 0.25) !important;
        }

        .form-label {
            color: var(--text-primary) !important;
        }

        /* Ensure all form labels are white */
        /* Bubblemart Color Utility Classes */
        .text-main { color: var(--main-color) !important; }
        .text-accent-green { color: var(--accent-green) !important; }
        .text-accent-light-green { color: var(--accent-light-green) !important; }
        .text-accent-orange { color: var(--accent-orange) !important; }
        .text-accent-red { color: var(--accent-red) !important; }
        
        .bg-main { background-color: var(--main-color) !important; }
        .bg-accent-green { background-color: var(--accent-green) !important; }
        .bg-accent-light-green { background-color: var(--accent-light-green) !important; }
        .bg-accent-orange { background-color: var(--accent-orange) !important; }
        .bg-accent-red { background-color: var(--accent-red) !important; }
        
        .border-main { border-color: var(--main-color) !important; }
        .border-accent-green { border-color: var(--accent-green) !important; }
        .border-accent-light-green { border-color: var(--accent-light-green) !important; }
        .border-accent-orange { border-color: var(--accent-orange) !important; }
        .border-accent-red { border-color: var(--accent-red) !important; }
        .form-label,
        label.form-label,
        .form-label.fw-bold,
        
        /* Ensure theme-1 text is white in dark mode */
        [data-bs-theme="dark"] .text-theme-1,
        [data-bs-theme="dark"] h1.text-theme-1,
        [data-bs-theme="dark"] h2.text-theme-1,
        [data-bs-theme="dark"] h3.text-theme-1,
        [data-bs-theme="dark"] h4.text-theme-1,
        [data-bs-theme="dark"] h5.text-theme-1,
        [data-bs-theme="dark"] h6.text-theme-1 {
            color: #ffffff !important;
        }
        
        /* Force white text for all headings in dark mode */
        [data-bs-theme="dark"] h1,
        [data-bs-theme="dark"] h2,
        [data-bs-theme="dark"] h3,
        [data-bs-theme="dark"] h4,
        [data-bs-theme="dark"] h5,
        [data-bs-theme="dark"] h6 {
            color: #ffffff !important;
        }
        .form-label.text-theme-1 {
            color: var(--text-primary) !important;
        }

        /* Navigation */
        .nav-tabs {
            border-bottom: 1px solid var(--border-color) !important;
        }

        .nav-tabs .nav-link {
            color: var(--text-secondary) !important;
            border: 1px solid transparent !important;
        }

        .nav-tabs .nav-link:hover {
            color: var(--accent-color) !important;
            border-color: var(--border-color) var(--border-color) transparent !important;
        }

        .nav-tabs .nav-link.active {
            color: var(--accent-color) !important;
            background: var(--bg-card) !important;
            border-color: var(--border-color) var(--border-color) var(--bg-card) !important;
        }

        /* Tables */
        .table {
            color: var(--text-primary) !important;
        }

        .table th {
            background: var(--bg-surface) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .table td {
            border-color: var(--border-color) !important;
        }

        /* Footer */
        footer {
            background: var(--bg-primary) !important;
            border-top: 1px solid var(--border-color) !important;
            color: var(--text-secondary) !important;
        }

        .adminuiux-footer {
            background: var(--bg-primary) !important;
            border-top: 1px solid var(--border-color) !important;
            color: var(--text-secondary) !important;
        }

        .adminuiux-footer a {
            color: var(--accent-color) !important;
        }

        .adminuiux-footer a:hover {
            color: var(--accent-hover) !important;
        }

        /* Links */
        a {
            color: var(--accent-color) !important;
        }

        a:hover {
            color: var(--accent-hover) !important;
        }

        /* Text colors */
        .text-muted {
            color: var(--text-secondary) !important;
        }

        .text-primary {
            color: var(--accent-color) !important;
        }

        .text-theme-1 {
            color: var(--dark-text) !important;
        }

        .text-theme-accent-1 {
            color: var(--dark-accent) !important;
        }

        .text-secondary {
            color: var(--dark-text-secondary) !important;
        }

        /* Badges */
        .badge.bg-primary {
            background: var(--dark-accent) !important;
        }

        /* Alerts */
        .alert-primary {
            background: rgba(220, 53, 69, 0.1) !important;
            border-color: var(--dark-accent) !important;
            color: var(--dark-text) !important;
        }

        /* Dropdowns */
        .dropdown-menu {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
        }

        .dropdown-item {
            color: var(--dark-text) !important;
        }

        .dropdown-item:hover {
            background: var(--dark-surface) !important;
            color: var(--dark-accent) !important;
        }

        /* Modal */
        .modal-content {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
        }

        .modal-header {
            border-bottom: 1px solid var(--dark-border) !important;
        }

        .modal-footer {
            border-top: 1px solid var(--dark-border) !important;
        }

        /* Close button */
        .btn-close {
            filter: invert(1) !important;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-surface);
        }

        /* Preloader/Loader5 color override */
        .loader5 {
            border-color: #004953 #fff transparent !important;
        }
        
        .loader5:after {
            border-color: transparent #004953 #004953 !important;
        }

        /* Scrollbar */
        ::-webkit-scrollbar-thumb {
            background: var(--dark-border);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-accent);
        }

        /* Product cards specific styling */
        .product-card {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border-color: var(--dark-accent) !important;
        }

        .product-card .card-body {
            background: var(--dark-card) !important;
        }

        .product-card .card-title {
            color: var(--dark-text) !important;
        }

        .product-card .card-text {
            color: var(--dark-text-secondary) !important;
        }

        .product-card .price {
            color: var(--dark-accent) !important;
            font-weight: bold;
        }

        /* Category cards */
        .category-card {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-3px);
            border-color: var(--dark-accent) !important;
        }

        /* Sidebar styling */
        .adminuiux-sidebar {
            background: var(--dark-bg) !important;
            border-right: 1px solid var(--dark-border) !important;
        }

        .adminuiux-sidebar .nav-link {
            color: var(--dark-text-secondary) !important;
            transition: all 0.3s ease;
        }

        .adminuiux-sidebar .nav-link:hover,
        .adminuiux-sidebar .nav-link.active {
            background: var(--dark-surface) !important;
            color: var(--dark-accent) !important;
            border-radius: 8px;
            margin: 2px 8px;
        }

        .adminuiux-sidebar .menu-icon {
            color: var(--dark-text-secondary) !important;
            margin-right: 10px;
            font-size: 1.1em;
        }

        .adminuiux-sidebar .nav-link:hover .menu-icon,
        .adminuiux-sidebar .nav-link.active .menu-icon {
            color: var(--dark-accent) !important;
        }

        .adminuiux-sidebar .menu-name {
            color: var(--dark-text-secondary) !important;
            font-weight: 500;
        }

        .adminuiux-sidebar .nav-link:hover .menu-name,
        .adminuiux-sidebar .nav-link.active .menu-name {
            color: var(--dark-accent) !important;
        }

        /* Content area */
        .adminuiux-content {
            background: var(--dark-gradient) !important;
        }

        /* Header styling */
        .adminuiux-header {
            background: var(--dark-bg) !important;
            border-bottom: 1px solid var(--dark-border) !important;
        }

        /* Hero section */
        .hero-section {
            background: var(--dark-gradient) !important;
            color: var(--dark-text) !important;
        }

        /* Section backgrounds */
        .section-bg {
            background: var(--dark-surface) !important;
        }

        /* Custom utility classes */
        .bg-dark-custom {
            background: var(--dark-bg) !important;
        }

        .text-red-accent {
            color: var(--dark-accent) !important;
        }

        .border-red-accent {
            border-color: var(--dark-accent) !important;
        }

        /* Search wrap */
        .search-wrap {
            background: var(--dark-surface) !important;
            border: 1px solid var(--dark-border) !important;
        }

        /* Header buttons */
        .btn-link-header {
            color: var(--dark-text) !important;
        }

        .btn-link-header:hover {
            color: var(--dark-accent) !important;
        }

        /* Fix text and theme colors to avoid blue */
        .text-primary,
        .link-primary,
        .btn-primary,
        .btn-theme {
            color: #fff !important;
            background: var(--dark-accent) !important;
            border-color: var(--dark-accent) !important;
        }
        .text-theme-1,
        h1, h2, h3, h4, h5, h6 {
            color: var(--dark-text) !important;
        }
        .text-theme-accent-1 {
            color: var(--dark-accent) !important;
        }
        a, a:visited, a:active {
            color: var(--dark-accent) !important;
        }
        a:hover {
            color: var(--dark-accent-hover) !important;
        }
        .btn-primary:hover, .btn-theme:hover {
            background: var(--dark-accent-hover) !important;
            border-color: var(--dark-accent-hover) !important;
        }
        .text-secondary, .text-muted {
            color: var(--dark-text-secondary) !important;
        }

        /* Welcome section color fixes */
        .welcome-label, .welcome-label * {
            color: rgba(255,255,255,0.5) !important;
        }
        .welcome-username, .welcome-username * {
            color: #fff !important;
        }
        .location-select, .location-select *, .location-icon, .location-icon * {
            color: #fff !important;
            fill: #fff !important;
        }

        /* Orange accent everywhere */
        .text-primary,
        .link-primary,
        .btn-primary,
        .btn-theme {
            color: #fff !important;
            background: var(--dark-accent) !important;
            border-color: var(--dark-accent) !important;
        }
        .btn-primary:hover, .btn-theme:hover {
            background: var(--dark-accent-hover) !important;
            border-color: var(--dark-accent-hover) !important;
        }
        .text-theme-accent-1 {
            color: var(--dark-accent) !important;
        }
        .badge.bg-danger, .notification-badge, .position-absolute.badge {
            background: var(--dark-accent) !important;
            color: #fff !important;
        }
        .navbar-nav .nav-link.active, .navbar-nav .nav-link:hover,
        .adminuiux-sidebar .nav-link.active, .adminuiux-sidebar .nav-link:hover,
        .adminuiux-sidebar .nav-link:hover .menu-icon, .adminuiux-sidebar .nav-link.active .menu-icon,
        .adminuiux-sidebar .nav-link:hover .menu-name, .adminuiux-sidebar .nav-link.active .menu-name {
            color: var(--dark-accent) !important;
        }
        a, a:visited, a:active {
            color: var(--dark-accent) !important;
        }
        a:hover {
            color: var(--dark-accent-hover) !important;
        }
        /* Shop section star icon */
        .bi-star-fill.text-warning {
            color: var(--dark-accent) !important;
        }

        /* Bottom Navigation Styles */
        .adminuiux-mobile-footer {
            background: var(--dark-bg) !important;
            border-top: 1px solid var(--dark-border) !important;
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1030 !important;
            padding: 0.5rem 0 !important;
        }

        .adminuiux-mobile-footer .nav-link {
            color: var(--dark-text-secondary) !important;
            border: none !important;
            background: transparent !important;
            padding: 0.5rem 0.25rem !important;
            font-size: 0.75rem !important;
        }

        .adminuiux-mobile-footer .nav-link.active {
            color: var(--dark-accent) !important;
            background: transparent !important;
        }

        .adminuiux-mobile-footer .nav-link:hover {
            color: var(--dark-accent) !important;
        }

        .adminuiux-mobile-footer .nav-text {
            display: block !important;
            font-size: 0.7rem !important;
            line-height: 1 !important;
        }

        /* Ensure bottom navigation icons are visible */
        .adminuiux-mobile-footer .nav-icon {
            font-size: 1.25rem !important;
            margin-bottom: 0.25rem !important;
            display: block !important;
            color: inherit !important;
        }

        .adminuiux-mobile-footer .bi {
            display: inline-block !important;
            font-size: inherit !important;
            color: inherit !important;
        }

        /* Force icon visibility with higher specificity */
        .adminuiux-mobile-footer .nav-link .nav-icon.bi {
            display: block !important;
            font-size: 1.25rem !important;
            margin-bottom: 0.25rem !important;
            color: inherit !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        .adminuiux-mobile-footer .nav-link .bi {
            display: inline-block !important;
            font-size: 1.25rem !important;
            color: inherit !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Add bottom padding to main content for mobile footer */
        @media (max-width: 768px) {
            .adminuiux-content {
                padding-bottom: 5rem !important;
            }
        }

        .progress-step:not(.active) p {
            color: var(--dark-text-secondary) !important;
        }

        /* Progress Steps Styling */
        .progress-step {
            transition: all 0.3s ease;
            padding: 15px;
            border-radius: 10px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .progress-step .avatar {
            width: 50px !important;
            height: 50px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: bold !important;
            font-size: 1.2rem !important;
            margin-bottom: 10px !important;
        }

        .progress-step h6 {
            font-size: 0.9rem !important;
            font-weight: 600 !important;
            margin-bottom: 5px !important;
            text-align: center !important;
        }

        .progress-step p {
            font-size: 0.75rem !important;
            margin-bottom: 0 !important;
            text-align: center !important;
        }

        .progress-step.active .avatar {
            background: var(--dark-accent) !important;
        }

        .progress-step.active h6 {
            color: var(--dark-accent) !important;
        }

        .progress-step:not(.active) .avatar {
            background: var(--dark-border) !important;
        }

        .progress-step:not(.active) h6 {
            color: var(--dark-text-secondary) !important;
        }

        .progress-step:not(.active) p {
            color: var(--dark-text-secondary) !important;
        }

        /* Light Theme Sidebar Overrides */
        [data-theme="light"] .adminuiux-sidebar {
            background: #ffffff !important;
            border-right: 1px solid rgba(0, 0, 0, 0.1) !important;
        }

        [data-theme="light"] .adminuiux-sidebar .nav-link {
            color: rgba(0, 0, 0, 0.7) !important;
            transition: all 0.3s ease;
        }

        [data-theme="light"] .adminuiux-sidebar .nav-link:hover,
        [data-theme="light"] .adminuiux-sidebar .nav-link.active {
            background: rgb(1, 174, 151) !important;
            color: #ffffff !important;
            border-radius: 8px;
            margin: 2px 8px;
        }

        [data-theme="light"] .adminuiux-sidebar .menu-icon {
            color: rgba(0, 0, 0, 0.7) !important;
            margin-right: 10px;
            font-size: 1.1em;
        }

        [data-theme="light"] .adminuiux-sidebar .nav-link:hover .menu-icon,
        [data-theme="light"] .adminuiux-sidebar .nav-link.active .menu-icon {
            color: #ffffff !important;
        }

        [data-theme="light"] .adminuiux-sidebar .menu-name {
            color: rgba(0, 0, 0, 0.7) !important;
            font-weight: 500;
        }

        [data-theme="light"] .adminuiux-sidebar .nav-link:hover .menu-name,
        [data-theme="light"] .adminuiux-sidebar .nav-link.active .menu-name {
            color: #ffffff !important;
        }

        [data-theme="light"] .adminuiux-sidebar .nav-link:hover small,
        [data-theme="light"] .adminuiux-sidebar .nav-link.active small {
            color: #ffffff !important;
        }
    </style>

    <!-- Template Assets -->
    <script defer src="{{ asset('template-assets/js/app.js') }}"></script>
    <link href="{{ asset('template-assets/css/app.css') }}" rel="stylesheet">
    
    <!-- Storage Helper Script -->
    <script>
        // Helper function to handle missing images
        function handleImageError(img) {
            if (img.src.includes('storage/')) {
                // If it's a storage image that failed, use fallback
                if (img.src.includes('products/')) {
                    img.src = '{{ asset("template-assets/img/ecommerce/image-6.jpg") }}';
                } else if (img.src.includes('avatars/')) {
                    img.src = '{{ asset("template-assets/img/avatars/1.jpg") }}';
                }
            }
        }
    </script>
</head>

<body class="main-bg main-bg-opac main-bg-blur roundedui adminuiux-header-standard adminuiux-sidebar-standard adminuiux-header-transparent theme-dark bg-r-gradient adminuiux-sidebar-fill-none scrollup" data-theme="theme-dark" data-sidebarfill="adminuiux-sidebar-fill-none" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0" data-sidebarlayout="adminuiux-sidebar-standard" data-headerlayout="adminuiux-header-standard" data-headerfill="adminuiux-header-transparent" data-bggradient="bg-r-gradient">
    
    <!-- Pageloader -->
    <div class="pageloader">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center text-center h-100 pb-ios">
                <div class="col-12 mb-auto pt-4"></div>
                <div class="col-auto">
                    <img src="{{ asset('template-assets/img/logo-512.png') }}" alt="" class="height-80 mb-3">
                    <p class="h2 mb-0 text-white">Bubblemart</p>
                    <p class="display-3 text-theme-1 fw-bold mb-4">Gift Delivery</p>
                    <div class="loader5 mb-2 mx-auto"></div>
                </div>
                <div class="col-12 mt-auto pb-4">
                    <p class="small text-secondary">Please wait we are preparing awesome things...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- standard header -->
    <header class="adminuiux-header">
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <!-- main sidebar toggle -->
                <button class="btn btn-link btn-square sidebar-toggler" type="button" onclick="initSidebar()">
                    <i class="sidebar-svg" data-feather="menu"></i>
                </button>
                <!-- logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img data-bs-img="light" src="{{ asset('template-assets/img/logo.png') }}" alt="" class="avatar avatar-30">
                    <img data-bs-img="dark" src="{{ asset('template-assets/img/logo-light.png') }}" alt="" class="avatar avatar-30">
                    <div class="d-block ps-2">
                        <h6 class="fs-6 mb-0">Bubblemart</h6>
                        <p class="company-tagline">Gift Delivery Service</p>
                    </div>
                </a>

                <!-- right icons button -->
                <div class="ms-auto">
                    <!-- Theme Toggle -->
                    <button class="btn btn-link btn-square btn-icon btn-link-header" type="button" id="theme-toggle" title="Toggle Theme">
                        <i class="theme-icon" data-feather="moon"></i>
                    </button>
                    
                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="btn btn-link btn-square btn-icon btn-link-header position-relative">
                        <i data-feather="shopping-cart"></i>
                        @php
                            $cartCount = 0;
                            if (session()->has('cart')) {
                                $cartCount = count(session('cart'));
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 end-0 badge rounded-pill bg-danger p-1">
                                <small>{{ $cartCount }}</small>
                            </span>
                        @endif
                    </a>
                    
                    <!-- User Menu -->
                    @auth
                        <div class="dropdown d-none d-sm-inline-block">
                            <button class="btn btn-link btn-square btn-icon btn-link-header dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather="user"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('wallet.index') }}">
                                    <i class="bi bi-wallet me-2"></i>My Wallet
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="bi bi-bag me-2"></i>My Orders
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-theme btn-link-header">Sign In</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <div class="adminuiux-wrap">
        <!-- Standard sidebar -->
        <div class="adminuiux-sidebar">
            <div class="adminuiux-sidebar-inner">
                @auth
                    <!-- Profile Section -->
                    <div class="mx-3 mb-3">
                        <a href="{{ route('profile.index') }}" class="style-none">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <img src="{{ \App\Helpers\StorageHelper::getAvatarUrl(Auth::user()) }}" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" onerror="handleImageError(this);">
                                </div>
                                <div class="flex-fill">
                                    <h6 class="font-600 mb-0 color-theme-1">Profile</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Divider -->
                    <hr class="mx-3 my-3">
                @endauth

                <ul class="nav flex-column menu-active-line mt-3">
                    <!-- Main Navigation -->
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="menu-icon bi bi-house"></i>
                            <span class="menu-name">Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link">
                            <i class="menu-icon bi bi-grid"></i>
                            <span class="menu-name">Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customize.index') }}" class="nav-link">
                            <i class="menu-icon bi bi-magic"></i>
                            <span class="menu-name">Customize Gift</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('track') }}" class="nav-link">
                            <i class="menu-icon bi bi-truck"></i>
                            <span class="menu-name">Track Gift</span>
                        </a>
                    </li>
                    
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('wallet.index') }}" class="nav-link">
                                <i class="menu-icon bi bi-wallet-fill"></i>
                                <span class="menu-name">Wallet</span>
                                <small class="text-theme-accent-1 ms-auto">₦{{ number_format(auth()->user()->wallet->balance ?? 0) }}</small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('orders.index') }}" class="nav-link">
                                <i class="menu-icon bi bi-bag"></i>
                                <span class="menu-name">My Orders</span>
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>

        <main class="adminuiux-content has-sidebar" onclick="contentClick()">
            <!-- content -->
            <div class="container mt-3 mt-lg-4 mt-xl-5" id="main-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bottom Navigation -->
    @include('components.bottom-nav')

    <!-- Theme Toggle Script -->
    <script>
        // Theme management
        class ThemeManager {
            constructor() {
                this.themeToggle = document.getElementById('theme-toggle');
                this.themeIcon = document.querySelector('.theme-icon');
                this.htmlElement = document.documentElement;
                this.currentTheme = this.getStoredTheme() || 'dark';
                
                this.init();
            }

            init() {
                // Set initial theme
                this.setTheme(this.currentTheme);
                
                // Add event listener
                this.themeToggle.addEventListener('click', () => {
                    this.toggleTheme();
                });

                // Update icon on page load
                this.updateIcon();
            }

            getStoredTheme() {
                return localStorage.getItem('bubblemart-theme');
            }

            setStoredTheme(theme) {
                localStorage.setItem('bubblemart-theme', theme);
            }

            setTheme(theme) {
                this.htmlElement.setAttribute('data-theme', theme);
                this.htmlElement.setAttribute('data-bs-theme', theme);
                this.currentTheme = theme;
                this.setStoredTheme(theme);
                this.updateIcon();
            }

            toggleTheme() {
                const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
                this.setTheme(newTheme);
            }

            updateIcon() {
                if (this.currentTheme === 'dark') {
                    this.themeIcon.setAttribute('data-feather', 'moon');
                } else {
                    this.themeIcon.setAttribute('data-feather', 'sun');
                }
                
                // Reinitialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }
        }

        // Initialize theme manager when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            new ThemeManager();
        });
    </script>
    
    @stack('scripts')
</body>
</html>
