<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pencarian Rumah Sakit</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100 font-sans text-gray-800">

    <!-- Header -->
    <header class="bg-orange-500 py-4 shadow-lg">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-6">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 w-auto">
            </div>

            <!-- Desktop Nav -->
            <nav class="hidden lg:flex gap-6 font-medium">
                <a href="{{ route('hospitals.index') }}" class="text-gray-500 hover:underline transition">Cari Rumah
                    sakit</a>
                <a href="{{ route('guest.create') }}" class="text-gray-500 hover:underline transition">Form</a>
            </nav>

            <!-- Burger Button -->
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

    <!-- Konten Utama -->
    <main class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-lg">

        <!-- Wrapper form pencarian -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">

            <!-- Cari berdasarkan Nama Rumah Sakit -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-semibold mb-2 text-gray-700"> Nama Rumah
                    Sakit</label>
                <input type="text" id="search"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Ketik nama rumah sakit...">
            </div>

            <!-- Pilih Provinsi -->
            <div class="flex-1" id="province-wrapper">
                <label for="province" class="block text-sm font-semibold mb-2 text-gray-700">Pilih Provinsi</label>
                <select id="province"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">-- Pilih Provinsi --</option>
                    @foreach ($provinces as $province)
                    <option value="{{ $province->province }}">{{ $province->province }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Kota -->
            <div class="flex-1" id="city-wrapper">
                <label for="city" class="block text-sm font-semibold mb-2 text-gray-700">Pilih Kota</label>
                <select id="city"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                    disabled>
                    <option value="">-- Pilih Kota --</option>
                </select>
            </div>

        </div>

        <!-- Hasil Pencarian Nama Rumah Sakit -->
        <div id="search-results" class="mb-6"></div>

        <!-- Hasil Rumah Sakit berdasarkan Provinsi & Kota -->
        <div id="hospital-results" class="mb-6"></div>
    </main>

    <!-- Footer -->
    <footer class="bg-orange-500 text-gray-800 text-center py-4 mt-10 shadow-inner">

        <p class="text-gray-500">&copy; 2024 PT PRIMANUSA MUKTI UTAMA. All Rights Reserved.</p>
    </footer>

    <!-- Modal -->
    <div id="map-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-2xl w-full">
            <div class="flex justify-between items-center px-4 py-2 bg-orange-500 text-gray-800">
                <h3 class="text-lg font-semibold">Preview Lokasi Rumah Sakit</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
            <div id="map-frame" class="w-full h-96">
                <!-- Google Maps iframe will be injected here -->
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        $(document).ready(function() {
            // Sidebar toggle
            $('#burger-btn').click(() => $('#sidebar').removeClass('hidden'));
            $('#close-btn').click(() => $('#sidebar').addClass('hidden'));
            // Modal logic
            $(document).on('click', '.preview-map', function() {
                const name = $(this).data('name');
                const city = $(this).data('city');
                const province = $(this).data('province');
                const query = encodeURIComponent(`${name}, ${city}, ${province}`);
                const iframe =
                    `<iframe class="w-full h-full" src="https://www.google.com/maps?q=${query}&output=embed" frameborder="0" allowfullscreen></iframe>`;
                $('#map-frame').html(iframe);
                $('#map-modal').removeClass('hidden');
            });
            $('#close-modal').click(() => {
                $('#map-modal').addClass('hidden');
                $('#map-frame').empty();
            });
            // Close modal on outside click
            $('#map-modal').on('click', function(e) {
                if ($(e.target).is('#map-modal')) {
                    $('#map-modal').addClass('hidden');
                    $('#map-frame').empty();
                }
            });
            // Provinsi -> Kota
            $('#province').change(function() {
                const province = $(this).val();
                // Reset kota & results
                $('#city').empty().append('<option value="">-- Pilih Kota --</option>').prop('disabled',
                    true);
                $('#hospital-results').empty();
                if (province) {
                    $.get('{{ route("hospitals.cities") }}', {
                        province
                    }, function(data) {
                        $('#city').empty().append('<option value="">-- Pilih Kota --</option>');
                        $.each(data, (_, value) => {
                            $('#city').append(
                                `<option value="${value.city}">${value.city}</option>`
                            );
                        });
                        $('#city').prop('disabled', false);
                    });
                    // Hide search by name results and search inputs
                    $('#search-results').empty();
                    $('#search').val('');
                }
            });
            // Kota -> Rumah Sakit
            $('#city').change(function() {
                const city = $(this).val();
                $('#hospital-results').empty();
                if (city) {
                    $.get('{{ route("hospitals.getHospitals") }}', {
                        city
                    }, function(data) {
                        if (data.length) {
                            let html =
                                `<h2 class="text-xl font-semibold text-orange-500 mb-4">Daftar Rumah Sakit di ${city}</h2><ul class="space-y-2">`;
                            $.each(data, (_, rs) => {
                                html += `<li class="bg-white p-4 rounded-lg shadow hover:shadow-md transition cursor-pointer preview-map" data-name="${rs.customer_name}" data-city="${rs.city}" data-province="${rs.province}">
                                    <span class="font-medium">${rs.customer_name}</span><br>
                                    <span class="text-sm text-gray-500">${rs.city}, ${rs.province}</span>
                                </li>`;
                            });
                            html += '</ul>';
                            $('#hospital-results').html(html);
                        } else {
                            $('#hospital-results').html(
                                '<p class="text-gray-600">Tidak ada rumah sakit ditemukan.</p>'
                            );
                        }
                    });
                    // Reset & hide search by name
                    $('#search-results').empty();
                    $('#search').val('');
                }
            });
            // Pencarian Nama Rumah Sakit
            $('#search').on('input', function() {
                const query = $(this).val();
                if (query.length >= 2) {
                    $.get('{{ route("hospitals.searchHospitals") }}', {
                        query
                    }, function(data) {
                        $('#search-results').empty();
                        $('#hospital-results').empty();
                        $('#province').val('');
                        $('#city').empty().append('<option value="">-- Pilih Kota --</option>')
                            .prop('disabled', true);
                        if (data.length) {
                            let html = '<ul class="space-y-2">';
                            $.each(data, (_, rs) => {
                                html += `<li class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition cursor-pointer preview-map" data-name="${rs.customer_name}" data-city="${rs.city}" data-province="${rs.province}">
                                    <span class="font-medium">${rs.customer_name}</span><br>
                                    <span class="text-sm text-gray-500">${rs.city}, ${rs.province}</span>
                                </li>`;
                            });
                            html += '</ul>';
                            $('#search-results').html(html);
                        } else {
                            $('#search-results').html(
                                '<p class="text-gray-600">Tidak ada rumah sakit ditemukan dengan nama tersebut.</p>'
                            );
                        }
                    });
                    // Hide province & city selectors while searching by name
                    $('#province-wrapper').hide();
                    $('#city-wrapper').hide();
                } else {
                    // Clear search results and show province & city selectors again
                    $('#search-results').empty();
                    $('#province-wrapper').show();
                    $('#city-wrapper').show();
                }
            });
        });
        //   slidebar
        document.getElementById('burger-btn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('hidden');
        });
        document.getElementById('close-btn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('hidden');
        });
    </script>

</body>

</html>
