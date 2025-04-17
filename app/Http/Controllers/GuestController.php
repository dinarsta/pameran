<?php

namespace App\Http\Controllers;

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

    // Menampilkan tabel data buku tamu
    public function table()
    {
        $guests = Guest::all();
        return view('table', compact('guests'));
    }

    // Export data buku tamu ke Excel
    public function export()
    {
        return Excel::download(new GuestsExport, 'guests.xlsx');
    }
}
