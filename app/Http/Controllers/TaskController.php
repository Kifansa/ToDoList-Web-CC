<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::latest()->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create($validatedData);

        return redirect()->route('tasks.index')
                         ->with('success', 'Tugas baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Untuk CRUD sederhana, halaman 'show' sering tidak diperlukan.
        // Kita arahkan saja ke 'edit'.
        return redirect()->route('tasks.edit', $task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($validatedData);

        return redirect()->route('tasks.index')
                         ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function toggleComplete(Request $request, Task $task)
    {
        // Logika ini mengecek apakah checkbox 'completed' dikirim
        // Jika ya, $task->completed = true
        // Jika tidak (unchecked), $task->completed = false
        $task->completed = $request->has('completed');
        $task->save();

        // redirect()->back() akan mengembalikan user ke halaman
        // di mana mereka berada (termasuk halaman paginasi yang benar)
        return redirect()->back()->with('success', 'Status tugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Tugas berhasil dihapus.');
    }
}
