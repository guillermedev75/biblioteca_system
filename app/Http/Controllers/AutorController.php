<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AutorController extends Controller
{

    public function index()
    {
        $autores = Autor::all();
        return response()->json($autores);
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'nome' => 'required|string|max:80|unique:autors,nome',
                'ano_nascimento' => 'required|integer|digits:4',
                'sexo' => 'required|string|max:10',
                'pais_origem' => 'required|string|max:60'
            ]);
            
            $autor = Autor::create([
                'nome' => $request->nome,
                'ano_nascimento' => $request->ano_nascimento,
                'sexo' => $request->sexo,
                'pais_origem' => $request->pais_origem
            ]);
            
            return response()->json($autor, 201);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $autor = Autor::findOrFail($id);

            $request->validate([
                'nome' => 'required|string|max:80|unique:autors,nome,' . $autor->id,
                'ano_nascimento' => 'required|integer|digits:4',
                'sexo' => 'required|string|max:10',
                'pais_origem' => 'required|string|max:60'
            ]);
            
            $autor->update([
                'nome' => $request->nome,
                'ano_nascimento' => $request->ano_nascimento,
                'sexo' => $request->sexo,
                'pais_origem' => $request->pais_origem
            ]);
            
            return response()->json($autor, 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Autor não encontrado'], 404);
        }
    }

    public function destroy($id)
    {
        try {

            $autor = Autor::findOrFail($id);
            
            $autor->delete();
            
            return response()->json(['message' => 'Autor excluido com sucesso'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Autor não encontrado'], 404);
        }
    }
}
