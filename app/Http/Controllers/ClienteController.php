<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClienteController extends Controller
{
    public function index()
    {
        $cliente = Cliente::all();
        return response()->json($cliente, 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:80',
                'sexo' => 'required|string|max:10',
                'contato1' => 'required|string|max:80',
                'contato2' => 'required|string|max:80',
                'endereco' => 'required|string|max:120',
                'cep' => 'required|string|max:10',
                'numero' => 'required|integer|max:10000|digits_between:1,5'
            ]);

            $cliente = Cliente::create([
                'nome'=> $request->nome,
                'sexo'=> $request->sexo,
                'contato1'=> $request->contato1,
                'contato2'=> $request->contato2,
                'endereco'=> $request->endereco,
                'cep'=> $request->cep,
                'numero'=> $request->numero
            ]);

            return response()->json($cliente, 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);

            $request->validate([
                'nome' => 'string|max:80',
                'sexo' => 'string|max:10',
                'contato1' => 'string|max:80',
                'contato2' => 'string|max:80',
                'endereco' => 'string|max:120',
                'cep' => 'string|max:10',
                'numero' => 'integer|max:10000|digits_between:1,5'
            ]);

            $cliente->update([
                'nome'=> $request->nome,
                'sexo'=> $request->sexo,
                'contato1'=> $request->contato1,
                'contato2'=> $request->contato2,
                'endereco'=> $request->endereco,
                'cep'=> $request->cep,
                'numero'=> $request->numero
            ]);

            return response()->json($cliente, 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => "Cliente não encontrado."], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();

            return response()->json(['message' => 'cliente deletado com sucesso.'], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        } 
    }
}   
