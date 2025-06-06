<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Presence;

class DailyPrintController extends Controller
{
    public function printHarian(Request $request)
    {
        // Ambil tanggal dari request, default hari ini
        $date = $request->input('date') ?? Carbon::today()->format('Y-m-d');
        $carbonDate = Carbon::parse($date);

        // Ambil data presensi dengan relasi teacher
        $attendances = Presence::with('teacher')
            ->where('date', $carbonDate->toDateString())
            ->orderBy('time', 'asc')
            ->get();

        // Hitung jumlah berdasarkan status
        $statusCounts = [
            'hadir' => $attendances->where('status', 'hadir')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
            'izin' => $attendances->where('status', 'izin')->count(),
            'tidak_hadir' => $attendances->where('status', 'tidak hadir')->count(),
        ];

        return view('prints.print-harian', [
            'attendances' => $attendances,
            'date' => $carbonDate->format('d-m-Y'),
            'rawDate' => $carbonDate->toDateString(),
            'statusCounts' => $statusCounts,
        ]);
    }
}
