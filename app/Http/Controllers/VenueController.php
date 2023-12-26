<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use App\Models\venues;
use Illuminate\Support\Facades\Session;
use App\Models\venuescourttimes;
use Illuminate\Http\Request;

use DB;

class VenueController extends Controller
{
	
    public function index()
    {
        $getsessioinid = Session::get('getsessionuserid');
		$getsessionusertype = Session::get('getsessionusertype');
		$pagetitle = 'Venue Management(Manage Courts)';
		$pageheading = 'Venue Management(Manage Courts)';
		

		if($getsessionusertype=='Vendor')
		{
			
								 $getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								 $getsessioinid = $getVendorDetails->createdby;

		}
		else
		{
			
			 $getsessioinid = Session::get('getsessionuserid');				
		}



		if($getsessioinid)
		{
            
			
			$venuedetails = venues::select('venues.*')->where('vendor_id', '=', $getsessioinid)->paginate(4);
			return view('VenueList',compact('venuedetails','pagetitle','pageheading'));
		}
		else
		{ 
		     return redirect('/login');
		}

       
    }
	
	
	
	public function sortingvenuelist(Request $request,$id1,$id2)
    {
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Venue Management(Manage Courts)';
			$pageheading = 'Venue Management(Manage Courts)';
			$txtserach = $id1; 
			$sorting = $id2;
			
			//dd($txtserach,$sorting);
			
			
			if($txtserach=='Search')
			{
			$venuedetails = venues::query()
						->where('vendor_id', '=', $getsessioinid)
						->orderBy('id',$sorting)
						->paginate(4);	
			}
			else
			{	
			//DB::enableQueryLog();
			
						
			$venuedetails = venues::where('name', 'LIKE', '%'.$txtserach.'%')
							->where('vendor_id', '=', $getsessioinid)
						  ->orderBy('id',$sorting)
						  ->paginate(4);			
						
			
			//$quries = DB::getQueryLog();
			//dd($quries);
			}			
			
			return view('VenueList',compact('venuedetails','pagetitle','pageheading','txtserach','sorting'));
		}
		else
		{ 
		   return redirect('/login');
		}


        
    }
	
	
	public function venuesearch(Request $request,$id1,$id2)
    {	
		 
		
		$getsessionuserid= session()->get('getsessionuserid');
		 $getsessionusertype = Session::get('getsessionusertype');
		 if($getsessionusertype=='Vendor')
		 {
			 
								 $getVendorDetails =  User::where("id", "=", $getsessionuserid)->first();
								 $getsessionuserid = $getVendorDetails->createdby;
 
		 }
		 else
		 {
			 
			 $getsessionuserid = Session::get('getsessionuserid');				
		 }
		
		
		
		if($getsessionuserid)
		{
			$pagetitle = 'Venue Management(Manage Courts)';
			$pageheading = 'Venue Management(Manage Courts)';
			$pagesubheading = 'Edit Courts';
		
			$venuedetails =  venues::select('venues.*')
							->where('venues.id', '=', $id1)
						   ->get();
			
			$allvendorlist=DB::table('vendors')
				->where('status', '=', 1)
				->where('vendor_id', '=', $getsessionuserid)
				->select('vendors.*')
				->get();
				
			
			
		   $allvenuescourttimes = venuescourttimes::select('venuescourttimes.*')
						 ->where('vendor_id', '=', $getsessionuserid)
						 ->where('court_id', '=', $id1)
						 ->where('days', '=', $id2)
						 ->get();

			$alldays=DB::table('days')->get();				 
						  /*echo '<pre>allvenuescourttimes :::';
						  print_r($allvenuescourttimes);
						  echo '</pre>';
						  exit();*/


				
			return view('VenueEdit',compact('pagetitle','pagesubheading','pageheading','venuedetails','allvendorlist','allvenuescourttimes','alldays','id2'));
		}
		else
		{ 
		   return redirect('/login');
		}


        
    }







	
	public function venuecreate()
    {
	  	
		$getsessionuserid= session()->get('getsessionuserid');
		$getsessionusertype = Session::get('getsessionusertype');
		
		if($getsessionusertype=='Vendor')
		{
			
								$getVendorDetails =  User::where("id", "=", $getsessionuserid)->first();
								$getsessionuserid = $getVendorDetails->createdby;

		}
		else
		{
			
			$getsessionuserid = Session::get('getsessionuserid');				
		}


		if($getsessionuserid)
		{
			$pagetitle = 'Venue Management(Manage Courts/Slots)';
			$pageheading = 'Venue Management';
			$pagesubheading = 'Add New Courts / Slots';
			
			$venuedetails = venues::select('venues.*')
							->get();
			$allvendorlist=DB::table('vendors')
				->where('status', '=', 1)
				->where('vendor_id', '=', $getsessionuserid)
				->select('vendors.*')
				->get();				
			
			return view('VenueAdd',compact('pagetitle','pagesubheading','pageheading','venuedetails','allvendorlist'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
		
	}
	
	
	public function venueedit(Request $request,$id)
    {
	    
		 $getsessionuserid= session()->get('getsessionuserid');
		
		 $getsessionusertype = Session::get('getsessionusertype');
		 if($getsessionusertype=='Vendor')
		 {
			 
								 $getVendorDetails =  User::where("id", "=", $getsessionuserid)->first();
								 $getsessionuserid = $getVendorDetails->createdby;
 
		 }
		 else
		 {
			 
			 $getsessionuserid = Session::get('getsessionuserid');				
		 }
		
		
		
		if($getsessionuserid)
		{
			$pagetitle = 'Venue Management(Manage Courts)';
			$pageheading = 'Venue Management(Manage Courts)';
			$pagesubheading = 'Edit Courts';
		
			$venuedetails =  venues::select('venues.*')
							->where('venues.id', '=', $id)
						   ->get();
			
			$allvendorlist=DB::table('vendors')
				->where('status', '=', 1)
				->where('vendor_id', '=', $getsessionuserid)
				->select('vendors.*')
				->get();
				
			
			
		   $allvenuescourttimes = venuescourttimes::select('venuescourttimes.*')
						 ->where('vendor_id', '=', $getsessionuserid)
						 ->where('court_id', '=', $id)
						 ->get();

			$alldays=DB::table('days')->get();				 
						//  echo '<pre>allvenuescourttimes :::';
						//  print_r($allvenuescourttimes);
						//  echo '</pre>';
						//  exit();


				
			return view('VenueEdit',compact('pagetitle','pagesubheading','pageheading','venuedetails','allvendorlist','allvenuescourttimes','alldays'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
      	
	}
	
	public function venuedelete(Request $request,$id)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionusertype = Session::get('getsessionusertype');
		
		

		if($getsessionusertype=='Vendor')
		{
			
								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;

		}
		
			
		$getsessioinid = Session::get('getsessionuserid');				
		if($getsessioinid)
		{
			$pagetitle = 'Venue Management(Manage Courts)';
			$pageheading = 'Venue Management(Manage Courts)';
			$delinstructorexists = DB::table('venues')->where('id', $id)->delete();			
			$delinstructorexists1 = DB::table('venuescourttimes')->where('court_id', $id)->delete();			
			
			$venuedetails = venues::select('venues.*')->where('vendor_id', '=', $getsessioinid)->paginate(4);
			
			return view('VenueList',compact('venuedetails','pagetitle','pageheading'));
		}
		else
		 { 
		   return redirect('/login');
		 }
		
	}	
	
	
	public function venuesadd(Request $request)
    {
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
           
					$validatedData = $request->validate([            
						'name' => 'required',
						'courtdesc' => 'required',
						'categoryimage' => 'required',
						'normalprice' => 'required',
						'courtprice' => 'required',
						
					],
					[   
						'name.required' => 'Court Name is required!',			
						'courtdesc.required' => 'Court Description is required!',			
						'categoryimage.required' => 'Gallery is required!',
						'normalprice.required' => 'Normal Price is required!',			
						'courtprice.required' => 'Court Price is required!',			
					]);
					
					if ($request->hasFile('categoryimage')) {
						$image = $request->file('categoryimage');
						$category_image1 = time().'.'.$image->getClientOriginalExtension();
						$destinationPath = public_path('/CourtsImages');
						$image->move($destinationPath, $category_image1);
					} else {
						$category_image1 = $request->hdn_category_image;
					}
			
					$data=array(
						'name'=>$request->name,
						'vendor_id'=>$request->vendor_id,
						'courtdesc'=>$request->courtdesc,
						'normalprice'=>$request->normalprice,
						'courtprice'=>$request->courtprice,
						'image' =>'CourtsImages/'.$category_image1,
						'status'=>'1', 
						'created_at' =>  date("Y-m-d H:i:s"),
						'updated_at' =>  date("Y-m-d H:i:s"),
					);
					
					$insertedId = venues::insertGetId($data);
					
					$vendordetails=DB::table('vendordetails')->Where('vendordetails.vendor_id',$request->vendor_id)->first();
					
						//echo "<br>";
						//print_r($vendordetails);
						//echo "<br>";

						 $sundaystime = strtotime($vendordetails->sundaystime);
						 $sundayetime = strtotime($vendordetails->sundayetime);
						
						 $mondaystime = strtotime($vendordetails->mondaystime);
						 $mondayetime = strtotime($vendordetails->mondayetime);

						 $tuesdaystime = strtotime($vendordetails->tuesdaystime);
						 $tuesdayetime = strtotime($vendordetails->tuesdayetime);

						 $wednesdaystime = strtotime($vendordetails->wednesdaystime);
						 $wednesdayetime = strtotime($vendordetails->wednesdayetime);

						 $thursdaystime = strtotime($vendordetails->thursdaystime);
						 $thursdayetime = strtotime($vendordetails->thursdayetime);

						 $fridaystime = strtotime($vendordetails->fridaystime);
						 $fridayetime = strtotime($vendordetails->fridayetime);
 						
						 $saturdaystime = strtotime($vendordetails->saturdaystime);
					  	 $saturdayetime = strtotime($vendordetails->saturdayetime);
						  
						 

								if(!empty($sundaystime) && !empty($sundayetime))
								{

											for ($i=$sundaystime;$i<$sundayetime;$i = $i + 60*60)
											{
												$data=array(
													'days'=> 'Sunday',
													'court_id_srno'=>0,
													'name'=>$request->name,
													'vendor_id'=>$request->vendor_id,						
													'court_id'=>$insertedId,
													"timedesc" =>1,
													"stime" => date('H:i',$i),
													"etime" => date('H:i',$i + 60*60),
													"price" => $request->courtprice,
													'status'=>'1', 
																				
												);	
												$inserteddata = venuescourttimes::insertGetId($data);
											}

								}

								if(!empty($mondaystime) && !empty($mondayetime))
								{

											for ($i=$mondaystime;$i<$mondayetime;$i = $i + 60*60)
											{
												$data=array(
													'days'=> 'Monday',
													'court_id_srno'=>0,
													'name'=>$request->name,
													'vendor_id'=>$request->vendor_id,						
													'court_id'=>$insertedId,
													"timedesc" =>2,
													"stime" => date('H:i',$i),
													"etime" => date('H:i',$i + 60*60),
													"price" => $request->courtprice,
													'status'=>'1', 
																				
												);	
												$inserteddata = venuescourttimes::insertGetId($data);
											}

								}

								if(!empty($tuesdaystime) && !empty($tuesdayetime))
								{

											for ($i=$tuesdaystime;$i<$tuesdayetime;$i = $i + 60*60)
											{
												$data=array(
													'days'=> 'Tuesday',
													'court_id_srno'=>0,
													'name'=>$request->name,
													'vendor_id'=>$request->vendor_id,						
													'court_id'=>$insertedId,
													"timedesc" =>3,
													"stime" => date('H:i',$i),
													"etime" => date('H:i',$i + 60*60),
													"price" => $request->courtprice,
													'status'=>'1', 
																				
												);	
												$inserteddata = venuescourttimes::insertGetId($data);
											}

								}


								if(!empty($wednesdaystime) && !empty($wednesdayetime))
								{

											for ($i=$wednesdaystime;$i<$wednesdayetime;$i = $i + 60*60)
											{
												$data=array(
													'days'=> 'Wednesday',
													'court_id_srno'=>0,
													'name'=>$request->name,
													'vendor_id'=>$request->vendor_id,						
													'court_id'=>$insertedId,
													"timedesc" =>4,
													"stime" => date('H:i',$i),
													"etime" => date('H:i',$i + 60*60),
													"price" => $request->courtprice,
													'status'=>'1', 
																				
												);	
												$inserteddata = venuescourttimes::insertGetId($data);
											}

								}

								if(!empty($thursdaystime) && !empty($thursdayetime))
								{

											for ($i=$thursdaystime;$i<$thursdayetime;$i = $i + 60*60)
											{
												$data=array(
													'days'=> 'Thursday',
													'court_id_srno'=>0,
													'name'=>$request->name,
													'vendor_id'=>$request->vendor_id,						
													'court_id'=>$insertedId,
													"timedesc" =>5,
													"stime" => date('H:i',$i),
													"etime" => date('H:i',$i + 60*60),
													"price" => $request->courtprice,
													'status'=>'1', 
																				
												);	
												$inserteddata = venuescourttimes::insertGetId($data);
											}

								}

								
								if(!empty($fridaystime) && !empty($fridayetime))
								{

											for ($i=$fridaystime;$i<$fridayetime;$i = $i + 60*60)
											{
												$data=array(
													'days'=> 'Friday',
													'court_id_srno'=>0,
													'name'=>$request->name,
													'vendor_id'=>$request->vendor_id,						
													'court_id'=>$insertedId,
													"timedesc" =>5,
													"stime" => date('H:i',$i),
													"etime" => date('H:i',$i + 60*60),
													"price" => $request->courtprice,
													'status'=>'1', 
																				
												);	
												$inserteddata = venuescourttimes::insertGetId($data);
											}

								}


						   

								if(!empty($saturdaystime) && !empty($saturdayetime))
								{

											for ($i=$saturdaystime;$i<$saturdayetime;$i = $i + 60*60)
											{
												$data=array(
													'days'=> 'Saturday',
													'court_id_srno'=>0,
													'name'=>$request->name,
													'vendor_id'=>$request->vendor_id,						
													'court_id'=>$insertedId,
													"timedesc" =>7,
													"stime" => date('H:i',$i),
													"etime" => date('H:i',$i + 60*60),
													"price" => $request->courtprice,
													'status'=>'1', 
																				
												);	
												$inserteddata = venuescourttimes::insertGetId($data);


								            }
						
						  }
						
						





						




					
					/*$i = 1;
					for($count=1;$count<9;$count++){
						
						if(!empty($_REQUEST['days_name'][$count])){
							foreach($_REQUEST['days_name'][$count] as $days_namekey=>$days_namevalue){

								if($_REQUEST['stime'][$count][0]=='')
								{
								    
									
									$delvenueexists = DB::table('venues')->where('id', $insertedId)->delete();
									return redirect('venuecreate')->with('success', 'Please select Start Time and Endtime and price');
								}
								$data1=array(
									'days'=> $days_namevalue,
									'court_id_srno'=>$i,
									'name'=>$request->name,
									'vendor_id'=>$request->vendor_id,						
									'court_id'=>$insertedId,
									"timedesc" => $count,
									"stime" => $_REQUEST['stime'][$count][0],
									"etime" => $_REQUEST['etime'][$count][0],
									"price" => $_REQUEST['price'][$count][0],
									'status'=>'1', 
									'created_at' =>  date("Y-m-d H:i:s"),
									'updated_at' =>  date("Y-m-d H:i:s")										
									);					
								
								$insertedvenuescourttimes = venuescourttimes::insertGetId($data1);	
								
								
							}
						}
						
						$i++;


						
						
					}*/
					
					/*
					print_r($_REQUEST['stime'][1][0]);
					echo "<br>";
					print_r($_REQUEST['etime'][1][0]);
					echo "<br>";
					print_r($_REQUEST['price'][1][0]);		
					echo "<br>";
					print_r($_REQUEST['vendor_name'][1]);
					echo "<br>";
					echo "<br>";
					echo "<br>";
					*/
					
					//echo '<pre>_REQUEST ';
					//print_r($_REQUEST);
					//echo '</pre>';
					//exit();
					
					/*$days =  $request->input('days', []);
					$stime =  $request->input('stime', []);
					$etime =  $request->input('etime', []);
					$price =  $request->input('price', []);
					
					foreach ($days as $dayskey => $daysval) 
					{
					
					$i = 1;
					foreach ($stime as $index => $unit) 
					{
						$data1=array(
							'days'=> $days[$dayskey],
							'name'=>$request->name,
							'vendor_id'=>$request->vendor_id,
							'court_id'=>'100',
							"timedesc" => 'stime'.$i,
							"stime" => $stime[$index],
							"etime" => $etime[$index],
							"price" => $price[$index],
							'status'=>'1', 
							'created_at' =>  date("Y-m-d H:i:s"),
							'updated_at' =>  date("Y-m-d H:i:s")
							
						);
					$i++;
					venuescourttimes::insertGetId($data1);		
					}
					
					}*/
					
					
					return redirect('venuecreate')->with('success', 'Thanks for submitting Venues Entry');
		}
		else
		{ 
		   return redirect('/login');
		}
		
		
		
	}
	
	
	public function venueupdate(Request $request,$id)
    {
	

		// echo '<pre>';
		// print_r($_REQUEST);
		// echo '</pre>';

		
/*
		foreach($_REQUEST['is_update'] as $keyeee=>$valueee){
				echo '<pre>keyeee ';
				print_r($keyeee);
				echo '</pre>';

				echo '<pre>valueee ';
				print_r($valueee);
				echo '</pre>';
				// exit();

				// exit();
		}

		exit();
		*/


		$validatedData = $request->validate([            
            'name' => 'required',
			'price' => 'required',
			//'categoryimage' => 'required',
			
			 
        ],
        [   
			'name.required' => 'Court Name is required!',			
			'price.required' => 'Price is required!',			
			//'categoryimage.required' => 'Gallery is required!',
			
            
        ]);
		

		if ($request->hasFile('categoryimage')) {
            $image = $request->file('categoryimage');
            $category_image1 = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/CourtsImages');
            $image->move($destinationPath, $category_image1);
        } else {
            $category_image1 = $request->hdn_category_image;
        }

		if($category_image1 == 'hdn_category_image')
		{
					$updatedata=array(
						'name'=>$request->name,
						'vendor_id'=>$request->vendor_id,
						'courtdesc'=>$request->courtdesc,
						'normalprice'=>$request->normalprice,
						'courtprice'=>$request->courtprice,
						
					);
		}
		else
		{
				$updatedata=array(
					'name'=>$request->name,
					'vendor_id'=>$request->vendor_id,
					'courtdesc'=>$request->courtdesc,
					'normalprice'=>$request->normalprice,
					'courtprice'=>$request->courtprice,
					'image' =>'CourtsImages/'.$category_image1,
					
				);
	   }
		
		$updtquery = DB::table('venues')->where('id',$id)->update($updatedata);

		$updtquery1 =  DB::table('venuescourttimes')
								->where('court_id', '=', $id)
								->update(['name' => $request->name]);



		$updated_row = array();
		foreach($request->existing_ids_data as $existing_ids_data_key=>$existing_ids_data_value){
			if($request->is_update[$existing_ids_data_value] == '1'){
				$updated_row[] = $existing_ids_data_value;
			}
		}

		if(!empty($updated_row)){

			foreach($updated_row as $updated_row_value){
				$dataupdt222=array(
					// 'days'=> $array_different_value,
					'court_id_srno'=>1,
					'name'=>$request->name,
					// "timedesc" => $days_namekey,
					// "stime" => $_REQUEST['stime'][$days_namekey][0],
					// "etime" => $_REQUEST['etime'][$days_namekey][0],
					"price" => $request->is_update_amount[$updated_row_value],
					'status'=>'1', 
					'created_at' =>  date("Y-m-d H:i:s"),
					'updated_at' =>  date("Y-m-d H:i:s")
					); 							

					$updtquery2 = DB::table('venuescourttimes')
					->where('id',$updated_row_value)
					->update($dataupdt222);
			}					
		}

		
		// exit();
		
		if(!empty($_REQUEST['days_name'] ))
		{
		foreach($_REQUEST['days_name'] as $days_namekey=>$days_namevalue)
		{
			
			$exising_days_array = array();
			$exising_id_array = array();
			foreach($_REQUEST['existing_ids'][$days_namekey] as $existing_idskey=>$existing_idsvalue){
				$exising_days_array[] = $existing_idsvalue['0'];
				$exising_id_array[] = $existing_idskey;
			}	

			$exitng_day_count = count($exising_days_array);
			$selected_day_count = count($days_namevalue);		

			if($exitng_day_count < $selected_day_count){				

				foreach($days_namevalue as $days_namevaluekey=>$days_namevaluevalue){

					if(!in_array($days_namevaluevalue, $exising_days_array))
					{
						$datains=array(
							'days'=> $days_namevaluevalue,
							'court_id_srno'=>1,
							'name'=>$request->name,
							'vendor_id'=>$request->vendor_id,						
							'court_id'=>$id,
							"timedesc" => $days_namekey,
							"stime" => $_REQUEST['stime'][$days_namekey][0],
							"etime" => $_REQUEST['etime'][$days_namekey][0],
							"price" => $_REQUEST['price'][$days_namekey][0],
							'status'=>'1', 
							'created_at' =>  date("Y-m-d H:i:s"),
							'updated_at' =>  date("Y-m-d H:i:s")
							); 
							venuescourttimes::insertGetId($datains);					
					}
				}

			}else if($exitng_day_count > $selected_day_count){
				
				foreach($exising_days_array as $exising_days_key=>$exising_days_array_value){
					if(!in_array($exising_days_array_value, $days_namevalue))
					{
						$delvenuescourttimesexists = DB::table('venuescourttimes')->where('id', $exising_id_array[$exising_days_key])->delete();
					}
				}
			}else{

				

				// echo "<br>==================<br>";

				// echo '<pre>exising_days_array ::';
				// print_r($exising_days_array);
				// echo '</pre>';

				// echo '<pre>days_namevalue ::';
				// print_r($days_namevalue);
				// echo '</pre>';

				// echo '<pre>updated_row ';
				// print_r($updated_row);
				// echo '</pre>';
				// exit();



				




				$array_different = array_diff($days_namevalue,$exising_days_array);

				if(!empty($array_different)){


					// echo '<pre>array_different ::';
					// print_r($array_different);
					// echo '</pre>';
					// exit();
	
					foreach($array_different as $array_differentkey=>$array_different_value){
						// echo '<pre>array_different_value ';
						// print_r($array_different_value);
						// echo '</pre>';
						$search_key = array_search ($array_different_value, $days_namevalue);
						// echo '<pre>search_key ::';
						// print_r($search_key);
						// echo '</pre>';		
						
						// print_r($exising_id_array[$search_key]);

						// print_r($request->is_update);

						

	
	
						$dataupdt=array(
							'days'=> $array_different_value,
							'court_id_srno'=>1,
							'name'=>$request->name,
							"timedesc" => $days_namekey,
							"stime" => $_REQUEST['stime'][$days_namekey][0],
							"etime" => $_REQUEST['etime'][$days_namekey][0],
							"price" => $_REQUEST['price'][$days_namekey][0],
							'status'=>'1', 
							'created_at' =>  date("Y-m-d H:i:s"),
							'updated_at' =>  date("Y-m-d H:i:s")
							); 	

							// echo '<pre>';
							// print_r($dataupdt);
							// echo '</pre>';
							// exit();

							
							$updtquery2 = DB::table('venuescourttimes')
							->where('id',$exising_id_array[$search_key])
							->update($dataupdt);
						//}

				}

			


					
				}

				

			}
		}
	}

	

		// echo '<pre>array_different ::';
				// print_r($array_different);
				// echo '</pre>';

				// echo '<pre>exising_id_array ::';
				// print_r($exising_id_array);
				// echo '</pre>';

				

				// exit();

				// exit();

				// echo "<br>==================<br>";

				// exit();
				
				/*foreach($exising_days_array as $exising_days_key=>$exising_days_array_value){
					if(!in_array($exising_days_array_value, $days_namevalue))
					{
						
							/*foreach($days_namevalue as $days_namevaluekey=>$days_namevaluevalue){
								/*if(!in_array($days_namevaluevalue, $exising_days_array))
								{
								$dataupdt=array(
									'days'=> $days_namevaluevalue,
									'court_id_srno'=>1,
									'name'=>$request->name,
									"timedesc" => $days_namekey,
									"stime" => $_REQUEST['stime'][$days_namekey][0],
									"etime" => $_REQUEST['etime'][$days_namekey][0],
									"price" => $_REQUEST['price'][$days_namekey][0],
									'status'=>'1', 
									'created_at' =>  date("Y-m-d H:i:s"),
									'updated_at' =>  date("Y-m-d H:i:s")
									); 	
									
									/*$updtquery2 = DB::table('venuescourttimes')
									->where('court_id',$id)
									->update($dataupdt);*/
								//}
							//}	

							
						
						

					//}
				//}
			
			
				/*echo '<pre>';
				print_r($dataupdt);
				echo '</pre>';*/
				
				// exit();


				/*
				$data1=array(
				'days'=> $days_namevalue,
				'name'=>$request->name,
				"timedesc" => $count,
				"stime" => $_REQUEST['stime'][$count][0],
				"etime" => $_REQUEST['etime'][$count][0],
				"id" => $_REQUEST['courtidpk'][$count][0],
				"price" => $_REQUEST['price'][$count][0],
				'status'=>'1', 
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' =>  date("Y-m-d H:i:s")
				);	

				$updtquery2 = DB::table('venuescourttimes')
						->where('court_id',$id)
						->update($data1);
				*/
				
		/*echo '<pre>existing_ids ::';
		print_r($_REQUEST['existing_ids']);
		echo '</pre>';

		echo '<pre>days_name ::';
		print_r($_REQUEST['days_name']);
		echo '</pre>';

		exit();

		exit();
		
		foreach($_REQUEST['hdn_row_id'] as $hdn_row_idkey=>$hdn_row_idvalue){
			print_r($hdn_row_idkey);
			echo '<br>';
			echo '<br>';
			print_r($hdn_row_idvalue[0]);
			echo '<br>';
			echo '<br>';

		}
		
		echo '</pre>';
		exit();*/
		
		
		
		
		
		//$delexistsvendorcourt = DB::table('venuescourttimes')->where('court_id', $id)->delete();
		
		/*for($count=1;$count<9;$count++){
			$i = 1;
			foreach($_REQUEST['days_name'][$count] as $days_namekey=>$days_namevalue){
				
				
					//print_r($days_namevalue);
					
					$data1=array(
					    'days'=> $days_namevalue,
						'name'=>$request->name,
						"timedesc" => $count,
						"stime" => $_REQUEST['stime'][$count][0],
						"etime" => $_REQUEST['etime'][$count][0],
						"id" => $_REQUEST['courtidpk'][$count][0],
						"price" => $_REQUEST['price'][$count][0],
						'status'=>'1', 
						'created_at' =>  date("Y-m-d H:i:s"),
						'updated_at' =>  date("Y-m-d H:i:s")
						);	
						
						


						/*$data1=array(
						'days'=> $days_namevalue,
						'court_id_srno'=>$i,
						'name'=>$request->name,
						'vendor_id'=>$request->vendor_id,						
						'court_id'=>$id,
						"timedesc" => $count,
						"stime" => $_REQUEST['stime'][$count][0],
						"etime" => $_REQUEST['etime'][$count][0],
						"price" => $_REQUEST['price'][$count][0],
						'status'=>'1', 
						'created_at' =>  date("Y-m-d H:i:s"),
						'updated_at' =>  date("Y-m-d H:i:s")
							
						);	*/							
				    //echo "<br>";
					//print_r($data1);
					//echo "<br>";
					//print_r($_REQUEST['courtidpk'][$count]);
				 
					
				 //$courtidpk = $_REQUEST['hdn_row_id'][$count];	
				 
				
				
					//DB::enableQueryLog();	
				/*$checkexitscourtdetails=   DB::table('venuescourttimes')
										  ->Where('id',$courtidpk)
										  ->Where('timedesc',$count)
										  ->Where('stime',$_REQUEST['stime'][$count][0])
										  ->Where('etime',$_REQUEST['etime'][$count][0])
										  ->select('venuescourttimes.*')
										   ->get();
										   
								   
					
                   $checkexitscourtdetailscount = $checkexitscourtdetails->count();					
					//echo "<br>";
					//print_r($checkexitscourtdetails);
					 //echo "<br>";
					
        //$quries = DB::getQueryLog();
		//dd($quries);	

			if(empty($courtidpk)){
						$datains=array(
						'days'=> $days_namevalue,
						'court_id_srno'=>$i,
						'name'=>$request->name,
						'vendor_id'=>$request->vendor_id,						
						'court_id'=>$id,
						"timedesc" => $count,
						"stime" => $_REQUEST['stime'][$count][0],
						"etime" => $_REQUEST['etime'][$count][0],
						"price" => $_REQUEST['price'][$count][0],
						'status'=>'1', 
						'created_at' =>  date("Y-m-d H:i:s"),
						'updated_at' =>  date("Y-m-d H:i:s")
						); 
						 venuescourttimes::insertGetId($datains);
				 }		
					
						 
						
					
					else
					{
						$updtquery2 = DB::table('venuescourttimes')
						  ->where('court_id',$id)
						  ->where('id',$courtidpk)
						  ->update($data1);
					}	
					//venuescourttimes::insertGetId($data1);	
					$i++;					
			}
			
	    
		}*/
		
		return redirect('venuecreate')->with('success', 'Thanks for updateing Venus Entry');
		
	}	
		
   
}

