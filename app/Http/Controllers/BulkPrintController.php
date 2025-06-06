<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class BulkPrintController extends Controller
{
    public function printCard()
    {
        $teachers = Teacher::all();
        return view('prints.card-id', compact('teachers'));
    }
}
