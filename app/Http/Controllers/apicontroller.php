<?php
    
    namespace App\Http\Controllers;
    use App\Models\User;
    use App\Models\usersauths;
    use App\Models\category;
    use Illuminate\Http\Request;
    use App\Models\banners;
    use App\Models\instructor;
    use App\Models\instructorbookings;
	use App\Models\membershipsbyusers;
    use App\Models\voucher;
    use App\Models\vendor;
    use App\Models\withdrawals;
    use App\Models\hostgames;
    use App\Models\buddybookings;
    use App\Models\booking_with_vendors;
    use App\Models\booking_with_vendorsdetails;
	use App\Models\cashbackdetails;
    use App\Models\venues;
	use Illuminate\Support\Carbon;
    use SenangPay\SenangPay;
	
	use Illuminate\Support\Facades\Cache;

    
    use SimpleSoftwareIO\QrCode\Facades\QrCode; 
    use Imagick;
    
    require_once  base_path() . '/vendor/autoload.php';
    use Orbitale\Component\ImageMagick\Command;
    use DB;
	use bulk360\client;
	
	Cache::flush();
    
	
	
	
	




    class apicontroller extends Controller
    {
		
         
		
		public function sendsms(Request $request)
		{
			
			// Please whitelist your IP and enable API in sms.360.my before you call this 
	
			//$smsClient = new client('YOUR_APP_KEY', 'YOUR_APP_SECRET');
			$smsClient = new client('W4QbYQObzq', 'rJViG05DM7HflZr7Y2wnacCZV2ADJyPMt0KBLB9f');
			$response = $smsClient->send([
							'from'	=> '68068',
							'to'	=> '91919191919191',
							'text'	=> 'Sportstigo booking App OTP is 12345'
						]);
			//echo  $response;
			 $data=json_decode($response ,true);
			 $responsecode = $data['code'];
			 if($responsecode==200)
			 {
                       
			 }
			 else
			 {

			 }


			
			
			// $json_response = json_decode($response);
			// print_r($json_response);
			
			
			// Check account balance
			// $balance = $smsClient->balance();
			// print_r($balance);
			
			
			// Check sms count that can send in China
			//$balance = $smsClient->balance(861);		
			//print_r($balance);
	



		}
		public function sendotp(Request $request){
            
			
		
			$mobileno ='';
			$firstCharacter = substr($request->mobile, 0, 1);
			if( $firstCharacter=='+')
			{
				$mobileno = $request->mobile;
			}
			else
			{
				$mobileno = '+'.$request->mobile;
			}
			
			
			
			$delmobileexists = DB::table('usersauths')->where('mobile',$mobileno)->delete();
    		
    		$userdetails = array(
                'mobile'=>$mobileno,
    			'otp'=> $request->otp,
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
    		);
    		
    		
    		$result = usersauths::insertGetId($userdetails);


			
			// Please whitelist your IP and enable API in sms.360.my before you call this 
	
			//$smsClient = new client('YOUR_APP_KEY', 'YOUR_APP_SECRET');

			$smsClient = new client('W4QbYQObzq', 'rJViG05DM7HflZr7Y2wnacCZV2ADJyPMt0KBLB9f');
			$response = $smsClient->send([
							'from'	=> '68068',
							'to'	=> $request->mobile,
							'text'	=> 'Hi, Welcome to Sportstigo. Your OTP is '.$request->otp
						]);
			//echo  $response;
			 $rdata=json_decode($response ,true);
			 $responsecode = $rdata['code'];
			 if($responsecode==200)
			 {
				 //$responsecode;
				$data['status'] = '1';
                $data['message'] = 'Send OTP Successfull';


			 }
			 else
			 {
				//$responsecode;
				$data['status'] = '0';
                $data['message'] = 'Send OTP Fail';
                $data['result'] = '0';


			 }
			 echo json_encode($data);




            
            /*if($result){
                $data['status'] = '1';
                $data['message'] = 'Send OTP Successfull';
                //$data['result'] = $userdetails;
            }else{
                $data['status'] = '0';
                $data['message'] = 'Send OTP Fail';
                $data['result'] = '0';
            }*/
    		
            
        }
    	
    	public function validateotp(Request $request){
            $userdetails = array(
                'mobile'=>$request->mobile,
    			'otp'=>$request->otp
            );
    		
    		$result = usersauths::where('mobile', '+'.$request->mobile)->where('otp', $request->otp)->count();			
    		
    		
    		if($result){
                $data['status'] = '1';
                $data['message'] = 'OTP Validation Successfull';
                //$data['result'] = $userdetails;
            }else{
                $data['status'] = '0';
                $data['message'] = 'OTP Validation Fail';
                $data['result'] = '0';
            }
    		
            echo json_encode($data);
        }
    	
		
		public function forgetpassword(Request $request)
    	  {
    	  
    		 
			$mobileno ='';
			$firstCharacter = substr($request->mobile, 0, 1);
			if( $firstCharacter=='+')
			{
				$mobileno = $request->mobile;
			}
			else
			{
				$mobileno = '+'.$request->mobile;
			}
			
			
			$checkexistsuser =  DB::table('usersauths')->where('mobile','+'.$request->mobile)->get();	

			if(count($checkexistsuser)>0)
			{
					$result =  DB::table('usersauths')->where('mobile',$mobileno)->first();	


					$smsClient = new client('W4QbYQObzq', 'rJViG05DM7HflZr7Y2wnacCZV2ADJyPMt0KBLB9f');
					$response = $smsClient->send([
									'from'	=> '68068',
									'to'	=> $mobileno,
									'text'	=> 'Hi, Welcome to Sportstigo. Your OTP is '.$result->otp
								]);
					//echo  $response;
					$rdata=json_decode($response ,true);
					$responsecode = $rdata['code'];
					if($responsecode==200)
					{
						//$responsecode;
						$data['status'] = '1';
						$data['result'] =  $result;
						$data['message'] = 'forgetpassword details Successfull & Send OTP Successfull';
		
		
					}
					else
					{
						//$responsecode;
						$data['status'] = '0';
						$data['message'] = 'Send OTP Fail';
						$data['result'] = '0';
		
		
					}
					echo json_encode($data);
			}
			else
			{
						$data['status'] = '0';
						$data['message'] = 'not found';
						$data['result'] = '0';
						echo json_encode($data);
			}


			
			

    		  /* if($result)
    		   {
    				$data['status'] = '1';
    				$data['message'] = 'forgetpassword details Successfull';
    				$data['result'] = $result;
    			}else{
    				$data['status'] = '0';
    				$data['message'] = 'No Data Found';
    				$data['result'] = array();
    			}
    			

    						 
    			echo json_encode($data);*/
    		}
    
    
    		public function changepassword(Request $request)
    		{
    			
				$firstCharacter = substr($request->mobile, 0, 1);
				if( $firstCharacter=='+')
				{
					$mobileno = $request->mobile;
				}
				else
				{
					$mobileno = '+'.$request->mobile;
				}


				
				
				$userdetails = array(
    				'password'=>$request->password,
    				'original_password'=>$request->password,
    			);
    			
    			



    			
    			if($request->password!=$request->cfpassword)  


                 {
                    $data['status'] = '0';
    				$data['message'] = 'Fail to change password';
    				$data['result'] = array();
    
                 } 
                 else
                 {
    				$userdetails['password'] = bcrypt($userdetails['password']); 
    				$result = DB::table('users')->where('mobile',$mobileno)->update($userdetails);
    
    				if($result){
    					$data['status'] = '1';
    					$data['message'] = 'changepassword Successfull';
    					$data['result'] = $result ;
    				}else{
    					$data['status'] = '0';
    					$data['message'] = 'Fail to change password';
    					$data['result'] = array();
    				}
    				
    				
    			
    			 }
    			 echo json_encode($data);
    			
    			
    			
    		}
    
		
		public function getusers(Request $request){
            $userdetails = array(
                'mobile' => $request->mobile,
                'password' => $request->password
            );
            

			$firstCharacter = substr($request->mobile, 0, 1);
			
			if( $firstCharacter=='+')
			{
				$mobileno = $request->mobile;
			}
			else
			{
				$mobileno = '+'.$request->mobile;
			}



    	$resultlist =  DB::table('users')
    		   ->where('mobile',$mobileno)
    		   ->Where('original_password',$request->password)
    		   ->get();

    	$result = $resultlist->count();
    	
    	
    	$resultlist1 =  DB::table('users')
    		   ->where('mobile',$mobileno)
    		   ->Where('original_password',$request->password)
    		   ->get()->toArray();
    	
    	foreach($resultlist1 as $userdetailskey=>$userdetailsvalue)
    			{
    				$referral_code=	$userdetailsvalue->referral_code;
    			} 
    
    		
            if($result){
                $data['status'] = '1';
                $data['message'] = 'User Get Successfull';
    			$data['referral_code'] = $referral_code;
                $data['result'] = $resultlist;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['query'] = $resultlist;
    			$data['referral_code'] = '0';
                $data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
		
        public function saveuser(Request $request){
    		
    		
    		    /*$referalcode = DB::table('users')->max('referral_code');
    			if($referalcode==0)
    			{
    				$referalcode = '10000'; 
    			}
    			else		 
    			{
    				$referalcode = $referalcode + 1;
    			}*/
				//echo $request->mobile;
				
				
				$firstCharacter = substr($request->mobile, 0, 1);
			
				if( $firstCharacter=='+')
				{
					$mobileno = $request->mobile;
				}
				else
				{
					$mobileno = '+'.$request->mobile;
				}

				
				if(!isset($request->referralid))
				{
					$request->referralid = 0;
				}

				$checkuserregister =  DB::table('users')->where('mobile',$mobileno)->orwhere('email',$request->email)->get();

				if(count($checkuserregister)>0)
				{
                   
					 
					 

					 $getuserdetails =   DB::table('users')
    							->select('id','name','mobile','email','role','user_type','userprofilepic1','aboutme','image1','image2','image3','image4','image5','image6',
    							'level','interested','instructorrate','referral_code','referral_user','status','earning','totalbook',
    							'bankname','bankacno','bankaccountname','wallet_amount','refferalcashback','createdby','created_at')
    							->where('mobile',$mobileno)->get();
					
					$data['message'] = 'User Already Register';
					$data['status'] = '0';
				    $data['result'] = $getuserdetails;			

				}
				else
				{
					 
					
					
					
								
								$randomNumber = rand(100000,999999);
					
								$referalcode = $randomNumber;
								
								$checkexistreferalcode = DB::table('users')
														->where('users.referral_code', '=', $referalcode)
														->select('users.referral_code')
														->get()->count();
								
								if($checkexistreferalcode==1)
								{
									$randomNumber = rand(100000,999999);
									$referalcode = $randomNumber;
								}


    			
								$userdetails = array(
									'name'=>$request->name,
									'email'=>$request->email,
									'mobile'=>$mobileno,
									'password'=>$request->password,
									'original_password'=>$request->password,
									'role'=>'0',
									'status'=>'1', 
									'created_at' =>  date("Y-m-d H:i:s"),
									'updated_at' =>  date("Y-m-d H:i:s"),
									'referral_code'=>$referalcode,
									'referral_user'=>$request->referralid,
								);
							
							
							$userdetails['password'] = bcrypt($userdetails['password']);        
							
							$result = User::insertGetId($userdetails);

							$getuserdetails =   DB::table('users')
    							->select('id','name','mobile','email','role','user_type','userprofilepic1','aboutme','image1','image2','image3','image4','image5','image6',
    							'level','interested','instructorrate','referral_code','referral_user','status','earning','totalbook',
    							'bankname','bankacno','bankaccountname','wallet_amount','refferalcashback','createdby','created_at')
    							->where('id',$result)->get();

								
								$data['message'] = 'Registration Successfull';
								$data['status'] = '1';
								$data['result'] = $getuserdetails;
					
					}
				
    						//$data['message'] = 'Registration Successfull';
								
    		
            					echo json_encode($data);
        }


    
    
    	
    	
    	public function gethomecategory(Request $request){
        
    	  $result =  DB::table('categories')
    			   ->whereNotIn('image2',array('myimagepath'))
    		       ->get();
    	   if($result){
                $data['status'] = '1';
                $data['message'] = 'Category Get Successfull';
    			$data['result'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    	
    	
    	public function getallcategory(Request $request){
        
    	  $result =  DB::table('categories')
    			   ->whereNotIn('image',array('myimagepath'))
    		       ->get();
    	   if($result){
                $data['status'] = '1';
                $data['message'] = 'Category Get Successfull';
    			$data['result'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    
    	public function getallstate(Request $request){
        
    		$result =  DB::table('states')->get();
    		 if($result){
    			  $data['status'] = '1';
    			  $data['message'] = 'State Get Successfull';
    			  $data['result'] = $result;
    		  }else{
    			  $data['status'] = '0';
    			  $data['message'] = 'No Data Found';
    			  $data['result'] = 0;
    		  }
    		  
    					   
    		  echo json_encode($data);
    	  }
    	
    	public function getbanner(Request $request){
        
    	  $result =  DB::table('banners')
    			    ->get();
    	   if($result){
                $data['status'] = '1';
                $data['message'] = 'Banner Get Successfull';
    			$data['result'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    	
    	public function getsportvenue(Request $request){
        
    	  $result =  DB::table('vendors')
    	  			 ->join('users','users.id','vendors.vendor_id')
    	  			 ->Where('users.status',1)	
    				 ->select('vendors.*')
    			     ->get();
    	   if($result){
                $data['status'] = '1';
                $data['message'] = 'get sportvenue Get Successfull';
    			$data['result'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
		
		public function mybookedvenue(Request $request){

			
			 $bookedvendorcode =  DB::table('booking_with_vendors')
			 					 ->where('booking_with_vendors.user_id',$request->user_id)
								 ->distinct()->get(['vendor_id']);

			 $vcode = '';
			 foreach($bookedvendorcode as $bookedvendorcodekey=>$bookedvendorcodevalue)
			 {
				$vcode = $vcode.','.$bookedvendorcodevalue->vendor_id;
			 }
			
			$str = ltrim($vcode, ',');
			
			
			$vendor_array = explode(',', $str);
			
			$result =  DB::table('vendors')
						->join('users','users.id','vendors.vendor_id')
						->Where('users.status',1)	
						->whereIn('vendors.vendor_id', $vendor_array)
					  	->select('vendors.*')
					  	->get();
			if(count($result)>0)
					{
						$data['status'] = '1';
						$data['message'] = 'get sportvenue Get Successfull';
						$data['result'] = $result;
					}else{
						$data['status'] = '0';
						$data['message'] = 'No Data Found';
						$data['result'] = array();
						}
 
			  
			echo json_encode($data);
		}

    	
    	public function getvendorprofile(Request $request){
        
    	
    	
    	$result=DB::table('vendors')
                ->join('vendordetails','vendordetails.vendor_id','vendors.vendor_id')
    			->join('states','states.id','vendors.state')
    			->join('categories','categories.id','vendors.business_category')
    			->Where('vendors.vendor_id',$request->vendor_id)
    			->select('vendors.*','vendordetails.*','states.name as statename','categories.name as categoryname')
    			->get();
    	
    	$result1=DB::table('vendorfacilities')
                ->Where('vendorfacilities.vendor_id',$request->vendor_id)
    			->select('vendorfacilities.facility as facility')
    			->get();
    
    	$vendorclosingdayslist=DB::table('vendorclosingdays')
                ->Where('vendorclosingdays.vendor_id',$request->vendor_id)
    			->whereNotNull('vendorclosingdays.closingdays')
    			->select('vendorclosingdays.id','vendorclosingdays.vendor_id','vendorclosingdays.closingdays')
    			->get();	
    			
    			
    		
    	 if($result){
                $data['status'] = '1';
    			$data['message'] = 'get vendors Successfull';
    			$data['result'] = $result;
    			$data['result1'] = $result1;
    			$data['vendorclosingdayslist'] = $vendorclosingdayslist;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    	
    	public function saveinstructor(Request $request){
    		
    			
			DB::table('users')->where('id', '=',$request->user_id)->update(['role' => '4']);
			
			
			/*$instructorcode = DB::table('users')->max('id');
    			if($instructorcode==0)
    			{
    				$instructorcode = 'instructor1'; 
    			}
    			else		 
    			{
    				$instructorcode = 'instructor'.$instructorcode + 1;
    			}
    		
    		$userdetails = array(
                'name'=>$request->name,
    			'email'=>$instructorcode.'@sportstigo.com',
    			'password'=>123456,
    			'original_password'=>123456,
    			'role'=>'4',
    			'status'=>'0', 
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s")
    		);
    		$userdetails['password'] = bcrypt($userdetails['password']); 
    		$insertedId = User::insertGetId($userdetails);*/
			

			
			


    		
    		$data1=array(
    			'instructor_id'=> $request->user_id,
                'user_name'=>$request->name,
                'icno'=>$request->icno,
                'sportcenter'=>$request->sportcenter,
    			'sportcategory'=>$request->sportcategory,
    			'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
            );
            
    		$result = instructor::insertGetId($data1);
    		
    		if($result){
                $data['status'] = '1';
                $data['message'] = 'Instructor Registration Successfull';
                //$data['result'] = $userdetails;
            }else{
                $data['status'] = '0';
                $data['message'] = 'Registration Fail';
                //$data['result'] = array();
            }
    		
            echo json_encode($data);
        }
    	
    	
    	public function getinstructor(Request $request){
        
			$category = $request->sportcategory;
			//$state = $request->state;
			$searchTerm = $request->name;
			if (($searchTerm=='') && ($category==''))
			{
				$result	= 	DB::table('instructor')
    			->join('users','users.id','instructor.instructor_id')
    			->join('categories','categories.id','instructor.sportcategory')
    			->join('vendors','vendors.businessname','instructor.sportcenter')
				->Where('users.bookingstatus',1)
    			->select('instructor.instructor_id as instructor_id','instructor.user_name as instructorname','users.userprofilepic1 as userprofilepic1','instructor.sportcenter as sportcenter','vendors.address as location','instructor.sportcategory as category','categories.name as sportcategory','users.instructorrate as instructorrate','users.instructorratetype')
				->get();

			}
			else if (($searchTerm==''))
			{
				
				$result	= 	DB::table('instructor')
    			->join('users','users.id','instructor.instructor_id')
    			->join('categories','categories.id','instructor.sportcategory')
    			->join('vendors','vendors.businessname','instructor.sportcenter')
    			->where('instructor.sportcategory', '=' , $category)
				->Where('users.bookingstatus',1)
				->select('instructor.instructor_id as instructor_id','instructor.user_name as instructorname','users.userprofilepic1 as userprofilepic1','instructor.sportcenter as sportcenter','vendors.address as location','instructor.sportcategory as category','categories.name as sportcategory','users.instructorrate as instructorrate','users.instructorratetype')
				->get();
			}
			else
			{
				
				$result	= 	DB::table('instructor')
    			->join('users','users.id','instructor.instructor_id')
    			->join('categories','categories.id','instructor.sportcategory')
    			->join('vendors','vendors.businessname','instructor.sportcenter')
    			->where('instructor.sportcategory', '=' , $category)
				->orWhere('instructor.user_name', 'LIKE', "%{$searchTerm}%")
				->Where('users.bookingstatus',1)
    		   	->select('instructor.instructor_id as instructor_id','instructor.user_name as instructorname','users.userprofilepic1 as userprofilepic1','instructor.sportcenter as sportcenter','vendors.address as location','instructor.sportcategory as category','categories.name as sportcategory','users.instructorrate as instructorrate','users.instructorratetype')
				->get();

			}
			
			
    	  
    	 
    	 if($result){
                $data['status'] = '1';
                $data['message'] = 'Instructor Get Successfull';
    			$data['result'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';


    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    	
    	
    	public function getmemberships(Request $request){
        
			$membershipscount =  DB::table('memberships')->Where('memberships.vendor_id',$request->vendor_id)->get()->count();
			
			
			if($membershipscount>0)
			{
										$result =  DB::table('memberships')
										->select('memberships.membership_id','memberships.vendor_id','memberships.package_name','memberships.package_desc1','memberships.package_desc2','memberships.package_desc3','memberships.package_desc4','memberships.package_desc5','memberships.package_duration','memberships.package_price','memberships.package_discount_price','memberships.image','memberships.status','memberships.created_at','memberships.updated_at')	
										->Where('memberships.vendor_id',$request->vendor_id)->get();
										$data['status'] = '1';
										$data['message'] = 'memberships Get Successfull';
										$data['result'] = $result;
									
												
									
			}
			else
			{
				$data['status'] = '0';
				$data['message'] = 'No Data Found';
				$data['result'] = array();
			}

			echo json_encode($data);						
        }
    	
    	
    	public function getnoticboard(Request $request){
        
    	  $result =  DB::table('noticeboards')->get();
    	   if($result){
                $data['status'] = '1';
                $data['message'] = 'noticeboards Get Successfull';
    			$data['result'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    	
    	public function updateuserprofile(Request $request)
        {
    		
    		
    		$userid = $request->userid;
    		
			if(empty($request->instructorrate))
			{
				$instructorrate = 0 ;
			}
			else
			{
				$instructorrate = $request->instructorrate;
			}

			if(empty($request->instructorratetype))
			{
				$instructorratetype = '' ;
			}
			else
			{
				$instructorratetype = $request->instructorratetype;
			}

			
			
			if(!empty($request->bookingstatus))
			{
				$bookingstatus =  $request->bookingstatus;
			}
			else
			{
				$bookingstatus = 1;
			}
			
    		$data1=array(
                
    			'aboutme' =>$request->aboutme,
    			'interested' =>$request->interested,
    			'level' =>$request->level,
				'name' =>$request->username,
				'instructorrate' =>$instructorrate,
				'instructorratetype' =>$instructorratetype,
				'bookingstatus' =>$bookingstatus,
    			
            );
    
    		
            
    		DB::table('users')->where('id',$userid)->update($data1);
    		
    		$result =  	DB::table('users')
    								->select('id','name','aboutme','interested','level','instructorrate','instructorratetype','bookingstatus')
    								->where('id',$userid)->get();
    		
    		if($result){
                $data['status'] = '1';
                $data['message'] = 'User profile Updated Successfully ';
                $data['$result'] = $result;
                
    			
                
            }else{
                $data['status'] = '0';
                $data['message'] = 'User profile Fail to update';
				$data['$result'] = array();
                
            }
    
    		echo json_encode($data);
    	}
    
    
    
    	public function updateuserpictures(Request $request)
        {
    		
    		
    		//print_r($_FILES);		
			
    			/*$userprofilepic1="";
    			$image1="";
    			$image2="";
    			$image3="";
    			$image4="";
    			$image5="";
    			$image6="";*/
    			$userid = $request->userid;
    			$index = $request->index;
				

				

				$imagefile = "";
    
    			if($index==0)
    			{
    
    				
    				
    
    					if ($request->hasFile('imagefile')) 
    					{
    					$image = $request->file('imagefile');
    					$imagefile = time().'_'.$image->getClientOriginalName();
    					$destinationPath = public_path('/UserImages');
    					$image->move($destinationPath, $imagefile);
    					}
    					else {
    					$image = '';
    					} 

						$data1=array(
                
							'userprofilepic1' =>'UserImages/'.$imagefile,
							
							
							
						 );

    			}
    
    			if($index==1)
    			{
    
    				
					if ($request->hasFile('imagefile')) 
					{
					$image = $request->file('imagefile');
					$imagefile = time().'_'.$image->getClientOriginalName();
					$destinationPath = public_path('/UserImages');
					$image->move($destinationPath, $imagefile);
					}
					else {
					$image = '';
					} 

					$data1=array(
			
						'image1' =>'UserImages/'.$imagefile,
						
						
					 );
    			}
    
    			if($index==2)
    			{
					if ($request->hasFile('imagefile')) 
					{
					$image = $request->file('imagefile');
					$imagefile = time().'_'.$image->getClientOriginalName();
					$destinationPath = public_path('/UserImages');
					$image->move($destinationPath, $imagefile);
					
					}
					else {
					$image = '';
					} 

					$data1=array(
			
						'image2' =>'UserImages/'.$imagefile,
						
						
					 );
    			}
    
    			if($index==3)
    			{
    
					if ($request->hasFile('imagefile')) 
					{
					$image = $request->file('imagefile');
					$imagefile = time().'_'.$image->getClientOriginalName();
					$destinationPath = public_path('/UserImages');
					$image->move($destinationPath, $imagefile);
					
					}
					else {
					$image = '';
					} 

					$data1=array(
			
						'image3' =>'UserImages/'.$imagefile,
						
						
					 );
    			}		
    			if($index==4)
    			{
					if ($request->hasFile('imagefile')) 
					{
					$image = $request->file('imagefile');
					$imagefile = time().'_'.$image->getClientOriginalName();
					$destinationPath = public_path('/UserImages');
					$image->move($destinationPath, $imagefile);
					}
					else {
					$image = '';
					} 

					$data1=array(
			
						'image4' =>'UserImages/'.$imagefile,
						
						
					 );
    			}
    
    			if($index==5)
    			{
    
    
    			
					if ($request->hasFile('imagefile')) 
					{
					$image = $request->file('imagefile');
					$imagefile = time().'_'.$image->getClientOriginalName();
					$destinationPath = public_path('/UserImages');
					$image->move($destinationPath, $imagefile);
					}
					else {
					$image = '';
					} 

					$data1=array(
			
						'image5' =>'UserImages/'.$imagefile,
						
						
					 );
    			}
    			if($index==6)
    			{
    				if ($request->hasFile('imagefile')) 
					{
					$image = $request->file('imagefile');
					$imagefile = time().'_'.$image->getClientOriginalName();
					$destinationPath = public_path('/UserImages');
					$image->move($destinationPath, $imagefile);
					}
					else {
					$image = '';
					} 

					$data1=array(
			
						'image6' =>'UserImages/'.$imagefile,
						
						
					 );
    			}	
    		
    		
    		DB::table('users')->where('id',$userid)->update($data1);
    
    		$result =   DB::table('users')
    					->select('id','name','mobile','email','role','user_type','userprofilepic1','aboutme','image1','image2','image3','image4','image5','image6',
    							'level','interested','instructorrate','instructorratetype','referral_code','referral_user','status','earning','totalbook',
    							'bankname','bankacno','bankaccountname','wallet_amount','refferalcashback','createdby','created_at')
    					->where('id',$request->userid)->get();
    		
    		if($result){
                $data['status'] = '1';
                $data['message'] = 'User Pictures Updated Successfully';
                $data['getusersdetails'] = $result;
    			
                
            }else{
                $data['status'] = '0';
                $data['message'] = 'User Pictures Fail to update';
                
            }
    		
            echo json_encode($data);
    	}
    
    
    
    
    
    
    
    
    	
    	
    	public function getcourttimebycourtid(Request $request){
        
    	  
    	    //echo 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh';
    		$getselectedday = date('l', strtotime($request->senddate));
    		$array_court = explode(',', $_REQUEST['court_id']);
    		
    		
    		$result =  DB::table('venuescourttimes')
    							->join('venues','venues.id','venuescourttimes.court_id')
    							->where('venuescourttimes.vendor_id', '=',$request->vendor_id)
    							//->whereIn('venuescourttimes.court_id',$request->court_id)
    							->whereIn('venuescourttimes.court_id', $array_court)
    							->where('venuescourttimes.days', '=',$getselectedday)
    							->select('venuescourttimes.court_id as court_id',
    									'venuescourttimes.vendor_id as vendor_id',     
    									'venuescourttimes.name as name',
    									'venuescourttimes.stime as stime',
    									'venuescourttimes.etime as etime',
    									'venuescourttimes.price as price',
    									'venuescourttimes.bookstatus as bookstatus',
    									'venuescourttimes.id as timeid',
    									'venuescourttimes.id as id',
    									'venuescourttimes.price as courtprice')
    							->get();
    			$time_array = array();
    			
    			$countdata = 1;
    			foreach($result as $resultkey=>$resultvalue){
    				$time_array[$resultvalue->court_id]['name'] = $resultvalue->name;			
    				$time_array[$resultvalue->court_id]['id'] = $resultvalue->court_id;			
    				/*
    				$time_array[$resultvalue->court_id]['slotdetails']['timeid'] = $resultvalue->timeid;
    				$time_array[$resultvalue->court_id]['slotdetails']['stime'] = $resultvalue->stime;				
    				$time_array[$resultvalue->court_id]['slotdetails']['etime'] = $resultvalue->etime;			
    				$time_array[$resultvalue->court_id]['slotdetails']['price'] = $resultvalue->price;
    				$time_array[$resultvalue->court_id]['slotdetails']['bookstatus'] = $resultvalue->bookstatus; */ 
    				
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['timeid'] = $resultvalue->id;
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['stime'] = $resultvalue->stime;				
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['etime'] = $resultvalue->etime;			
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['price'] = $resultvalue->price;
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['bookstatus'] = $resultvalue->bookstatus;
    
    				$countdata++;
    			}	
    
    			// echo '<pre>time_array ';
    			// print_r($time_array);
    			// echo '</pre>';
    			// // exit();
    
    			$properdata = array();
    			foreach($time_array as $time_arraykey=>$time_arrayvalue){
    
    				// echo '<pre>';
    				// print_r($time_arrayvalue['slotdetails']);
    				// echo '</pre>';
    				// exit();
    
    				// echo '<pre>';
    				// print_r($time_array[$time_arraykey]['test']);
    				// echo '</pre>';
    				// exit();
    
    				// echo '<pre>';
    				// print_r($time_arrayvalue['slotdetails']);
    				// echo '</pre>';
    				// exit();
    
    
    				
    				$time_arrayvalue['slotdetails'] = array_values($time_arrayvalue['slotdetails']);
    				$properdata[] = $time_arrayvalue;
    				// $properdata['slotdetailsqws'] = $time_arrayvalue;
    			}
    
    			// echo '<pre>';
    			// print_r($properdata);
    			// echo '</pre>';
    			// exit();
    	   if($result){
                $data['status'] = '1';
                $data['message'] = 'getcourttimebycourtid Successfull 1212121212';
    			// $data['result'] = $result;
    			$data['time_result'] = $properdata;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    	
    	
    	public function getbookingsummarybytimeid(Request $request){
        
    	   
    		
    		$array_timeid = explode(',', $_REQUEST['timeid']);
    		
    		$result =  DB::table('venuescourttimes')
    							->join('venues','venues.id','venuescourttimes.court_id')
    							->whereIn('venuescourttimes.id', $array_timeid)
    							->select('venuescourttimes.court_id as court_id',
    									'venuescourttimes.vendor_id as vendor_id',     
    									'venuescourttimes.name as name',
    									'venuescourttimes.stime as stime',
    									'venuescourttimes.etime as etime',
    									'venuescourttimes.price as price',
    									'venuescourttimes.bookstatus as bookstatus',
    									'venuescourttimes.id as id',
    									'venuescourttimes.price as courtprice')
    							->get();
    
    					
    
    			$time_array = array();
    			
    			$countdata = 1;
    			foreach($result as $resultkey=>$resultvalue){
    				$time_array[$resultvalue->court_id]['name'] = $resultvalue->name;			
    				$time_array[$resultvalue->court_id]['id'] = $resultvalue->court_id;			
    				
    				
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['id'] = $resultvalue->id;				
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['stime'] = $resultvalue->stime;				
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['etime'] = $resultvalue->etime;			
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['price'] = $resultvalue->price;
    				$time_array[$resultvalue->court_id]['slotdetails'][$countdata]['bookstatus'] = $resultvalue->bookstatus;
					
    				$countdata++;
    			}	
    
    			
    			$properdata = array();
    			foreach($time_array as $time_arraykey=>$time_arrayvalue)
				{
    	
    				$time_arrayvalue['slotdetails'] = array_values($time_arrayvalue['slotdetails']);
    				$properdata[] = $time_arrayvalue;
  				}
    
    			
    	   if($result){
                $data['status'] = '1';
                $data['message'] = 'getbookingsummarybytimeid Successfull';
    			//$data['time_result1'] = $time_array;
    			$data['time_result'] = $properdata;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    	
    	
    	public function getcourtbyvenodrid(Request $request){
        
    	  $result =  DB::table('venues')
    					   ->where('venues.vendor_id', '=', $request->vendor_id)
    					   ->orderBy('name','ASC')
    					   ->get();
    	   if($result){
                $data['status'] = '1';
                $data['message'] = 'getcourtbyvenodrid Successfull';
    			$data['result'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    	
    	
    	public function getcourtbyvenodriddate(Request $request){
        
    	  $result = DB::table('venues')
    					   ->where('venues.vendor_id', '=', $request->vendor_id)
    					   ->where('venues.courtdate', '=', $request->courtdate)
    					   ->orderBy('name','ASC')
    					   ->get();
    	   if($result){
                $data['status'] = '1';
                $data['message'] = 'getcourtbyvenodriddate Successfull';
    			$data['result'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    	
    
    
    	public function getvoucherdetails(Request $request)
    	{
        

			$result = 		DB::table('vouchers')
    						->where('vouchers.voucher_code', '=', $request->voucher_code)
							->where('vouchers.vendor_code', '=', $request->vendor_code)
							->where('vouchers.status', '=', 1)
							->where('vouchers.voucher_total_usage', '>', 0)
							//->where('vouchers.voucher_from_date', '>',now() )
							->where('vouchers.voucher_to_date', '>', now() )
    						->get();

    		 if(count($result))
    		 {
    			  $data['status'] = '1';
    			  $data['message'] = 'getvoucherdetails Successfull';
    			  $data['result'] = $result;
    		  }else{
    			  $data['status'] = '0';
    			  $data['message'] = 'No Data Found';
    			  $data['result'] = array();
    		  }
    		  
    					   
    		  echo json_encode($data);
    	  }
    	  
    
    	  public function getallvoucherdetails(Request $request)
    	  {
        

			
    		
    		$voucherdetails =	DB::table('vouchers')
								->where('vouchers.vendor_code', '=', $request->vendor_code)
								->where('vouchers.status', '=', 1)
								->where('vouchers.voucher_total_usage', '>', 0)
								//->where('vouchers.voucher_from_date', '<=', now() )
								->where('vouchers.voucher_to_date', '>', now() )
								->get();
    		 if(count($voucherdetails))
    		 {
    			  $data['status'] = '1';
    			  $data['message'] = 'getallvoucherdetails Successfull';
    			  $data['voucherdetails'] = $voucherdetails;
    		  }else{
    			  $data['status'] = '0';
    			  $data['message'] = 'No Data Found';
    			  $data['voucherdetails'] = array();
    		  }
    		  
    					   
    		  echo json_encode($data);
    	  }
    
    	  
    
    		public function getallbookingdetails(Request $request)
    		{
        
    		$result	= 	DB::table('booking_with_vendors')
    					->join('vendors','vendors.vendor_id','booking_with_vendors.vendor_id')
						->where('booking_with_vendors.paystatus_id',1)
						->where('booking_with_vendors.user_id',$request->user_id)
						->select('booking_with_vendors.*','vendors.vendor_id','vendors.businessname','vendors.description','vendors.refund','vendors.phonecode',
						'vendors.whatsapp','vendors.address','vendors.latitude','vendors.longitude','vendors.state','vendors.district','vendors.business_category',
						'vendors.promo','vendors.moredetails','vendors.image','vendors.image1','vendors.image2',
						'vendors.image3','vendors.createdby','vendors.vendorrefferalid','vendors.vendor_reffer_commisionval','vendors.created_at','vendors.updated_at')
						->orderBy('booking_with_vendors.booking_id','DESC')
    					->get();
    									
    		 if(count($result)>0)
    		 {
    			  $data['status'] = '1';
    			  $data['message'] = 'getallbookingdetails Successfull';
    			  $data['result'] = $result;
    		  }
			  
			  else{
    			  $data['status'] = '0';
    			  $data['message'] = 'No Data Found';
    			  $data['result'] = array();
    		  }
    		  
    					   
    		  echo json_encode($data);
    	   } 
    
		   public function getinstructorbookingdetails(Request $request)
    		{
        
    		$result	= 	DB::table('instructorbookings')
    					->join('users','users.id','instructorbookings.instructor_id')
						->join('vendors','vendors.businessname','instructorbookings.sportcenter')
						->where('instructorbookings.user_id',$request->user_id)
						->select('vendors.businessname','vendors.image','instructorbookings.instructor_id','instructorbookings.username as instructorname','instructorbookings.time','instructorbookings.date','users.name as username','users.userprofilepic1',
						'instructorbookings.amount','instructorbookings.bookingstatus','instructorbookings.paystatus','instructorbookings.paystatus_id','instructorbookings.transaction_id','instructorbookings.msg','instructorbookings.hash','instructorbookings.created_at')
						->orderBy('instructorbookings.instructor_booking_id','DESC')
    					->get();
    									
    		 if(count($result)>0)
    		 {
    			  $data['status'] = '1';
    			  $data['message'] = 'getinstructorbookingdetails Successfull';
    			  $data['result'] = $result;
    		  }
			  
			  else{
    			  $data['status'] = '0';
    			  $data['message'] = 'No Data Found';
    			  $data['result'] = array();
    		  }
    		  
    					   
    		  echo json_encode($data);
    	   } 
    
    
    	  public function cancelbookingdetails(Request $request)
    		{
        
    			
    
    		
    
    			$bookingtransactiondtls	=   DB::table('booking_with_vendors')
											->join('vendors','vendors.vendor_id','booking_with_vendors.vendor_id')
    									    ->Where('booking_with_vendors.bookingno',$request->bookingno)
										    ->select('booking_with_vendors.*','vendors.refund')
    									    ->first();
    			
 	   			$getbookingstatus = $bookingtransactiondtls->status;
				$paystatus_id = $bookingtransactiondtls->paystatus_id;
				
    			if($getbookingstatus==1)
    			{


						if($paystatus_id==0)
						{
							
							$data['status'] = '0';
							$data['message'] = 'without payment can not cancel booking';
							//$data['result'] = array();
							

						}
						else
						{
							
																
																//date_default_timezone_set('Asia/Kolkata');
																date_default_timezone_set('Asia/Kuala_Lumpur');

																$bookingcreateddate = $bookingtransactiondtls->created_at;
																$vendor_id = $bookingtransactiondtls->vendor_id;
																$refund = $bookingtransactiondtls->refund;
																
															
																
																$currentdate = date("Y-m-d H:i:s");
																$timestamp1 = strtotime($bookingcreateddate);
																
																$timestamp2 = strtotime($currentdate);
																$bookinghours = abs($timestamp1)/(60*60);

																

																//echo "Difference between two dates is " . $hour = abs($timestamp1 - $timestamp2)/(60*60) . " hour(s)";

																$hour = abs($timestamp1 - $timestamp2)/(60*60);
																
																//if($hour>=5)
																if($hour>$refund)
																{
																	
																	$data['status'] = '0';
																	$data['message'] = 'non-refundable booking due to Cancellation Policy:'.$refund.' Hours';
																	//$data['result'] = array();

																}
																else
																{
																	
																	

																	
																									$getbookingamount = $bookingtransactiondtls->amount;
																									$admin_commision_Calculate = $bookingtransactiondtls->admin_commision;
																									$getbookingvendor_id = $bookingtransactiondtls->vendor_id;
																									$getbookinguser_id = $bookingtransactiondtls->user_id;
																									$vednor_fees_Calculate = $bookingtransactiondtls->vednor_fees;
																									$Refferal_commision_Calculate = $bookingtransactiondtls->Refferal_commision;
																									$sales_agent_commision_Calculate = $bookingtransactiondtls->sales_agent_commision;
																									$Vendor_Reffer_commision_Calculate= $bookingtransactiondtls->Vendor_Reffer_commision;
																									$paymentmethodid = $bookingtransactiondtls->paymethod;
																									$mobileno = $bookingtransactiondtls->mobileno;
																									
																									//Update commisson for above all 
																			
																									$getexistsadmin =       User::where("role", "=", 1)->where('id', '=', 1)->first();
																									$getwallet_amountadmin =   $getexistsadmin->wallet_amount - $admin_commision_Calculate;
																									DB::table('users')->where('id', '=', 1)->where('role', '=', 1)->update(['wallet_amount' => $getwallet_amountadmin]); // Update for Admin Wallet							
																			
																									$getexistsvendor =  User::where("id", "=", $getbookingvendor_id)->first();			
																									$getwallet_amountvendor = $getexistsvendor->wallet_amount - $vednor_fees_Calculate;
																									$getvendorcreatedby = $getexistsvendor->createdby;
																									DB::table('users')->where('id', '=', $getbookingvendor_id)->update(['wallet_amount' => $getwallet_amountvendor]); // Update for Vendor Wallet
																															
																									$getSalesperson =  User::where("id", "=", $getvendorcreatedby )->first();
																									$getSalespersonID = $getSalesperson->id;
																									$getwallet_amountsalesperson = $getSalesperson->wallet_amount - $sales_agent_commision_Calculate;
																									DB::table('users')->where('id', '=', $getSalespersonID)->where('role', '=', 7)->update(['wallet_amount' => $getwallet_amountsalesperson]); // Update for SalesAgent Wallet
																									
																								
																									$checkVenodrrefferal =  vendor::where("vendor_id", "=", $getbookingvendor_id)->first();
																									$checkvendor_createdby=  $checkVenodrrefferal->createdby;
																									$checkvendor_salesperson_vendorrefferal=  $checkVenodrrefferal->vendorrefferalid;
																									$checkvendor_reffer_commisionval=  $checkVenodrrefferal->vendor_reffer_commisionval;
																								
																									if($checkvendor_reffer_commisionval=='Y')
																									{
																									$getexistsvendorrefferal =  User::where("id", "=", $checkvendor_salesperson_vendorrefferal)->first();	
																									$getwallet_vendorrefferal  = $getexistsvendorrefferal->wallet_amount - $Vendor_Reffer_commision_Calculate;
																																DB::table('users')
																																->where('id', '=', $checkvendor_salesperson_vendorrefferal)
																																->update(['wallet_amount' => $getwallet_vendorrefferal]);
																			
																									}

																									
																									
																			
																									//Update Refferal User Commision if exists
																									
																									if($paymentmethodid=='1')
																									{
																			
																													$getuserdetails = DB::table('users')->where('mobile',$mobileno)->first();
																													$getusername = $getuserdetails->name;
																													$getreferral_usercode = $getuserdetails->referral_user;
																													$gettotalbook = $getuserdetails->totalbook - 1;
																													DB::table('users')->where('mobile', '=',$mobileno)->update(['totalbook' => $gettotalbook]); 
																													
																													if($getreferral_usercode)
																													{
																														$greferral_code = DB::table('users')->where('referral_code',$getreferral_usercode)->get();
																														
																														foreach($greferral_code as $rdtls)
																														{
																															$referral_user_id = $rdtls->id;
																															$existwallet_amount = $rdtls->wallet_amount;
																															$existearning = $rdtls->earning;
																															$totexistwallet_amount  = $existwallet_amount - $Refferal_commision_Calculate;
																															$totexistearning = $existearning - $Refferal_commision_Calculate;
																															$updatedata=array('wallet_amount'=>$totexistwallet_amount,'earning'=>$totexistearning);
																															DB::table('users')->where('id', '=', $referral_user_id)->update($updatedata); // Update for Refferal User Commision if exists
																											
																														}
																			
																													}
																										}

																										

																										$getuserlogindtls = DB::table('users')->where('id',$getbookinguser_id)->first();
																										$userexistwallet_amount = $getuserlogindtls->wallet_amount;
																										$totuserexistwallet_amount  = $userexistwallet_amount + $getbookingamount;
																										$updatedata1=array('wallet_amount'=>$totuserexistwallet_amount);
																										DB::table('users')->where('id', '=', $getbookinguser_id)->update($updatedata1); // update user wallet after cancel booking
																										
																										
																										$updatedata=array('status'=>$request->status,'paystatus'=>'R','cancellation_date'=>date("Y-m-d H:i:s"));  //update booking refund status
    																									$result =  DB::table('booking_with_vendors')->where('bookingno',$request->bookingno)->update($updatedata);

																										$data['status'] = '1';
																										$data['message'] = 'bookingdetails cancel Successfull';
																										//$data['result'] = $result;

																				}
																

							

						}
    							

										
    								
    
    			}
    			else
    			{
    
    				$data['status'] = '0';
					$data['message'] = 'Already cancel booking no';
					$data['result'] = array();				
    
    			}
    
    			 echo json_encode($data);
    	  }
    
		  
		  public function getbooking2(Request $request)
		  {
		  }
		  public function getbooking3(Request $request)
		  {
		  }
		  public function getbooking4(Request $request)
		  {
		  }
		  public function getbooking5(Request $request)
		  {
		  }

    	  public function getbooking(Request $request)
		  {
			$result=DB::table('booking_with_vendors')
    				->Where('booking_with_vendors.booking_id',$request->booking_id)		
    				->select('booking_with_vendors.*')
    				->get();

			if($result)
    		 {
    			  $data['status'] = '1';
    			  $data['message'] = 'getbooking Successfull';
    			  $data['result'] = $result;
    		  }else{
    			  $data['status'] = '0';
    			  $data['message'] = 'No Data Found';
    			  $data['result'] = array();
    		  }
    		  
    					   
    		  echo json_encode($data);

		  }
    
    	  public function getbookingsumary(Request $request)
    		{
    
    			/*
    		$result=DB::table('booking_with_vendors')
    		->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
    		->join('vendors','vendors.vendor_id','booking_with_vendors.vendor_id')
    		->Where('booking_with_vendors.bookingno',$request->bookingno)
    		->select('booking_with_vendors.*','booking_with_vendorsdetails.*','vendors.businessname')
    		->get(); */
    
    		$result=DB::table('booking_with_vendors')
    		->join('vendors','vendors.vendor_id','booking_with_vendors.vendor_id')
    		->Where('booking_with_vendors.bookingno',$request->bookingno)	
			->Where('booking_with_vendors.paystatus_id',1)	
			//->Where('booking_with_vendors.status',1)
    		->select('booking_with_vendors.bookingno','booking_with_vendors.date','booking_with_vendors.amount','booking_with_vendors.admin_commision','booking_with_vendors.voucher_code','booking_with_vendors.voucher_sales','booking_with_vendors.qrcodeimage','booking_with_vendors.status','booking_with_vendors.checkinstatus','booking_with_vendors.created_at','booking_with_vendors.paymentdate','vendors.businessname','vendors.description','vendors.address')
    		->get()->first();


			if(!empty($result))
			{
				
				$booking_with_vendorsdetails_result=DB::table('booking_with_vendorsdetails')		
				->Where('booking_with_vendorsdetails.bookingno',$request->bookingno)
				->select('booking_with_vendorsdetails.courtid','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.days','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','booking_with_vendorsdetails.created_at')
				->get();
		
				$result->courtdetails = $booking_with_vendorsdetails_result;
			}
			else
			{

				
			}

							
    		 if($result)
    		 {
    			  $data['status'] = '1';
    			  $data['message'] = 'getbookingsumary Successfull';
    			  $data['result'] = $result;
    		  }else{
    			  $data['status'] = '0';
    			  $data['message'] = 'No Data Found';
    			  $data['result'] = array();
    		  }
    		  
    					   
    		  echo json_encode($data);
    	   } 
    
    
    
    	   public function sportsvenuedetails(Request $request)
    		{
        
    		$result	= 	DB::table('venues')
    			->join('vendors','vendors.vendor_id','venues.vendor_id')
    			->select('venues.*','vendors.address','vendors.state','vendors.district')
    			->orderBy('venues.id','DESC')
    			->get();
    									
    		 if($result)
    		 {
    			  $data['status'] = '1';
    			  $data['message'] = 'sportsvenuedetails Successfull';
    			  $data['result'] = $result;
    		  }else{
    			  $data['status'] = '0';
    			  $data['message'] = 'No Data Found';
    			  $data['result'] = array();
    		  }
    		  
    					   
    		  echo json_encode($data);
    	   } 
    
    
    
    	   
    
    	   public function refferaleditbankdetail(Request $request)
    		{
    			
    			
    			$userdetails = array(
    				'bankname'=>$request->bankname,
    				'bankacno'=>$request->bankacno,
    				'bankaccountname'=>$request->bankaccountname
    				
    			);
    			
    			$result = DB::table('users')->where('users.id',$request->id)->update($userdetails);
    			$data['status'] = '1';
    			$data['message'] = 'refferaleditbankdetail Successfull';
    
    		
    
    
    
    			//$result1= DB::table('users')->Where('users.id',$request->id)->select('users.wallet_amount')->get();
    
    			/*if($result){
    				$data['status'] = '1';
    				$data['message'] = 'refferaleditbankdetail Successfull';
    				//$data['result'] = $result;
    				//$data['result1'] = $result1;
    				
    			}
    			else{
    				$data['status'] = '0';
    				$data['message'] = 'refferaleditbankdetail Fail';
    				//$data['result'] = 0;
    				//$data['result1'] =  0;
    			}*/
    			
    			echo json_encode($data);
    		}
    
    
			public function instructorwithdrawaldetails(Request $request)
			{
				
				$instructorwithdrawaldetails =   DB::table('users')
    								->join('withdrawals','withdrawals.user_id','users.id')
    								->Where('withdrawals.user_id','=',$request->userid)
    								//->Where('withdrawals.withdrawal_status','=','2')
    								//->Where('withdrawals.reportflag','=','Y')
    								->select('users.id','users.name','users.wallet_amount','withdrawals.withdrawal_id','withdrawals.withdrawal_amount','withdrawals.withdrawal_status','withdrawals.created_at')
    								->get();

									$data['status'] = '1';
									$data['message'] = 'instructorwithdrawaldetails Successfull';
									$data['instructorwithdrawaldetails'] = $instructorwithdrawaldetails;
									echo json_encode($data);					

			}	
    
    		  
    		   public function refferalbookingtransation(Request $request)
    			{
    				
    				$refferalbookingtran =   DB::table('users')
    								->join('withdrawals','withdrawals.user_id','users.id')
    								->Where('users.role','=','0')
    								->Where('withdrawals.user_id','=',$request->userid)
    								->Where('withdrawals.withdrawal_status','=','2')
    								->Where('withdrawals.reportflag','=','Y')
    								->select('users.id','users.name','users.wallet_amount','withdrawals.withdrawal_amount')
    								->get();
    								
    
    			  $refferaluserbankdetails =   DB::table('users')
    							
    								->Where('users.role','=','0')
    								->Where('users.id','=',$request->userid)
    								->select('users.id','users.bankname','users.bankacno','users.bankaccountname')
    								->get();			
    							
    				$totalrefferaluser = DB::table("users")
    									->Where('users.referral_user','!=','')
    									->Where('users.role','=','0')->count('id');
    
    				$totalrefferaluserRM = DB::table("users")
    									->Where('users.referral_user','!=','')
    									->Where('users.role','=','0')->sum('wallet_amount');
    
    												
    				
    				if($refferalbookingtran){
    					$data['status'] = '1';
    					$data['message'] = 'refferalbookingtransation Successfull';
    					$data['refferaluserbankdetails'] = $refferaluserbankdetails;
    					$data['totalrefferaluser'] = $totalrefferaluser;
    					$data['totalrefferaluserRM'] = $totalrefferaluserRM;
    					$data['refferalbookingtransaction'] = $refferalbookingtran;
    					
    
    				   
    				}else{
    					$data['status'] = '0';
    					$data['message'] = 'No Data Found';
    					$data['refferaluserbankdetails'] = array();
    					$data['totalrefferaluser'] = array();
    					$data['totalrefferaluserRM'] = array();
    					$data['refferalbookingtransaction'] = array();
    					
    					
    				}
    				
    							 
    				echo json_encode($data);
    
    			}
    
    		  public function hostgameadd(Request $request)
    		  {
    		
    			$data1=array(
    				'hostcreatedby'=>$request->hostcreatedby,
					'host_game_name'=>$request->host_game_name,
    				'description'=>$request->description,
    				'totalplayer'=>$request->totalplayer,
    				'gamestartdate'=>$request->gamestartdate,
    				//'gameenddate'=>$request->gameenddate,
    				'stime'=>$request->stime,
    				'etime'=>$request->etime,
    				'category'=>$request->category,
    				'venuebook'=>$request->venuebook,
    				'venuename'=>$request->venuename,
    				'customvenue'=>$request->customvenue,
					'hostcancelationdate'=>$request->hostcancelationdate,
    				'hostcancelationtime'=>$request->hostcancelationtime,
					'teamgame'=>$request->teamgame,
    				
    			);
    			
    			$insertedid = hostgames::insertGetId($data1);
				$result =  DB::table('hostgames')
							->join('users','users.id','hostgames.hostcreatedby')
							->select('hostgames.*','users.name','users.mobile','users.email','users.userprofilepic1')
							->where('hostgames.host_id',$insertedid)
							->get();


    			if($result){
    				$data['status'] = '1';
    				$data['message'] = 'hostgameadd Successfull';
    				$data['result'] = $result;
    			}else{
    				$data['status'] = '0';
    				$data['message'] = 'hostgameadd Fail';
    				$data['result'] = array();
    			}
    			
    			echo json_encode($data);
    		}
    
    
    		public function hostgamecancel(Request $request)
    		{
        
    			//$updatedata=array('status'=>$request->status);
    			//$result = DB::table('hostgames')->where('hostgames.host_id',$request->host_id)->update($updatedata);
				$result = DB::table('hostgames')->where('hostgames.host_id',$request->host_id)->Update(['status'=>$request->status]);

				
    									
    			/*if($result)
    			{
    				$data['status'] = 1;
    				$data['message'] = 'hostgamecancel Successfull';
    				//$data['result'] = $result;
					$data['result'] = array();

    			}else{
    				$data['status'] = '0';
    				$data['message'] = 'No Data Found';
    				$data['result'] = array();
    			}*/
				
    		  		$data['status'] = 1;
    				$data['message'] = 'hostgamecancel Successfull';
    				//$data['result'] = array();
    					   
    		  echo json_encode($data);
    	  }	
    	
		  public function hostgamefilterby(Request $request)
		  {
	  
			  /*$result = hostgames::select('hostgames.*')
								   ->Where('category', '=', $request->category)
									 ->orderBy('host_id','DESC')
								   ->get();*/


			 $result	= DB::table('hostgames')
								   ->join('vendors','vendors.vendor_id','hostgames.venuename')
								   ->Where('hostgames.category', '=', $request->category)
								   ->orWhere('vendors.state', '=', $request->state)
								   ->select('hostgames.*','vendors.businessname','vendors.state','vendors.image','vendors.address')
								   ->orderBy('hostgames.host_id','DESC')->get();					 
			  
								   
		
			  if($result)
			  {
				  $data['status'] = '1';
				  $data['message'] = 'hostgamefilterby Successfull';
				  $data['result'] = $result;
			  }else{
				  $data['status'] = '0';
				  $data['message'] = 'No Data Found';
				  $data['result'] = array();
			  }
			
						 
			echo json_encode($data);
		}

		 public function gethostgames(Request $request){
        
			
			

			$result	= DB::table('hostgames')
						->leftJoin('vendors','vendors.vendor_id','hostgames.venuename')
						->Where('hostgames.status','=',1)
						->whereDate('hostgames.hostcancelationdate', '>=', Carbon::today()->toDate())
						->select('hostgames.*','vendors.businessname','vendors.state','vendors.image','vendors.address','vendors.latitude','vendors.longitude')
						->orderBy('hostgames.host_id','DESC')->get();




			if($result){
				  $data['status'] = '1';
				  $data['message'] = 'hostgames Get Successfull';
				  $data['result'] = $result;
			  }else{
				  $data['status'] = '0';
				  $data['message'] = 'No Data Found';
				  $data['result'] = array();






			  }
			  
						   
			  echo json_encode($data);
		  }

		  public function nearestsports(Request $request)
    	   {
    		  
    		   $category = $request->category;
    		   $state = $request->state;
			   $searchTerm = $request->name;
			  
			   if (($searchTerm=='') && ($category=='') && ($state==''))
			   {
				$result	= 	DB::table('venues')
							->join('vendors','vendors.vendor_id','venues.vendor_id')
							->select('venues.*','vendors.businessname','vendors.address','vendors.latitude','vendors.longitude','vendors.business_category as category','vendors.state')
							->orderBy('venues.id','DESC')
							->get();
   
			   }
			
			   else if (($searchTerm=='') && ($category!='') && ($state==''))
			   {
					$result	= 	DB::table('venues')
					->join('vendors','vendors.vendor_id','venues.vendor_id')
					->where('vendors.business_category', '=', $category)
					->select('venues.*','vendors.businessname','vendors.address','vendors.latitude','vendors.longitude','vendors.business_category as category','vendors.state')
					->orderBy('venues.id','DESC')
					->get();
			   }
			   else if (($searchTerm=='') && ($category=='') && ($state!=''))
			   {
					$result	= 	DB::table('venues')
					->join('vendors','vendors.vendor_id','venues.vendor_id')
					->where('vendors.state', '=', $state)
					->select('venues.*','vendors.businessname','vendors.address','vendors.latitude','vendors.longitude','vendors.business_category as category','vendors.state')
					->orderBy('venues.id','DESC')
					->get();
			   }
			   else
			   {
					$result	= 	DB::table('venues')
					->join('vendors','vendors.vendor_id','venues.vendor_id')
					->where('vendors.business_category', '=', $category)
					->where('vendors.state', '=', $state)
					->orWhere('vendors.businessname', 'LIKE', "%{$searchTerm}%") 
					->select('venues.*','vendors.businessname','vendors.address','vendors.latitude','vendors.longitude','vendors.business_category as category','vendors.state')
					->orderBy('venues.id','DESC')
					->get();
			   }
    
    	     


			   $sportdetails	= 	DB::table('venues')
    		   ->join('vendors','vendors.vendor_id','venues.vendor_id')
			   ->orwhereNotIn('vendors.business_category', [$category])
			   ->orwhereNotIn('vendors.state', [$state])
			   ->select('venues.*','vendors.businessname','vendors.address','vendors.latitude','vendors.longitude','vendors.business_category as category','vendors.state')
    		   ->orderBy('venues.id','DESC')
    		   ->get();
			   
			   
    								   
    		if($result)
    		{
    			 $data['status'] = '1';
    			 $data['message'] = 'sportsvenuedetails Successfull';
    			 $data['result'] = $result;
				 $data['sportdetails'] = $sportdetails;
    		 }else{
    			 $data['status'] = '0';
    			 $data['message'] = 'No Data Found';
    			 $data['result'] = array();
    		 }
    		 
    					  
    		 echo json_encode($data);
    	  } 

		  public function nearesthost(Request $request){

			$category = $request->category;
    		$state = $request->state;
		    $searchTerm = $request->name;
        
			
			if (($searchTerm=='') && ($category=='') && ($state==''))
			{
						$result	= DB::table('hostgames')
						->leftJoin('vendors','vendors.vendor_id','hostgames.venuename')
						->where('hostgames.status', '=', 1)
						->whereDate('hostgames.hostcancelationdate', '>=', Carbon::today()->toDate())
						->select('hostgames.*','vendors.businessname','vendors.state','vendors.image','vendors.address','vendors.latitude','vendors.longitude')
						->orderBy('hostgames.host_id','DESC')->get();
			}
			else if (($searchTerm=='') && ($category!='') && ($state==''))
			{

				$result	= DB::table('hostgames')
						->leftJoin('vendors','vendors.vendor_id','hostgames.venuename')
						->where('hostgames.status', '=', 1)
						->where('hostgames.category', '=', $category)
						->where('hostgames.hostcancelationdate', '>=', Carbon::today()->toDate())
    		   			->select('hostgames.*','vendors.businessname','vendors.state','vendors.image','vendors.address','vendors.latitude','vendors.longitude')
						->orderBy('hostgames.host_id','DESC')->get();

			}
			else if (($searchTerm=='') && ($category=='') && ($state!=''))
			{
				$result	= DB::table('hostgames')
						->leftJoin('vendors','vendors.vendor_id','hostgames.venuename')
						->where('hostgames.status', '=', 1)
						->where('vendors.state', '=', $state)
						->where('hostgames.hostcancelationdate', '>=', Carbon::today()->toDate())
				   		->select('hostgames.*','vendors.businessname','vendors.state','vendors.image','vendors.address','vendors.latitude','vendors.longitude')
						->orderBy('hostgames.host_id','DESC')->get();
			}
			else
			{

				$result	= DB::table('hostgames')
						->leftJoin('vendors','vendors.vendor_id','hostgames.venuename')
						->where('hostgames.status', '=', 1)
						->where('hostgames.category', '=', $category)
    		   			->where('vendors.state', '=', $state)						
						->where('hostgames.hostcancelationdate', '>=', Carbon::today()->toDate())
						->orWhere('hostgames.host_game_name', 'LIKE', "%{$searchTerm}%") 
						->select('hostgames.*','vendors.businessname','vendors.state','vendors.image','vendors.address','vendors.latitude','vendors.longitude')
						->orderBy('hostgames.host_id','DESC')->get();
			}
			
			

			if($result){
				  $data['status'] = '1';
				  $data['message'] = 'hostgames Get Successfull';

				  
				  $data['result'] = $result;
			  }else{
				  $data['status'] = '0';
				  $data['message'] = 'No Data Found';
				  $data['result'] = array();
			  }
			  
						   
			  echo json_encode($data);
		  }

		   public function hostgamesbyuserid(Request $request)
		  {
			
			
			Cache::flush();
			   
				$hostgamescheck	= DB::table('hostgames')
								->join('vendors','vendors.vendor_id','hostgames.venuename')
								->Where('hostgames.hostcreatedby','=',$request->user_id)
								->Where('hostgames.status','=',1)
								->select('hostgames.*','vendors.*')
								->orderBy('hostgames.host_id','DESC')
								->get();

				if(count($hostgamescheck)>0)
						{
							$data['status'] = '1';
							$data['message'] = 'hostgames list get Successfull';
							$data['result'] = $hostgamescheck;
							
						}else{
							$data['status'] = '0';
							$data['message'] = 'No Data Found';
							$data['result'] = array();
						}
						
									 
						echo json_encode($data);



		  }
		
		  public function hostgamesbyid(Request $request){
        
			/*$result	= DB::table('hostgames')
						->join('vendors','vendors.vendor_id','hostgames.venuename')
						->join('buddybookings','buddybookings.host_id','hostgames.host_id')
						->join('users','users.id','buddybookings.user_id')
						->Where('hostgames.host_id','=',$request->host_id)
						->select('hostgames.*','vendors.businessname','vendors.state','vendors.image','vendors.address','vendors.latitude','vendors.longitude','buddybookings.user_id','users.name','users.mobile','users.email','users.userprofilepic1',
						'users.image1','users.image2','users.image3','users.image4','users.image5','users.image6')
						->orderBy('hostgames.host_id','DESC')->get();*/

						
				error_log($request->host_id);
			
						$hostgamescheck	= DB::table('hostgames')
						->leftJoin('vendors','vendors.vendor_id','hostgames.venuename')
						->Where('hostgames.host_id','=',$request->host_id)
						->select('hostgames.*')
						->orderBy('hostgames.host_id','DESC')
						->get();

						if(count($hostgamescheck)>0)
						{
							$result	= DB::table('hostgames')
							->leftJoin('vendors','vendors.vendor_id','hostgames.venuename')
							->Where('hostgames.host_id','=',$request->host_id)
							->select('hostgames.*','vendors.businessname','vendors.state','vendors.image','vendors.address','vendors.latitude','vendors.longitude')
							->orderBy('hostgames.host_id','DESC')
							->get()->first();

										$buddybookingscountlist=DB::table('buddybookings')		
										->join('users','users.id','buddybookings.user_id')
										->Where('buddybookings.host_id',$request->host_id)
										->select('buddybookings.user_id','users.name','users.mobile','users.email','users.userprofilepic1',
										'users.image1','users.image2','users.image3','users.image4','users.image5','users.image6')
										->get();
						  
										$buddybookingscount = $buddybookingscountlist->count();

										if($buddybookingscount>0)
										{

											$buddybookings=DB::table('buddybookings')		
											->join('users','users.id','buddybookings.user_id')
											->Where('buddybookings.host_id',$request->host_id)
											->select('buddybookings.user_id','users.name','users.mobile','users.email','users.userprofilepic1',
											'users.image1','users.image2','users.image3','users.image4','users.image5','users.image6')
											->get();

											$result->buddybookingsdetails = $buddybookings;	
										}
										else
										{
											$result->buddybookingsdetails = array();
										}



						}
						else
						{
							$result	 = array();

						}


						if(count($hostgamescheck)>0)
						{
							$data['status'] = '1';
							$data['message'] = 'hostgames Get Successfull';
							$data['result'] = $result;
							//$data['buddybookings'] = $buddybookings;
						}else{
							$data['status'] = '0';
							$data['message'] = 'No Data Found';
							$data['result'] = array();
						}
						
									 
						echo json_encode($data);
						

		  }
    	
    
    	  public function hostgamejoin(Request $request){
        
    	
    		$hostgamedetails=DB::table('hostgames')->Where('hostgames.host_id',$request->host_id)->select('hostgames.*')->get()->first();
    		
			
		  
		     $userdetails = array(
    					'host_id'=>$request->host_id,
    					'host_game_name'=>$hostgamedetails->host_game_name,
    					'user_id'=>$request->user_id,
    				);
    	
    
			//$userdetails1 = User::select('users.*')->where('users.id', '=',$request->user_id)->get();

			$userdetails1=DB::table('users')
							  ->Where('users.id',$request->user_id)
							  ->select('users.id','users.name','users.userprofilepic1','users.mobile','users.email')
							   ->get();

    		 $checkexistsuser =  DB::table('buddybookings')->Where('buddybookings.host_id',$request->host_id)->Where('buddybookings.user_id',$request->user_id)->select('buddybookings.*')->get();
			 
			 $checkexistsusercount = $checkexistsuser->count();
		
			 if($checkexistsusercount>0)
			 {
				
				$data['status'] = '0';
    			$data['message'] = 'already exists the user in hostgamejoin';
    		    $data['result'] = $userdetails1;

			 }	
			 else
			 { 

				

				$insertedId = buddybookings::insertGetId($userdetails);
				$total_invitation = $hostgamedetails->total_invitation;	
				$sumtotal_invitation = $total_invitation + 1 ;	
				$updatedata1=array('total_invitation'=>$sumtotal_invitation);
				DB::table('hostgames')->where('hostgames.host_id', '=', $request->host_id)->update($updatedata1);  //Update Buddy user list

				$data['status'] = '1';
    			$data['message'] = 'hostgamejoin by user Successfull';
    		    $data['result'] = $userdetails1;


			 }	

			 echo json_encode($data);
    
    
    		  }
    

    
			  public function hostgameremove(Request $request)
			  {
        
    			
				$hostgamedetails=DB::table('hostgames')
    				 			 ->Where('hostgames.host_id',$request->host_id)
    				  			->select('hostgames.*')
    				  			->get()->first();
				$total_invitation = $hostgamedetails->total_invitation;	
				$sumtotal_invitation = $total_invitation - 1 ;	
				$updatedata1=array('total_invitation'=>$sumtotal_invitation);
				DB::table('hostgames')->where('hostgames.host_id', '=', $request->host_id)->update($updatedata1);  //Remove Buddy user list


				$delexistshostgameuser = DB::table('buddybookings')->where('host_id', $request->host_id)->where('user_id', $request->user_id)->delete();
		
				   if($delexistshostgameuser){
						  $data['status'] = '1';
						  $data['message'] = 'hostgamermove by user Successfull';
						  //$data['result'] = $userdetails;
						 
					  }else{
						  $data['status'] = '0';
						  $data['message'] = 'No Data Found';
						  $data['result'] = '0';
					  }
					  
								   
					  echo json_encode($data);
		
		
				  }
		
    
    	public function updateinstructorprofile(Request $request)
        {
    		
    		
    		//print_r($_FILES);		
    		
    			$category_image="";
    			$category_image1="";
    			$category_image2="";
    			$category_image3="";
    			$category_image4="";
    			$category_image5="";
    			$category_image6="";
    			
    			if ($request->hasFile('userprofilepic1')) 
    			{
    			$image = $request->file('userprofilepic1');
                $category_image = time().'_'.$image->getClientOriginalName();
                $destinationPath = public_path('/InstructorImages');
                $image->move($destinationPath, $category_image);
    			}
    			else {
                $image = '';
    			} 
    			
    			if ($request->hasFile('image1')) 
    			{
    			$image = $request->file('image1');
                $category_image1 = time().'_'.$image->getClientOriginalName();
                $destinationPath = public_path('/InstructorImages');
                $image->move($destinationPath, $category_image1);
    			}
    			else {
                $image = '';
    			} 
    			
    			if ($request->hasFile('image2')) 
    			{
    			$image = $request->file('image2');
                $category_image2 = time().'_'.$image->getClientOriginalName();
                $destinationPath = public_path('/InstructorImages');
                $image->move($destinationPath, $category_image2);
    			}
    			else {
                $image = '';
    			} 
    			
    			if ($request->hasFile('image3')) 
    			{
    			$image = $request->file('image3');
                $category_image3 = time().'_'.$image->getClientOriginalName();
                $destinationPath = public_path('/InstructorImages');
                $image->move($destinationPath, $category_image3);
    			}
    			else {
                $image = '';
    			}
    			
    			if ($request->hasFile('image4')) 
    			{
    			$image = $request->file('image4');
                $category_image4 = time().'_'.$image->getClientOriginalName();
                $destinationPath = public_path('/InstructorImages');
                $image->move($destinationPath, $category_image4);
    			}
    			else {
                $image = '';
    			}
    			
    			if ($request->hasFile('image5')) 
    			{
    			$image = $request->file('image5');
                $category_image5 = time().'_'.$image->getClientOriginalName();
                $destinationPath = public_path('/InstructorImages');
                $image->move($destinationPath, $category_image5);
    			}
    			else {
                $image = '';
    			}
    			
    			if ($request->hasFile('image6')) 
    			{
    			$image = $request->file('image6');
                $category_image6 = time().'_'.$image->getClientOriginalName();
                $destinationPath = public_path('/InstructorImages');
                $image->move($destinationPath, $category_image6);
    			}
    			else {
                $image = '';
    			}
    			
    		
    		$id = $request->id;
    		$data=array(
                
    			'aboutme' =>$request->aboutme,
    			'interested' =>$request->interested,
    			'level' =>$request->level,
    			'userprofilepic1' =>$category_image,
    			'image1' =>$category_image1,
    			'image2' =>$category_image2,
    			'image3' =>$category_image3,
    			'image4' =>$category_image4,
    			'image5' =>$category_image5,
    			'image6' =>$category_image6,
    		
    		);
            
    		$result = DB::table('users')->where('id',$id)->update($data);
    
    		$updatedata=array('rate_hourly'=>$request->rate_hourly,'category' =>$request->category,'state' =>$request->state,'district' =>$request->district);
    		$result1 = DB::table('instructor')->where('instructor_id',$id)->update($updatedata);
    		
    		if($result){
                $data['status'] = '1';
                $data['message'] = 'User Profile Successfully Updated';
                $data['result'] = $data;
            }else{
                $data['status'] = '0';
                $data['message'] = 'Registration Fail';
                $data['result'] = array();
            }
    		
            echo json_encode($data);
    	}
    
    
    	public function instructorfilterby(Request $request)
    	{
    
    		$result = instructor::select('instructor.*')
    								->orWhere('category', 'LIKE', '%'.$request->txtserach.'%')
    							   ->orWhere('state', 'LIKE', '%'.$request->txtserach.'%')
    							   ->orWhere('district', 'LIKE', '%'.$request->txtserach.'%')
    							 	->orderBy('instructor_id','DESC')
    								 ->get();
    		
    								 
    	
    		if($result)
    		{
    			$data['status'] = '1';
    			$data['message'] = 'instructorfilterby Successfull';
    			$data['result'] = $result;
    		}else{
    			$data['status'] = '0';
    			$data['message'] = 'No Data Found';
    			$data['result'] = array();
    		}
    	  
    				   
    	  echo json_encode($data);
      }
    
      public function instructorhireme(Request $request)
      {
    	  
    	  $userid = $request->userid;
    	  $instructor_id = $request->instructor_id;
    	  
    	 
    	  $getusername = DB::table('users')->where('id',$userid)->first();
    	  $getusername->name;
    
    	  $getsportcenterdata = DB::table('instructor')->where('instructor_id',$instructor_id)->first();
    	  $getsportcenter = $getsportcenterdata->sportcenter;
    
    	  $instructorratedtls = DB::table('users')->where('id',$instructor_id)->first();
    	  $instructorratedtls->instructorrate;


		  $instructorratedtls->instructorrate;

		  if($instructorratedtls->instructorrate==0)
		  {

					$data['status'] = '0';
					$data['message'] = 'instructorhireme Fail due to empty instructor rate';
					$data['result'] = array();
		  }
		  else
		  {

							// randomNumber
							$randomNumber = rand(100000000,999999999);
							$instructor_booking_no = 'I'.$randomNumber;
							$checkexistinstructor_booking_no = DB::table('instructorbookings')
													->where('instructor_booking_no', '=', $instructor_booking_no)
													->select('instructorbookings.instructor_booking_no')
													->get()->count();
							
							if($checkexistinstructor_booking_no==1)
							{
								$randomNumber = rand(100000000,999999999);
								$instructor_booking_no = 'I'.$randomNumber;
							}
						
								//Calculating commission  
								$commisionmgmt=  DB::table('commisionmgmt')->select('commisionmgmt.*')->first();
								$admin_commisionval = $commisionmgmt->admin_commisionval;
								
								$admin_commision_Calculate = ($instructorratedtls->instructorrate * $admin_commisionval) / 100;
								$netprofit = 	$instructorratedtls->instructorrate - $admin_commision_Calculate;
						
								//Update commisson for admin 
								//$getexistsadmin =       User::where("role", "=", 1)->where('id', '=', 1)->first();
								//$getwallet_amountadmin =   $getexistsadmin->wallet_amount + $admin_commision_Calculate;
								//DB::table('users')->where('id', '=', 1)->where('role', '=', 1)->update(['wallet_amount' => $getwallet_amountadmin]); // Update for Admin Wallet
						
								//Update commisson for instructor 
								//$getexistsinstructor =       User::where("role", "=", 4)->where('id', '=', $request->instructor_id)->first();
								//$getwallet_amountinstructor =   $getexistsinstructor->wallet_amount + $netprofit;
						
								/*$userdetails1 = array(
									'earning'=>$getwallet_amountinstructor,
									'wallet_amount'=>$getwallet_amountinstructor,
								);
								DB::table('users')->where('users.id',$request->instructor_id)->update($userdetails1);   // Update for instructor Wallet*/
						
								
								
								$data1=array(
									
								'instructor_booking_no' =>$instructor_booking_no,
								'instructor_id' =>$request->instructor_id,
								'user_id' =>$request->userid,
								'username' =>$getusername->name,
								'sportcenter' =>$getsportcenter,
								'time' =>$request->time,
								'date' =>$request->date,
								'amount' =>$instructorratedtls->instructorrate,
								'admin_commision' =>$admin_commision_Calculate,
								'netprofit' =>$netprofit,
							);
						
							$inserteddata = instructorbookings::insertGetId($data1);
							
							$result =   DB::table('instructorbookings')->where('instructor_booking_id',$inserteddata)->get();
							
							
							if(count($result)>0){
						
								$data['status'] = '1';
								$data['message'] = 'instructorhireme updated';
								$data['result'] = $result;
							}
							else
							{
								$data['status'] = '0';
								$data['message'] = 'instructorhireme Fail';
								$data['result'] = array();
								
							}
			  

		  }
		  

    
    
    	
    	  echo json_encode($data);
       }
    
    
       public function instructoreditbankdetail(Request $request)
       {
    	   
    	   $userdetails = array(
    		   'bankname'=>$request->bankname,
    		   'bankacno'=>$request->bankacno,
    		   'bankaccountname'=>$request->bankaccountname,
    		   
    	   );
    	   
    	   
    	    $result = DB::table('users')->where('users.id',$request->instructor_id)->update($userdetails);
    
    		$data['status'] = '1';
    		$data['message'] = 'instructoreditbankdetail Successfull';
    
    	 	echo json_encode($data);
       }
    
    
	   public function refferalwithdrawal(Request $request){
        
    	
		$resultvalue=DB::table('users')->Where('users.id',$request->id)->select('users.*')->first();
	 
		$userdetails = array(
			'bankname'=>$resultvalue->bankname,
			'bankacno'=>$resultvalue->bankacno,
			'bankaccountname'=>$resultvalue->bankaccountname,
			'wallet_amount'=>$resultvalue->wallet_amount,
			'withdrawal_amount'=>$request->withdrawal_amount,
			'user_id'=>$request->id,
			
		);


		if($request->withdrawal_amount>=50)
		{
			
			$insertedId = withdrawals::insertGetId($userdetails);
			$data['status'] = '1';
			$data['message'] = 'withdrawal request Successfull';
			
		}
		else
		{
			
			//$insertedId = 0;
			$data['status'] = '0';
			$data['message'] = 'Minimum withdrawal request RM 50';

		}
	
			echo json_encode($data);
	
	}
	
       public function instructorwithdrawal(Request $request){
        
       $result=DB::table('users')->Where('users.id',$request->id)->select('users.*')->first();
    	  
	   $userdetails = array(
		'bankname'=>$result->bankname,
		'bankacno'=>$result->bankacno,
		'bankaccountname'=>$result->bankaccountname,
		'wallet_amount'=>$result->wallet_amount,
		'withdrawal_amount'=>$request->withdrawal_amount,
		'user_id'=>$request->id,
		
	   );
    
    	 $insertedId = withdrawals::insertGetId($userdetails);
    	
    	 
		 if($insertedId){
    			  $data['status'] = '1';
    			  $data['message'] = 'withdrawal request Successfull';
    			  
    			 
    		  }else{
    			  $data['status'] = '0';
    			  $data['message'] = 'No Data Found';
    			  $data['result'] = '0';
    		  }
    		  
    					   
    		  echo json_encode($data);
    
    
    	  }
    
    
    
    
    
       public function bookingorderbyuser(Request $request)
       {
    	   



		
    	  
    	   $user_id = $request->user_id;
    	   $vendor_id = $request->vendor_id;
    	   $getbookingday = date('l', strtotime($request->bookingdate));
    	   $getbookingdate = date("Y-m-d", strtotime($request->bookingdate));  
    	   $courtid_pk = explode(',', $_REQUEST['courtid_pk']);
    	   
    	   
    	   $getuserdetails = DB::table('users')->where('id',$user_id)->first();
    	   $getusername = $getuserdetails->name;
		   $getuseremail = $getuserdetails->email;
    	   $getreferral_usercode = $getuserdetails->referral_user;
    	   $getusermobile = $getuserdetails->mobile;
    	   $gettotalbook = $getuserdetails->totalbook + 1;

		   
    
    	    $paymethod = 1;

		    $randomNumber = rand(1000000000,9999999999);
		
			$maxbookingno = 'B'.$randomNumber;
			
			$checkexistmaxbookingno = DB::table('booking_with_vendors')
									->where('bookingno', '=', $maxbookingno)
									->select('booking_with_vendors.bookingno')
									->get()->count();
			
			if($checkexistmaxbookingno==1)
			{
				$randomNumber = rand(1000000000,9999999999);
				$maxbookingno = 'B'.$randomNumber;
			}

		   /*$maxbookingno = DB::table('booking_with_vendors')->max('bookingno');
    	   if($maxbookingno==''){
    		$maxbookingno = '10001'; 
    		}
    		else{
    		$maxbookingno = $maxbookingno + 1;
    		}*/
    
    		
    
    	   $bookingsummary =  DB::table('venuescourttimes')
    							->join('venues','venues.id','venuescourttimes.court_id')
    							->where('venuescourttimes.vendor_id', '=',$request->vendor_id)
    							->whereIn('venuescourttimes.id', $courtid_pk)
    							->where('venuescourttimes.days', '=',$getbookingday)
    							->select('venuescourttimes.court_id as court_id',
    									'venuescourttimes.vendor_id as vendor_id',     
    									'venuescourttimes.name as name',
    									'venuescourttimes.timedesc as timedesc',
    									'venuescourttimes.days as days',
    									'venuescourttimes.stime as stime',
    									'venuescourttimes.etime as etime',
    									'venuescourttimes.price as price',
    									'venuescourttimes.bookstatus as bookstatus',
    									'venuescourttimes.id as timeid')
    							->get();
    
    
    			$totalamount=0;
    			foreach($bookingsummary as $bdata)
    			{
    								   
    				   
    				$data1=array(
    					'bookingno'=>$maxbookingno,
    					'vendor_id'=>$bdata->vendor_id,
    					'courtid'=>$bdata->court_id,
    					'courtname'=>$bdata->name,
    					"timedesc" =>$bdata->timedesc,
    					"days" =>$bdata->days,
    					"stime" =>$bdata->stime,
    					"etime" =>$bdata->etime,
    					"price" =>$bdata->price,
    					"date"  =>$getbookingdate,
    					
    					
    					);
    					$totalamount = $totalamount + $bdata->price;
    
    
    					
    					
    					$result1= booking_with_vendorsdetails::insertGetId($data1);
    					/*$bookstatus =array('bookstatus'=>'1');
    					$updatebookslot =  DB::table('venuescourttimes')
    									   ->where('vendor_id',$bdata->vendor_id)
    									   ->where('court_id',$bdata->court_id)
    									   ->where('timedesc',$bdata->timedesc)
    									   ->where('days',$bdata->days)
    									   ->where('stime',$bdata->stime)
    									   ->where('etime',$bdata->etime)
    									   ->update($bookstatus);*/
    		    }						
    	   
    		   
    			//$totalamount	
    					
    			$commisionmgmt=  DB::table('commisionmgmt')->select('commisionmgmt.*')->first();
    			$admin_commisionval = $commisionmgmt->admin_commisionval;			 
    			$Refferal_commisionval = $commisionmgmt->Refferal_commisionval;			 
    			$sales_agent_commisionval = $commisionmgmt->sales_agent_commisionval;			 
    			$Vendor_Reffer_commisionvalue	= $commisionmgmt->Vendor_Reffer_commisionval;			 	
    
    
    
    			//Calculating
    			//$admin_commision_Calculate = ($totalamount * $admin_commisionval) / 100;	
    			//$vednor_fees_Calculate = 	$totalamount - $admin_commision_Calculate;
				$admin_commision_Calculate = ($request->total_amount * $admin_commisionval) / 100;	
    			$vednor_fees_Calculate = 	$request->total_amount - $admin_commision_Calculate;
				
				
    
    			$Refferal_commision_Calculate = ($admin_commision_Calculate * $Refferal_commisionval) / 100;
    			$sales_agent_commision_Calculate = ($admin_commision_Calculate * $sales_agent_commisionval) / 100;
				$Vendor_Reffer_commision_Calculate = ($admin_commision_Calculate * $Vendor_Reffer_commisionvalue) / 100;
				$sporstigototalcommision_Calculate = $admin_commision_Calculate;
    			$netprofit_Calculate =   $vednor_fees_Calculate;

    			/*$checkvendorreffercommison =  vendor::where("vendor_id", "=", $request->vendor_id)->first();
    			$checkvendorreffercommisonID=  $checkvendorreffercommison->vendorrefferalid;
    			$checkvendorreffercommisonValue=  $checkvendorreffercommison->vendor_reffer_commisionval;
    			if(($checkvendorreffercommisonID==0) && ($checkvendorreffercommisonValue=='N'))
    			{
    			$Vendor_Reffer_commision_Calculate = 0;
    			}
    			else
    			{
    
    			
    
    			}*/		
    
    
    			//$sporstigototalcommision_Calculate = $admin_commision_Calculate + $Refferal_commision_Calculate  + $sales_agent_commision_Calculate  + $Vendor_Reffer_commision_Calculate;
    			//$netprofit_Calculate = $totalamount - $sporstigototalcommision_Calculate;
    
    			$qrcodeimage = 'qrcodeimages/'.$maxbookingno.'.png';
    			
    			//date_default_timezone_set('Asia/Kolkata');
		   		date_default_timezone_set('Asia/Kuala_Lumpur');
				if(isset($request->vouchercode))
				{
					
					DB::table('vouchers')->where('voucher_code', '=', $request->vouchercode)->update(['status' => 0]);

					$data2=array(
						'bookingno'=>$maxbookingno,
						'vendor_id'=>$request->vendor_id,
						'vendor_id'=>$request->vendor_id,
						'user_id'=>$user_id,
						'email'=>$getuseremail,
						'mobileno'=>$getusermobile,
						'paymethod'=>$paymethod,
						//'amount'=>$totalamount,
						'amount'=>$request->total_amount,
						'vednor_fees'=>$vednor_fees_Calculate,
						'admin_commision'=>$admin_commision_Calculate,
						'Refferal_commision'=>$Refferal_commision_Calculate,
						'sales_agent_commision'=>$sales_agent_commision_Calculate,
						'Vendor_Reffer_commision'=>$Vendor_Reffer_commision_Calculate,
						'sporstigototalcommision'=>$sporstigototalcommision_Calculate,
						'netprofit'=>$netprofit_Calculate,
						'qrcodeimage'=>$qrcodeimage,
						'date'  =>$getbookingdate,
						'paystatus_id'=>$request->paystatus_id,
						'paystatus'=>'N',
						'voucher_code'=>$request->vouchercode,
						'created_at' => date("Y-m-d H:i:s"),
						'updated_at' => date("Y-m-d H:i:s"),

						);


				}
				else
				{

    			$data2=array(
    				'bookingno'=>$maxbookingno,
    				'vendor_id'=>$request->vendor_id,
					'vendor_id'=>$request->vendor_id,
    				'user_id'=>$user_id,
					'email'=>$getuseremail,
    				'mobileno'=>$getusermobile,
    				'paymethod'=>$paymethod,
    				//'amount'=>$totalamount,
					'amount'=>$request->total_amount,
    				'vednor_fees'=>$vednor_fees_Calculate,
    				'admin_commision'=>$admin_commision_Calculate,
    				'Refferal_commision'=>$Refferal_commision_Calculate,
    				'sales_agent_commision'=>$sales_agent_commision_Calculate,
    				'Vendor_Reffer_commision'=>$Vendor_Reffer_commision_Calculate,
    				'sporstigototalcommision'=>$sporstigototalcommision_Calculate,
    				'netprofit'=>$netprofit_Calculate,
    				'qrcodeimage'=>$qrcodeimage,
    				'date'  =>$getbookingdate,
					'paystatus_id'=>$request->paystatus_id,
    				'paystatus'=>'N',
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s"),
    				
    				);

				}


			
    		$result = booking_with_vendors::insertGetId($data2);
    
    		//Generated QRCODE
    		$JSONdata = json_encode($maxbookingno);	
    		QrCode::size(200)->format('png')->generate($JSONdata , public_path($qrcodeimage)); 
    		
    		
						

							
							$getvendornamedtls = DB::table('vendors')->where('vendor_id',$request->vendor_id)->first();
							$getvendorname = $getvendornamedtls->businessname;

							$paydetails = $getvendorname.' With Amount '.$request->total_amount;

							$merchantId = '644166729208395';
							$secretKey = '37411-1981929663';
							
						
							$senangPay = new SenangPay($merchantId, $secretKey);
							$paymentUrl = $senangPay->createPayment(
							$paydetails,
							$request->total_amount,
							$maxbookingno,
							[
								'name' => $getuserdetails->name,
								'email' => $getuserdetails->email,
								'phone' => $getuserdetails->mobile
							]
							);
    	   
							
							

			$getbookingdetails =  DB::table('booking_with_vendors')
								  ->Where('booking_with_vendors.bookingno',$maxbookingno)
								  ->select('booking_with_vendors.*')
								  ->get();				
		   

			// User Wallet Amount Update
			if($request->walletmoney==1)
			{
									//DB::table('users')->where('id', '=', $bookinguser_id)->update(['wallet_amount' => '0']);
								DB::table('users')->where('id', '=',$user_id)->update(['wallet_amount' => $request->walletamount]);

								$cashbackdata = array('refferalcashback'=>$request->walletamount,
													  'user_id'=>$user_id
													 );
								

								cashbackdetails::insertGetId($cashbackdata);

								
			}
		   
		   if($request->paystatus_id==1)
		   {
			   DB::table('booking_with_vendors')->where('bookingno', '=',$maxbookingno)->update(['paystatus' => 'Y']);
		   }
		

    	   if($result){
    		   $data['status'] = '1';
    		   $data['message'] = 'bookingorderbyuser created';
			   $data['paymentUrl'] = $paymentUrl;
			   $data['getbookingdetails'] = $getbookingdetails;


               
    	   }else{
    		   $data['status'] = '0';
    		   $data['message'] = 'bookingorderbyuser Fail';
    		   $data['result'] = '0';
    	   }
    	   
    	   echo json_encode($data);
    	}
    
		public function instructorbookingstatus(Request $request){
			
			$details = array(
    			'bookingstatus'=>$request->bookingstatus,
    			
    		);
    		
    		

			if($request->bookingstatus==1)
			{
				DB::table('instructorbookings')->where('instructor_booking_no',$request->instructor_booking_no)->update($details);
			
				$data['status'] = '1';
				$data['message'] = 'instructorbookingstatus updated Successfull';

			}
			

			if($request->bookingstatus==2)
			{
					$getuserdetails = DB::table('users')
									 ->join('instructorbookings','instructorbookings.user_id','users.id')
									  ->where('instructorbookings.instructor_booking_no',$request->instructor_booking_no)->first();

					 $getusername = $getuserdetails->name;
					 $getuseremail = $getuserdetails->email;
					 $getusermobile = $getuserdetails->mobile;
					 $totalamount = $getuserdetails->netprofit;
					 
					 $getinstructordetails= DB::table('users')->join('instructorbookings','instructorbookings.instructor_id','users.id')->where('instructorbookings.instructor_booking_no',$request->instructor_booking_no)->first();
					 $getinstructorname = $getinstructordetails->name;
					 $paydetails = $getinstructorname.' With Amount '.$totalamount;


				
					 $merchantId = '644166729208395';
					 $secretKey = '37411-1981929663';
				 
					 $senangPay = new SenangPay($merchantId, $secretKey);
					 $paymentUrl = $senangPay->createPayment(
					 $paydetails,
					 $totalamount,
					 $request->instructor_booking_no,
					 [
						 'name' => $getusername,
						 'email' => $getuseremail,
						 'phone' => $getusermobile
					 ]
					 );

					 $data['paymentUrl'] = $paymentUrl;

			}

			if($request->bookingstatus==4)
			{

						
						DB::table('instructorbookings')->where('instructor_booking_no',$request->instructor_booking_no)->update($details);
					
						$data['status'] = '1';
						$data['message'] = 'instructorbookingstatus updated Successfull';

				//Calculating commission 
									
									$instructorratedtls = DB::table('instructorbookings')
														->join('users','users.id','instructorbookings.instructor_id')
														->select('users.instructorrate','instructorbookings.instructor_id','instructorbookings.amount','instructorbookings.admin_commision','instructorbookings.netprofit')
													    ->where('instructor_booking_no',$request->instructor_booking_no)->first();
    	   							
									$instructorratedtls->instructor_id;
									$instructorratedtls->instructorrate;
									$instructorratedtls->amount;
									$instructorratedtls->admin_commision;
									$instructorratedtls->netprofit;


									//Update commisson for admin 
									$getexistsadmin =       User::where("role", "=", 1)->where('id', '=', 1)->first();
									$getwallet_amountadmin =   $getexistsadmin->wallet_amount + $instructorratedtls->admin_commision;
									DB::table('users')->where('id', '=', 1)->where('role', '=', 1)->update(['wallet_amount' => $getwallet_amountadmin]); // Update for Admin Wallet
							
									//Update commisson for instructor 
									$getexistsinstructor =       User::where("role", "=", 4)->where('id', '=', $instructorratedtls->instructor_id)->first();
									$getwallet_amountinstructor =   $getexistsinstructor->earning + $instructorratedtls->netprofit;
							
									$userdetails1 = array(
										'earning'=>$getwallet_amountinstructor,
										//'wallet_amount'=>$getwallet_amountinstructor,
									);
									DB::table('users')->where('users.id',$instructorratedtls->instructor_id)->update($userdetails1);   // Update for instructor Wallet
									
			}
    		
			



			$instructordetails =  DB::table('instructorbookings')
								->join('users','users.id','instructorbookings.user_id')
								->Where('instructorbookings.instructor_booking_no',$request->instructor_booking_no)
								->select('instructorbookings.*','users.userprofilepic1')
								->get();

			 $data['instructordetails'] = $instructordetails;

    		 echo json_encode($data);
        }
    
    
    	public function getusersdetailsbyid(Request $request){
          
        
    		/*$result =   DB::table('users')
    					->select('id','name','mobile','email','role','user_type','userprofilepic1','aboutme','image1','image2','image3','image4','image5','image6',
    							'level','interested','instructorrate','referral_code','referral_user','status','earning','totalbook',
    							'bankname','bankacno','bankaccountname','wallet_amount','refferalcashback','createdby','created_at')
    					->where('id',$request->userid)->get();*/

			
						$result = User::select('id','name','mobile','email','role','user_type','userprofilepic1','aboutme','image1','image2','image3','image4','image5','image6',
						'level','interested','instructorrate','instructorratetype','referral_code','referral_user','status','earning','totalbook',
						'bankname','bankacno','bankaccountname','wallet_amount','refferalcashback','createdby','created_at')
						->where('id', '=', $request->userid)
						->get();			

    		
            if($result){
                $data['status'] = '1';
                $data['message'] = 'getusersdetailsbyid Successfull';
    			$data['getusersdetails'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = '0';
            }
    		
    					 
            echo json_encode($data);
        }
    
    
		
    	public function getinstructordetailsbyid(Request $request){
          
        
    		//$result =   DB::table('instructor')->where('instructor_id',$request->userid)->get();
			$result =   DB::table('instructor')
						->join('users','users.id','instructor.instructor_id')
						->select('instructor.*','users.name','users.mobile','users.email','users.role','users.user_type','users.userprofilepic1','users.aboutme','users.image1','users.image2','users.image3','users.image4','users.image5','users.image6','users.level','users.interested','users.instructorrate','users.instructorratetype','users.referral_code','users.referral_user',
						'users.status','users.earning','users.totalbook','users.bankname','users.bankacno','users.bankaccountname','users.wallet_amount','users.refferalcashback')
						->where('instructor_id',$request->userid)->get();
			
    		
            if(count($result)){
                $data['status'] = '1';
                $data['message'] = 'getinstructordetailsbyid Successfull';
    			$data['result'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    
    	public function instructorbookingdetailsbyinstructorid(Request $request){
          
        
    		$result =   DB::table('instructorbookings')->where('instructor_id',$request->instructor_id)->orderBy('instructor_booking_id','DESC')->get();
    		
            if(count($result)){
                $data['status'] = '1';
                $data['message'] = 'instructorbookingdetailsbyinstructorid Successfull';
				$data['result'] = $result;
    			
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    
    	public function instructorbookingdetailsbyuserid(Request $request){
          
        
    		//$result =   DB::table('instructorbookings')->where('user_id',$request->user_id)->orderBy('instructor_booking_id','DESC')->get();


			$result =   DB::table('instructorbookings')
						->join('users','users.id','instructorbookings.instructor_id')
						->select('instructorbookings.instructor_booking_id','instructorbookings.instructor_booking_no','instructorbookings.instructor_id','instructorbookings.user_id','users.name as username',
						'instructorbookings.sportcenter','instructorbookings.time','instructorbookings.date','instructorbookings.amount','instructorbookings.admin_commision','instructorbookings.netprofit','instructorbookings.bookingstatus','instructorbookings.paystatus',
						'instructorbookings.paystatus_id','instructorbookings.transaction_id','instructorbookings.msg','instructorbookings.hash','instructorbookings.created_at','instructorbookings.updated_at')
						->where('user_id',$request->user_id)->orderBy('instructor_booking_id','DESC')->get();

    		
            if(count($result)){
                $data['status'] = '1';
                $data['message'] = 'instructorbookingdetailsbyuserid Successfull';
				$data['result'] = $result;
    			
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = array();
            }
    		
    					 
            echo json_encode($data);
        }
    
    
        public function userroleupdate(Request $request){
          
    		
    		$details = array(
    			'role'=>$request->role,
    			
    		);
    		
    		DB::table('users')->where('id',$request->userid)->update($details);
    		
    		
           	$data['status'] = '1';
            $data['message'] = 'userroleupdate updated Successfull';
    		
    					 
            echo json_encode($data);
        }
        
    	public function instructorpanel(Request $request)
    	{
    		
    		
    
    	    $instructordetails =   		DB::table('users')
    								  ->Where('users.id','=',$request->instructor_id)
    								  ->select('users.id','users.bankname','users.bankacno','users.bankaccountname','users.earning','users.wallet_amount')
    								  ->get();			
    					
    		$totalinstructorbooking =  DB::table("instructorbookings")
									 ->Where('instructorbookings.paystatus_id','=',1)
    								  ->Where('instructorbookings.instructor_id','=',$request->instructor_id)->count('instructor_booking_no');
    
    		$totalwitdrawalamount = 	DB::table("withdrawals")
    								->Where('withdrawals.user_id','=',$request->instructor_id)
    								->Where('withdrawals.withdrawal_status','=','2')
    								->Where('withdrawals.reportflag','=','Y')
    								->sum('withdrawal_amount');
    
    			$data['status'] = '1';
    			$data['message'] = 'instructorpanel details get Successfull';
    			$data['instructordetails'] = $instructordetails;
    			$data['totalinstructorbooking'] = $totalinstructorbooking;
    			$data['totalwitdrawalamount'] = $totalwitdrawalamount;
    			
    			
    			echo json_encode($data);
    
    	}
    
    
    
    
    
    	public function checkpayment(Request $request)
    	{
    
    	$result=DB::table('booking_with_vendors')
    			->Where('booking_with_vendors.bookingno',$request->bookingno)		
    			->get();
    							
    	 if($result)
    	 {
    		  $data['status'] = '1';
    		  $data['message'] = 'checkpayment Successfull';
    		  $data['result'] = $result;
    	  }else{
    		  $data['status'] = '0';
    		  $data['message'] = 'No Data Found';
    		  $data['result'] = '0';
    	  }
    	  
    				   
    	  echo json_encode($data);
       } 



	   public function membershipsbyusers(Request $request){
    		
		$checkexistmembership =   DB::table('membershipsbyusers')->Where('membershipsbyusers.membership_id','=',$request->membership_id)->Where('membershipsbyusers.vendor_id','=',$request->vendor_id)->Where('membershipsbyusers.user_id','=',$request->user_id)->select('membershipsbyusers.*')->get()->count();	
		
		if($checkexistmembership==0)
		{
														$userdetails =   DB::table('users')->Where('users.id','=',$request->user_id)->select('users.*')->first();	
														$vendordetails =   DB::table('vendors')->Where('vendors.vendor_id','=',$request->vendor_id)->select('vendors.*')->first();
														

														$username = $userdetails->name;
														$getuseremail = $userdetails->email;
														$getusermobile = $userdetails->mobile;

														$vendorname = $vendordetails->businessname;
														$vendoraddress = $vendordetails->address;
														
														
														$membershipsdetails =   DB::table('memberships')
																				->Where('memberships.membership_id','=',$request->membership_id)
																				->select('memberships.*')
																				->first();	

														$package_duration = $membershipsdetails->package_duration;
														$package_price = $membershipsdetails->package_discount_price;
														
														
														

														$curdate = date("Y-m-d");
														$newDate = date('Y-m-d', strtotime($curdate. ' + '.$package_duration.' months')); 
														
														$randomNumber = rand(1000000,9999999);
														$qrcodeimage = 'membershipqrcode/'.'M'.$randomNumber.'.png';
														$userdetails = array(
															'memberbookingno'=>'M'.$randomNumber,
															'user_id'=>$request->user_id,
															'vendor_id'=>$request->vendor_id,
															'membership_id'=>$request->membership_id,
															'qrcodeimage'=>$qrcodeimage,
															//'package_price'=>$package_price,
															'package_price'=>$request->package_price,
															'person'=>$request->person,
															'fromdate'=>$curdate,
															'todate'=>$newDate,
														);
														
														//Generated QRCODE
														$qrcodeimagedetails =  array(
															
															'username'=>$username,
															'sportsname'=>$vendorname,
															'sportsaddress'=>$vendoraddress,
															'membershipstartdate'=>$curdate,
															'membershipenddate'=>$newDate
														);

														

														$JSONdata = json_encode($qrcodeimagedetails);	
														QrCode::size(200)->format('png')->generate($JSONdata , public_path($qrcodeimage));
														
														
														$result = membershipsbyusers::insertGetId($userdetails);
													
														
														$getpackagename = $membershipsdetails->package_name;
														$ptotalamount = $request->package_price;

														$paydetails = $vendordetails->businessname.' '.$getpackagename.' With Amount '.$ptotalamount;

														/**Payment Integration Start */
																	$merchantId = '644166729208395';
																	$secretKey = '37411-1981929663';
																
																	$senangPay = new SenangPay($merchantId, $secretKey);
																	$paymentUrl = $senangPay->createPayment(
																	$paydetails,
																	$request->package_price,
																	'M'.$randomNumber,
																	[
																		'name' => $username,
																		'email' => $getuseremail,
																		'phone' => $getusermobile
																	]
																	);

																	$data['paymentUrl'] = $paymentUrl;


														/**End Payment Integration Start */



														$getmembershipsbyuser	 =	DB::table('memberships')
																	->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
																	->join('vendors','vendors.vendor_id','membershipsbyusers.vendor_id')
																	->join('users','users.id','membershipsbyusers.user_id')
																	->where('memberships.status',1)
																	->where('membershipsbyusers.id', $result)
																	->select('membershipsbyusers.id','membershipsbyusers.memberbookingno','users.name as name','vendors.businessname','vendors.address','membershipsbyusers.fromdate','membershipsbyusers.todate','memberships.image','membershipsbyusers.qrcodeimage','memberships.package_name',
																	'memberships.package_desc1','memberships.package_desc2','memberships.package_desc3','memberships.package_desc4','memberships.package_desc5',
																	'memberships.package_duration','membershipsbyusers.renew','membershipsbyusers.person','membershipsbyusers.package_price','memberships.status','membershipsbyusers.created_at','membershipsbyusers.paystatus','membershipsbyusers.paystatus_id','membershipsbyusers.transaction_id','membershipsbyusers.msg','membershipsbyusers.hash')
																	->get();
																								
														if($result){
															$data['status'] = '1';
															$data['message'] = 'membershipsbyuser Registration Successful';
															$data['paymentUrl'] = $paymentUrl;
															$data['getmembershipbyuser'] = $getmembershipsbyuser;
														}else{
															$data['status'] = '0';
															$data['message'] = 'membershipsbyuser Registration Fail';
															$data['result'] = array();
															$data['getmembershipbyuser'] = array();
														}
															
														echo json_encode($data);

		}
		else
		{
			

			$checkpaymentstatus =   DB::table('membershipsbyusers')->Where('membershipsbyusers.membership_id','=',$request->membership_id)->Where('membershipsbyusers.vendor_id','=',$request->vendor_id)->Where('membershipsbyusers.user_id','=',$request->user_id)->select('membershipsbyusers.*')->first();	
			
			$getpaymentstatusid = $checkpaymentstatus->paystatus_id;

			if($getpaymentstatusid==0)
			{
			
			
										$userdetails =   DB::table('users')->Where('users.id','=',$request->user_id)->select('users.*')->first();	
										$vendordetails =   DB::table('vendors')->Where('vendors.vendor_id','=',$request->vendor_id)->select('vendors.*')->first();
										

										$username = $userdetails->name;
										$getuseremail = $userdetails->email;
										$getusermobile = $userdetails->mobile;

										$vendorname = $vendordetails->businessname;
										$vendoraddress = $vendordetails->address;
										
										
										$membershipsdetails =   DB::table('memberships')
																->Where('memberships.membership_id','=',$request->membership_id)
																->select('memberships.*')
																->first();	

										$package_duration = $membershipsdetails->package_duration;
										$package_price = $membershipsdetails->package_discount_price;
										
										
										

										$curdate = date("Y-m-d");
										$newDate = date('Y-m-d', strtotime($curdate. ' + '.$package_duration.' months')); 
										$randomNumber = $checkpaymentstatus->memberbookingno;
										//$randomNumber = rand(1000000,9999999);
										$qrcodeimage = 'membershipqrcode/'.$randomNumber.'.png';
										$userdetails = array(
											'user_id'=>$request->user_id,
											'vendor_id'=>$request->vendor_id,
											'membership_id'=>$request->membership_id,
											'qrcodeimage'=>$qrcodeimage,
											//'package_price'=>$package_price,
											'package_price'=>$request->package_price,
											'person'=>$request->person,
											'fromdate'=>$curdate,
											'todate'=>$newDate,
										);


										$userpersonamount = array(
											'package_price'=>$request->package_price,
											'person'=>$request->person,
										);

										$resultupdate = DB::table('membershipsbyusers')
														->where('membershipsbyusers.membership_id', $request->membership_id)
														->where('membershipsbyusers.vendor_id', $request->vendor_id)
														->where('membershipsbyusers.user_id', $request->user_id)->update($userpersonamount);
										
										//Generated QRCODE
										$qrcodeimagedetails =  array(
											
											'username'=>$username,
											'sportsname'=>$vendorname,
											'sportsaddress'=>$vendoraddress,
											'membershipstartdate'=>$curdate,
											'membershipenddate'=>$newDate
										);
										
										$getpackagename = $membershipsdetails->package_name;
									    $ptotalamount = $request->package_price;

										$paydetails = $vendordetails->businessname.' '.$getpackagename.' With Amount '.$ptotalamount;


										/**Payment Integration Start */
										$merchantId = '644166729208395';
										$secretKey = '37411-1981929663';
									
										$senangPay = new SenangPay($merchantId, $secretKey);
										$paymentUrl = $senangPay->createPayment(
										$paydetails,
										$request->package_price,
										$randomNumber,
										[
											'name' => $username,
											'email' => $getuseremail,
											'phone' => $getusermobile
										]
										);

										$data['paymentUrl'] = $paymentUrl;


									/**End Payment Integration Start */

										$checkexistmembership	 =	DB::table('memberships')
																								->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
																								->join('vendors','vendors.vendor_id','membershipsbyusers.vendor_id')
																								->join('users','users.id','membershipsbyusers.user_id')
																								->where('memberships.status',1)
																								->where('membershipsbyusers.membership_id', $request->membership_id)
																								->where('membershipsbyusers.vendor_id', $request->vendor_id)
																								->where('membershipsbyusers.user_id', $request->user_id)
																								->select('membershipsbyusers.id','membershipsbyusers.memberbookingno','users.name as name','vendors.businessname','vendors.address','membershipsbyusers.fromdate','membershipsbyusers.todate','memberships.image','membershipsbyusers.qrcodeimage','memberships.package_name',
																								'memberships.package_desc1','memberships.package_desc2','memberships.package_desc3','memberships.package_desc4','memberships.package_desc5',
																								'memberships.package_duration','membershipsbyusers.renew','membershipsbyusers.person','membershipsbyusers.package_price','memberships.status','membershipsbyusers.created_at','membershipsbyusers.paystatus','membershipsbyusers.paystatus_id','membershipsbyusers.transaction_id','membershipsbyusers.msg','membershipsbyusers.hash')
																								->get();


										$data['status'] = '1';
										$data['message'] = 'Already exists membership without payment for the user.';
										$data['paymentUrl'] = $paymentUrl;
										$data['getmembershipbyuser'] = $checkexistmembership;
										echo json_encode($data);

			}	
			else
			{

										$checkexistmembership	 =	DB::table('memberships')
																								->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
																								->join('vendors','vendors.vendor_id','membershipsbyusers.vendor_id')
																								->join('users','users.id','membershipsbyusers.user_id')
																								->where('memberships.status',1)
																								->where('membershipsbyusers.membership_id', $request->membership_id)
																								->where('membershipsbyusers.vendor_id', $request->vendor_id)
																								->where('membershipsbyusers.user_id', $request->user_id)
																								->select('membershipsbyusers.id','membershipsbyusers.memberbookingno','users.name as name','vendors.businessname','vendors.address','membershipsbyusers.fromdate','membershipsbyusers.todate','memberships.image','membershipsbyusers.qrcodeimage','memberships.package_name',
																								'memberships.package_desc1','memberships.package_desc2','memberships.package_desc3','memberships.package_desc4','memberships.package_desc5',
																								'memberships.package_duration','membershipsbyusers.renew','membershipsbyusers.person','membershipsbyusers.package_price','memberships.status','membershipsbyusers.created_at','membershipsbyusers.paystatus','membershipsbyusers.paystatus_id','membershipsbyusers.transaction_id','membershipsbyusers.msg','membershipsbyusers.hash')
																								->first();


										$data['status'] = '1';
										$data['message'] = 'Already exists membership from '.$checkexistmembership->fromdate.' to '.$checkexistmembership->todate.' with success payment.';
										$data['paymentUrl'] = '';
										$data['getmembershipbyuser'] = $checkexistmembership;
										echo json_encode($data);
			}								

			
		}
		
		
										
	}

	public function membershipscheckbyuser(Request $request)
	{
		
		$membershipsbyuser	 =		DB::table('memberships')
									->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
									->join('vendors','vendors.vendor_id','memberships.vendor_id')
									->join('users','users.id','membershipsbyusers.user_id')
									->where('memberships.status',1)
									->where('membershipsbyusers.paystatus','Y')
									->where('membershipsbyusers.user_id', $request->user_id)
									->select('membershipsbyusers.id','membershipsbyusers.memberbookingno','users.name as name','vendors.businessname','vendors.address','membershipsbyusers.fromdate','membershipsbyusers.todate','memberships.image','membershipsbyusers.qrcodeimage','memberships.package_name',
									'memberships.package_desc1','memberships.package_desc2','memberships.package_desc3','memberships.package_desc4','memberships.package_desc5','memberships.package_duration','membershipsbyusers.person','membershipsbyusers.package_price','membershipsbyusers.renew','memberships.status','membershipsbyusers.created_at','membershipsbyusers.paystatus','membershipsbyusers.paystatus_id','membershipsbyusers.transaction_id','membershipsbyusers.msg','membershipsbyusers.hash')
									->get();
				

									
	   $membershipsbyusercount = $membershipsbyuser->count();
									


	   if($membershipsbyusercount>0){
					$data['status'] = '1';
					$data['message'] = 'check your membership e-card successfully';
					$data['getmembershipbyuser'] = $membershipsbyuser;
		}else{
					$data['status'] = '0';
					$data['message'] = 'user membership e-card not exists';
					$data['result'] = array();
		}

		echo json_encode($data);

	}


	
	public function membershipsrenewal(Request $request)
	{
		$result	 =		DB::table('membershipsbyusers')->where('membershipsbyusers.id', $request->id)->where('membershipsbyusers.paystatus', 'Y')->get();
		$membershipsrenewalcount = $result->count();	
		if($membershipsrenewalcount==1)
		{			
			
											$membershipsrenewaldetails	 =		DB::table('memberships')
																				->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
																				->join('vendors','vendors.vendor_id','memberships.vendor_id')
																				->join('users','users.id','membershipsbyusers.user_id')
																				->where('memberships.status',1)
																				->where('membershipsbyusers.paystatus','Y')
																				->where('membershipsbyusers.id', $request->id)
																				->select('membershipsbyusers.id','membershipsbyusers.memberbookingno','membershipsbyusers.user_id','membershipsbyusers.vendor_id','users.name as name','vendors.businessname','vendors.address','membershipsbyusers.fromdate','membershipsbyusers.todate','memberships.image','membershipsbyusers.qrcodeimage','memberships.package_name',
																				'memberships.package_desc1','memberships.package_desc2','memberships.package_desc3','memberships.package_desc4','memberships.package_desc5','memberships.package_duration','memberships.package_discount_price','membershipsbyusers.person','membershipsbyusers.package_price','memberships.status','membershipsbyusers.created_at','membershipsbyusers.paystatus','membershipsbyusers.paystatus_id','membershipsbyusers.transaction_id','membershipsbyusers.msg','membershipsbyusers.hash')
																				->first();				

											
											
											$memberbookingno = $membershipsrenewaldetails->memberbookingno;
											$user_id = $membershipsrenewaldetails->user_id;
											$vendor_id = $membershipsrenewaldetails->vendor_id;
											$package_price = $membershipsrenewaldetails->package_price;
											$fromdate = $membershipsrenewaldetails->fromdate;
											$todate = $membershipsrenewaldetails->todate;

											$membershippackage_discount_price = $membershipsrenewaldetails->package_discount_price;
											


											//Update Renewal flag
											
												$updtrenewal = DB::table('membershipsbyusers')->where('memberbookingno',$memberbookingno)->update(['renew' => 1]);
															 
											//End 




											$userdetails =   DB::table('users')->Where('users.id','=',$user_id)->select('users.*')->first();		
											$username = $userdetails->name;
											$getuseremail = $userdetails->email;
											$getusermobile = $userdetails->mobile;

											$paydetails = $membershipsrenewaldetails->businessname.' '.$membershipsrenewaldetails->package_name.' With Amount '.$membershippackage_discount_price;

											

											/**Payment Integration Start */
											$merchantId = '644166729208395';
											$secretKey = '37411-1981929663';

											$senangPay = new SenangPay($merchantId, $secretKey);
											$paymentUrl = $senangPay->createPayment(
											$paydetails,
											$membershippackage_discount_price,
											$memberbookingno,
											[
												'name' => $username,
												'email' => $getuseremail,
												'phone' => $getusermobile
												
											]
											);

											$data['paymentUrl'] = $paymentUrl;


											/**End Payment Integration Start */

											$membershipsrdtls	 =		DB::table('memberships')
															->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
															->join('vendors','vendors.vendor_id','memberships.vendor_id')
															->join('users','users.id','membershipsbyusers.user_id')
															->where('memberships.status',1)
															->where('membershipsbyusers.id', $request->id)
															->select('membershipsbyusers.id','membershipsbyusers.memberbookingno','users.name as name','vendors.businessname','vendors.address','membershipsbyusers.fromdate','membershipsbyusers.todate','memberships.image','membershipsbyusers.qrcodeimage','memberships.package_name',
															'memberships.package_desc1','memberships.package_desc2','memberships.package_desc3','memberships.package_desc4','memberships.package_desc5','memberships.package_duration','membershipsbyusers.person','membershipsbyusers.package_price','membershipsbyusers.renew','memberships.status','membershipsbyusers.created_at','membershipsbyusers.paystatus','membershipsbyusers.paystatus_id','membershipsbyusers.transaction_id','membershipsbyusers.msg','membershipsbyusers.hash')
															->get();

												
												$data['status'] = '1';
												$data['message'] = 'membershipsrenewal Details';
												$data['result'] = $membershipsrdtls;
		}
		
		else
		{
			$data['status'] = '0';
			$data['message'] = 'No Data Found';
			$data['result'] = array();
		}


		echo json_encode($data);
		
		



	}

	public function getmembershipsbyid(Request $request){
        
		$result	 =		DB::table('memberships')
									->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
									->join('vendors','vendors.vendor_id','memberships.vendor_id')
									->join('users','users.id','membershipsbyusers.user_id')
									->where('memberships.status',1)
									->where('membershipsbyusers.id', $request->id)
									->select('membershipsbyusers.id','membershipsbyusers.memberbookingno','users.name as name','vendors.businessname','vendors.address','membershipsbyusers.fromdate','membershipsbyusers.todate','memberships.image','membershipsbyusers.qrcodeimage','memberships.package_name',
									'memberships.package_desc1','memberships.package_desc2','memberships.package_desc3','memberships.package_desc4','memberships.package_desc5','memberships.package_duration','membershipsbyusers.person','membershipsbyusers.package_price','membershipsbyusers.renew','memberships.status','membershipsbyusers.created_at','membershipsbyusers.paystatus','membershipsbyusers.paystatus_id','membershipsbyusers.transaction_id','membershipsbyusers.msg','membershipsbyusers.hash')
									->get();

	$membershipsbyusercount = $result->count();
									
	if($membershipsbyusercount==1){							
		
			  $data['status'] = '1';
			  $data['message'] = 'memberships Get Successfull';
			  $data['result'] = $result;
		  }else{
			  $data['status'] = '0';
			  $data['message'] = 'No Data Found';
			  $data['result'] = array();
		  }
		  
					   
		  echo json_encode($data);
	  }

    

	public function gethomepagedtls(Request $request)
		  {
			    
			
			     $userid = $request->user_id;
				 if(isset($request->name))
				 {
					 $searchTerm = $request->name;
				 }
				 else
				 {
					$searchTerm = '';
				 }
				 
				 
				 
				 //->orWhere('instructor.user_name', 'LIKE', "%{$searchTerm}%")

					$usersdetails =  DB::table('users')->Where('users.id',$userid)->select('users.id','users.name','users.mobile','users.userprofilepic1','users.wallet_amount','users.refferalcashback')->get();

								$result = $usersdetails;
				
								$mainbannersdetails =  DB::table('banners')->Where('banners.bannertype',1)->select('banners.id','banners.bannertype','banners.bannertitle','banners.bannerpath','banners.vendor_code','banners.bannerimage','banners.created_at')->get();
								
								$secondarybannersdetails =  DB::table('banners')->Where('banners.bannertype',2)->select('banners.id','banners.bannertype','banners.bannertitle','banners.bannerpath','banners.vendor_code','banners.bannerimage','banners.created_at')->get();
				
								//$bannersdetails =  DB::table('banners')->get();
				
								$categorydetails =  DB::table('categories')->get();
				
								$sportvenuedetails =    DB::table('vendors')->join('users','users.id','vendors.vendor_id')
				 										->join('featured_vendors', 'featured_vendors.vendor_id', 'vendors.vendor_id')
														->Where('users.status',1)
														->Where('vendors.businessname', 'LIKE', "%{$searchTerm}%")
														->orderBy('featured_vendors.position')
														->select('vendors.vendor_id','vendors.businessname','vendors.address','vendors.image')
														->get();
				
								$instructordetails	= 	DB::table('instructor')
														->join('users','users.id','instructor.instructor_id')
														->join('categories','categories.id','instructor.sportcategory')
														->join('vendors','vendors.businessname','instructor.sportcenter')
														->Where('users.bookingstatus',1)
														->select('instructor.instructor_id as instructor_id','instructor.user_name as instructorname','users.userprofilepic1 as userprofilepic1','instructor.sportcenter as sportcenter','vendors.address as location','categories.name as sportcategory','users.instructorrate as instructorrate','users.instructorratetype as instructorratetype')
														->get();
				
								$bookingtransactiondetails	= DB::table('booking_with_vendors')
														->join('users','users.id','booking_with_vendors.user_id')
														->join('vendors','vendors.vendor_id','booking_with_vendors.vendor_id')
														->join('categories','categories.id','vendors.business_category')
														->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
														->where('booking_with_vendors.user_id',$userid)
														->where('booking_with_vendors.paystatus_id',1)
														->select('booking_with_vendorsdetails.bookingno','vendors.businessname','vendors.address','users.name as username','users.userprofilepic1','booking_with_vendors.date','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','categories.name as categoriesname')
														->orderBy('booking_with_vendors.booking_id','DESC')
														->get();
														
								
								
								$membershipsdetails	 = DB::table('memberships')
														->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
														->join('vendors','vendors.vendor_id','membershipsbyusers.vendor_id')
														->join('users','users.id','membershipsbyusers.user_id')
														->where('memberships.status',1)
														->where('membershipsbyusers.paystatus_id',1)
														->where('membershipsbyusers.user_id',$userid)
														->select('users.userprofilepic1','users.name as name','vendors.businessname','vendors.address','memberships.package_duration','memberships.package_price','membershipsbyusers.fromdate','membershipsbyusers.todate','membershipsbyusers.created_at')
														->get();	

								$hostgamedetails	 = DB::table('hostgames')
														->leftJoin('vendors','vendors.vendor_id','hostgames.venuename')
														->join('users','users.id','hostgames.hostcreatedby')
														->where('hostgames.status',1)
														->whereDate('hostgames.hostcancelationdate', '>=', Carbon::today()->toDate())														
														->where('hostgames.hostcreatedby',$userid)
														->select('users.userprofilepic1','users.name as name','vendors.businessname','vendors.address','hostgames.host_id','hostgames.host_game_name','hostgames.totalplayer','hostgames.gamestartdate','hostgames.hostcreatedby','hostgames.created_at','hostgames.customvenue')
														->get();
									error_log($hostgamedetails);
				
									if($userid==0)
									{
										 
										$data['status'] = '1';
										$data['message'] = 'home page details get Successfull';
										$data['usersdetails'] = array();
										$data['mainbannersdetails'] = $mainbannersdetails;
										$data['secondarybannersdetails'] = $secondarybannersdetails;
										//$data['bannersdetails'] = $bannersdetails;
										$data['categorydetails'] = $categorydetails;
										$data['sportvenuedetails'] = $sportvenuedetails;
										$data['instructordetails'] = $instructordetails;
										$data['bookingtransactiondetails'] = array();
										$data['membershipsdetails'] = array();
										$data['hostgamedetails'] = array();

									}
									else
									{
										$data['status'] = '1';
										$data['message'] = 'home page details get Successfull';
										$data['usersdetails'] = $usersdetails;
										$data['mainbannersdetails'] = $mainbannersdetails;
										$data['secondarybannersdetails'] = $secondarybannersdetails;
										//$data['bannersdetails'] = $bannersdetails;
										$data['categorydetails'] = $categorydetails;
										$data['sportvenuedetails'] = $sportvenuedetails;
										$data['instructordetails'] = $instructordetails;
										$data['bookingtransactiondetails'] = $bookingtransactiondetails;
										$data['membershipsdetails'] = $membershipsdetails;
										$data['hostgamedetails'] = $hostgamedetails;

									}
									

				
				  
	 								echo json_encode($data);

		  }


		  public function checkvendorbookcourt(Request $request)
		  {

			
			
			$totalvendorcourtrecords = DB::table("venuescourttimes")->where('vendor_id',$request->vendor_id)->count();
			$totalbookingrecords = DB::table("venuescourttimes")->where('vendor_id',$request->vendor_id)->where('bookstatus','1')->sum('bookstatus');

			if($totalvendorcourtrecords==$totalbookingrecords)
			{
				$data['status'] = '1';
				$data['message'] = 'Booking records and vendor courts records are same';
				$data['totalvendorcourtrecords'] = $totalvendorcourtrecords;
				$data['totalvendorbookingrecords'] = $totalbookingrecords;
			}
			else{
				$data['status'] = '0';
				$data['message'] = 'Booking records and vendor courts records are not same';
				$data['totalvendorcourtrecords'] = $totalvendorcourtrecords;
				$data['totalvendorbookingrecords'] = $totalbookingrecords;
			}
 
			  
				 echo json_encode($data);
			



		  }


		  public function contactus(Request $request)
		  {
								
			
									$name = $request->name;
									$email = $request->email;
									$mobileno = $request->mobileno;
									$subjectdetails = $request->subject;
									$messagedetails = $request->message;

									$to = 'support@sportstigo.com';
                                    $subject = $subjectdetails;
                            
                                    $message = "
                                    <html>
                                    <head>
                                    <title>welcome to sportstigo</title>
                                    
                                    </head>
                                    <body><br>
                                   
                                    <div class='myDiv1'>
                                    <br>

									
									
                                    <p><b><font size='3'>Hi ".$name."</b></font></p><br>
                                    <p><b><font size='3'>Email ID : ".$email."   </font></b></p><br>
									<p><b><font size='3'>Mobile No : ".$mobileno."   </font></b></p><br>
									<p><b><font size='3'>Message Details : ".$messagedetails."   </font></b></p><br>
                            		</div>
                            		
                                    </body>
                                    </html>";
            
                                   
                                    $headers = "MIME-Version: 1.0" . "\r\n";
                                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                    $headers .= 'From: <support@sportstigo.com>' . "\r\n";
                                    
                                    
                                    if (mail($to,$subject,$message,$headers))
                                    {
                                        //echo "<script>window.location = 'https://mrinvito.com/laravel/sportstigo/login';</script>";
										$data['status'] = '1';
										$data['message'] = 'Mail Sent Successfully';
                                    }
                                    else
                                    {
                                        //echo "<script>window.location = 'index.php';</script>";
										$data['status'] = '0';
										$data['message'] = 'Fail to send Mail';
                                    }

									echo json_encode($data);


		  }

		  public function cashbackdetailsbyid(Request $request)
		  {
          
        
    		$result =    DB::table('cashbackdetails')
						->join('users','users.id','cashbackdetails.user_id')
    					->select('cashbackdetails.cashback_id','users.name','cashbackdetails.user_id','cashbackdetails.referral_code','cashbackdetails.date','cashbackdetails.admin_commision','cashbackdetails.refferalcashback','cashbackdetails.status','cashbackdetails.created_at')
    					->where('cashbackdetails.user_id',$request->user_id)->get();


			if($result){
                $data['status'] = '1';
                $data['message'] = 'cashbackdetailsbyid Successfull';
    			$data['cashbackdetailsbyid'] = $result;
            }else{
                $data['status'] = '0';
                $data['message'] = 'No Data Found';
    			$data['result'] = '0';
            }
    		
            echo json_encode($data);
        }

		  
    
    }


	
	
	