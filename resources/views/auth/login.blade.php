@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">                    
                    <form name="formLogin" >
                        @csrf

                        <div class="form-group row">                           
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">                                    
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>                                 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">                                                                                                      
                                    <!-- Mensagens de Erro -->
                                    <div class="alert alert-danger mt-3 d-none messageBox" role="alert">                                        
                                    </div>                                                                        
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>

    <script>
        $(function(){
            $('form[name="formLogin"]').submit(function(event){
                //evento para prever a ação padrão
                //ou seja, não deixa atualizar a página
                event.preventDefault(); 

                //pegar valor do campo email
                //var email = $(this).fing('input#email').val();

                //Serializar recebimento de campos do forme e enviar para destino
                $.ajax({
                    url: "{{ route('admin.login.do') }}",
                    type: "post",
                    //pega todos os valores do form
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response){
                        if(response.success === true){                            
                            window.location.href = "{{ route('admin') }}";
                        }else{
                            $('.messageBox').removeClass('d-none').html(response.message);                            
                        }                        
                        console.log(response);
                    }
                });                
            });
        });
    </script>
@endsection
