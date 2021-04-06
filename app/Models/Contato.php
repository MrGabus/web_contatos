<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'imagem', 'user_id'];

    //Regras para inserção e atualização do DB
    public function rules(){
        return [
            'nome' => 'required|min:3',            
        ];
        
    }

    public function feedback() {
        return [
            'nome.required' => 'O campo Nome é obrigatório.',          
            'nome.min' => 'O nome da deve ter no mínimo 3 caracteres'
        ];
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function telefoneContato(){
        //Um contato possui varios conteudos
        return $this->hasMany('App\Models\Tel');
    }

    public function endContato(){
        //Um contato possui varios conteudos
        return $this->hasMany('App\Models\End');
    }
}
