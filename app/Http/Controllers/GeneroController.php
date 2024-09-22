<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GeneroController extends Controller
{

    public function index()
    {
        $generos = Genero::all();
        return response()->json($generos, 200);
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'genero' => 'required|string|max:100|unique:generos,genero'
            ]);
            
            $genero = Genero::create([
                'genero' => $request->genero,
            ]);
            
            return response()->json($genero, 201);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $genero = Genero::findOrFail($id);

            $request->validate([
                'genero' => 'required|string|max:100|unique:generos,genero,' . $genero->id,
            ]);
            
            $genero = Genero::findOrFail($id);
            
            $genero->update([
                'genero' => $request->genero,
            ]);
            
            return response()->json($genero, 200);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message'=> 'Genero não encontrado'], 404);
        }
    }

    public function destroy($id)
    {
        try {

            $genero = Genero::findOrFail($id);
            
            $genero->delete();
            
            return response()->json(['message' => 'Genero deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Genero não encontrado'], 404);
        }
    }
}