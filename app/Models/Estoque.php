<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    protected $fillable = [
        'livro_id',
        'condicao'
    ];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function emprestimo()
    {
        return $this->hasMany(Emprestimo::class);
    }
}
