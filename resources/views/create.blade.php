<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome (Optional) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .bg-custom {
            background-image: url('{{ asset('images/bg.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-custom text-gray-900">

    <!-- Header -->
    <header class="bg-white py-4 shadow-lg">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 w-auto">
            </div>

            <nav class="hidden lg:flex gap-6 font-medium">
                <a href="{{ route('hospitals.index') }}" class="text-gray-500 hover:underline transition">Cari Rumah
                    sakit</a>
                <a href="{{ route('guest.create') }}" class="text-gray-500 hover:underline transition">Form</a>
            </nav>

            <button id="burger-btn" class="lg:hidden text-gray-500 focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Sidebar Mobile -->
    <div id="sidebar" class="lg:hidden fixed inset-0 bg-black/50 z-50 hidden">
        <div class="bg-white w-64 h-full p-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-500">Menu</h2>
                <button id="close-btn" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <ul class="space-y-2">
                <li>
                    <a href="{{ route('hospitals.index') }}"
                        class="flex items-center gap-2 text-gray-600 hover:text-blue-600 hover:bg-blue-100 rounded-md px-3 py-2 transition-colors duration-300">
                        <svg class="w-5 h-5 stroke-current transition-colors duration-300" fill="none"
                            stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 10V6a2 2 0 00-2-2H8a2 2 0 00-2 2v4M4 10h16v10H4V10z" />
                        </svg>
                        Cari Rumah Sakit
                    </a>
                </li>
                <li>
                    <a href="{{ route('guest.create') }}"
                        class="flex items-center gap-2 text-gray-600 hover:text-blue-600 hover:bg-blue-100 rounded-md px-3 py-2 transition-colors duration-300">
                        <svg class="w-5 h-5 stroke-current transition-colors duration-300" fill="none"
                            stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 4H8a2 2 0 00-2 2v14l6-3 6 3V6a2 2 0 00-2-2z" />
                        </svg>
                        Form Buku Tamu
                    </a>
                </li>
            </ul>

        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto my-12 px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-2xl bg-white bg-opacity-90 shadow-xl rounded-3xl p-8">
                <!-- Error Validation -->
                @if ($errors->any())
                <div class="border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('guestbook.store') }}" method="POST" id="guestbookForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-medium text-[#2E073F]">Nama Lengkap</label>
                                <input type="text" id="name" name="name"
                                    class="mt-2 w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:ring-2 focus:ring-[#A367B1] focus:border-[#A367B1]"
                                    value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-medium text-[#2E073F]">Email</label>
                                <input type="email" id="email" name="email"
                                    class="mt-2 w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:ring-2 focus:ring-[#A367B1] focus:border-[#A367B1]"
                                    value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-6">
                                <label for="phone" class="block text-sm font-medium text-[#2E073F]">Nomor
                                    Telepon</label>
                                <input type="text" id="phone" name="phone"
                                    class="mt-2 w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:ring-2 focus:ring-[#A367B1] focus:border-[#A367B1]"
                                    value="{{ old('phone') }}" required>
                            </div>
                        </div>

                        <div>
                            <div class="mb-6">
                                <label for="instansi" class="block text-sm font-medium text-[#2E073F]">Asal
                                    Instansi</label>
                                <input type="text" id="instansi" name="instansi"
                                    class="mt-2 w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:ring-2 focus:ring-[#A367B1] focus:border-[#A367B1]"
                                    value="{{ old('instansi') }}" required>
                            </div>
                            <div class="mb-6">
                                <label for="address" class="block text-sm font-medium text-[#2E073F]">Alamat</label>
                                <input type="text" id="address" name="address"
                                    class="mt-2 w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:ring-2 focus:ring-[#A367B1] focus:border-[#A367B1]"
                                    value="{{ old('address') }}" required>
                            </div>
                            <div class="mb-6">
                                <label for="message" class="block text-sm font-medium text-[#2E073F]">Pesan</label>
                                <textarea id="message" name="message" rows="4"
                                    class="mt-2 w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:ring-2 focus:ring-[#A367B1] focus:border-[#A367B1]"
                                    required>{{ old('message') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-[#2E073F] text-white font-medium rounded-lg shadow-lg hover:bg-[#521E6F] transition-transform transform hover:scale-105">
                        Submit
                    </button>
                </form>

                <!-- Modal -->
                <div id="successModal"
                    class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center z-50">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4 relative">

                        <div class="flex justify-center mb-4">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-3xl">&#10003;</span>
                            </div>
                        </div>
                        <h2 class="text-lg font-semibold text-[#2E073F] text-center">Thank you!</h2>
                        <p class="text-gray-700 text-center">Terima kasih telah mengisi buku tamu kami.</p>
                        <button
                            class="mt-4 py-2 px-4 bg-[#2E073F] text-white rounded-lg hover:bg-[#521E6F] mx-auto block"
                            onclick="document.getElementById('successModal').classList.add('hidden')">
                            Tutup
                        </button>
                    </div>
                </div>

                <!-- Script for Modal and Sidebar -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const modal = document.getElementById('successModal');
                        const sidebar = document.getElementById('sidebar');
                        const burgerBtn = document.getElementById('burger-btn');
                        const closeBtn = document.getElementById('close-btn');
                        @if(session('success'))
                        modal.classList.remove('hidden');
                        @endif
                        burgerBtn.addEventListener('click', () => {
                            sidebar.classList.remove('hidden');
                        });
                        closeBtn.addEventListener('click', () => {
                            sidebar.classList.add('hidden');
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white bg-opacity-80 text-center py-6 backdrop-blur-md">

        <p class="text-gray-500">&copy; 2024 PT PRIMANUSA MUKTI UTAMA. All Rights Reserved.</p>

    </footer>
</body>

</html>
