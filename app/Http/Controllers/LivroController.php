<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LivroController extends Controller
{
    public function index()
    {
        $livros = Livro::with(['generos', 'autor','editora'])->get();
        return response()->json($livros, 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'titulo' => 'required|string|max:50',
                'autor_id' => 'required|integer|exists:autors,id',
                'editora_id' => 'required|integer|exists:editoras,id',
                'ano' => 'required|integer|digits:4',
                'isbn' => 'required|string|max:17|unique:livros,isbn',
                'generos' => 'required|array',
                'generos.*' => 'integer|exists:generos,id'
            ]);
    
            $isbn = $request->isbn;
            $openLibraryUrl = "https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&jscmd=data&format=json";
            $response = Http::get($openLibraryUrl);
    
            if ($response->successful()) {
                $bookData = $response->json();
                $bookInfo = $bookData["ISBN:$isbn"] ?? null;

                $cover = $bookInfo['cover']['large'] ?? 'https://i.pinimg.com/564x/88/c2/21/88c221f5748e7f862c444f817513d782.jpg';

                $livro = Livro::create([
                    'titulo' => $request->titulo,
                    'autor_id' => $request->autor_id,
                    'editora_id' => $request->editora_id,
                    'ano' => $request->ano,
                    'cover' => $cover,
                    'isbn' => $request->isbn,
                ]);

                $livro->generos()->attach($request->generos);
                return response()->json($livro, 200);
            } else {
                return response()->json(['error' => 'ISBN não encontrado'], 404);
            }
    
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }    

    public function update(Request $request, $id)
{
    try {
        $livro = Livro::findOrFail($id);
        
        $request->validate([
            'titulo' => 'required|string|max:50',
            'autor_id' => 'required|integer|exists:autors,id',
            'editora_id' => 'required|integer|exists:editoras,id',
            'ano' => 'required|integer|digits:4',
            'isbn' => 'required|string|max:17|unique:livros,isbn,' . $livro->id,
            'generos' => 'required|array',
            'generos.*' => 'integer|exists:generos,id'
        ]);

        if ($livro->isbn !== $request->isbn) {
            $isbn = $request->isbn;
            $openLibraryUrl = "https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&jscmd=data&format=json";
            $response = Http::get($openLibraryUrl);

            if ($response->successful()) {
                $bookData = $response->json();
                $bookInfo = $bookData["ISBN:$isbn"] ?? null;

                if ($bookInfo) {
                    $cover = $bookInfo['cover']['large'] ?? null;

                    if ($cover === null) {
                        return response()->json(['error' => 'Capa não encontrada'], 404);
                    }
                } else {
                    return response()->json(['error' => 'ISBN não encontrado'], 404);
                }
            } else {
                return response()->json(['error' => 'Falha ao consultar o ISBN.'], 500);
            }
        } else {
            $cover = $livro->cover;
        }

        $livro->update([
            'titulo' => $request->titulo,
            'autor_id' => $request->autor_id,
            'editora_id' => $request->editora_id,
            'ano' => $request->ano,
            'isbn' => $request->isbn,
            'cover' => $cover
        ]);

        $livro->generos()->sync($request->generos);

        return response()->json($livro, 200);
    } catch (ValidationException $e) {
        return response()->json($e->validator->errors(), 422);
    } catch (ModelNotFoundException) {
        return response()->json(['message' => 'Livro não encontrado'], 404);
    }
}

    public function destroy($id)
    {
        try {
            $livro = Livro::findOrFail($id);
            $livro->delete();

            return response()->json(['message' => 'livro deletado com sucesso.'], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'livro não encontrado.'], 404);
        }
    }
}