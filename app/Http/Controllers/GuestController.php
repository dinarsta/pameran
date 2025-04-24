<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Hospital;
use Illuminate\Http\Request;

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

    // Menampilkan halaman data rumah sakit (provinsi)
    public function index()
    {
        $provinces = Hospital::select('province')->distinct()->orderBy('province')->get();
        return view('data', compact('provinces'));
    }

    // Mengambil kota berdasarkan provinsi (AJAX)
    public function getCities(Request $request)
    {
        $province = $request->province;
        $cities = Hospital::where('province', $province)
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->get();
        return response()->json($cities);
    }

    // Mengambil rumah sakit berdasarkan kota (AJAX)
    public function getHospitals(Request $request)
    {
        $city = $request->city;
        $hospitals = Hospital::where('city', $city)
            ->select('customer_name', 'city', 'province')
            ->orderBy('customer_name')
            ->get();
        return response()->json($hospitals);
    }

    // Search rumah sakit berdasarkan nama (AJAX)
    public function searchHospitals(Request $request)
    {
        $query = $request->query('query');
        $hospitals = Hospital::where('customer_name', 'LIKE', "%{$query}%")
            ->select('customer_name', 'city', 'province')
            ->orderBy('customer_name')
            ->get();
        return response()->json($hospitals);
    }
}
