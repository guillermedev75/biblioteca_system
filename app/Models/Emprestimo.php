<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'estoque_id', 'data_emprestimo', 'data_devolucao', 'data_limite'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function estoque()
    {
        return $this->belongsTo(Estoque::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
