<?php

namespace App\Http\Controllers;

use App\Models\Editora;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EditoraController extends Controller
{
    public function index()
    {
        $editoras = Editora::all();
        return response()->json($editoras, 200);
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'nome' => 'required|string|max:50|unique:editoras,nome'
            ]);
            
            $editora = Editora::create([
                'nome' => $request->nome,
            ]);

            return response()->json($editora, 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $editora = Editora::findOrFail($id);

            $request->validate([
                'nome' => 'required|string|max:50|unique:editoras,nome,' . $editora->id,
            ]);

            $editora->update([
                'nome' => $request->nome
            ]);

            return response()->json($editora, 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Editora não encontrada'], 404);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $editora = Editora::findOrFail($id);
            $editora->delete();
            return response()->json(['message' => 'Editora deleteada com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => "Editora não encontrada"], 404);
        }
    }
}
