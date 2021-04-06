<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class End extends Model
{
    use HasFactory;

    protected $fillable = ['contato_id', 'endereco_rua', 'endereco_numero', 'endereco_bairro', 'endereco_cep', 'endereco_estado'];

     //Regras para inserção e atualização do DB
     public function rules(){
        return [
            'contato_id' => 'exists:contatos,id', 
            'endereco_rua' => 'required',
            'endereco_numero' => 'required',  
            'endereco_bairro' => 'required',  
            'endereco_cep' => 'required',  
            'endereco_estado' => 'required',                       
        ];
        
    }

    public function contato(){
        return $this->belongsTo('App\Models\Contato');
    }
}
