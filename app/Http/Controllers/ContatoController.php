<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use App\Repositories\ContatoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContatoController extends Controller
{
    public function __construct(Contato $contato){
        $this->contato = $contato;
        //$this->middleware('auth');
    }  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Inicio filtro

        $contatoRepository = new ContatoRepository($this->contato);

        if($request->has('atributos_contato')) {
            $atributos_contato = 'user:id,'.$request->atributos_contato;          

            $contatoRepository->selectAtributosRegistrosRelacionados($atributos_contato);
        } else{            
            $contatoRepository->selectAtributosRegistrosRelacionados('user');
        }

        if($request->has('filtro')) {
            $contatoRepository->filtro($request->filtro);      
        }

        if($request->has('atributos')) {                       
            $contatoRepository->selectAtributos($request->atributos);
        } 
        //Fim do filtro*/
        
        return response()->json($contatoRepository->getResultado(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->contato->rules(), $this->contato->feedback());                        

        $contato = $this->contato->create([
            'nome' => $request->nome,
            'user_id' => $request->user_id            
        ]);   
        return response()->json($contato, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contato = $this->contato->with('telefonecontato', 'endcontato')->find($id);
        if($contato === null){
            return response()->json(['ERROR' => 'Recurso pesquisado não existe'], 404);
        }
        //return response()->json($contato, 200);
        return view('contato', ['contato'=> $contato->toArray(),]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function edit(Contato $contato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contato = $this->contato->find($id);

        if($contato === null){
            return response()->json(['ERROR' => 'Impossivel realizar a atualização. Recurso pesquisado não existe'], 404);
        }

        if($request->method() === 'PATCH'){
            $regraDinamicas = array();

            //Metodo para percorrer todas as regras definidas no Model    
            foreach($contato->rules() as $input => $regra) {
                //Coletar as regras aplicaveis aos parâmetros da requisição
                if(array_key_exists($input, $request->all())) {
                    $regraDinamicas[$input] = $regra;
                }
            }            
        $request->validate($regraDinamicas, /*$contato->feedback()*/);

        }else{
            $request->validate($contato->rules(), $contato->feedback());
        }

        //Remove o arquivo antigo caso tenha sido enviado um novo.
        if($request->file('imagem')) {                     
            Storage::disk('public')->delete($contato->imagem);
        }
        
        if($request->file('imagem') != null){
            $imagem = $request->file('imagem');
        //Armazenando imagem em Storage/App/Public
        $imagem_urn = $imagem->store('imagens\contato', 'public');
        
        $contato->fill($request->all());
        $contato->imagem = $imagem_urn;
        }
        

        $contato->save();
       
        return response()->json($contato, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contato = $this->contato->find($id);
        
        if($contato === null){
            return response()->json(['ERROR' => 'Impossivel realizar a exclusão. Recurso pesquisado não existe'], 404);
        }

        //Deleta a imagem do disco       
        //Storage::disk('public')->delete($contato->imagem);
        

        $contato->delete();
        return response()->json(['msg' => 'O contato foi deletado com sucesso'], 200);
    }
}
