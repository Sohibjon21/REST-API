<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotebookPostRequest;
use App\Http\Requests\NotebookUpdateRequest;
use App\Models\Notebook;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        
        $notes = Notebook::paginate($limit, ['*'], 'page', $page);
        return response()->json([
            'notebooks' => $notes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotebookPostRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            // Выполните необходимые действия с файлом, например, сохраните его
            $data['photo'] = $file->store('photos'); // Сохраняет файл в хранилище Laravel

        }

        $store = Notebook::create($data);
        if ($store) {
            return response()->json([
                'status' => 'success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notebook $notebook)
    {
        if (!$notebook) {
            return response()->json(['error' => 'Notebook not found'], 404);
        }

        return response()->json([
            'notebook' => $notebook
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notebook $notebook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotebookUpdateRequest $request, Notebook $notebook)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            // Выполните необходимые действия с файлом, например, сохраните его
            $data['photo'] = $file->store('photos'); // Сохраняет файл в хранилище Laravel

        }

        $notebook->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notebook $notebook)
    {
        $notebook->delete();
    }
}
