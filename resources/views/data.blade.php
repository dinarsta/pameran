<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Rumah Sakit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="max-w-7xl mx-auto px-4 py-8">

        <h2 class="text-2xl font-semibold mb-6">Data Rumah Sakit</h2>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('data') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <div>
                <label for="hospital_name" class="block text-sm font-medium mb-1">Nama Rumah Sakit</label>
                <select name="hospital_name" id="hospital_name"
                    class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua --</option>
                    @foreach ($hospitalNames as $name)
                        <option value="{{ $name }}" {{ request('hospital_name') == $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="city" class="block text-sm font-medium mb-1">Kota</label>
                <select name="city" id="city"
                    class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua --</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="province" class="block text-sm font-medium mb-1">Provinsi</label>
                <select name="province" id="province"
                    class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua --</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province }}" {{ request('province') == $province ? 'selected' : '' }}>
                            {{ $province }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3 flex justify-end space-x-2">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Filter</button>
                <a href="{{ route('data') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Reset</a>
            </div>
        </form>

        <!-- Data Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-2 text-sm font-medium text-gray-700">No</th>
                        <th class="text-left px-4 py-2 text-sm font-medium text-gray-700">Nama Rumah Sakit</th>
                        <th class="text-left px-4 py-2 text-sm font-medium text-gray-700">Kota</th>
                        <th class="text-left px-4 py-2 text-sm font-medium text-gray-700">Provinsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($results as $index => $hospital)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $hospital['hospital_name'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $hospital['city'] ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $hospital['province'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
