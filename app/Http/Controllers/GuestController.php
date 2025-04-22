<?php

namespace App\Http\Controllers;
use Smalot\PdfParser\Parser;
use App\Models\Guest;
use Illuminate\Http\Request;
use App\Exports\GuestsExport;
use Maatwebsite\Excel\Facades\Excel;

class GuestController extends Controller
{
    // Menampilkan form buku tamu
    public function create()
    {
        return view('create');
    }

    // Menyimpan data buku tamu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        // Simpan data buku tamu ke database
        Guest::create($request->all());

        // Kirim pesan sukses
        return redirect()->back()->with('success', 'Data Berhasil Dikirim!');
    }

    public function data(Request $request)
    {
        $hospitalList = $this->extractHospitals();

        // Filtering data berdasarkan input
        $filtered = collect($hospitalList)->filter(function ($item) use ($request) {
            return (!$request->hospital_name || $item['hospital_name'] === $request->hospital_name)
                && (!$request->city || $item['city'] === $request->city)
                && (!$request->province || $item['province'] === $request->province);
        });

        // Untuk dropdown filter
        $hospitalNames = collect($hospitalList)->pluck('hospital_name')->unique()->sort();
        $cities = collect($hospitalList)->pluck('city')->unique()->sort();
        $provinces = collect($hospitalList)->pluck('province')->unique()->sort();

        return view('data', [
            'results' => $filtered->values(),
            'hospitalNames' => $hospitalNames,
            'cities' => $cities,
            'provinces' => $provinces,
        ]);
    }




    public function extractHospitals()
    {
        $pdfPath = public_path('data.pdf');
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = $pdf->getText();

        // Ambil setiap baris teks dari PDF
        $lines = explode("\n", $text);
        $data = [];

        foreach ($lines as $line) {
            // Gunakan regex untuk mencoba mengambil 3 bagian utama:
            // Nama RS - Kota - Provinsi
            // Contoh: RS Harapan Sehat - Bandung - Jawa Barat
            $parts = array_map('trim', explode('-', $line));

            if (count($parts) >= 3) {
                $data[] = [
                    'customer_name' => $parts[0],
                    'city' => $parts[1],
                    'province' => $parts[2],
                ];
            }
        }

        return $data;
    }



    public function bacaDataPDF(Request $request)
    {
        $filter = $request->input('filter'); // Optional filter like "Jawa Barat"
        $parser = new Parser();
        $pdf = $parser->parseFile(public_path('data.pdf'));
        $text = $pdf->getText();

        $lines = explode("\n", $text);
        $data = [];

        foreach ($lines as $line) {
            if (stripos($line, 'RS') !== false || stripos($line, 'Rumah Sakit') !== false) {
                // Example format: RS Harapan Sehat - Bandung - Jawa Barat
                $parts = array_map('trim', explode('-', $line));

                if (count($parts) >= 3) {
                    if ($filter && stripos($line, $filter) === false) {
                        continue;
                    }

                    $data[] = [
                        'hospital_name' => $parts[0],
                        'city' => $parts[1],
                        'province' => $parts[2],
                    ];
                }
            }
        }

        // Extract unique values for filters
        $hospitalNames = collect($data)->pluck('hospital_name')->unique()->sort();
        $cities = collect($data)->pluck('city')->unique()->sort();
        $provinces = collect($data)->pluck('province')->unique()->sort();

        return view('data', [
            'results' => collect($data)->values(),
            'hospitalNames' => $hospitalNames,
            'cities' => $cities,
            'provinces' => $provinces,
        ]);
    }


}
