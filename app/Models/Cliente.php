<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'sexo', 'contato1', 'contato2', 'endereco', 'cep', 'numero'];

    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }
}
