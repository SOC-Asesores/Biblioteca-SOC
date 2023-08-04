<?php
use Illuminate\Http\Request;
use App\Models\Folders;
use App\Models\Archivos;

    function getFolders($id){
        $folders_child = Folders::where("id_folder","=",$id)->get();
        return $folders_child;
    }

    function migas($id_folder){
        $migas = array();
            $migas_name = array();
            for ($i = 1; $i <= 100; $i++) { 
                $folder_busqueda = Folders::where('id', $id_folder)->first();
                if($folder_busqueda != null){
                     $last_folder = $folder_busqueda->id_folder;
                    if ($last_folder != 0) {
                        array_push($migas, $folder_busqueda->url);
                        array_push($migas_name, $folder_busqueda->name);
                    }else{
                        array_push($migas, $folder_busqueda->url);
                        array_push($migas_name, $folder_busqueda->name);
                        break;
                    }
                    $id_folder = $folder_busqueda->id_folder;
                }
               
                
            }

            $migas = array_reverse($migas);
            $migas_name = array_reverse($migas_name);

            
            return ['migas'=>$migas,'migas_name'=>$migas_name];
    }
