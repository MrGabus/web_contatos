{{ $slot }}  

<script>
    
    

    function testes() {
                let xmlHttp = new XMLHttpRequest();
                let user = {{ Auth::user()->id }}
                xmlHttp.open('GET', 'api/contato?'.user)
                console.log(xmlHttp)

                xmlHttp.onreadystatechange = () =>{
                    if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
                        
                        let JSONtestes = xmlHttp.responseText

                        let objJSONtestes = JSON.parse(JSONtestes)
                        //console.log(JSONtestes) 
                        let num = 0                        

                        //console.log(objJSONtestes)               
                        
                        
                        for(let i in objJSONtestes){

                            let item = objJSONtestes[i]

                            //console.log(item)
                            /*
                            let divRow = document.createElement('div')
                            divRow.className = 'row'

                            let divCol = document.createElement('div')
                            divCol.className = 'col'

                            let p1 = document.createElement('p')
                            p1.innerHTML = '<strong>Título:</strong> ' + item.titulo

                            let p2 = document.createElement('p')
                            p2.innerHTML = '<strong>Resumo:</strong> ' + item.resumo

                            let genero = ''
                            for(let g in item.generos) {
                                if(genero){
                                    genero += ', '
                                }
                                genero += item.generos[g].genero
                            }

                            let p3 = document.createElement('p')
                            p3.innerHTML = '<strong>Gênero:</strong> ' + genero

                            let elenco = ''
                            for(let e in item.elenco) {
                                if(elenco){
                                    elenco += ', '
                                }
                                elenco += item.elenco[e].ator
                            }

                            let p4 = document.createElement('p')
                            p4.innerHTML = '<strong>Elenco:</strong> ' + elenco

                            let p5 = document.createElement('p')
                            p5.innerHTML = '<strong>Data de lançamento:</strong> ' + item.dataLancamento.data + ' (' + item.dataLancamento.pais + ')'

                            let hr = document.createElement('hr')

                            divRow.appendChild(divCol)
                            divCol.appendChild(p1)
                            divCol.appendChild(p2)
                            divCol.appendChild(p3)
                            divCol.appendChild(p4)
                            divCol.appendChild(p5)
                            divCol.appendChild(hr)

                            document.getElementById('lista').appendChild(divRow)*/
                            
                        }
                        xmlHttp.send();
                    }
                    
                    if(xmlHttp.readyState == 4 && xmlHttp.status == 404){
                        //
                    }
                }                
            }
</script>

<div class="container bootstrap snippets bootdey">
    <button type="button" class="btn btn-success" onclick="testes()" >Contatos</button>

    {{--<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body p-t-0">
                    <div class="p-2 input-group">
                        <input type="text" id="example-input1-group2" name="example-input1-group2" class="form-control" placeholder="Pesquisa">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    
    <div class="row">            
        
        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-body p-t-10">
                    <div class="media-main">
                        <a class="pull-left" href="#">
                            <img class="thumb-lg img-circle bx-m" src="{{ asset('imagem/user_1.jpg') }}" alt="">
                        </a>
                        <div class="pull-right btn-group-sm">
                            <a href="#" class="btn btn-success tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="#" class="btn btn-danger tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Delete">
                                <i class="fa fa-close"></i>
                            </a>
                        </div>
                        <div class="info">
                            <h2 id="user">?</h2>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>                   
                </div>
            </div>
        </div>

        
        
        
    </div>
</div>