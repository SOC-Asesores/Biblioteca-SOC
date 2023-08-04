<?php

namespace App\Http\Controllers;
use App\Models\Folders;
use App\Models\Archives;
use App\Models\User;
use App\Utils\Paginate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class foldersController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->id_bank != 0) {
                $folders = Folders::where('id',Auth::user()->id_bank)->orderBy('id','asc')->get();
                return view('user',['folders_main'=>$folders]);
            }else{
                $folders = Folders::where('id_folder',0)->orderBy('id','asc')->get();
                return view('user',['folders_main'=>$folders]);
            }
        }
        else{
            $folders = Folders::where('id_folder',0)->orderBy('id','asc')->get();
            return view('user',['folders_main'=>$folders]);
        }
        
    }
    public function update_file(Request $request)
    {
        if ($request->type === "folder") {
            $folder = Folders::find($request->id);
            $url = Str::slug($request->name, '-');
            $url = $url."-".rand();
            $folder->url = $url;
            $folder->name = $request->name;
            $folder->save();
            return "Success";
        } else{
            if(!file_exists(public_path('img/archivos/'.$request->name))){
                $archive = Archives::find($request->id);

                $old_name = $archive->img;

                $archive->img = $request->name;
                $archive->save();

                $location = 'img/archivos/';
                if(\File::move($location.$old_name, $location.$request->name)){
                    return "Success";
                } else{
                    return "File not found. ".$location.$old_name;
                }

            } else{
                return "File already exist";
            }
        }
    }
    public function form_folder(Request $request)
    {
        $id = $request->id;
        $folders = Folders::where('id_folder',$id)->orderBy('id','asc')->get();
        $folders_main = Folders::where('id_folder',0)->orderBy('id','asc')->get();
        return ['form_folder'=>$folders,'folders_main'=>$folders_main];
    }
    public function folder_insert(Request $request)
    {

            if (isset($request->folder)) {
                $id_folder = $request->folder;
            }elseif (isset($request->folder_main)) {
                $id_folder = $request->folder_main;
            }else{
                $id_folder = 0;
            }
            
            if (isset($request->visible_2)) {
                $visible = $request->visible_2;
            }else{
                $visible = 0;
            }

            if($request->file('imagen')) {
                $file = $request->file('imagen');
                $file_name = $file->getClientOriginalName();
                $imagen = $file_name;

                $location = 'img';
                $file->move($location,$imagen);
            }else{
                $imagen = "soc.png";
            }
            
            $url = Str::slug($request->nombre, '-');
            $url = $url."-".rand();
            $registro = Folders::insertGetId([
                'name' => $request->nombre,
                'img' => $imagen,
                'url' => $url,
                'hide' => $visible,
                'id_folder' => $id_folder
            ]);
            return Response()->json([
                "success" => true
            ]);
        
    }
    public function file_insert(Request $request)
    {
        if($request->file('imagen_2')) {
            if (isset($request->folder_2)) {
                $id_folder = $request->folder_2;
            }else{
                $id_folder = $request->folder_main_2;
            }
            if (isset($request->visible)) {
                $visible = $request->visible;
            }else{
                $visible = 0;
            }
  

            if($request->hasfile('imagen_2'))
            {
                foreach($request->file('imagen_2') as $file)
                {
                    $file_name = $file->getClientOriginalName();
                    $imagen = $file_name;
        
                    $location = 'img/archivos';
                    $file->move($location,$imagen);
                    $registro = Archives::insertGetId([
                        'img' => $imagen,
                        'id_folder' => $id_folder,
                        'hide' => $visible
                    ]);
                }
            }

           
            return Response()->json([
                "success" => true
            ]);
        }else{
            return Response()->json([
                "success" => false
          ]);

        }
    }
    public function delete_multiple(Request $request)
    {
        if(isset($request->archivos) && !empty($request->archivos)){
        foreach ($request->archivos as $key => $value) {
            $id = intval($value);
            $files = Archives::where('id', $id)->first();
                $path = public_path()."/archivos/".$files->url;
                if(file_exists($path)){
                    @unlink($path); }
                
            Archives::destroy($id);
        } }

        return "Success";
    }
    public function delete_multiple_folder(Request $request)
    {
        if(isset($request->folder) && !empty($request->folder)){
        foreach ($request->folder as $key => $value) {
            $id = intval($value);
            $files = Folders::where('id', $id)->first();
            Folders::destroy($id);
        } }

        return "Success";
    }
    public function main_folder($main_folder, Request $request)
    {

        if (Auth::check()) {
            if (Auth::user()->id_bank != 0) {
                $folders_main = Folders::where('id',Auth::user()->id_bank)->orderBy('id','asc')->get();
            }else{
                $folders_main = Folders::where('id_folder',0)->orderBy('id','asc')->get();
            }
        }
        else{
            $folders_main = Folders::where('id_folder',0)->orderBy('id','asc')->get();
        }

        $folder = Folders::where('url',$main_folder)->first();
        if ($folder === null) {
            
        }else{
            $id_folder = $folder->id;
            $title_folder = $folder->name;
            $folders = Folders::where('id_folder',$id_folder)->orderBy('id','asc')->get();
            $archives = array();
            $sub_folders = array();
            if ($folders != null) {
                # code...
            }
            foreach ($folders as $key => $value) {
                $folder = Folders::where('id_folder',$value->id)->orderBy('id','asc')->get();
                array_push($sub_folders, $folder);
            }
            foreach ($folders as $key => $value) {
                $archive = Archives::where('id_folder',$value->id)->orderBy('img','asc')->get();
                array_push($archives, $archive);
            }
            return view('folder',['folders'=>$folders,'title_folder'=>$title_folder,'url_folder'=>$main_folder,'sub_folders'=>$sub_folders,'archives'=>$archives,'folders_main'=>$folders_main]);
        }
    }
    public function sub_folder($main_folder, Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->id_bank != 0) {
                $folders_main = Folders::where('id',Auth::user()->id_bank)->orderBy('id','asc')->get();
            }else{

                $folders_main = Folders::where('id_folder',0)->orderBy('id','asc')->get();
            }
        }
        else{
            $folders_main = Folders::where('id_folder',0)->orderBy('id','asc')->get();
        }

        $folder = Folders::where('url',$main_folder)->first();
        if ($folder === null) {
            
        }else{
            $id_folder_main = $folder->id;
            $id_folder = $folder->id;
            $last_folder = $folder->id_folder;
            $migas = array();
            $migas_name = array();
            for ($i = 1; $i <= 100; $i++) { 
                $folder_busqueda = Folders::where('id', $id_folder)->first();
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

            $migas = array_reverse($migas);
            $migas_name = array_reverse($migas_name);
            $title_folder = $folder->name;
            $main_folder = $folder->url;
            $sub_folders = Folders::where('id_folder',$folder->id)->orderBy('id','asc')->get();

            $archives = Archives::where('id_folder',$folder->id)->orderBy('img','asc')->get();
            return view('subfolder',['id_folder'=>$id_folder_main,'title_folder'=>$title_folder,'url_folder'=>$main_folder,'sub_folders'=>$sub_folders,'archives'=>$archives,'folders_main'=>$folders_main, 'migas' => $migas, 'migas_name' => $migas_name]);
        }
    }
    public function search(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->id_bank != 0) {
                $folders_main = Folders::where('id',Auth::user()->id_bank)->orderBy('id','asc')->get();
                $searchTerm = $request->search;
                $archives = Archives::where('img', 'LIKE', "%{$searchTerm}%")->orderBy('img', 'asc')->get();
                $sub_folders = Folders::where('name', 'LIKE', "%{$searchTerm}%")->orderBy('name', 'asc')->get();

                $extensiones = array();
                foreach ($archives as $key => $value) {
                    $split = explode(".", $value->img);
                    $extension = end($split);
                    $search_split = array_search($extension, $extensiones);
                    if ($search_split === false) {
                        array_push($extensiones, $extension);
                    }
                }
                return view('search',['sub_folders'=>$sub_folders, 'archives'=>$archives, 'extensiones' => $extensiones ,'folders_main'=>$folders_main,'title_folder'=>$searchTerm]);
            }else{
                $folders_main = Folders::where('id_folder',0)->orderBy('id','asc')->get();
                $searchTerm = $request->search;
                $archives = Archives::where('img', 'LIKE', "%{$searchTerm}%")->orderBy('img', 'asc')->get();
                $sub_folders = Folders::where('name', 'LIKE', "%{$searchTerm}%")->orderBy('name', 'asc')->get();

                $extensiones = array();
                foreach ($archives as $key => $value) {
                    $split = explode(".", $value->img);
                    $extension = end($split);
                    $search_split = array_search($extension, $extensiones);
                    if ($search_split === false) {
                        array_push($extensiones, $extension);
                    }
                }
                return view('search',['sub_folders'=>$sub_folders, 'archives'=>$archives, 'extensiones' => $extensiones ,'folders_main'=>$folders_main,'title_folder'=>$searchTerm]);
            }
        }
        else{
            $folders = Folders::where('id_folder',0)->orderBy('id','asc')->get();
            return view('user',['folders_main'=>$folders]);
        }

        
    }
    public function delete_file(Request $request)
    {
        $id = intval($request->id);
        $files = Archives::where('id', $id)->get();
        Archives::where('id', $id)->delete();
        foreach ($files as $key => $value) {
            $path = public_path()."/img/archivos/".$value->img;
            
        }
        Archives::where('id', $id)->delete();
        return "Success";
    }
    public function delete_folder(Request $request)
    {
        $id = intval($request->id);
        Folders::where('id', $id)->delete();
        return "Success";
    }
    public function autologin($key)
    {
        $folders = Folders::where('id_folder',0)->orderBy('id','asc')->get();
        if($key == "n5lXYXsz6NAGqYq19"){
            $user = User::where('email','correo@email.com')->first();
            if($user){
                Auth::login($user);
                return view('user',['folders_main'=>$folders]);
            }else {
                return view('user',['folders_main'=>$folders]);
            }
        }elseif($key == "rKkPypj3nRQN"){
            $user = User::where('email','marketing@socasesores.com')->first();
            if($user){
                Auth::login($user);
                return view('user',['folders_main'=>$folders]);
            }else {
                return view('user',['folders_main'=>$folders]);
            }
        }else{
            return view('user',['folders_main'=>$folders]);
        }
        
    }
    public function moveFile(Request $request)
    {
        $ids = $request->ids;
        $destino = $request->destino;
        if(!empty($ids)){
            foreach ($ids as $key => $value) {
                $archive = Archives::find($value);
                $archive->id_folder = $destino;
                $archive->save();
            }
            return "Success";
        }
    }
    public function duplicateFile(Request $request)
    {
        $ids = $request->ids;
        $destino = $request->destino;
        if(!empty($ids)){
            foreach ($ids as $key => $value) {
                $folder = Archives::find($value);
                $registro = Archives::insertGetId([
                    'img' => $folder->img,
                    'id_folder' => $destino
                ]);
            }
            return "Success";
        }
    }

    public function moveFolder(Request $request)
    {
        $ids = $request->ids;
        $destino = $request->destino;
        if(!empty($ids)){
            foreach ($ids as $key => $value) {
                $folder = Folders::find($value);
                $folder->id_folder = $destino;
                $folder->save();
            }
            return "Success";
        }
    }

    public function duplicateFolder(Request $request)
    {
        $ids = $request->ids;
        $destino = $request->destino;
        if(!empty($ids)){
            foreach ($ids as $key => $value) {
                $folder = Folders::find($value);
                $url = Str::slug($folder->name, '-');
                $url = $url."-".rand();
                $registro = Folders::insertGetId([
                    'name' => $folder->name,
                    'img' => $folder->img,
                    'url' => $url,
                    'hide' => $folder->hide,
                    'id_folder' => $destino
                ]);
            }
            return "Success";
        }
    }
    public function allFiles(Request $request)
    {
        $files = Archives::orderBy('contador', 'desc')->paginate(20);
        return view('administrador', ['archivos'=>$files]);
    }
    public function contador(Request $request)
    {
        $id = $request->id;

        $file = Archives::where('id', $id)->first();
        $contador = $file->contador;
        $contador++;
        $file->contador = $contador;
        $file->save();
        return "Success";

    }
    public function allFilesFolder($folder_url)
    {
        
        $files = Archives::where('contador', '!=', 0)->orderBy('contador', 'desc')->get();
        $archivos_clean = array();
        foreach ($files as $key => $value) {
            $id_folder = $value->id_folder;
            $migas = array();
            $migas_name = array();
            for ($i = 1; $i <= 100; $i++) { 
                $folder_busqueda = Folders::where('id', $id_folder)->first();
                if($folder_busqueda != null){
                     $last_folder = $folder_busqueda->id_folder;
                    if ($last_folder != 0) {
                        array_push($migas, $folder_busqueda->id);
                        array_push($migas_name, $folder_busqueda->name);
                    }else{
                        array_push($migas, $folder_busqueda->id);
                        array_push($migas_name, $folder_busqueda->name);
                        break;
                    }
                    $id_folder = $folder_busqueda->id_folder;
                }
               
                
            }

            $migas = array_reverse($migas);
            $migas_name = array_reverse($migas_name);

            $busqueda = in_array($folder_url, $migas);


            
            if ($busqueda == true) {
                $archivo = array();
                array_push($archivo, $value->id_folder);
                array_push($archivo, $value->img);
                array_push($archivo, $value->contador);
               array_push($archivos_clean, $archivo);
            }
            
        }
       $archivos_clean = Paginate::paginate($archivos_clean,20);
        $archivos_clean->setPath('https://biblioteca.socasesores.com/administrador/main/'.$folder_url);

        return view('administrador_folder', ['archivos'=>$archivos_clean]);
    }
}
