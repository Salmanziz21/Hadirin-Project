<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    public function showScanner()
    {
        return view('scan.scan');
    }

  public function processScan(Request $request)
{
    try {
        Log::info('Memproses permintaan scan:', $request->all());
        
        // Cari teacher berdasar user_id dari request
        $teacher = Teacher::where('user_id', $request->user_id)->first();

        if (!$teacher) {
            Log::error('User tidak ditemukan:', ['user_id' => $request->user_id]);
            return redirect()->route('scan.error')->with('error', 'ID anggota tidak ditemukan.');
        }

        // Cek apakah sudah presensi hari ini berdasarkan teacher_id dan tanggal
        $alreadyPresent = Presence::where('teacher_id', $teacher->id)
            ->whereDate('date', now()->toDateString())
            ->exists();

        if ($alreadyPresent) {
            Log::warning('Percobaan presensi ganda:', ['teacher_id' => $teacher->id]);
            return redirect()->route('scan.error')->with('error', 'Anda sudah melakukan presensi hari ini.');
        }

        $presenceData = [
            'teacher_id' => $teacher->id,
            'status' => $request->status ?? 'hadir',
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
        ];

        Log::info('Membuat data presensi:', $presenceData);

        $presence = Presence::create($presenceData);

        Log::info('Presensi berhasil dibuat:', $presence->toArray());

        return redirect()->route('scan.success')->with([
            'success' => 'Presensi berhasil dicatat',
            'data' => [
                'nama' => $teacher->name,
                'status' => $presence->status,
                'waktu' => $presence->date . ' ' . $presence->time
            ]
        ]);
    } catch (\Exception $e) {
        Log::error('Gagal memproses presensi:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->route('scan.error')->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    }
}

    public function scanSuccess()
    {
        if (!session()->has('success')) {
            return redirect()->route('scan.show');
        }

        return view('scan.success', [
            'message' => session('success'),
            'data' => session('data')
        ]);
    }

    public function scanError()
    {
        if (!session()->has('error')) {
            return redirect()->route('scan.show');
        }

        return view('scan.error', [
            'message' => session('error')
        ]);
    }
}
