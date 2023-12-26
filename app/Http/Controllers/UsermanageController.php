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

class UsermanageController extends Controller
{
	
	
	

	/*public function boot()
	{
		Paginator::defaultView('bootsrap-4');

		Paginator::defaultSimpleView('simple-bootsrap-4');
	}*/
   
    public function index()
    {
        $pagetitle = 'User Management';
		$pageheading = 'User Management';
        $getsessioinid = Session::get('getsessionuserid');
		$getsessioinrole = Session::get('getsessionrole');

		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{
			
								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								 $getsessioinid = $getVendorDetails->createdby;

		}
		else
		{
			
			 $getsessioinid = Session::get('getsessionuserid');				

		}
		
		

		
		if($getsessioinrole==1)
		{
			$userdetails = User::select('users.*')
			->where('users.role', '=', 0)
			->paginate(20);

			return view('UserList',compact('userdetails','pagetitle','pageheading'));
		}
		if($getsessioinrole==3)
		{
			
			DB::enableQueryLog();

			$userdetails =   		 DB::table('booking_with_vendors')
									->leftjoin('users','users.id','booking_with_vendors.user_id')
									->where('users.role', '=', 0)
									->where('booking_with_vendors.vendor_id', '=',$getsessioinid)
									->select('users.created_at','users.name','users.mobile','users.totalbook')
									->distinct()
									->paginate(20);


			
			//$quries = DB::getQueryLog();
			//dd($quries);
									
			return view('UserList',compact('userdetails','pagetitle','pageheading'));


		}	
		if($getsessioinrole==6)
		{
			
			DB::enableQueryLog();

			$userdetails =   		 DB::table('booking_with_vendors')
									->leftjoin('users','users.id','booking_with_vendors.user_id')
									->where('users.role', '=', 0)
									->where('booking_with_vendors.vendor_id', '=',$getsessioinid)
									->select('users.created_at','users.name','users.mobile','users.totalbook')
									->distinct()
									->paginate(20);


			
			//$quries = DB::getQueryLog();
			//dd($quries);
									
			return view('UserList',compact('userdetails','pagetitle','pageheading'));


		}	
		else
		{
			return redirect('/login');
		}
		
		
    }
	
	
	
