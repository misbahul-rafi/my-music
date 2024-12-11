<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){
        $notes = Note::all();
        $search = $request->input('search');
        if ($search) {
            $notes = Note::where('title', 'like', '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%')
            ->get();
        }
        return view('notes.index', [
            'title' => 'Notes',
            'notes' => $notes,
        ]);
    }
    public function dashboard(Request $request)
    {
        $search = $request->input('search');
        $notes = Auth::user()->notes()
            ->when($search, function($query, $search) {
                return $query->where('title', 'like', "%{$search}%")->orWhere('content', 'like', "%{$search}%");
            })
            ->get();

        return view('notes.mynotes', [
            'title' => 'My Notes',
            'notes' => $notes,
        ]);
    }
    public function showNote($id)
    {
        $note = Note::findOrFail($id);
        return view('notes.shownote', compact('note'));
    }
    public function create()
    {
        return view('notes.create', ['title'=>'Add Note']);
    }

    // POST Add Note
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Note::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil ditambahkan.');
    }

    // GET Edit Notes
    public function edit(Note $note)
    {
        // Pastikan catatan milik pengguna yang sedang login
        $this->authorize('update', $note);

        return view('notes.edit', compact('note'));
    }

    // Update Notes
    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil diperbarui.');
    }

    // Menghapus catatan
    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus.');
    }
}
