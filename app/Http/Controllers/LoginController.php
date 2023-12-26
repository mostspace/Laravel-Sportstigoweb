<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\rightsmapping;
use Illuminate\Support\Facades\Auth;
use App\Models\booking_with_vendors;
use App\Models\booking_with_vendorsdetails;
use Illuminate\Support\Facades\Session;

use DB;


/*
** Fuction Index **
-> index()
-> checkauth()
-> logout()
*/


class LoginController extends Controller
{
    
	public function index()
    {
        $pagetitle = 'Login';
        return view('LoginView',compact('pagetitle'));
    }

    public function checkauth(request $request){
		
		$input = $request->all();        
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',            
        ],
        [
            'email.required' => 'Please enter email address required..!',
            'email.email' => 'Please enter valid email address..!',
            'password.required' => 'Enter password required..!',            
        ]);
		
		
		
		if($request->remember===null){
			
                setcookie('email',$request->email,100);
                setcookie('password',$request->password,100);
             }
             else{
			
                setcookie('email',$request->email,time()+60*60*24*100);
                setcookie('password',$request->password,time()+60*60*24*100);
 
             }
		
		
		//DB::enableQueryLog();
            
		//$userlist = User::where("email", "=", $request->email)->where('original_password', '=', $request->password)->get();
		//dd($userlist);
		
		
		
		$userlist=DB::table('users')
				->Where('email',$request->email)
				->Where('original_password',$request->password)
				->Where('status','1')
				 ->select('users.*')
				 ->get();
		
		$result = $userlist->toArray();
		foreach ($result as $d) 
        {
			//dd($d->password);
		}	

		$usercount = $userlist->count();
		
		if($usercount>0)
		{
			$getrole = User::where("email", "=", $request->email)->where('original_password', '=', $request->password)->where('status', '=', 1)->first();
			$role = $getrole->role;
			$usertype = $getrole->user_type;
			$userid = $getrole->id;
			$createdby = $getrole->createdby;
			$loginname = $getrole->name;
			$request->session()->put('getsessionuserid', $userid);
			$request->session()->put('getsessionrole', $role);
			$request->session()->put('getsessionloginname', $loginname);
			
			$request->session()->put('getsessioncreatedby', $createdby);
			$request->session()->put('getsessionusertype', $usertype);
			
			//Session::set('getsessionuserid')=$userid;





			
			
						if ($role==0)
						{
							
							return view('LoginView',compact( 'role'));
						}
						else if ($role==1)
						{
							
							return view('AdminDashboard',compact( 'role'));
						}
						else if ($role==7)
						{
							
							return view('RefferalDashboard',compact( 'role'));
						}
						else if ($role==8)
						{
							
							return view('VendorRefferalDashboard',compact( 'role'));
						}
						else if ($role==3)
						{
							
							
							
							/*$bookingdtls= DB::table('booking_with_vendors')
											->where('booking_with_vendors.vendor_id',$userid)
											->Where('booking_with_vendors.paystatus','Y')
											->select('booking_with_vendors.*')
											->orderBy('booking_with_vendors.booking_id','DESC')
											->get();*/

											$bookingdtls= DB::table('booking_with_vendors')
											->where('booking_with_vendors.vendor_id',$userid)
											->select('booking_with_vendors.*')
											->orderBy('booking_with_vendors.booking_id','DESC')
											->get();
											
							$bookingcheckdetails	= DB::table('booking_with_vendors')
													->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
													->where('booking_with_vendors.vendor_id',$userid)
													->where('booking_with_vendorsdetails.checkinstatus',1)
													->select('booking_with_vendorsdetails.*','booking_with_vendors.username','booking_with_vendors.mobileno','booking_with_vendors.paymethod')
													->orderBy('booking_with_vendors.booking_id','DESC')
													->get();
							
							
							return view('VendorDashboard',compact('role','bookingdtls','bookingcheckdetails'));
						}
						else if ($role==4)
						{
							
							return view('InstructorDashboard',compact( 'role'));
						}
						else if ($role==5)
						{
							
							return view('HostDashboard',compact( 'role'));
						}
						else if ($role==6)
						{
							
									$staffmoduledetails = rightsmapping::select('rightsmapping.*')
									->where('rightsmapping.userid', '=', $userid)
									->get();							
						
								return view('StaffDashboard',compact( 'role','staffmoduledetails'));
						}
						else
						{
							
					    return view('LoginView',compact( 'role'));
						}
			
			
		}
		else
		{
			
			
			/*$vendorlist=DB::table('vendors')
				->Where('email',$request->email)
				->Where('password',$request->password)
				 ->select('vendors.*')
				 ->get();*/
				
		       //return view('LoginView');
			   return redirect()->route('login')->with('success','Email or Password Are Wrong.');
		}
		
		
		//$quries = DB::getQueryLog();
           //dd($quries);
		//$role = $first_bs->role;
		
		
		//$new_bs = $bs->toArray();
		//echo "<pre>";
		//print_r($first_bs->role);
		//echo "</pre>";
		//var_dump($bs);
		
		// $role = User::where('email', '=', $request->email)
			// 				->where('password', '=', $request->password)
				//			->get();
		
		//dd($role);
		
	
		/*$this->validate($request, [
            'userid' => 'required', 
            'password' => 'required', 
        ]);*/

			

        // echo '<pre>';
        // print_r($_FILES);
        // echo '</pre>';
        // exit();

        // echo '<pre>';
        // print_r($request);
        // echo '</pre>';
        // exit();

        // if ($request->hasFile('mydata')) {
        //     $image = $request->file('mydata');
        //     $teaser_image = time().'.'.$image->getClientOriginalExtension();
        //     $destinationPath = public_path('/banner');
        //     $image->move($destinationPath, $teaser_image);
        // } else {
        //     dd('Request Has No File');
        // }      


       //return redirect('AdminDashboard');
    }

    public function logout(Request $request) {
		  //Auth::logout();
		  //return redirect('/');
		  $request->session()->flush();
		  return redirect('/login');
		}

	public function logouturl(Request $request) {
		  //Auth::logout();
		  //return redirect('/');
		  $request->session()->flush();
		  return redirect('/login');
		  
		}	
		
	
	
	public function login(){
         $pagetitle = 'Login';
          return view('LoginView',compact('pagetitle'));
    }
}
