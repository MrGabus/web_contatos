<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tel extends Model
{
    use HasFactory;

    protected $fillable = ['contato_id', 'telefone'];

    //Regras para inserção e atualização do DB
    public function rules(){
       return [
           'contato_id' => 'exists:contatos,id', 
           'telefone' => 'required'           
       ];
       
   }

   public function contato(){
       return $this->belongsTo('App\Models\Contato');
   }
}