	public function sortinguserlist(Request $request,$id1,$id2)
    {
       
        
		$getsessioinid = Session::get('getsessionuserid');
		$getsessioinrole = Session::get('getsessionrole');
		$pagetitle = 'User Management';
		$pageheading = 'User Management';
		$txtserach = $id1; 
		$sorting = $id2;

		if($getsessioinrole==1)
		{
			
			
							if($txtserach=='Search')
							{
												 $userdetails = User::query()
												->where('users.role', '=', 0)
												->orderBy('id',$sorting)
												->paginate(20);	
							}
							else
							{	
								/*$userdetails =  		 DB::table('booking_with_vendors')
														->leftjoin('users','users.id','booking_with_vendors.user_id')
														->where('users.role', '=', 0)
														->where('name', 'LIKE', '%'.$txtserach.'%')
														->orwhere('mobile', 'LIKE', '%'.$txtserach.'%')
														->orderBy('id',$sorting)
														->select('users.id','users.created_at','users.name','users.mobile','users.totalbook')
														->distinct()
														->paginate(4);*/
								
								
								$userdetails =  		 DB::table('booking_with_vendors')
														->rightjoin('users','users.id','booking_with_vendors.user_id')
														->where('users.role', '=', 0)
														->where('users.name', 'LIKE', '%'.$txtserach.'%')
														->orwhere('mobile', 'LIKE', '%'.$txtserach.'%')
														->orderBy('id',$sorting)
														->select('users.id','users.created_at','users.name','users.mobile','users.totalbook')
														->distinct()
														->paginate(20);
								
								
							/*echo "<pre>";
							print_r($userdetails);
							echo "</pre>";	*/
								
							}			
			
						return view('UserList',compact('userdetails','pagetitle','pageheading','txtserach','sorting'));
			
			
			
			
			
		}
		if($getsessioinrole==3)
		{
			
					if($txtserach=='Search')
					{
					$userdetails = User::query()
								->where('users.role', '=', 0)
								->orderBy('id',$sorting)
								->paginate(20);	
					}
					else
					{	
					
					
								
										//DB::enableQueryLog();

										$userdetails =  		 DB::table('booking_with_vendors')
																->leftjoin('users','users.id','booking_with_vendors.user_id')
																->where('users.role', '=', 0)
																->where('booking_with_vendors.vendor_id', '=',$getsessioinid)
																->where('name', 'LIKE', '%'.$txtserach.'%')
																->orwhere('mobile', 'LIKE', '%'.$txtserach.'%')
                           										->orderBy('id',$sorting)
																->select('users.id','users.created_at','users.name','users.mobile','users.totalbook')
																->distinct()
																->paginate(20);
																
															
										$quries = DB::getQueryLog();
										//dd($quries);	
					
				
					}			
					
					return view('UserList',compact('userdetails','pagetitle','pageheading','txtserach','sorting'));
			


		}	
		else
		{
			return redirect('/login');
		}





		if($getsessioinid)
		{
			$pagetitle = 'User Management';
			$pageheading = 'User Management';
			$txtserach = $id1; 
			$sorting = $id2;
			
			//dd($txtserach,$sorting);
			
			
			
		}
		else
		{ 
		   return redirect('/login');
		}


		
    }
	
	
	
	
	public function userscreate()
    {
	  	$pagetitle = 'Users  Management';
        $pageheading = 'Users  Management';
        $pagesubheading = 'Add New Users';
		
		$userdetails = 	User::select('users.*')
					  //->where('users.role', '=', 1)
					->get();
		
		
		
        return view('AdminUserAdd',compact('pagetitle','pagesubheading','pageheading','userdetails'));
		
	}
	
	
	public function usersedit(Request $request,$id)
    {
	
		$pagetitle = 'Users Management';
        $pageheading = 'Users Management';
        $pagesubheading = 'Edit New Users';
	
		$userdetails = 	User::select('users.*')
					  ->where('users.role', '=', 0)
					  ->where('users.id', '=', $id)
					->get();
					
		return view('AdminUsersEdit',compact('pagetitle','pagesubheading','pageheading','userdetails'));
      	
	}
	public function usersview(Request $request,$id)
    {
		$pagetitle = 'Users Management';
        $pageheading = 'Users Management';
        $pagesubheading = 'View Users';
	
		$userdetails = 	User::select('users.*')
					  ->where('users.role', '=', 0)
					  ->where('users.id', '=', $id)
					->get();
					
		return view('AdminUsersView',compact('pagetitle','pagesubheading','pageheading','userdetails'));
		
	}
	public function usersdelete(Request $request,$id)
    {
		$pagetitle = 'Users Management';
        $pageheading = 'Users Management';
		$delinstructorexists = DB::table('users')->where('id', $id)->delete();			
		
		$userdetails = 	User::select('users.*')
					  ->where('users.role', '=',0)
					->paginate(4);
        return view('UserList',compact('userdetails','pagetitle','pageheading'));
	}	
	
	
	public function userssadd(Request $request)
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
		
		$referalcode = DB::table('users')->max('referral_code');
			if($referalcode==0)
			{
				$referalcode = '10000'; 
			}
			else		 
			{
				$referalcode = $referalcode + 1;
			}
		
		$data=array(
            'name'=>$request->name,
			'email'=>$request->email,
            'password'=>$request->password,
			'original_password'=>$request->password,
			'role'=>'0',
			//'original_password'=>$request->stafpassword,
			'status'=>'1', 
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
			'referral_code'=>$referalcode
        );
        $data['password'] = bcrypt($data['password']);

		$insertedId = User::insertGetId($data);
       
