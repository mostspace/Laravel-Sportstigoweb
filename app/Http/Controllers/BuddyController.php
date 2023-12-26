<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\buddybookings;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class BuddyController extends Controller
{
   
    public function buddylist()
    {

        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Buddy Managment';
			$pageheading = 'Buddy Managment';
		   
		
			$buddydetails=  DB::table('buddybookings')
								->join('users','users.id','buddybookings.user_id')
								->select('buddybookings.*','users.name as name','users.role as role','users.mobile as mobile','users.email as email')
								->orderBy('buddybookings.buddy_booking_id','DESC')
								->paginate(4);
				
				
			return view('BuddyList',compact('buddydetails','pagetitle','pageheading'));
			
		}
		else
		{ 
		   return redirect('/login');
		}

		
		
    }
	
	public function sortingbuddylist(Request $request,$id1,$id2)
    {
       
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Buddy Managment';
			$pageheading = 'Buddy Managment';
			$txtserach = $id1; 
			$sorting = $id2;
			//$sortval = $id2;
		  if($txtserach=='Search')
			{
			$buddydetails=  DB::table('buddybookings')
								->join('users','users.id','buddybookings.user_id')
								->select('buddybookings.*','users.name as name','users.role as role','users.mobile as mobile','users.email as email')
								->orderBy('buddybookings.buddy_booking_id',$sorting)
								->paginate(4);		
			}
			else
			{	
			//DB::enableQueryLog();
			
						
			$buddydetails=  DB::table('buddybookings')
								->join('users','users.id','buddybookings.user_id')
								->select('buddybookings.*','users.name as name','users.role as role','users.mobile as mobile','users.email as email')
								->orWhere('buddybookings.host_game_name','LIKE','%' .$txtserach.'%' )
								->orWhere('users.name','LIKE','%' .$txtserach.'%' )
								->orWhere('users.mobile','LIKE','%' .$txtserach.'%' )
								->orWhere('users.email','LIKE','%' .$txtserach.'%' )
								->orderBy('buddybookings.buddy_booking_id',$sorting)
								->paginate(4);		
						
			
			//$quries = DB::getQueryLog();
			//dd($quries);
			}	
			
			
			
			return view('BuddyList',compact('buddydetails','pagetitle','pageheading','txtserach','sorting'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
    }
	
	
	
	
	/*public function refferalcreate()
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
					->get();
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
		
	}*/	
	
	
	
   
}
