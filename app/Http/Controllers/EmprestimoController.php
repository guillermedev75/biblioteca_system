<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmprestimoController extends Controller
{
    public function index()
    {
        $emprestimos = Emprestimo::with(['estoque','estoque.livro','cliente'])->get();
        return response()->json($emprestimos, 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'cliente_id' => 'required|integer|exists:clientes,id',
                'estoque_id' => 'required|integer|exists:estoques,id',
                'data_emprestimo' => 'required|date',
                'data_devolucao' => 'nullable|date',
                'data_limite' => 'required|date'
            ]);

            $emprestimo = Emprestimo::create([
                'cliente_id' => $request->cliente_id,
                'estoque_id' => $request->estoque_id,
                'data_emprestimo' => $request->data_emprestimo,
                'data_devolucao' => $request->data_devolucao,
                'data_limite' => $request->data_limite
            ]);

            return response()->json($emprestimo, 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $emprestimo = Emprestimo::findOrFail($id);

            $request->validate([
                'cliente_id' => 'required|integer|exists:clientes,id',
                'estoque_id' => 'required|integer|exists:estoques,id',
                'data_emprestimo' => 'required|date',
                'data_devolucao' => 'nullable|date',
                'data_limite' => 'required|date'
            ]);

            $emprestimo->update([
                'cliente_id' => $request->cliente_id,
                'estoque_id' => $request->estoque_id,
                'data_emprestimo' => $request->data_emprestimo,
                'data_devolucao' => $request->data_devolucao,
                'data_limite' => $request->data_limite
            ]);

            return response()->json($emprestimo, 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'emprestimo não encontrado.'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $emprestimo = Emprestimo::findOrFail($id);
            $emprestimo->delete();

            return response()->json(['message' => 'Emprestimo deletado'], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Emprestimo não encontrado'], 404);
        }
    }
}
