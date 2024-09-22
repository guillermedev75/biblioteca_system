<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EstoqueController extends Controller
{
    public function index()
    {
        $livro_estoque = Estoque::with('livro')->get();
        return response()->json($livro_estoque, 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'livro_id' => 'required|integer|exists:livros,id',
                'condicao' => 'required|string'
            ]);

            $livro_estoque = Estoque::create([
                'livro_id' => $request->livro_id,
                'condicao' => $request->condicao
            ]);

            return response()->json($livro_estoque, 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $estoque = Estoque::findOrFail($id);
            
            $request->validate([
                'livro_id' => 'required|integer|exists:livros,id',
                'condicao' => 'required|string'
            ]);

            $estoque->update([
                'livro_id' => $request->livro_id,
                'condicao' => $request->condicao
            ]);

            return response()->json($estoque, 200);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'livro de estoque não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function destroy($id) {
        try {
            $estoque = Estoque::findOrFail($id);
            $estoque->delete();
            
            return response()->json(['message' => 'Livro de estoque deletado com sucesso.'], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'livro de estoque não encontrado.'], 404);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }
}
