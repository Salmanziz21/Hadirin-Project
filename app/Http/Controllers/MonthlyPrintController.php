<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Presence;

class MonthlyPrintController extends Controller
{
    public function printBulanan(Request $request)
    {
       
        $month = $request->input('month');
        if ($month) {
            $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        
        $attendances = Presence::with('teacher') 
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return view('prints.print-bulanan', [
            'attendances' => $attendances,
            'month' => $startDate->translatedFormat('F Y')
        ]);
    }
}
