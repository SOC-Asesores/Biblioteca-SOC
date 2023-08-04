<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Folders;
use Session;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // If we don't have an authorization code then get one
        if (isset($_GET['code'])) {

 
            $response = Http::asForm()->post('https://auth.sisec.mx/connect/token', [
                'code' => $_GET['code'],
                'client_id' => 'soc_biblioteca',
                'client_secret' => 'Kn5g5d22oV15f',
                'grant_type' => 'authorization_code',
                'redirect_uri' => 'http://biblioteca.socasesores.com/login'
            ]);
            $respuesta = json_decode($response->body());
            $response_verify = Http::withToken($respuesta->access_token)->post('https://auth.sisec.mx/connect/userinfo');
            $response_verify = json_decode($response_verify->body());
            session_start();
            $_SESSION["name_user"]=$response_verify->name;
            switch ($response_verify->preferred_username) {
                case "GRUPOAPA_josanchez":
                    Auth::loginUsingId(14);
                    return redirect('https://biblioteca.socasesores.com/');
                    break;
                case "grupoapa_mrangel":
                    Auth::loginUsingId(15);
                    $folder = Folders::find(2);
                    return redirect('https://biblioteca.socasesores.com/folder/'.$folder->url);
                    break;
                case "grupoapa_lbrito":
                    Auth::loginUsingId(15);
                    $folder = Folders::find(2);
                    return redirect('https://biblioteca.socasesores.com/folder/'.$folder->url);
                    break;
                case "grupoapa_scastaneda":
                    Auth::loginUsingId(16);
                    $folder = Folders::find(1);
                    return redirect('https://biblioteca.socasesores.com/folder/'.$folder->url);
                    break;
                case "grupoapa_lelizalde":
                    Auth::loginUsingId(16);
                    $folder = Folders::find(1);
                    return redirect('https://biblioteca.socasesores.com/folder/'.$folder->url);
                    break;
                case "GRUPOAPA_mgonzalez":
                    Auth::loginUsingId(30);
                    $folder = Folders::find(6);
                    return redirect('https://biblioteca.socasesores.com/folder/'.$folder->url);
                    break;
                case "grupoapa_marmartinez":
                    Auth::loginUsingId(35);
                    $folder = Folders::find(599);
                    return redirect('https://biblioteca.socasesores.com/folder/'.$folder->url);
                    break;
                default:
                    Auth::loginUsingId(3);
                    return redirect('http://biblioteca.socasesores.com/');
            }
          
        } else {
            $query = http_build_query([
                'client_id' => 'soc_biblioteca',
                'redirect_uri' => 'http://biblioteca.socasesores.com/login',
                'response_type' => 'code',
                'scope' => 'openid profile email roles',
                'state' => 'abc',
                'nonce' => 'xyz'
            ]);
         
            return redirect('https://auth.sisec.mx/connect/authorize?'.$query);
           
        }
        
        return view('auth.login');
    }

    public function create2()
    {

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = User::where("email", "=", $request->email)->first();


        if ($user->type == 0 && $user->id_bank == 0) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }elseif ($user->type == 2) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }else{
            $folder = Folders::find($user->id_bank);
            return redirect('/folder/'.$folder->url);
        }

    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $perfil = Auth::user()->id_bank;
        if ($perfil != 0) {
             Auth::guard('web')->logout();
        return redirect('https://biblioteca.socasesores.com/admin');
        }else{
             Auth::guard('web')->logout();
            return redirect('https://auth.sisec.mx/Account/Login?ReturnUrl=%2Fconnect%2Fauthorize%2Fcallback%3Fclient_id%3Dsoc_biblioteca%26redirect_uri%3Dhttp%253A%252F%252Fbiblioteca.socasesores.com%252Flogin%26response_type%3Dcode%26scope%3Dopenid%2520profile%2520email%2520roles%26state%3Dabc%26nonce%3Dxyz');
        }
       
    }
}
