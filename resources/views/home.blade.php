@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
                <div class="card-header">Contatos</div>                   
                    @component('layouts.contatos')                   
                    @endcomponent                      
                </div>             
            
        </div>
    </div>
</div>
@endsection

{{--
     @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
    --}}
