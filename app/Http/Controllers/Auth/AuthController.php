<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
  
class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');

        // echo '<pre>';
        // print_r($credentials);
        // echo '</pre>';
        // exit();

        if (Auth::attempt($credentials)) { 
            // echo "adasdasdasd"; 
            
            // here you need to get user details base on user email address ans store that value in session
            $userdetails = User::whereEmail($request->email)->first();

            // Session::set('username', $userdetails->name);
            session()->put('username', $userdetails->name);

            // echo '<pre>userdetails ::';
            // print_r($userdetails->name);
            // print_r($userdetails->email);
            // echo '</pre>';

            // $usernamevalue = session('username');
            // echo '<pre>usernamevalue ::';
            // print_r($usernamevalue);
            // echo '</pre>';
            // exit();

            // Session::get('username');

            // echo '<pre> _SESSION ';
            // print_r($_SESSION);
            // echo '</pre>';
            // exit();

            // exit();

            
            return redirect()->intended('dashboard')->withSuccess('You have Successfully loggedin');
        }else{
            // echo "adasdasdasd"; 
            return redirect()->route('admin')->with('success', 'Your Username Or Password Invalid. Please Try Again.');
        }
        // exit();

        return redirect("admin")->withSuccess('Oppes! You have entered invalid credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('admin');
    }
}