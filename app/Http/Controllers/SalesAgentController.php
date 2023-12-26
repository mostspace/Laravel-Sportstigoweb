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

class SalesAgentController extends Controller
{
	public function index()
    {
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Sales Agent Managment';
			$pageheading = 'Sales Agent Managment';
			$userdetails = User::select('users.*')
								->where('users.role', '=', 7)
								->where('createdby', '=', $getsessioinid)
								->paginate(7);
								
			
			return view('SalesAgentList',compact('userdetails','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

        
    }
	
	public function salesagentprofile(Request $request)
    {
	    $getsessionuserid= session()->get('getsessionuserid');

		
		if($getsessionuserid)
		{
			$pagetitle = 'Profile';
			$pageheading = 'Sales Agent Profile';
			$pagesubheading = 'Profile';
		
			$userdetails = 	User::select('users.*')
						  ->where('users.role', '=', 7)
						  ->where('users.id', '=', $getsessionuserid)
						->get();
						
			return view('SalesAgentprofile',compact('pagetitle','pagesubheading','pageheading','userdetails'));
		}
		else
		{ 
		   return redirect('/login');
		}


		
      	
	}
	
	public function sortingsalesagentlist(Request $request,$id1,$id2)
    {
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Sales Agent Managment';
			$pageheading = 'Sales Agent Managment';
			$txtserach = $id1; 
			$sorting = $id2;
			
			//dd($txtserach,$sorting);
			
			
			if($txtserach=='Search')
			{
			$userdetails = User::query()
						->where('users.role', '=', 0)
						->orderBy('id',$sorting)
						->paginate(7);	
			}
			else
			{	
			//DB::enableQueryLog();
			
						
			$userdetails = User::where('name', 'LIKE', '%'.$txtserach.'%')
						  ->orWhere('email', 'LIKE', '%'.$txtserach.'%')
						  ->where('users.role', '=', 0)
						  ->orderBy('id',$sorting)
						  ->paginate(7);			
						
			
			//$quries = DB::getQueryLog();
			//dd($quries);
			}			
			
			return view('SalesAgentList',compact('userdetails','pagetitle','pageheading','txtserach','sorting'));
		}
		else
		{ 
		   return redirect('/login');
		}

        
    }
	
	
	
	
	public function salesagentcreate()
    {
	  	
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Sales Agent Managment';
			$pageheading = 'Sales Agent Managment';
			$userdetails = User::select('users.*')
								->where('users.role', '=', 0)
								->paginate(7);
								
			
			return view('SalesAgentAdd',compact('userdetails','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}
		
		
	}
	
	
	public function salesagentedit(Request $request,$id)
    {
	
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Sales Agent Managment';
			$pageheading = 'Sales Agent Managment';
			$pagesubheading = 'Edit New Sales Agent';
		
			$userdetails = 	User::select('users.*')
						  ->where('users.role', '=', 7)
						  ->where('users.id', '=', $id)
						->get();
						
			return view('SalesAgentEdit',compact('pagetitle','pagesubheading','pageheading','userdetails'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
      	
	}
	
	public function salesagentdelete(Request $request,$id)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$pagetitle = 'Sales Agent Managment';
        $pageheading = 'Sales Agent Managment';
		$delinstructorexists = DB::table('users')->where('id', $id)->delete();			
		
		$userdetails = User::select('users.*')
							->where('users.role', '=', 7)
							->where('createdby', '=', $getsessioinid)
							->paginate(7);
        return view('SalesAgentList',compact('userdetails','pagetitle','pageheading'));
	}	
	
	
	public function salesagentadd(Request $request)
    {
		
		$getsessioinid = Session::get('getsessionuserid');
		$validatedData = $request->validate([            
           
            'email' => 'required|email', 
            'name' => 'required',
			'password' => 'required',
			'mobile' => 'required',
            
        ],
        [            
            
			'name.required' => 'User Name is required!',			
            'email.required' => 'Email is required!',
			'password.required' => 'Password is required!',            
			'mobile.required' => 'Mobile is required!',            
			
        ]);
		
		/*$referalcode = DB::table('users')->max('referral_code');
			if($referalcode==0)
			{
				$referalcode = '10000'; 
			}
			else		 
			{
				$referalcode = $referalcode + 1;
			}*/
		
		$data=array(
            'name'=>$request->name,
			'email'=>$request->email,
			'mobile'=>$request->mobile,
            'password'=>$request->password,
			'original_password'=>$request->password,
			'role'=>'7',
			//'original_password'=>$request->stafpassword,
			'status'=>'1',
			'createdby'=>$getsessioinid, 
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
			'referral_code'=>0
        );
        $data['password'] = bcrypt($data['password']);

		
		$duplicateCheck = User::select('users.*')
						->where('users.mobile', '=', $request->mobile)
						->orwhere('email', '=', $request->email)
						->get();
		
		if(count($duplicateCheck)>0)
		{
			return redirect('salesagentcreate')->with('success', 'Email or Mobile no already exits');

		}
		else
		{
			$insertedId = User::insertGetId($data);
       
			return redirect('salesagentcreate')->with('success', 'Thanks for submitting Sales Agent Entry');
		}


					
		
			
	}
	
	
	
	
	public function salesagentprofileupdate(Request $request,$id)
    {
		$validatedData = $request->validate([            
           
            'email' => 'required|email', 
            'name' => 'required',
			'password' => 'required',
			'mobile' => 'required',
            
        ],
        [            
            
			'name.required' => 'User Name is required!',			
            'email.required' => 'Email is required!',
			'password.required' => 'Password is required!',            
			'mobile.required' => 'mobile is required!',            
			
        ]);
		
		$updatedata=array('email'=>$request->email,'name'=>$request->name,'original_password'=>$request->password,'mobile'=>$request->mobile,'bankname'=>$request->bankname,'bankacno'=>$request->bankacno,'bankaccountname'=>$request->bankaccountname);
		$updtquery = DB::table('users')->where('id',$id)->update($updatedata);
		
		return redirect('salesagentprofile')->with('success', 'Thanks for updating profile');
		
	}	
	
	public function salesagentupdate(Request $request,$id)
    {
		$validatedData = $request->validate([            
           
            'email' => 'required|email', 
            'name' => 'required',
			'password' => 'required',
			'mobile' => 'required',
            
        ],
        [            
            
			'name.required' => 'User Name is required!',			
            'email.required' => 'Email is required!',
			'password.required' => 'Password is required!',            
			'mobile.required' => 'mobile is required!',            
			
        ]);
		
		$updatedata=array('email'=>$request->email,'name'=>$request->name,'original_password'=>$request->password,'mobile'=>$request->mobile,'bankname'=>$request->bankname,'bankacno'=>$request->bankacno,'bankaccountname'=>$request->bankaccountname);
		$updtquery = DB::table('users')->where('id',$id)->update($updatedata);
		
		return redirect('salesagentcreate')->with('success', 'Thanks for updateing Sales Agent Entry');
		
	}	
	
	
	
	
	
}
