@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-12 text-center">
            <img style="width: 300px" src="{{ url('img/universidad_nuevo.png') }}" alt="" class="img-fluid">
        </div>
        <div class="col-md-8">
            <div class="card" style="border: 0px">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row flex-column align-content-center">
                            <label for="email" class="col-md-6 col-form-label">Correo</label>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="Ingresa tu correo" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row flex-column align-content-center">
                            <label for="password" class="col-md-6 col-form-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Ingresa tu contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row flex-column align-content-center">
                            <div class="col-md-8 text-center">
                                <button type="submit" class="btn btn-success">
                                    Inicia sesión
                                </button>

                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-center pt-4" style="border-top: 2px solid #F6F6F6;">
           <!-- <a href="https://biblioteca.socasesores.com/" class="btn btn-outline-light" style="color: #015694; border: 2px solid #015694">Inicia sesión con usuario SISEC</a>-->
        </div>
    </div>
</div>
@endsection
