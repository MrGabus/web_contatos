<?php

namespace App\Http\Controllers;

use App\Models\End;
use App\Repositories\EndRepository;
use Illuminate\Http\Request;

class EndController extends Controller
{
    public function __construct(End $end){
        $this->end = $end;
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $endRepository = new EndRepository($this->end);

       if($request->has('atributos_end')) {
           $atributos_end = 'contato:id,'.$request->atributos_end;          

           $endRepository->selectAtributosRegistrosRelacionados($atributos_end);
       } else{            
           $endRepository->selectAtributosRegistrosRelacionados('contato');
       }

       if($request->has('filtro')) {
           $endRepository->filtro($request->filtro);      
       }

       if($request->has('atributos')) {                     
           $endRepository->selectAtributos($request->atributos);
       } 
       //Fim do filtro
       
       return response()->json($endRepository->getResultado(), 200);       
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
        $request->validate($this->end->rules());      
        

        $end = $this->end->create([
            'contato_id' => $request->contato_id,            
            'endereco_rua' =>$request->endereco_rua,
            'endereco_numero' => $request->endereco_numero,
            'endereco_bairro' => $request->endereco_bairro,
            'endereco_cep' => $request->endereco_cep,
            'endereco_estado' => $request->endereco_estado

        ]);   
        return response()->json($end, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\End  $end
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $end = $this->end->with('contatos')->find($id);
        if($end === null){
            return response()->json(['ERROR' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($end, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\End  $end
     * @return \Illuminate\Http\Response
     */
    public function edit(End $end)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\End  $end
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $end = $this->end->find($id);

        if($end === null){
            return response()->json(['ERROR' => 'Impossivel realizar a atualização. Recurso pesquisado não existe'], 404);
        }

        if($request->method() === 'PATCH'){
            $regraDinamicas = array();

            //Metodo para percorrer todas as regras definidas no Model    
            foreach($end->rules() as $input => $regra) {
                //Coletar as regras aplicaveis aos parâmetros da requisição
                if(array_key_exists($input, $request->all())) {
                    $regraDinamicas[$input] = $regra;
                }
            }            
            $request->validate($regraDinamicas);

        }else{
            $request->validate($end->rules());
        }
        
        $end->fill($request->all());        
        $end->save();
        
        return response()->json($end, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\End  $end
     * @return \Illuminate\Http\Response
     */
    public function destroy(End $end)
    {
        if($end === null){
            return response()->json(['ERROR' => 'Impossivel realizar a exclusão. Recurso pesquisado não existe'], 404);
        }        

        $end->delete();
        return response()->json(['msg' => 'O conteudo foi deletado com sucesso'], 200);
    }
}
