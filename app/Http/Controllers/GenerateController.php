<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class GenerateController extends Controller
{
    public function index(){
        $teachers = Teacher::all();

        return view('tools.generate', compact('teachers'));
    }

     public function search(Request $request)
    {
        $search = $request->input('search');

        $teachers = Teacher::with('type')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('type', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })  
            ->orderBy('name')
            ->get();

        return view('tools.generate', compact('teachers'));
    }

     public function process()
    {
        $users = Teacher::whereNull('user_id')->get();

        foreach ($users as $user) {
            $user->user_id = 'MID' . str_pad($user->id, 5, '0', STR_PAD_LEFT);
            $user->save();
        }

        return redirect()->route('generate.id.show')->with('success', 'user ID berhasil digenerate.');
    }
}
