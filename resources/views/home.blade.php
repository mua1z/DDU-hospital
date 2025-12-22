<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DDU Student Clinic</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css','resources/js/app.js'])
    @else
        <link rel="stylesheet" href="/build/assets/app.css">
    @endif
</head>
<body class="antialiased bg-slate-50 text-slate-800">
    <header class="bg-teal-900 text-white">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white p-1 flex items-center justify-center">
                    <img src="/images/logo.png" alt="DDU" class="w-full h-full object-contain" onerror="this.style.display='none'">
                </div>
                <span class="font-semibold text-lg">DDU Clinic</span>
            </a>
            <nav class="hidden md:flex gap-6">
                <a href="#" class="hover:underline">Home</a>
                <a href="#" class="hover:underline">About</a>
                <a href="#" class="hover:underline">Services</a>
                <a href="#" class="hover:underline">Contact</a>
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
            </nav>
            <div class="md:hidden">
                <!-- mobile menu placeholder -->
            </div>
        </div>
    </header>

    <main>
        <section class="bg-gradient-to-r from-sky-100 to-emerald-100">
            <div class="max-w-6xl mx-auto px-6 py-24 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">Welcome to DDU Student Clinic</h1>
                <p class="text-slate-700 mb-8">Accessible, Student-Centered Healthcare for Every Need</p>

                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('reception.schedule-appointments') }}" class="px-6 py-3 bg-sky-800 text-white rounded shadow hover:bg-sky-700">Book Appointment</a>
                    <a href="#" class="px-6 py-3 bg-sky-700 text-white rounded shadow hover:bg-sky-600">View Services</a>
                </div>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 bg-white rounded-lg p-8 shadow-sm">
                    <!-- space for content or hero image -->
                </div>

                <aside class="bg-white rounded-lg p-6 shadow">
                    <h3 class="font-semibold text-lg mb-2">Need Help?</h3>
                    <p class="text-slate-600">Visit our FAQs or contact the clinic team</p>
                </aside>
            </div>
        </section>
    </main>

    <footer class="bg-teal-900 text-white">
        <div class="max-w-6xl mx-auto px-6 py-4 text-center">
            <p>© {{ date('Y') }} Dire Dawa University Student Clinic | Support</p>
        </div>
    </footer>

</body>
</html>
