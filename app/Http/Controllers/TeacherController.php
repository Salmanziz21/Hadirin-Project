<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Teacher; 

class TeacherController extends Controller
{
      public function index()
    {
       $teachers = Teacher::all();
       return view('tools.teachers', compact('teachers'));
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

        return view('tools.teachers', compact('teachers'));
    }


   
      public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:teachers,nip',
            'name' => 'required|unique:teachers,name',
            'type_id' => 'required|exists:types,id',
            'gender' => 'required|in:laki-laki,perempuan',

        ], 
        [
            'name.unique' => 'Nama guru sudah digunakan, silakan gunakan nama lain.',
        ]);

        Teacher::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'type_id' => $request->type_id,
            'gender' => $request->gender,
        ]);

        return redirect()->back()->with('success', 'Guru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|unique:teachers,nip,' . $id,
            'name' => 'required|unique:teachers,name,' . $id,
            'type_id' => 'required|exists:types,id',
            'gender' => 'required|in:laki-laki,perempuan',
        ], [
            'name.unique' => 'Nama guru sudah digunakan, silakan gunakan nama lain.',
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->update([
            'nip' => $request->nip,
            'name' => $request->name,
            'type_id' => $request->type_id,
            'gender' => $request->gender,
        ]);

        return redirect()->back()->with('success', 'Guru berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->back()->with('success', 'Guru berhasil dihapus.');
    }


}
