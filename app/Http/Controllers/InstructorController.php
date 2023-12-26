<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\instructor;
use App\Models\staff;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class InstructorController extends Controller
{
    
	
	
	public function instructorslist()
    {

		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Instructor Managment';
			$pageheading = 'Instructor Managment';
		
			$userdetails = instructor::select('instructor.*')
						//->where('users.role', '=', 4)
						->paginate(4);
			return view('InstructorList',compact('userdetails','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
    }
	
	
	public function sortinginstructorslist(Request $request,$id1,$id2)
    {
       
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Instructor Managment';
			$pageheading = 'Instructor Managment';
			$txtserach = $id1; 
			$sorting = $id2;
			
			//dd($txtserach,$sorting);
			
			
			if($txtserach=='Search')
			{
			$userdetails =  instructor::query()
							->orderBy('instructor_id',$sorting)
							->paginate(4);	
			}
			else
			{	
			//DB::enableQueryLog();
			
						
			$userdetails = instructor::where('mobile', 'LIKE', '%'.$txtserach.'%')
						  ->orWhere('user_name', 'LIKE', '%'.$txtserach.'%')
						  ->orderBy('instructor_id',$sorting)
						  ->paginate(4);			
						
			
			//$quries = DB::getQueryLog();
			//dd($quries);
			}			
			
			return view('InstructorList',compact('userdetails','pagetitle','pageheading','txtserach','sorting'));
		}
		else
		{ 
		   return redirect('/login');
		}


		
    }
	
	
	
	public function create()
    {
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Instructor  Managment';
			$pageheading = 'Instructor  Managment';
			$pagesubheading = 'Add New Instructor';
			
			$instructorslist = instructor::select('instructor.*')
							->get()->toArray();
			
			
			
			return view('InstructorAdd',compact('pagetitle','pagesubheading','pageheading','instructorslist'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
		
	}
	public function store(Request $request)
    {
		$validatedData = $request->validate([            
           
            'user_name' => 'required|email', 
            'mobile' => 'required',
			'password' => 'required',
            
        ],
        [            
            
			'user_name.required' => 'User Name is required!',			
            'mobile.required' => 'Mobile is required!',
			'password.required' => 'Password is required!',            
			
        ]);
		

		$data1=array(
			'name'=>'Instructor',
            'mobile'=>$request->mobile,
            'email'=>$request->user_name,
            'password'=>$request->password,
            'original_password'=>$request->password,
			'role'=>4,
			'status'=>'1',
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        $data1['password'] = bcrypt($data1['password']);        
		$insertedId = User::insertGetId($data1);
		
		
		
		$data=array(
			'instructor_id'=> $insertedId,
            'user_name'=>$request->user_name,
            'mobile'=>$request->mobile,
            'password'=>$request->password,
			'OTP_validate'=>'0',
			'skill_name'=>'NULL',
			'years_of_experience'=>'0',
			'rate_hourly'=>'0',
			'rate_weekly'=>'0',
			'rate_monthly'=>'0',
			'available_time_slot'=>'NULL',
			'wallet_balance'=>'0',
			//'original_password'=>$request->stafpassword,
			//'role'=>6, 
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        
		$insertedId = instructor::insertGetId($data);
       

		
		return redirect('instructors')->with('success', 'Thanks for submitting Instructors Entry');
	}
	public function edit(Request $request, $id )
    {
	    
		
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Instructor  Managment';
			$pageheading = 'Instructor  Managment';
			$pagesubheading = 'Edit New Instructor';
		
			$userdetails = instructor::select('instructor.*')
							  ->where('instructor_id', '=', $id)
							  ->get();


			$allcategorieslist=	DB::table('categories')
								->select('categories.*')
								->get();
			
			$vendorlist =  	 	DB::table('vendors')
								->where('vendors.status', '=', 1)
								->select('vendors.vendor_id','vendors.businessname')
								->get();	

			
			
			return view('InstructorEdit',compact('pagetitle','pagesubheading','pageheading','userdetails','allcategorieslist','vendorlist'));
		}
		else
		{ 
		   return redirect('/login');
		}
		
		
	}
	
	public function instructordelete(Request $request, $id )
    {
        
		//dd($id);
		$pagetitle = 'Instructor Managment';
        $pageheading = 'Instructor Managment';
        
		
      
		$delusersexists = DB::table('users')->where('id', $id)->delete();						
		$delinstructorexists = DB::table('instructor')->where('instructor_id', $id)->delete();			
        
		 $userdetails = instructor::select('instructor.*')
					//->where('users.role', '=', 4)
					->paginate(4);
        return view('InstructorList',compact('userdetails','pagetitle','pageheading'));
						
		
		
    }
	
	
	public function instructorsupdate(Request $request,$id)
    {
		$validatedData = $request->validate([            
           
            'user_name' => 'required', 
            'icno' => 'required',
			'sportcenter' => 'required',
			'sportcategory' => 'required',
            
        ],
        [            
            
			'user_name.required' => 'Instructor Name is required!',			
            'icno.required' => 'IC Number is required!',
			'sportcenter.required' => 'Sport Center is required!',            
			'sportcategory.required' => 'Sport Category is required!',            
			
        ]);
		
		
	
		
		
		
		$updatedata1=array('user_name'=>$request->user_name,'icno'=>$request->icno,'sportcategory'=>$request->sportcategory,'sportcenter'=>$request->sportcenter);
		$updtquery = DB::table('instructor')->where('instructor_id',$id)->update($updatedata1);
		
		return redirect('instructoredit/'.''.$id)->with('success', 'Thanks for updateing Instructors Entry');
		
	}	
	
	
	public function instructorapproved(Request $request, $id)
    {
       
		$pagetitle = 'Instructor Managment';
        $pageheading = 'Instructor Managment';
        $Iapproved = DB::table('instructor')->Where('instructor_id',$id)->Update(['status'=>1]);
		$Iusersapproved = DB::table('users')->Where('id',$id)->Update(['status'=>1]);
		$userdetails = instructor::select('instructor.*')
					   ->paginate(4);
        return view('InstructorList',compact('userdetails','pagetitle','pageheading'));
    }
	public function instructorrejected(Request $request, $id)
    {
       
		$pagetitle = 'Instructor Managment';
        $pageheading = 'Instructor Managment';
        $Iapproved = DB::table('instructor')->Where('instructor_id',$id)->Update(['status'=>0]);
		$Iusersapproved = DB::table('users')->Where('id',$id)->Update(['status'=>0]);
		$userdetails = instructor::select('instructor.*')
					   ->paginate(4);
        return view('InstructorList',compact('userdetails','pagetitle','pageheading'));
    }
	
}
