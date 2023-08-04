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
</head>
<body>
    <div id="app">
        <header>
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
                         @if (Auth::check())
                        
                        <div class="d-inline">
                                @if(Auth::user()->type == 0)
                                    <a href="" class="new-folder"><img src="{{url('img')}}/folder.png" alt="">
                                        Nueva Carpeta
                                    </a> 
                                @endif            
                           
                            
                            <div class="carpeta d-none">
                                <form method="POST" enctype="multipart/form-data" id="laravel-ajax-file-upload" action="javascript:void(0)" >
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" required>
                                    <label for="imagen">Imagen</label>
                                    <input type="file" name="imagen" id="imagen">
                                    <label for="folder_main">Guardar en</label>
                                    <div id="select_folder">
                                        <select name="folder_main" id="folder_main">
                                            <option value="" select hidden></option>
                                            @foreach($folders_main as $key => $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                        <select name="folder" id="folder" class="d-none"></select>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" value="1" id="visible_2" name="visible_2" style="margin-left: -7rem;">
                                        <label class="form-check-label" for="visible_2">¿Ocultar nombre?</label>
                                    </div>
                                    <input type="submit" class="btn btn-success" value="Guardar">
                                </form>
                            </div>
                        </div>
                       
                            <div class="d-inline">
                                 @if(Auth::user()->type == 0)
                                    <a href="" class="more-files d-inline-block"><img src="{{url('img')}}/plus.png" alt=""> Agregar material</a>
                                 @endif
                                
                                <div class="carpeta_2 d-none">
                                    <form method="POST" enctype="multipart/form-data" id="file-upload">
                                        <label for="imagen_2">Imagen</label>
                                        <input type="file" name="imagen_2[]" id="imagen_2" multiple="multiple" required>
                                        <label for="folder_main_2">Guardar en</label>
                                        <div id="select_folder">
                                            <select name="folder_main_2" id="folder_main_2" required data-bank="{{ Auth::user()->id_bank; }}" data-type="{{ Auth::user()->type; }}">
                                                <option value="" select hidden></option>
                                                
                                                    @foreach($folders_main as $key => $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                
                                            </select>
                                            <select name="folder_2" id="folder_2" class="d-none"></select>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" value="1" id="visible" name="visible" style="margin-left: -7rem;">
                                            <label class="form-check-label" for="visible">¿Ocultar nombre?</label>
                                        </div>
                                        <input type="submit" class="btn btn-success" value="Guardar">
                                    </form>
                                </div>
                            </div>        
                        @else
                        @endif
                    </div>
                </div>
            </div>
        </header>
        <main class="position-relative">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-md-3">
                    <div class="alert alert-success text-venter d-none" role="alert">
                        <strong>Se guardo con éxito</strong>
                    </div>
                    <div class="alert alert-danger text-center d-none" role="alert">
                        <strong>Archivo Eliminado</strong>
                    </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </main>
    </div>
     <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PWWWBX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>
    <div class="modal" id="exampleModalDelete2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-center w-100" id="exampleModalLabel">¿Deseas eliminar estos archivos?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <a href="" class="delete-multiple-send" style="color: red" data-id=""><i class="far fa-trash-alt" aria-hidden="true"></i> Sí eliminar</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Liquid Slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css">
    <link rel="stylesheet" href="{{ url('lib/liquidslider/css/liquid-slider.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
    <script src="{{ url('lib/liquidslider/js/jquery.liquid-slider.min.js') }}"></script>
    <script>
        if($('#slider').length){
            $('#slider').liquidSlider({
                includeTitle:false,
                slideEaseDuration:300,
                heightEaseDuration:1000,
                slideEaseFunction:'animate.css',
                animateIn:"fadeInRight",
                animateOut:"slideOutLeft",
                hideSideArrows: true,
                useCSSMaxWidth: 3000,
                dynamicArrows: false,
                swipe: false,
            });
            
            var api1 = $.data( $('#slider')[0], 'liquidSlider');
        }

        $(document).ready(function() {
            $('.filter_type_buttons label input').change(function(){
                var extension = $(this).val();
                $('.files_type_search .col-md-2').addClass("d-none");
                $('.files_type_search .'+extension).removeClass("d-none");
            });
            $('.tab-link').click(function(e) {
                $(this).addClass('active');
                $(this).parent().siblings().find('.tab-link').removeClass('active');
            })
            $('.new-folder').click(function(e){
                e.preventDefault();
                $(".carpeta").toggleClass("d-none");
                $(".carpeta_2").addClass("d-none");
            });
            $('.more-files').click(function(e){
                e.preventDefault();
                $(".carpeta_2").toggleClass("d-none");
                $(".carpeta").addClass("d-none");
            });
            $('.delete_file').click(function(e){
                e.preventDefault();
                var id = $(this).attr("id");
		if(confirm("¿Estás seguro de eliminar el elemento?") == true){ 
              	     $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{url('folder/delete_file')}}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(response){
                            console.log(response)
                            if(response === "Success"){
                                $(".alert-danger").removeClass("d-none");
                                $("#files_"+id).addClass("d-none");
                                $(".link_files_"+id).addClass("d-none");
                            }else{
                                
                            }
                        }
                    }); 
		}
            });
            $('.delete_folder').click(function(e){
                e.preventDefault();
                var id = $(this).attr("id");
		if(confirm("¿Estás seguro de eliminar el elemento?") == true){
               	   $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{url('folder/delete_folder')}}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(response){
                            if(response === "Success"){
                                $(".alert-danger").removeClass("d-none");
                                $("#folder_"+id).addClass("d-none");
                                $("#sub_folder"+id).addClass("d-none");
                                $("#"+id).addClass("d-none");
                                $(".link_folder_"+id).addClass("d-none");
                            }else{
                                
                            }
                        }
                    });
		} 
            });

            $('.counter_file').click(function(e){
                
                var id = $(this).attr("data-id");
                console.log(id);
      
                  $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ url('folder/contador') }}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(response){
                           console.log(response);
                        }
                    });
        
            });
            $('#folder_main').change(function(e){
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{url('folder/form_folder')}}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(response){
                            if(response["form_folder"][0] != null){
                                $("#folder").removeClass("d-none");
                                $("#folder").html('');
                                $("#folder").append('<option value="" select hidden></option>');
                                $.each(response["form_folder"], function(index, val) {
                                    $("#folder").append('<option value="'+val.id+'">'+val.name+'</option>');
                                });
                            }else{
                                $("#folder").addClass("d-none");
                                $("#folder").html('');
                            }
                        }
                }); 
            });

            $('#folder_main_2').change(function(e){
                e.preventDefault();
                var id = $(this).val();
                var type = $(this).attr("data-type");
                var id_bank = $(this).attr("data-bank");
                $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{url('folder/form_folder')}}",
                        type: 'POST',
                        data: {
                            id: id,
                            type: type,
                            id_bank: id_bank
                        },
                        success: function(response){
                            if(response["form_folder"][0] != null){
                                $("#folder_2").removeClass("d-none");
                                $("#folder_2").html('');
                                $("#folder_2").append('<option value="" select hidden></option>');
                                $.each(response["form_folder"], function(index, val) {
                                    $("#folder_2").append('<option value="'+val.id+'">'+val.name+'</option>');
                                });
                            }else{
                                $("#folder_2").addClass("d-none");
                                $("#folder_2").html('');
                            }
                        }
                }); 
            });

            $('#folder').change(function(e){
                e.preventDefault();
                var id = $(this).val();
                var text = $( "#folder option:selected" ).text();
                $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{url('folder/form_folder')}}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(response){
                            if(response["form_folder"][0] != null){
                                $("#folder").removeClass("d-none");
                                $("#folder").html('');
                                $("#folder").append('<option value="" select hidden></option>');
                                $.each(response["form_folder"], function(index, val) {
                                    $("#folder").append('<option value="'+val.id+'">'+val.name+'</option>');
                                });
                                $("#folder_main").html('<option value="'+id+'" select>'+text+'</option>');
                            }else{
                                
                            }
                        }
                }); 
            });

            $('#folder_2').change(function(e){
                e.preventDefault();
                var id = $(this).val();
                var text = $( "#folder_2 option:selected" ).text();
                
                $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{url('folder/form_folder')}}",
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response){
                            if(response["form_folder"][0] != null){
                                $("#folder_2").removeClass("d-none");
                                $("#folder_2").html('');
                                $("#folder_2").append('<option value="" select hidden></option>');
                                $.each(response["form_folder"], function(index, val) {
                                    $("#folder_2").append('<option value="'+val.id+'">'+val.name+'</option>');
                                });
                                $("#folder_main_2").html('<option value="'+id+'" select>'+text+'</option>');
                            }else{
                                
                            }
                        }
                }); 
            });

            $('#file-upload').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:'POST',
                    url: "{{ url('folder/file_insert')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $(".alert-success").removeClass("d-none");
                        $(".carpeta_2").addClass("d-none");
                        console.log(data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });

            $('#laravel-ajax-file-upload').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:'POST',
                    url: "{{ url('folder/insert')}}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $(".alert-success").removeClass("d-none");
                        $(".carpeta").addClass("d-none");
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });
            $(".more-link").click(function(e){
                e.preventDefault();
                var id = $(this).attr("data-id");
                
                $(this).parent().siblings().find(".menu-more-items").addClass("d-none");
                $(this).parent().parent().siblings().find(".menu-more-items").addClass("d-none");
                $(this).parent().parent().parent().siblings().find(".menu-more-items").addClass("d-none");
                $("#more_"+id).toggleClass("d-none");

                $(".more-name").addClass("d-none");
                $(".menu-more").removeClass("d-none");
                
                $('.more-name-btn-submit').remove();
                
                cancel_selection();
            });
            $(".more_name_link").click(function(e){
                e.preventDefault();
                var id = $(this).attr("data-id");
                $(".menu-more").removeClass("d-none");
                $(".more-name").addClass("d-none");
                $("#more-name-"+id).removeClass("d-none").focus();
                $('<a class="more-name-btn-submit fa fa-check"></a>').insertAfter("#more-name-"+id);
                $("#menu-more-"+id).addClass("d-none");
                $("#more_"+id).addClass("d-none");
            });
            $('.select_link').click(function(e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                $(".menu-more-items").addClass("d-none");
                $('.floating-checkbox').fadeIn('fast');
                $('.delete-multiple-btn').fadeIn('fast');
                $(this).parent().siblings('label').find('[data-id="'+id+'"]').prop('checked',true);
                /*$('[data-id="'+id+'"][name="select_folder[]"]').prop('checked',true);
                $('[data-id="'+id+'"][name="select[]"]').prop('checked',true);*/
            });

            $('#header_search').on('submit',function(e) {
                let s = $(this).find('[name="search"]').val()
                if(s !== null && s !== '' && s.length){
                    return true;
                } else{
                    return false;
                }
            });

            $("input").on("focus", function() {
                var a = $(this).parent().parent().parent();
                $(a).on("click", function (event) {
                  event.preventDefault();
                  $(a).off();
                });
            });

            // Actualizar nombre con ENTER o click al botón
            $('.more-name').keypress(function(event){
              var id = $(this).attr("data-id");
              var type = $(this).attr("data-type");
              var name = $(this).val();
              var keycode = (event.keyCode ? event.keyCode : event.which);
              if(keycode == '13'){
                update_name(id,type,name);
              }
            });
            $('body').on('click','.more-name-btn-submit',function(e){
              var id = $(this).prev().attr("data-id");
              var type = $(this).prev().attr("data-type");
              var name = $(this).prev().val();

              update_name(id,type,name);
            });
            function update_name(id,type,name){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('update-file')}}",
                    type: 'POST',
                    data: {
                      id: id,
                      type: type,
                      name: name
                    },
                    success: function(response){
                        console.log('Response: '+response);
                        // $(".more-name").addClass("d-none");
                        // $(".more-name").removeClass("d-none");
                        $('.more-name-btn-submit').remove();
                        $("#more-name-"+id).addClass("d-none");
                        //  $("#menu-more-"+id+' > span').html(name);
                        $("#menu-more-"+id).removeClass("d-none");
            			if(response.length && response == "Success"){
                            $("#menu-more-"+id+' > p').html(name);
            			    $("#menu-more-"+id+' > span').html(name);
            			    if(type=='file'){$('#files_'+id).attr('href','{{ asset('img/archivos') }}/'+name);}
            			} else if(name !== $('#menu-more-'+id+' > span.list-view-name').html()){
            			    alert(response);
            			}
                    },
                    error: function(xhr, textStatus, error) {
                      console.log(xhr.responseText);
                      console.log(xhr.statusText);
                      console.log(textStatus);
                      console.log(error);
                    }
                }); 
            };
            $("#cuadricula").click(function(e){
                e.preventDefault();
                $(".tab-pane").removeClass("lista-view");
                $(".folder-1").removeClass("lista-view");
            });
            $("#lista").click(function(e){
                e.preventDefault();
                $(".tab-pane").addClass("lista-view");
                $(".folder-1").addClass("lista-view");
            });
            $(".delete-multiple-send").click(function(e){
              e.preventDefault();
              let archivos = [];
              let folder = [];
              $('.archivos_multiple:checked').each(function() {
                  archivos.push($(this).attr("data-id"));
              });
              $('.folder_multiple:checked').each(function() {
                  folder.push($(this).attr("data-id"));
              });
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('delete_file_multiple')}}",
                type: 'POST',
                data: {
                  archivos: archivos,
                },
                success: function(response){
                  $.each(archivos, function(index, val) {
                    $("#content_files_"+val).addClass("d-none");
                  });
                },
                error: function(xhr, textStatus, error) {
                  console.log(xhr.responseText);
                  console.log(xhr.statusText);
                  console.log(textStatus);
                  console.log(error);
                }
              });
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('delete_folder_multiple')}}",
                type: 'POST',
                data: {
                  folder: folder,
                },
                success: function(response){
                  $.each(folder, function(index, val) {
                    $("#sub_folder"+val).addClass("d-none");
                    $("#home_folder"+val).addClass("d-none");
                  });
                },
                error: function(xhr, textStatus, error) {
                  console.log(xhr.responseText);
                  console.log(xhr.statusText);
                  console.log(textStatus);
                  console.log(error);
                }
              });

              // Cerramos modal
                $('#exampleModalDelete2').modal('hide');
                $('.floating-checkbox').hide();
                $('.delete-multiple-btn').hide();
            });

            $('#cancel_selection').click(cancel_selection);

            function cancel_selection(e) {
                $('.floating-checkbox input[type="checkbox"]').prop('checked',false);
                $('.floating-checkbox').hide();
                $('.delete-multiple-btn').hide();
            }

            $('#duplicate_folder').change(function(e){
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{url('folder/form_folder')}}",
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(response){
                        console.log('change');
                        if(response["form_folder"][0] != null){
                            $("#duplicate_folder_child").removeClass("d-none");
                            $("#duplicate_folder_child").html('');
                            $("#duplicate_folder_child").append('<option value="" select hidden></option>');
                            $.each(response["form_folder"], function(index, val) {
                                $("#duplicate_folder_child").append('<option value="'+val.id+'">'+val.name+'</option>');
                            });
                        }else{
                            $("#duplicate_folder_child").addClass("d-none");
                            $("#duplicate_folder_child").html('');
                        }
                    }
                }); 
            });

            $(".clone-multiple").click(function(e){
                $('#move_container').slideUp();
                $('#duplicate_container').slideToggle();
            });

            $("#duplicate_container").submit(function(e){
              e.preventDefault();
              let archivos = [];
              let folder = [];
              
              var folder_id = $('#duplicate_folder').val();
              var subfolder_id = $('#duplicate_folder_child').val();

              var destino = subfolder_id !== '' && subfolder_id !== null ? subfolder_id : folder_id;

              var validation_archivos = '';
              var validation_folder = '';
              $('.archivos_multiple:checked').each(function() {
                  archivos.push($(this).attr("data-id"));
              });
              $('.folder_multiple:checked').each(function() {
                  folder.push($(this).attr("data-id"));
              });
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('clone_file_multiple') }}",
                type: 'POST',
                data: {
                  destino: destino,
                  ids: archivos,
                },
                beforeSend: function() {
                    console.log(destino);
                },
                success: function(response){
                   if(archivos.length > 0) { validation_archivos = true; }
                },
                error: function(xhr, textStatus, error) {
                  console.log(xhr.responseText);
                  console.log(xhr.statusText);
                  console.log(textStatus);
                  console.log(error);
                }
              });
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('clone_folder_multiple') }}",
                type: 'POST',
                data: {
                  destino: destino,
                  ids: folder,
                },
                beforeSend: function() {
                    console.log(destino);
                },
                success: function(response){
                  if(folder.length > 0) { validation_folder = true; }
                },
                error: function(xhr, textStatus, error) {
                  console.log(xhr.responseText);
                  console.log(xhr.statusText);
                  console.log(textStatus);
                  console.log(error);
                }
              });

              if(
                (archivos.length > 0 && validation_archivos == true) ||
                (folder.length > 0 && validation_folder == true)
              ){
                location.reload();
              }
              $('#duplicate_container').slideUp();
              cancel_selection();
            });

            $('.move-multiple').click(function(e) {
                $('#duplicate_container').slideUp();
                $('#move_container').slideToggle();
            })

            $('#move_folder').change(function(e){
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{url('folder/form_folder')}}",
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(response){
                        console.log('change');
                        if(response["form_folder"][0] != null){
                            $("#move_folder_child").removeClass("d-none");
                            $("#move_folder_child").html('');
                            $("#move_folder_child").append('<option value="" select hidden></option>');
                            $.each(response["form_folder"], function(index, val) {
                                $("#move_folder_child").append('<option value="'+val.id+'">'+val.name+'</option>');
                            });
                        }else{
                            $("#move_folder_child").addClass("d-none");
                            $("#move_folder_child").html('');
                        }
                    }
                }); 
            });

            $('#move_folder_child').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var nameSelected = $(this).find('option:selected').text();

                $("#move_folder").html("");

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{url('folder/form_folder')}}",
                    type: 'POST',
                    data: {
                        id: valueSelected,
                    },
                    success: function(response){
                      console.log(move_folder);
                      console.log(response);
                      $('#move_folder').append('<option value="'+valueSelected+'" selected>'+nameSelected+'</option>');
                        if(response["form_folder"][0] != null){
                            $("#move_folder_child").removeClass("d-none");
                            $("#move_folder_child").html('');
                            $("#move_folder_child").append('<option value="" select hidden></option>');
                            $.each(response["form_folder"], function(index, val) {
                                $("#move_folder_child").append('<option value="'+val.id+'">'+val.name+'</option>');
                            });
                        }else{
                            $("#move_folder_child").addClass("d-none");
                            $("#move_folder_child").html('');
                        }
                        
                        
                    },
                    error: function(xhr, textStatus, error) {
                        console.log(xhr.responseText);
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                    }
                });
               
        
        });


            $("#move_container").submit(function(e){
              e.preventDefault();
              let archivos = [];
              let folder = [];
              
              var folder_id = $('#move_folder').val();
              var subfolder_id = $('#move_folder_child').val();

              var destino = subfolder_id !== '' && subfolder_id !== null ? subfolder_id : folder_id;

              $('.archivos_multiple:checked').each(function() {
                  archivos.push($(this).attr("data-id"));
              });
              $('.folder_multiple:checked').each(function() {
                  folder.push($(this).attr("data-id"));
              });
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('move_file_multiple') }}",
                type: 'POST',
                data: {
                  destino: destino,
                  ids: archivos,
                },
                beforeSend: function() {
                    console.log(destino);
                },
                success: function(response){
                  $.each(archivos, function(index, val) {
                    $("#content_files_"+val).addClass("d-none");
                  });                   
                },
                error: function(xhr, textStatus, error) {
                  console.log(xhr.responseText);
                  console.log(xhr.statusText);
                  console.log(textStatus);
                  console.log(error);
                }
              });
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('move_folder_multiple') }}",
                type: 'POST',
                data: {
                  destino: destino,
                  ids: folder,
                },
                beforeSend: function() {
                    console.log(destino);
                },
                success: function(response){
                  $.each(folder, function(index, val) {
                    $("#sub_folder"+val).addClass("d-none");
                    $("#home_folder"+val).addClass("d-none");
                  });
                  
                },
                error: function(xhr, textStatus, error) {
                  console.log(xhr.responseText);
                  console.log(xhr.statusText);
                  console.log(textStatus);
                  console.log(error);
                }
              });

              $('#move_container').slideUp();
              cancel_selection();
            });
        });
    </script>
   
</html>
