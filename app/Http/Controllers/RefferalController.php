<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class RefferalController extends Controller
{
   
    public function index()
    {

        
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Refferal Managment';
			$pageheading = 'Refferal Managment';
		   
			$userdetails = User::select('users.*')
								->where('users.role', '=', 0)
								->paginate(4);
						
			
			return view('RefferalList',compact('userdetails','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}
		
		
    }
	
	
	public function sortingrefferallist(Request $request,$id1,$id2)
    {
       
        
		
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Refferal Managment';
			$pageheading = 'Refferal Managment';
			$txtserach = $id1; 
			$sorting = $id2;
			
			//dd($txtserach,$sorting);
			
			
			if($txtserach=='Search')
			{
			$userdetails = User::query()
						->where('users.role', '=', 0)
						->orderBy('id',$sorting)
						->paginate(4);	
			}
			else
			{	
			//DB::enableQueryLog();
			
						
			$userdetails = User::where('name', 'LIKE', '%'.$txtserach.'%')
						  ->orWhere('email', 'LIKE', '%'.$txtserach.'%')
						  ->orWhere('mobile', 'LIKE', '%'.$txtserach.'%')
						  ->where('users.role', '=', 0)
						  ->orderBy('id',$sorting)
						  ->paginate(4);			
						
			
			//$quries = DB::getQueryLog();
			//dd($quries);
			}	
			
			
			return view('RefferalList',compact('userdetails','pagetitle','pageheading','txtserach','sorting'));
		}
		else
		{ 
		   return redirect('/login');
		}


		
    }
	
	
	
	public function refferalcreate()
    {
	  	$pagetitle = 'Refferal  Managment';
        $pageheading = 'Refferal  Managment';
        $pagesubheading = 'Add New Refferal';
		
		$userdetails = 	User::select('users.*')
					  //->where('users.role', '=', 1)
					->get();
		
		 return view('AdminRefferalAdd',compact('pagetitle','pagesubheading','pageheading','userdetails'));
		
	}
	
	
	public function refferaledit(Request $request,$id)
    {
	
		$pagetitle = 'Refferal Managment';
        $pageheading = 'Refferal Managment';
        $pagesubheading = 'Edit New Refferal';
	
		$userdetails = 	User::select('users.*')
					  ->where('users.role', '=', 2)
					  ->where('users.id', '=', $id)
					->get();
					
		return view('AdminRefferalEdit',compact('pagetitle','pagesubheading','pageheading','userdetails'));
      	
	}
	public function refferalview(Request $request,$id)
    {
		$pagetitle = 'Refferal Managment';
        $pageheading = 'Refferal Managment';
        $pagesubheading = 'View Refferal';
	
		$userdetails = 	User::select('users.*')
					  ->where('users.role', '=', 2)
					  ->where('users.id', '=', $id)
					->get();
					
		return view('AdminRefferalView',compact('pagetitle','pagesubheading','pageheading','userdetails'));
		
	}
	public function refferaldelete(Request $request,$id)
    {
		$pagetitle = 'Refferal Managment';
        $pageheading = 'Refferal Managment';
		$delinstructorexists = DB::table('users')->where('id', $id)->delete();			
		
		$userdetails = 	User::select('users.*')
					  ->where('users.role', '=', 2)
					->paginate(4);
        return view('RefferalList',compact('userdetails','pagetitle','pageheading'));
	}	
	
	
	public function refferaladd(Request $request)
    {
		$validatedData = $request->validate([            
           
            'email' => 'required|email', 
            'name' => 'required',
			'password' => 'required',
            
        ],
        [            
            
			'name.required' => 'User Name is required!',			
            'email.required' => 'Email is required!',
			'password.required' => 'Password is required!',            
			
        ]);
		

		$data=array(
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
			'original_password'=>$request->password,
			'mobile'=>$request->mobile,
			'role'=>'2',
			'status'=>'1',
			//'original_password'=>$request->stafpassword,
			//'role'=>6, 
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        $data['password'] = bcrypt($data['password']);        
		$insertedId = User::insertGetId($data);
       
		return redirect('refferalcreate')->with('success', 'Thanks for submitting Refferal Entry');	
	}
	
	
	public function refferalupdate(Request $request,$id)
    {
		$validatedData = $request->validate([            
           
            'email' => 'required|email', 
            'name' => 'required',
			'password' => 'required',
            
        ],
        [            
            
			'name.required' => 'User Name is required!',			
            'email.required' => 'Email is required!',
			'password.required' => 'Password is required!',            
			
        ]);
		
		$updatedata=array('email'=>$request->email,'name'=>$request->name,'mobile'=>$request->mobile,'original_password'=>$request->password);
		$updtquery = DB::table('users')->where('id',$id)->update($updatedata);
		
		return redirect('refferalcreate')->with('success', 'Thanks for updateing Refferal Entry');
		
	}	
	
	
	
   
}
