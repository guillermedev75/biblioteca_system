<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'autor_id',
        'editora_id',
        'ano',
        'isbn'
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }

    public function generos()
    {
        return $this->belongsToMany(Genero::class, 'livro_generos');
    }

    public function estoque()
    {
        return $this->hasOne(Estoque::class);
    }
}