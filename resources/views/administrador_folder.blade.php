<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Biblioteca | SOC Universidad</title>
    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/ab58011517.js" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link rel="icon" type="image/png" href="https://socasesores.com/img/favicon.png">
    <link href="{{ url('css/main.css') }}" rel="stylesheet">
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PWWWBX');</script>
<!-- End Google Tag Manager -->
<style>
  svg{
    width: 20px;
  }
  .flex.justify-between.flex-1{
    display: none!important;
  }
  .menu-item{
    list-style-type: none;

  }
  .menu-item li{
    display: inline-block;
  }
</style>
</head>
<body>
    <div id="app">
             @if (Auth::check()) 
             <div class="container">
                 <div class="row">
                     <div class="col-12 text-right">
                        @php
                            session_start();
                            if (isset($_SESSION["name_user"])) {
                                $name_user = $_SESSION["name_user"];
                            }else{
                                $name_user = Auth::user()->name;
                            }
                        @endphp

                       {{ $name_user }}
                         <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Cerrar sesión') }}
                                        </x-dropdown-link>
                                    </form>                   
                        
                     </div>
                 </div>
             </div>
             @endif
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <a href="{{url('/')}}"><img src="{{url('img/universidad_nuevo.png')}}" style="width:200px"  alt="" class="img-fluid"></a>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="d-inline">
                            @if (Auth::check())   
                                @if(Auth::user()->type == 0 && Auth::user()->id_bank == 0)
                                    <form id="header_search" action="{{url('search')}}" method="post" class="d-inline">
                                    @csrf
                                        <input type="image" src="{{url('img')}}/loupe.png" class="loupe" alt="Submit Form" />
                                        <input type="text" class="search" name="search" placeholder="Buscar">
                                    </form>
                                                
                                @elseif(Auth::user()->type == 2)
                                    <form id="header_search" action="{{url('search')}}" method="post" class="d-inline">
                                    @csrf
                                        <input type="image" src="{{url('img')}}/loupe.png" class="loupe" alt="Submit Form" />
                                        <input type="text" class="search" name="search" placeholder="Buscar">
                                    </form>
                                                
                                @endif
                            @else
                                
                            @endif
                            
                        </div>
                         
                    </div>
                </div>
            </div>
        </header>
      <div class="container mt-4 pt-4">
        <div class="row">
            <div class="col-12">
                <ul class="menu-item">
                    <li><a class="btn btn-outline-success mr-2" href="https://biblioteca.socasesores.com/administrador/main/1">Hipotecario</a></li>
                    <li><a class="btn btn-outline-success mr-2" href="https://biblioteca.socasesores.com/administrador/main/2">Empresarial</a></li>
                    <li><a class="btn btn-outline-success mr-2" href="https://biblioteca.socasesores.com/administrador/main/6">Seguros</a></li>
                    <li><a class="btn btn-outline-success mr-2" href="https://biblioteca.socasesores.com/administrador/main/599">Venta Cruzada</a></li>
                </ul>
            </div>
          <div class="col-12">
            <table class="table">
      <thead class="thead-dark">
        <tr>
          <th>Archivo</th>
          <th>Ruta</th>
          <th>Descargas</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($archivos as $archivo)

          @php
            $folders = migas($archivo[0]);
          
            $migas = $folders["migas"];
            $migas_name = $folders["migas_name"];
            
          @endphp

          @if(count($folders["migas"]) > 0)
          <tr>
          <td>
          <ul style="list-style: none; padding-left: 0;" class="mt-4 mb-4">
                    <li class="ml-0 d-inline-block"><a href="https://biblioteca.socasesores.com/">Inicio</a></li>
                    @php
                        $count_migas = 0;
                    @endphp
                    
                    @if(count($migas) > 0)
                      @foreach ($migas as $miga)
                          <li class="ml-0 d-inline-block"><a href="https://biblioteca.socasesores.com/folder/{{ $miga }}"> / {{ $migas_name[$count_migas] }}</a></li>
                          @php
                              $count_migas++;
                          @endphp

                      @endforeach
                    @else
                    @endif
                </ul>
        
          </td>
          <td>{{ $archivo[1] }}</td>
          <td>{{ $archivo[2] }}</td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
    {{ $archivos->links() }}
          </div>
        </div>
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>