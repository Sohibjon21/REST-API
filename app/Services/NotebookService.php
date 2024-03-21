<?php


namespace App\Services;

use App\Models\Notebook;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Expr\Cast\Bool_;

class NotebookService
{
    public function index($limit, $page): Paginator
    {
        $notes = Notebook::paginate($limit, ['*'], '', $page);
        return $notes;
    }
    public function store($request, $data): Bool
    {

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $data['photo'] = $file->store('public/photos');
        }

        $store = Notebook::create($data);
        if ($store) {
            return true;
        }

        return false;
    }
    public function show($id): Notebook|Bool
    {
        $notebook = Notebook::find($id);
        if (!$notebook) {
            return false;
        }
        return $notebook;
    }
    public function update($request, $notebook, $data): Bool|Response
    {
        $isHasRequest = false;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $data['photo'] = $file->store('photos');

            $isHasRequest = true;
        }

        if (isset($data['fio'])) {
            $update = $notebook->update([
                'fio' => $data['fio']
            ]);
            $isHasRequest = true;
        }
        if (isset($data['company'])) {

            $update = $notebook->update([
                'company' => $data['company']
            ]);

            $isHasRequest = true;
        }
        if (isset($data['phone'])) {
            $update = $notebook->update([
                'phone' => $data['phone']
            ]);

            $isHasRequest = true;
        }
        if (isset($data['email'])) {
            $update = $notebook->update([
                'email' => $data['email']
            ]);

            $isHasRequest = true;
        }

        if (isset($data['born_date'])) {
            $update = $notebook->update([
                'born_date' => $data['born_date']
            ]);

            $isHasRequest = true;
        }

        if (isset($data['photo'])) {
            $update = $notebook->update([
                'photo' => $data['photo']
            ]);

            $isHasRequest = true;
        }

        if (!$isHasRequest) {
            return response()->json([
                'message' => 'Unprocessable Entity'
            ], 422);
        }

        if ($update) {
            return true;
        }

        return false;
    }
    public function destroy($notebook): Bool
    {

        $delete = $notebook->delete();

        if ($delete) {
            return true;
        }

        return false;
    }
}
