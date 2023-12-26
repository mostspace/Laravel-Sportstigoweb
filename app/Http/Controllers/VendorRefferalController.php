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

class VendorRefferalController extends Controller
{
	public function index()
    {
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Vendor Referral Management';
			$pageheading = 'Vendor Referral Management';
			$userdetails = User::select('users.*')
								->where('users.role', '=', 8)
								->where('createdby', '=', $getsessioinid)
								->paginate(7);
								
			
			return view('VendorRefferalList',compact('userdetails','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

        
    }
	
	
	
	public function vendorrefferalprofile(Request $request)
    {
	    $getsessionuserid= session()->get('getsessionuserid');

		
		if($getsessionuserid)
		{
			$pagetitle = 'Profile';
			$pageheading = 'Vendor Referral Profile';
			$pagesubheading = 'Profile';
		
			$userdetails = 	User::select('users.*')
						  ->where('users.role', '=', 8)
						  ->where('users.id', '=', $getsessionuserid)
						->get();
						
			return view('VendorRefferalprofile',compact('pagetitle','pagesubheading','pageheading','userdetails'));
		}
		else
		{ 
		   return redirect('/login');
		}


		
      	
	}
	

	public function vendorrefferalupdate(Request $request,$id)
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
		
		return redirect('vendorrefferalprofile')->with('success', 'Thanks for updating profile');
		
	}	



	public function sortingsalesagentlist(Request $request,$id1,$id2)
    {
       
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Vendor Referral Management';
			$pageheading = 'Vendor Referral Management';
			$txtserach = $id1; 
			$sorting = $id2;
			
			//dd($txtserach,$sorting);
			
			
			if($txtserach=='Search')
			{
			$userdetails = User::query()
						->where('users.role', '=', 8)
						->orderBy('id',$sorting)
						->paginate(7);	
			}
			else
			{	
			//DB::enableQueryLog();
			
						
			$userdetails = User::where('name', 'LIKE', '%'.$txtserach.'%')
						  ->orWhere('email', 'LIKE', '%'.$txtserach.'%')
						  ->where('users.role', '=', 8)
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
	
	
	
	
	public function vendorrefferalcreate()
    {
        
		
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Vendor Referral Management';
			$pageheading = 'Vendor Referral Management';
			$userdetails = User::select('users.*')
								->where('users.role', '=', 0)
								->paginate(7);
								
			
			return view('VendorRefferalAdd',compact('userdetails','pagetitle','pageheading'));
		}
		else
		{ 
		return redirect('/login');
		}
		
		
	}
	
	
	public function vendorrefferaledit(Request $request,$id)
    {
	
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Vendor Refferal Management';
			$pageheading = 'Vendor Refferal Management';
			$pagesubheading = 'Edit New Vendor Refferal';
		
			$userdetails = 	User::select('users.*')
						  ->where('users.role', '=', 8)
						  ->where('users.id', '=', $id)
						->get();
						
			return view('VendorRefferalEdit',compact('pagetitle','pagesubheading','pageheading','userdetails'));
			  
		}
		else
		{ 
		   return redirect('/login');
		}
		
		
	}
	
	public function vendorrefferaldelete(Request $request,$id)
    {
        $getsessioinid = Session::get('getsessionuserid');
        $pagetitle = 'Vendor Referral Management';
        $pageheading = 'Vendor Referral Management';
		$delinstructorexists = DB::table('users')->where('id', $id)->delete();			
		$userdetails = User::select('users.*')
							->where('users.role', '=', 8)
                            ->where('createdby', '=', $getsessioinid)
							->paginate(7);
		
        return view('vendorrefferallist',compact('userdetails','pagetitle','pageheading'));
	}	
	
	
	public function vendorrefferaladd(Request $request)
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
		
		
		
		$data=array(
            'name'=>$request->name,
			'email'=>$request->email,
			'mobile'=>$request->mobile,
            'password'=>$request->password,
			'original_password'=>$request->password,
			'role'=>'8',
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
			return redirect('vendorrefferalcreate')->with('success', 'Email or Mobile no already exits');

		}
		else
		{
			$insertedId = User::insertGetId($data);
       
			return redirect('vendorrefferalcreate')->with('success', 'Thanks for submitting Vendor Refferal Entry');	
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
	
	public function venodrrefferalupdate(Request $request,$id)
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
		
		$updatedata=array('email'=>$request->email,'name'=>$request->name,'original_password'=>$request->password,'mobile'=>$request->mobile);
		$updtquery = DB::table('users')->where('id',$id)->update($updatedata);
		
		return redirect('vendorrefferalcreate')->with('success', 'Thanks for updateing Vendor Refferal Entry');
		
	}	
	
	
	
	
	
}
