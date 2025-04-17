<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buku Tamu</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Background Image */
        .bg-custom {
            background-image: url('path_to_your_background_image.jpg');
            background-size: cover;
            background-position: center;
        }

        /* Custom Styles */
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-custom text-gray-900">

    <header class="bg-white bg-opacity-80 shadow-md py-6 backdrop-blur-md">
        <div class="container mx-auto">
            <img src="{{ asset('logo.png') }}" alt="Logo Perusahaan" class="mx-auto h-14">
        </div>
    </header>

    <div class="container mx-auto my-12">
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
                        <!-- First Column -->
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
                                <label for="phone" class="block text-sm font-medium text-[#2E073F]">Nomor Telepon</label>
                                <input type="text" id="phone" name="phone"
                                    class="mt-2 w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:ring-2 focus:ring-[#A367B1] focus:border-[#A367B1]"
                                    value="{{ old('phone') }}" required>
                            </div>
                        </div>

                        <!-- Second Column -->
                        <div>
                            <div class="mb-6">
                                <label for="instansi" class="block text-sm font-medium text-[#2E073F]">Asal Instansi</label>
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
                <div id="successModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center z-50 rounded-lg">
                    <div class="bg-white rounded-lg p-6 w-full max-w-xs md:max-w-md lg:max-w-lg mx-4 relative">
                        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                            <span class="text-2xl">&times;</span>
                        </button>

                        <div class="flex justify-center mb-4">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-3xl">&#10003;</span>
                            </div>
                        </div>

                        <h2 class="text-lg font-semibold text-[#2E073F] text-center">Thank you!</h2>
                        <p class="text-gray-700 text-center">Terima kasih telah mengisi buku tamu kami.</p>
                        <button id="closeModal" class="mt-4 py-2 px-4 bg-[#2E073F] text-white rounded-lg hover:bg-[#521E6F] mx-auto block">
                            Tutup
                        </button>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const modal = document.getElementById('successModal');
                        const closeModal = document.querySelectorAll('#closeModal');

                        @if (session('success'))
                            modal.classList.remove('hidden');
                        @endif

                        closeModal.forEach((button) => {
                            button.addEventListener('click', () => {
                                modal.classList.add('hidden');
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</body>

<footer class="bg-white bg-opacity-80 text-center py-6 backdrop-blur-md">
    <a href="https://www.primanusamuktiutama.com" target="_blank" rel="noopener noreferrer">
        <p class="text-gray-500">&copy; 2024 PT PRIMANUSA MUKTI UTAMA. All Rights Reserved.</p>
    </a>
</footer>

</html>
