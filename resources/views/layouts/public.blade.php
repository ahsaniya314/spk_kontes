<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hasil Kontes Unggas')</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @endif
    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            background: #fafafa;
        }
        .podium {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 16px;
            margin: 48px 0;
        }
        .podium-item {
            text-align: center;
            flex: 1;
            max-width: 180px;
        }
        .podium-base {
            background: linear-gradient(180deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 24px 16px;
            border-radius: 12px 12px 0 0;
            margin-bottom: 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .podium-1 { 
            height: 180px; 
            background: linear-gradient(180deg, #fbbf24 0%, #f59e0b 100%);
        }
        .podium-2 { 
            height: 140px; 
            background: linear-gradient(180deg, #e5e7eb 0%, #9ca3af 100%);
        }
        .podium-3 { 
            height: 110px; 
            background: linear-gradient(180deg, #d97706 0%, #b45309 100%);
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-bottom: 24px;
        }
        .text-muted {
            color: #6b7280;
        }
    </style>
</head>
<body class="bg-gray-50" style="background: #fafafa;">
    <!-- Navigation Bar - Minimalis -->
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900 tracking-tight">Hasil Kontes Unggas</h1>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer - Minimalis -->
    <footer class="border-t border-gray-100 mt-16 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} SPK Kontes Unggas</p>
        </div>
    </footer>
</body>
</html>

