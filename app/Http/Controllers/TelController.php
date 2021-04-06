<?php

namespace App\Http\Controllers;

use App\Models\Tel;
use App\Repositories\TelRepository;
use Illuminate\Http\Request;

class TelController extends Controller
{
    public function __construct(Tel $tel){
        $this->tel = $tel;
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $telRepository = new TelRepository($this->tel);

       if($request->has('atributos_tel')) {
           $atributos_tel = 'contato:id,'.$request->atributos_tel;          

           $telRepository->selectAtributosRegistrosRelacionados($atributos_tel);
       } else{            
           $telRepository->selectAtributosRegistrosRelacionados('contato');
       }

       if($request->has('filtro')) {
           $telRepository->filtro($request->filtro);      
       }

       if($request->has('atributos')) {                     
           $telRepository->selectAtributos($request->atributos);
       } 
       //Fim do filtro
       
       return response()->json($telRepository->getResultado(), 200);
       
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
        $request->validate($this->tel->rules());      
        

        $tel = $this->tel->create([
            'contato_id' => $request->contato_id,            
            'telefone' =>$request->telefone,

        ]);   
        return response()->json($tel, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tel  $tel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tel = $this->tel->with('contatos')->find($id);
        if($tel === null){
            return response()->json(['ERROR' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($tel, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tel  $tel
     * @return \Illuminate\Http\Response
     */
    public function edit(Tel $tel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tel  $tel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tel = $this->tel->find($id);

        if($tel === null){
            return response()->json(['ERROR' => 'Impossivel realizar a atualização. Recurso pesquisado não existe'], 404);
        }

        if($request->method() === 'PATCH'){
            $regraDinamicas = array();

            //Metodo para percorrer todas as regras definidas no Model    
            foreach($tel->rules() as $input => $regra) {
                //Coletar as regras aplicaveis aos parâmetros da requisição
                if(array_key_exists($input, $request->all())) {
                    $regraDinamicas[$input] = $regra;
                }
            }            
            $request->validate($regraDinamicas);

        }else{
            $request->validate($tel->rules());
        }
        
        $tel->fill($request->all());        
        $tel->save();
        
        return response()->json($tel, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tel  $tel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tel $tel)
    {
        if($tel === null){
            return response()->json(['ERROR' => 'Impossivel realizar a exclusão. Recurso pesquisado não existe'], 404);
        }        

        $tel->delete();
        return response()->json(['msg' => 'O conteudo foi deletado com sucesso'], 200);
    }
}