		return redirect('userscreate')->with('success', 'Thanks for submitting Users Entry');	
	}
	
	
	public function usersupdate(Request $request,$id)
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
		
		$updatedata=array('email'=>$request->email,'name'=>$request->name,'original_password'=>$request->password);
		$updtquery = DB::table('users')->where('id',$id)->update($updatedata);
		
		return redirect('userscreate')->with('success', 'Thanks for updateing Users Entry');
		
	}	
	
	
	
	
	public function create()
    {
        
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Staff Management';
			$pageheading = 'Staff Management';
			$pagesubheading = 'Add New Staff';
			
			$moduledtlsdd = modulemast1::select('modulemast1s.*')
							->where('roletype', '=','Admin')
							->get()->toArray();
			
			//print_r($moduledtlsdd);
			
			
			return view('AdminStaffAdd',compact('pagetitle','pagesubheading','pageheading','moduledtlsdd'));
		}
		else
		{ 
		   return redirect('/login');
		}


		
    }


	public function vendorstaff()
    {
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'Staff Management';
			$pageheading = 'Staff Management';
			$pagesubheading = 'Add New Staff';
			
			$moduledtlsdd = modulemast1::select('modulemast1s.*')
							->where('roletype', '=','Vendor')
							->get()->toArray();
			
			//print_r($moduledtlsdd);
			
			
			return view('VendorStaffAdd',compact('pagetitle','pagesubheading','pageheading','moduledtlsdd'));
			}
		else
		{ 
			return redirect('/login');

		}

		
    }

	public function stafflist()
    {

       
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Staff Management';
			$pageheading = 'Staff Management';
			$userdetails = User::select('users.*')
								->where('users.role', '=',6)
								->where('users.user_type', '=','Admin')
								->paginate(4);
								//->get();	
						
				
			return view('StaffList',compact('userdetails','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
    }

	
    public function vendorstafflist()
    {

       
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{
			
								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}


		if($getsessioinid)
		{
            $pagetitle = 'Staff Management';
			$pageheading = 'Staff Management';
			$userdetails = User::select('users.*')
								->where('users.role', '=',6)
								->where('users.user_type', '=','Vendor')
								->where('users.createdby', '=',$getsessioinid)
								->paginate(4);
								//->get();	
						
				
			return view('VendorStaffList',compact('userdetails','pagetitle','pageheading'));
		}
		else
		{ 
			return redirect('/login');
		}

		
    }
    public function store(Request $request)
    {
		$getsessioinid = Session::get('getsessionuserid');

		
		
		$validatedData = $request->validate([            
           
            'staffname' => 'required', 
            'username' => 'required|email',
			'stafpassword' => 'required',
            
        ],
        [            
            
			'staffname.required' => 'Staff Name is required!',			
            'username.required' => 'Email is required!',
			'stafpassword.required' => 'Password is required!',            
			
        ]);
		

		//echo '<pre>111 ';		
		//print_r($request->is_checked);
		//echo '</pre>';
		
		//echo '<pre>222 ';
		//print_r($request->PERMISSIONMODULENAME);
		//print_r($request->PERMISSION);		
		//echo '</pre>'; 
		
		
		
	
		$data=array(
            'name'=>$request->staffname,
            'email'=>$request->username,
            'password'=>$request->stafpassword,
            'original_password'=>$request->stafpassword,
			'role'=>6,
			'user_type'=>'Admin',
			'status'=>'1',
			'createdby' =>  $getsessioinid,			
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        $data['password'] = bcrypt($data['password']); 

		


		$duplicateCheck = User::select('users.*')
						 ->where('users.email', '=', $request->username)
						 ->get();
	   
		if(count($duplicateCheck)>0)
		{
			//return redirect('salesagentcreate')->with('success', 'Email or Mobile no already exits');

			return redirect('staff')->with('success', 'Email already exits');	

		}
		else
		{
			   $insertedId = User::insertGetId($data);
       
						$i = 0;
					//foreach($request->PERMISSION  as $permission_key=>$permission_Value){
					foreach($request->PERMISSIONMODULENAME  as $permission_key=>$permission_Value){
								
							if(!empty($request->is_checked[$i])){
									$permissiondetailsdata=array(
									'userid'=>$insertedId, 
									'modulename'=>trim($request->PERMISSIONMODULENAME[$permission_key]),
									'muduledesc'=>trim($request->PERMISSIONDESC[$permission_key]),
									'route'=>trim($request->PERMISSIONROUTE[$permission_key]),
									//'route' =>$permission_Value,
									'checkstatus'=>'1',
									'created_at' =>  date("Y-m-d H:i:s"),
									'updated_at' =>  date("Y-m-d H:i:s"),
									);
									
									//echo "<pre>";
									//print_r($permissiondetailsdata);
									//echo "</pre>"; 
									rightsmapping::create($permissiondetailsdata);
							}
						$i++;
							
					}
					//exit();
					return redirect('staff')->with('success', 'Thanks for submitting Staff Entry');	
		}


       

		
		
		
		
		
    }

	public function vendorstaffadd(Request $request)
    {
    
		$getsessioinid = Session::get('getsessionuserid');
		
		
		$validatedData = $request->validate([            
           
            'staffname' => 'required', 
            'username' => 'required|email',
			'stafpassword' => 'required',
            
        ],
        [            
            
			'staffname.required' => 'Staff Name is required!',			
            'username.required' => 'Email is required!',
			'stafpassword.required' => 'Password is required!',            
			
        ]);
		

		
		$data=array(
            'name'=>$request->staffname,
            'email'=>$request->username,
            'password'=>$request->stafpassword,
            'original_password'=>$request->stafpassword,
			'role'=>6,
			'user_type'=>'Vendor',
			'status'=>'1',
			'createdby'	=> $getsessioinid,		
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        $data['password'] = bcrypt($data['password']);        
		
		
		$duplicateCheck = User::select('users.*')
						 ->where('users.email', '=', $request->username)
						 ->get();
	   
		if(count($duplicateCheck)>0)
		{
			//return redirect('salesagentcreate')->with('success', 'Email or Mobile no already exits');

			return redirect('vendorstaff')->with('success', 'Email already exits');	

		}
		else
		{
			
			$insertedId = User::insertGetId($data);
       

		
			$i = 0;
			//foreach($request->PERMISSION  as $permission_key=>$permission_Value){
			foreach($request->PERMISSIONMODULENAME  as $permission_key=>$permission_Value){
						
					if(!empty($request->is_checked[$i])){
							$permissiondetailsdata=array(
							'userid'=>$insertedId, 
							'modulename'=>trim($request->PERMISSIONMODULENAME[$permission_key]),
							'muduledesc'=>trim($request->PERMISSIONDESC[$permission_key]),
							'route'=>trim($request->PERMISSIONROUTE[$permission_key]),
							//'route' =>$permission_Value,
							'checkstatus'=>'1',
							'created_at' =>  date("Y-m-d H:i:s"),
							'updated_at' =>  date("Y-m-d H:i:s"),
							);
							
							//echo "<pre>";
							//print_r($permissiondetailsdata);
							//echo "</pre>"; 
							rightsmapping::create($permissiondetailsdata);
					}
				$i++;
					
			}
			//exit();
			return redirect('vendorstaff')->with('success', 'Thanks for submitting Staff Entry');	

		}
		
		
		
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\usermanage  $usermanage
     * @return \Illuminate\Http\Response
     */
    public function show(usermanage $usermanage)
    {
        //
        echo '<pre>usermanage 121212::';
        print_r($usermanage);
        echo '</pre>';
        // exit();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\usermanage  $usermanage
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id )
    {
        
		//dd($id);
		$pagetitle = 'Staff Management';
        $pageheading = 'Staff Management';
        $pagesubheading = 'Edit New Staff';
		
		$moduledtlsdd = modulemast1::select('modulemast1s.*')
						->where('roletype', '=','Admin')
						->get()->toArray();
						
		//echo "<pre>moduledtlsdd ::";
		//print_r($moduledtlsdd);
		//echo "</pre>";
		$customer_right_array = array();
		
		$rightsmoduledtlsdd = rightsmapping::select('rightsmapping.*')
							  ->where('userid', '=', $id)
						      ->get()->toArray();				
		
		//print_r($moduledtlsdd);
		
		//echo "<pre>rightsmoduledtlsdd ::";
		//print_r($rightsmoduledtlsdd);
		//echo "</pre>";
		
		
		foreach($rightsmoduledtlsdd as $rightsmoduledtlsddkey=>$rightsmoduledtlsddvalue)
			{
					 //echo "<pre>rightsmoduledtlsddvalue ::";
					//print_r($rightsmoduledtlsddvalue);
					// echo "</pre>";
					$customer_right_array[] = $rightsmoduledtlsddvalue['modulename'];
			} 
			
		//echo "<pre>customer_right_array ::";
		//print_r($customer_right_array);
		//echo "</pre>";
						

		$userlist=DB::table('users')
				->Where('id',$id)
				->select('users.*')
				 ->get();			 
				 
		
        return view('AdminStaffEdit',compact('pagetitle','pagesubheading','pageheading','rightsmoduledtlsdd','userlist','moduledtlsdd','customer_right_array'));
    }

	
	

	public function vendorstaffeditprofile(Request $request)
    {
        
		//dd($id);
		
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Staff Management';
			$pageheading = 'Staff Management';
			$pagesubheading = 'Edit New Staff';
			
			$moduledtlsdd = modulemast1::select('modulemast1s.*')
							->where('roletype', '=','Vendor')
							->get()->toArray();
							
			
			$customer_right_array = array();
			
			$rightsmoduledtlsdd = rightsmapping::select('rightsmapping.*')
								  ->where('userid', '=', $getsessioinid)
								  ->get()->toArray();				
			
			
			
			
			foreach($rightsmoduledtlsdd as $rightsmoduledtlsddkey=>$rightsmoduledtlsddvalue)
				{
						
						$customer_right_array[] = $rightsmoduledtlsddvalue['modulename'];
				} 
				
			
	
			$userlist=DB::table('users')
					->Where('id',$getsessioinid)
					->select('users.*')
					 ->get();			 
					 
			
			return view('VendorStaffEdit',compact('pagetitle','pagesubheading','pageheading','rightsmoduledtlsdd','userlist','moduledtlsdd','customer_right_array'));
		}
		
		else
		{ 
			return redirect('/login');
		}

    }

	public function vendorstaffedit(Request $request, $id)
    {
        
		//dd($id);
		$pagetitle = 'Staff Management';
        $pageheading = 'Staff Management';
        $pagesubheading = 'Edit New Staff';
		
		$moduledtlsdd = modulemast1::select('modulemast1s.*')
						->where('roletype', '=','Vendor')
						->get()->toArray();
						
		
		$customer_right_array = array();
		
		$rightsmoduledtlsdd = rightsmapping::select('rightsmapping.*')
							  ->where('userid', '=', $id)
						      ->get()->toArray();				
		
		
		
		
		foreach($rightsmoduledtlsdd as $rightsmoduledtlsddkey=>$rightsmoduledtlsddvalue)
			{
					
					$customer_right_array[] = $rightsmoduledtlsddvalue['modulename'];
			} 
			
		

		$userlist=DB::table('users')
				->Where('id',$id)
				->select('users.*')
				 ->get();			 
				 
		
        return view('VendorStaffEdit',compact('pagetitle','pagesubheading','pageheading','rightsmoduledtlsdd','userlist','moduledtlsdd','customer_right_array'));
    }
	public function view(Request $request, $id )
    {
        
		
		$pagetitle = 'Staff Management';
        $pageheading = 'Staff Management';
        $pagesubheading = 'View Staff';
		
		$moduledtlsdd = modulemast1::select('modulemast1s.*')
						->where('roletype', '=','Admin')
						->get()->toArray();
						
		
		$customer_right_array = array();
		
		$rightsmoduledtlsdd = rightsmapping::select('rightsmapping.*')
							  ->where('userid', '=', $id)
						      ->get()->toArray();				
	
		foreach($rightsmoduledtlsdd as $rightsmoduledtlsddkey=>$rightsmoduledtlsddvalue)
			{
					
					$customer_right_array[] = $rightsmoduledtlsddvalue['modulename'];
			} 
			
		

		$userlist=DB::table('users')
				->Where('id',$id)
				->select('users.*')
				 ->get();			 
				 
		
        return view('AdminStaffView',compact('pagetitle','pagesubheading','pageheading','rightsmoduledtlsdd','userlist','moduledtlsdd','customer_right_array'));
		
		
       
    }


	public function deletestaff(Request $request, $id )
    {
        
		//dd($id);
		$pagetitle = 'Staff Management';
        $pageheading = 'Staff Management';
        $pagesubheading = 'Add New Staff';
		$delusersexists = DB::table('users')->where('id', $id)->delete();
		
		$delrightsexists = DB::table('rightsmapping')->where('userid', $id)->delete();
		
        $userdetails = User::select('users.*')
							->where('users.role', '=', 6)
							->where('users.user_type', '=','Admin')
							->paginate(4);	
					
			
		return view('StaffList',compact('userdetails','pagetitle','pageheading'));
						
		
		//$success1 = $request->session()->put('success', 'Thanks for deleting Staff Entry');		
        //return view('AdminStaffAdd',compact('pagetitle','pagesubheading','pageheading','moduledtlsdd'));
		//return redirect('AdminStaffAdd')->with('success', 'Thanks for deleting Staff Entry');
    }

	public function vendorstaffdelete(Request $request, $id )
    {
        
		//dd($id);
		$pagetitle = 'Staff Management';
        $pageheading = 'Staff Management';
        $pagesubheading = 'Add New Staff';

		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{
			
								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}


		$delusersexists = DB::table('users')->where('id', $id)->delete();
		
		$delrightsexists = DB::table('rightsmapping')->where('userid', $id)->delete();
		
        $userdetails = User::select('users.*')
							->where('users.role', '=', 6)
							->where('users.user_type', '=','Vendor')
							->where('users.createdby', $getsessioinid)
							->paginate(4);	
					
			
		return view('VendorStaffList',compact('userdetails','pagetitle','pageheading'));
						
		
    }
	
		
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\usermanage  $usermanage
     * @return \Illuminate\Http\Response
     */
   


   public function update(Request $request,$id)
    {
        $validatedData = $request->validate([            
           
            'staffname' => 'required', 
            'username' => 'required|email',
			'stafpassword' => 'required',
            
        ],
        [            
            
			'staffname.required' => 'Staff Name is required!',			
            'username.required' => 'Email is required!',
			'stafpassword.required' => 'Password is required!',            
			
        ]);

		//$updatedata = [['name' => $request->staffname],['email' => $request->username],['original_password' => $request->stafpassword]];
		$updatedata=array('name'=>$request->staffname,'email'=>$request->username,'original_password'=>$request->stafpassword);
		$updtquery = DB::table('users')->where('id',$id)->update($updatedata);
		
		
		
		
		$delrightsexists = DB::table('rightsmapping')->where('userid', $id)->delete();
		
		/*echo '<pre>';
		print_r($request->PERMISSION);
		echo '</pre>'; */
		// exit();
		
		/*$i = 0;
		foreach($request->PERMISSION  as $permission_key=>$permission_Value){
					
				if(!empty($request->is_checked[$i])){
						$permissiondetailsdata=array(
						'userid'=>$id, 
						//'modulename'=>ucfirst($permission_Value),
						'modulename'=>$request->PERMISSIONMODULENAME[$permission_key],
						'muduledesc'=>$request->PERMISSIONDESC[$permission_key],
						//'route' =>'{{ route('.$permission_Value.') }}',
						'route' =>$permission_Value,
						'checkstatus'=>'1',
						'created_at' =>  date("Y-m-d H:i:s"),
						'updated_at' =>  date("Y-m-d H:i:s"),
						);
						
						rightsmapping::create($permissiondetailsdata);
				}		
			$i++;
				
		}*/
		
		$i = 0;
		
		foreach($request->PERMISSIONMODULENAME  as $permission_key=>$permission_Value){
					
				if(!empty($request->is_checked[$i])){
						$permissiondetailsdata=array(
						'userid'=>$id, 
						'modulename'=>trim($request->PERMISSIONMODULENAME[$permission_key]),
						'muduledesc'=>trim($request->PERMISSIONDESC[$permission_key]),
						'route'=>trim($request->PERMISSIONROUTE[$permission_key]),
						//'route' =>$permission_Value,
						'checkstatus'=>'1',
						'created_at' =>  date("Y-m-d H:i:s"),
						'updated_at' =>  date("Y-m-d H:i:s"),
						);
						
						//echo "<pre>";
						//print_r($permissiondetailsdata);
						//echo "</pre>"; 
						rightsmapping::create($permissiondetailsdata);
				}
			$i++;
				
		}
		
		return redirect('staff')->with('success', 'Thanks for updating Staff Entry');
		
		
		
		
		
		
		//dd($updtquery);
		//DB::table('users')->where('staffname',$request->staffname)->where('email',$request->username)->where('password',$request->password)->where('original_password',$request->original_password)->update($id);
    }





	public function vendorstaffupdate(Request $request,$id)
    {
        $validatedData = $request->validate([            
           
            'staffname' => 'required', 
            'username' => 'required|email',
			'stafpassword' => 'required',
            
        ],
        [            
            
			'staffname.required' => 'Staff Name is required!',			
            'username.required' => 'Email is required!',
			'stafpassword.required' => 'Password is required!',            
			
        ]);

		
		$updatedata=array('name'=>$request->staffname,'email'=>$request->username,'original_password'=>$request->stafpassword);
		$updtquery = DB::table('users')->where('id',$id)->update($updatedata);
		
		$delrightsexists = DB::table('rightsmapping')->where('userid', $id)->delete();
		
		
		$i = 0;
		
		foreach($request->PERMISSIONMODULENAME  as $permission_key=>$permission_Value){
					
				if(!empty($request->is_checked[$i])){
						$permissiondetailsdata=array(
						'userid'=>$id, 
						'modulename'=>trim($request->PERMISSIONMODULENAME[$permission_key]),
						'muduledesc'=>trim($request->PERMISSIONDESC[$permission_key]),
						'route'=>trim($request->PERMISSIONROUTE[$permission_key]),
						'checkstatus'=>'1',
						'created_at' =>  date("Y-m-d H:i:s"),
						'updated_at' =>  date("Y-m-d H:i:s"),
						);
						
						rightsmapping::create($permissiondetailsdata);
				}
			$i++;
				
		}
		
		return redirect('vendorstaff')->with('success', 'Thanks for updating Staff Entry');
		
		
    }







    /**
     * Remove the specified resource from storage.	
     *
     * @param  \App\Models\usermanage  $usermanage
     * @return \Illuminate\Http\Response
     */
    public function destroy(usermanage $usermanage)
    {
        echo '<pre>usermanage 4567897::';
        print_r($usermanage);
        echo '</pre>';
        exit();
    }

   
   public function sortingstafflist(Request $request,$id1,$id2)
    {
       
        $pagetitle = 'Staff Management';
        $pageheading = 'Staff Management';
        $txtserach = $id1; 
		$sorting = $id2;
		
		if($txtserach=='Search')
		{
		$userdetails = User::query()
					->where('users.role', '=', 6)
					->where('users.user_type', '=','Admin')
					->orderBy('id',$sorting)
                    ->paginate(4);	
		}
		else
		{	
		//DB::enableQueryLog();
		
					
		$userdetails = User::where('name', 'LIKE', '%'.$txtserach.'%')
					  ->orWhere('email', 'LIKE', '%'.$txtserach.'%')
					  ->where('users.role', '=', 6)
					  ->where('users.user_type', '=','Admin')
					  ->orderBy('id',$sorting)
				      ->paginate(4);			
					
		
		//$quries = DB::getQueryLog();
		//dd($quries);
		}
		
		return view('StaffList',compact('userdetails','pagetitle','pageheading','txtserach','sorting'));
    }
   
	public function vendorsortingstafflist(Request $request,$id1,$id2)
    {
       
        $pagetitle = 'Staff Management';
        $pageheading = 'Staff Management';
        $txtserach = $id1; 
		$sorting = $id2;

		$getsessioinid = Session::get('getsessionuserid');
		if($txtserach=='Search')
		{
		$userdetails = User::query()
					->where('users.role', '=', 6)
					->where('users.user_type', '=','Vendor')
					->where('users.createdby', '=',$getsessioinid)
					->orderBy('id',$sorting)	
                    ->paginate(4);	
		}
		else
		{	
		//DB::enableQueryLog();
		
					
		$userdetails = User::
					   where('users.createdby', '=',$getsessioinid)
					  ->where('users.role', '=', 6)
					  ->where('users.user_type', '=','Vendor')	
					  ->where('email', 'LIKE', '%'.$txtserach.'%')
					  ->orderBy('id',$sorting)
				      ->paginate(4);			
					
		
		//$quries = DB::getQueryLog();
		//dd($quries);
		}
		
		return view('VendorStaffList',compact('userdetails','pagetitle','pageheading','txtserach','sorting'));
    }
}
