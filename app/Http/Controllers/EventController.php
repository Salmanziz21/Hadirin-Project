<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('tools.events', compact('events'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $events = Event::when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy('date', 'desc')
            ->get();

        return view('tools.events', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|unique:events,title',
            'description' => 'nullable|string|max:255',
            'date'        => 'required|date',
        ], [
            'title.unique' => 'Judul kegiatan sudah digunakan, silakan gunakan judul lain.',
        ]);

        Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'date'        => $request->date,
        ]);

        return redirect()->back()->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|unique:events,title,' . $id,
            'description' => 'nullable|string|max:255',
            'date'        => 'required|date',
        ], [
            'title.unique' => 'Judul kegiatan sudah digunakan, silakan gunakan judul lain.',
        ]);

        $event = Event::findOrFail($id);
        $event->update([
            'title'       => $request->title,
            'description' => $request->description,
            'date'        => $request->date,
        ]);

        return redirect()->back()->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus.');
    }
}