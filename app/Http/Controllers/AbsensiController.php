<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Import Carbon
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    // Simpan absen untuk hari ini
    public function store(Request $request) //
    {
        $userId = Auth::id();
        $today = Carbon::today()->toDateString(); // Menggunakan Carbon untuk tanggal hari ini

        // Periksa apakah pengguna sudah absen hari ini
        $existingAbsen = Absensi::where('user_id', $userId)
                                ->where('date', $today)
                                ->first();

        if ($existingAbsen) {
            return response()->json(['message' => 'Anda sudah melakukan absensi hari ini.'], 409); // 409 Conflict
        }

        try {
            $absen = Absensi::create([
                'user_id' => $userId,
                'time' => Carbon::now()->toTimeString(), // Waktu saat ini
                'date' => $today,                         // Tanggal hari ini
            ]);
            Log::info('Absensi berhasil: User ID ' . $userId . ' pada ' . $today . ' jam ' . $absen->time);
            return response()->json(['message' => 'Absensi berhasil dicatat!', 'absen' => $absen], 201);
        } catch (\Exception $e) {
            Log::error('Gagal catat absensi: User ID ' . $userId . '. Error: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mencatat absensi. Terjadi kesalahan server.'], 500);
        }
    }

    // Ambil riwayat absen
    public function getByDate(Request $request) //
    {
        $query = Absensi::where('user_id', Auth::id()); //

        if ($request->filled('date')) { // Periksa apakah parameter 'date' ada dan tidak kosong
            $request->validate([
                'date' => 'required|date', //
            ]);
            $query->where('date', $request->date); //
        }

        // Urutkan dari yang terbaru
        $absensi = $query->orderBy('date', 'desc')->orderBy('time', 'desc')->get();

        return response()->json($absensi);
    }
}