<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body,
        html {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .main {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .sidebar a {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid #34495e;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            background-color: #f4f4f4;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            align-items: center;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 10px 20px;
            text-align: center;
            border-top: 1px solid #ddd;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logout-button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                left: -100%;
                top: 0;
                height: 100%;
                z-index: 1000;
            }

            .sidebar.active {
                left: 0;
            }

            .menu-toggle {
                display: block;
                cursor: pointer;
                font-size: 24px;
            }
        }

        .menu-toggle {
            display: none;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />
    @yield('styles')
</head>

<body>
    <div class="wrapper">
        @include('layouts.partials.header')

        <div class="main">
            @include('layouts.partials.sidebar')

            <div class="content">
                @yield('content')
            </div>
        </div>

        @include('layouts.partials.footer')
    </div>





    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.querySelector('.menu-toggle');
            const sidebar = document.querySelector('.sidebar');
            if (toggle) {
                toggle.addEventListener('click', () => {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
