<?php

namespace App\Http\Controllers;

use App\Models\vendor;
use App\Models\User;
use App\Models\vendordetails;
use App\Models\category;
use App\Models\vendorfacilities;
use App\Models\vendorclosingdays;
use App\Models\facilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('AdminVendorProfile');
		$getsessioinid = Session::get('getsessionuserid');

        $pagetitle = 'Vendor';
        $pageheading = 'Profile';
		
		$allstatelist=DB::table('states')
            ->select('states.*')
            ->get();
		
		$allcategorieslist=DB::table('categories')
            ->select('categories.*')
            ->get();
			
		$allvenuelist=DB::table('venues')
            ->select('venues.*')
            ->get();
		
		$allfacilitylist=DB::table('facilities')
            ->select('facilities.*')
            ->get();
			
		$allrefundpolicylist=DB::table('refunds')
            ->select('refunds.*')
            ->get();
		
		$allvendorrefferallist=DB::table('users')
							->where('role', '=', 8)
							->where('createdby', '=', $getsessioinid)
							->select('users.*')
							->get();	
			
		
        return view('AdminVendorProfile',compact('pagetitle','pageheading','allcategorieslist','allvenuelist','allstatelist','allfacilitylist','allrefundpolicylist','allvendorrefferallist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savevendor(Request $request)
    {
       
	   $getsessioinid = Session::get('getsessionuserid');
	   $getsessionrole = Session::get('getsessionrole');
	   $validatedData = $request->validate([            
           
            'businessname' => 'required', 
			'refund' => 'required', 
			'address' => 'required', 
			'description' => 'required', 
			'state' => 'required', 
			'business_category' => 'required',
			'whatsapp' => 'required',
			'categoryimage' => 'required',
			'categoryimage2' => 'required',
			'categoryimage3' => 'required',
			'categoryimage4' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
		     
                     
        ],
        [            
            
			'businessname.required' => 'Business Name is required!',
			'refund.required' => 'Refund Policy is required!',
			'address.required' => 'Address is required!',
			'description.required' => 'Description is required!',
			'state.required' => 'State is required!',
			'business_category.required' => 'Business Category is required!',
			'whatsapp.required' => 'Phone Number is required!',
			'categoryimage.required' => 'Gallery is required!',
			'categoryimage2.required' => 'Sub Gallery1 is required!',
			'categoryimage3.required' => 'Sub Gallery2 is required!',
			'categoryimage4.required' => 'Sub Gallery3 is required!',
			'latitude.required' => 'Address is required!',
			'longitude.required' => 'Address is required!',
		
        ]);

		if($getsessionrole==1)
		{
			$vendorrefferalid   = 0;
		}
		else
		{
			$vendorrefferalid = $request->vendorrefferalid;
		}

		
		if($vendorrefferalid==0)
		{
			$vendor_reffer_commisionval = 'N';
		}
		else
		{
			$vendor_reffer_commisionval = 'Y';
		}

		

		
		$businessname = $request->businessname;
		$vloginname = substr($businessname, 0, 5);
		$refund = $request->refund;
        $address = $request->address;
		$latitude = $request->latitude;
		$longitude = $request->longitude;
        $description = $request->description;
		$phonecode = $request->phonecode;
        $whatsapp = $request->whatsapp;
        $moredetails = $request->moredetails;
        $state = $request->state;
        $business_category = $request->business_category;
		$email = $request->email;
		$password = $request->password;
		

        $promo = $request->promo; 
        $imageupload = $request->imageupload; 
        $remember = $request->remember; 
        $sundaystime = $request->sundaystime; 
        $sundayetime = $request->sundayetime; 
        $mondaystime = $request->mondaystime; 
        $mondayetime = $request->mondayetime; 
        $tuesdaystime = $request->tuesdaystime; 
        $tuesdayetime = $request->tuesdayetime; 
        $wednesdaystime = $request->wednesdaystime; 
        $wednesdayetime = $request->wednesdayetime; 
        $thursdaystime = $request->thursdaystime; 
        $thursdayetime = $request->thursdayetime; 
        $fridaystime = $request->fridaystime; 
        $fridayetime = $request->fridayetime; 
        $saturdaystime = $request->saturdaystime; 
        $saturdayetime = $request->saturdayetime;
		
		
		
		
		if ($request->hasFile('categoryimage')) {
            $image = $request->file('categoryimage');
            $category_image1 = time().'.'.$image->getClientOriginalName();
            $destinationPath = public_path('/VendorImages');
            $image->move($destinationPath, $category_image1);
        } else {
            $category_image1 = $request->hdn_category_image;
        }
		
		
		if ($request->hasFile('categoryimage2')) {
            $image2 = $request->file('categoryimage2');
            $category_image2 = time().'.'.$image2->getClientOriginalName();
            $destinationPath2 = public_path('/VendorImages');
            $image2->move($destinationPath2, $category_image2);
        } else {
            $category_image2 = $request->hdn_category_image2;
        }
		
		if ($request->hasFile('categoryimage3')) {
            $image3 = $request->file('categoryimage3');
            $category_image3 = time().'.'.$image3->getClientOriginalName();
            $destinationPath3= public_path('/VendorImages');
            $image3->move($destinationPath3, $category_image3);
        } else {
            $category_image3= $request->hdn_category_image3;
        }
		
		if ($request->hasFile('categoryimage4')) {
            $image4 = $request->file('categoryimage4');
            $category_image4 = time().'.'.$image4->getClientOriginalExtension();
            $destinationPath4= public_path('/VendorImages');
            $image4->move($destinationPath4, $category_image4);
        } else {
            $category_image4= $request->hdn_category_image4;
        }





		
			$vendorcode = DB::table('users')->max('id');
			if($vendorcode==0)
			{
				$vendorcode = 'vendor1'; 
			}
			else		 
			{
				$vendorcode = 'vendor'.$vendorcode + 1;
			}
		
		  $vmobile =  $request->phonecode.$request->whatsapp;
		  $data=array(
            'name'=>$request->businessname ,
            'email'=>$vendorcode.'@sportstigo.com',
			'mobile'=>$vmobile,
            'password'=>'123456',
			'original_password'=>'123456',
			'role'=>'3',
			'status'=>'0',
			'bankname'=>$request->bankname,
			'bankacno'=>$request->bankacno,
			'bankaccountname'=>$request->bankaccountname,
			'createdby'=>$getsessioinid,
			'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        $data['password'] = bcrypt($data['password']);        
		$insertedId = User::insertGetId($data);	
		//dd($category_image1,$category_image2,$category_image3,$category_image4);
        
        $vendordata=array(
			'vendor_id' =>$insertedId,
            'businessname'=>$businessname,
			'description'=>$description,
			'refund'=>$refund,
			'phonecode'=>$phonecode,
            'whatsapp'=>$whatsapp,
            'address'=>$address,
			'latitude'=>$latitude,
			'longitude'=>$longitude,
            'state'=>$state,
            'business_category'=>$business_category,
			'moredetails' => $moredetails,
			'promo' =>$promo,
			'image' =>'VendorImages/'.$category_image1,
			'image1' =>'VendorImages/'.$category_image2,
			'image2' =>'VendorImages/'.$category_image3,
			'image3' =>'VendorImages/'.$category_image4,
			'vendorrefferalid' => $vendorrefferalid,
			'vendor_reffer_commisionval' => $vendor_reffer_commisionval,
			'createdby'=>$getsessioinid,
            'status'=>'0',
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        $insertedvendorId = vendor::insertGetId($vendordata);
		
		
		
		$Facility =  $request->input('Facility', []);
		
		$i = 1;
		foreach ($Facility as $index => $unit) 
		{
			$data1=array(
				
				"vendor_id"=> $insertedId,
				"facility" => $Facility[$index]
				
				
			);
		$i++;
		vendorfacilities::insertGetId($data1);		
		}
		
		$closing_days =  $request->input('closing_days', []);
		
		$i = 1;
		foreach ($closing_days as $index => $unit) 
		{
			
					$data1=array(
						
						"vendor_id"=> $insertedId,
						"closingdays" => $closing_days[$index]
						
						
					);
		    
		$i++;
		vendorclosingdays::insertGetId($data1);		
		}


        $vendordetailsdata=array(
        'vendor_id' => $insertedId,
		
		'sundaystime' => $sundaystime,
        'sundayetime' => $sundayetime,
        'mondaystime' => $mondaystime,
        'mondayetime' => $mondayetime,
        'tuesdaystime' => $tuesdaystime,
        'tuesdayetime' => $tuesdayetime,
        'wednesdaystime' => $wednesdaystime,
        'wednesdayetime' => $wednesdayetime,
        'thursdaystime' => $thursdaystime,
        'thursdayetime' => $thursdayetime,
        'fridaystime' => $fridaystime,
        'fridayetime' => $fridayetime,
        'saturdaystime' => $saturdaystime,
        'saturdayetime' => $saturdayetime,
        
		'status' => '1',
        'created_at' =>  date("Y-m-d H:i:s"),
        'updated_at' =>  date("Y-m-d H:i:s"),
        );
		
		
		
        //$userdetail = vendordetail::create($vendordetailsdata);
		//return redirect('vendor');
		
		if( vendordetails::create($vendordetailsdata) ){
            
			return redirect('vendor')->with('success', 'Thanks for submitting Vendor Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
        

    }
	
	
	

   public function vendorlist(Request $request)
    {
       
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
		    $getsessionrole = Session::get('getsessionrole');

			$pagetitle = 'Vendor Management';
			$pageheading = 'Vendor Management';
		   
			/*if($getsessionrole ==7)
			{
				
				$checkvendorrefferal = DB::table('users')->where('users.createdby', '=', $getsessioinid)->where('users.role', '=', 8)
					->select('users.id')->first();
				$getvendorrefferal = $checkvendorrefferal->id;
				
				$vendorlistdetails=  DB::table('vendors')
									->join('users','users.id','vendors.vendor_id')
									->where('users.createdby', '=', $getsessioinid)
									->orwhere('users.createdby', '=', $getvendorrefferal)
									->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile')
									->orderBy('vendors.vendor_id','DESC')
									->paginate(4);
			}*/
			
			if($getsessionrole ==7)
			{
				
				$checkvendorrefferal = DB::table('users')->where('users.createdby', '=', $getsessioinid)->where('users.role', '=', 8)->select('users.id')->first();
				//$getvendorrefferal = $checkvendorrefferal->id;
				
				$vendorlistdetails=  DB::table('vendors')
									->join('users','users.id','vendors.vendor_id')
									->where('users.createdby', '=', $getsessioinid)
									//->orwhere('users.createdby', '=', $getvendorrefferal)
									->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile')
									->orderBy('vendors.vendor_id','DESC')
									->paginate(4);
			}
			
			if($getsessionrole ==8)
			{
				$vendorlistdetails=  DB::table('vendors')
				->join('users','users.id','vendors.vendor_id')
				->where('users.createdby', '=', $getsessioinid)
				->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile')
				->orderBy('vendors.vendor_id','DESC')
				->paginate(4);
			}
			if($getsessionrole ==1)
			{
				$vendorlistdetails =  DB::table('vendors')
				->join('users','users.id','vendors.vendor_id')
				->leftJoin('featured_vendors', 'featured_vendors.vendor_id', 'vendors.vendor_id')
				->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile', 'featured_vendors.position')
				->orderBy('vendors.vendor_id','DESC')
				->paginate(4);
			}
			if($getsessionrole ==6)
			{
				$vendorlistdetails=  DB::table('vendors')
				->join('users','users.id','vendors.vendor_id')
				->where('users.createdby', '=', $getsessioinid)
				->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile')
				->orderBy('vendors.vendor_id','DESC')
				->paginate(4);
			}
			
								
			return view('VendorList',compact('vendorlistdetails','pagetitle','pageheading'));
		}
		else
		{ 
			//$request->session()->flush();
			return redirect('/login');

		}

    }
	
	public function sortingvendorlist(Request $request,$id1,$id2)
    {
    	
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
           
							$pagetitle = 'Vendor Management';
							$pageheading = 'Vendor Management';
							$txtserach = $id1; 
							$sorting = $id2;
							
							//dd($txtserach,$sorting);
							
							
							if($txtserach=='Search')
							{
							
							
								$vendorlistdetails=  DB::table('vendors')
												->join('users','users.id','vendors.vendor_id')
												//->where('users.createdby', '=', $getsessioinid)
												->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile')
												->orderBy('vendors.vendor_id',$sorting)
												->paginate(4);		
							}
							else
							{	
							//DB::enableQueryLog();
							
										
								
							
							$vendorlistdetails=  DB::table('vendors')
												->join('users','users.id','vendors.vendor_id')
												//->where('users.createdby', '=', $getsessioinid)
												->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile')
												->where('businessname', 'LIKE', '%'.$txtserach.'%')
												->orWhere('whatsapp', 'LIKE', '%'.$txtserach.'%')
												->orWhere('address', 'LIKE', '%'.$txtserach.'%')
												->orWhere('email', 'LIKE', '%'.$txtserach.'%')
												->orderBy('vendors.vendor_id',$sorting)
												->paginate(4);		
										
							
							//$quries = DB::getQueryLog();
							//dd($quries);
							}			
							return view('VendorList',compact('vendorlistdetails','pagetitle','pageheading','txtserach','sorting'));
							}
		else
		{ 
			
			return redirect('/login');

		}

		
    }
	
	
	
	
	public function vendorapproved(Request $request, $id)
    {
       
		$pagetitle = 'Vendor Management';
        $pageheading = 'Vendor Management';
        $vapproved = DB::table('vendors')->Where('vendor_id',$id)->Update(['status'=>1]);
		$vusersapproved = DB::table('users')->Where('id',$id)->Update(['status'=>1]);
		$vendorlistdetails=  DB::table('vendors')
							->join('users','users.id','vendors.vendor_id')
							->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile')
							->orderBy('vendors.vendor_id','DESC')
							->paginate(4);
							
							
							
		
        return view('VendorList',compact('vendorlistdetails','pagetitle','pageheading'));
    }
	public function vendorrejected(Request $request, $id)
    {
       
		$pagetitle = 'Vendor  Management';
        $pageheading = 'Vendor  Management';
        $vrejected = DB::table('vendors')->Where('vendor_id',$id)->Update(['status'=>0]);
		$vusersrejected = DB::table('users')->Where('id',$id)->Update(['status'=>0]);
		$vendorlistdetails=  DB::table('vendors')
							->join('users','users.id','vendors.vendor_id')
							->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile')
							->orderBy('vendors.vendor_id','DESC')
							->paginate(4);
							
							
							
		
        return view('VendorList',compact('vendorlistdetails','pagetitle','pageheading'));
    }
	
	
	public function deletevendor(Request $request, $id )
    {
        
		//dd($id);
		$getsessioinid = Session::get('getsessionuserid');
		$pagetitle = 'Vendor  Management';
        $pageheading = 'Vendor  Management';
		$delusersexists = DB::table('users')->where('id', $id)->delete();
		$delvendorexists = DB::table('vendors')->where('vendor_id', $id)->delete();
		$delvendordtlsexists = DB::table('vendordetails')->where('vendor_id', $id)->delete();
		$delvendorfacilitiesexists = DB::table('vendorfacilities')->where('vendor_id', $id)->delete();
		
		
		$vendorlistdetails=  DB::table('vendors')
							->join('users','users.id','vendors.vendor_id')
							->where('users.createdby', '=', $getsessioinid)
							->select('vendors.*','users.name as name','users.role as role','users.email as email','users.original_password as password','users.mobile as mobile')
							->orderBy('vendors.vendor_id','DESC')
							->paginate(4);
							
							
		
        return view('VendorList',compact('vendorlistdetails','pagetitle','pageheading'));
    }
	
	public function editvendor(Request $request,$id)
    {
	
		
		$getsessioinid = Session::get('getsessionuserid');
		$pagetitle = 'Vendor Management';
        $pageheading = 'Vendor Management';
        $pagesubheading = 'Edit New Vendor';
	
		$allstatelist=DB::table('states')
            ->select('states.*')
            ->get();
		
		$allcategorieslist=DB::table('categories')
            ->select('categories.*')
            ->get();
		
		$allvenuelist=DB::table('venues')
            ->select('venues.*')
            ->get();

		$allvendorrefferallist=DB::table('users')
			->where('role', '=', 8)
			->where('createdby', '=', $getsessioinid)
			->select('users.*')
			->get();
			
			
	
		/*$vendorlist = 	vendor::select('vendors.*')
					    ->where('vendors.vendor_id', '=', $id)
					    ->get();*/

		$vendorlist =  	 DB::table('vendors')
							->join('users','users.id','vendors.vendor_id')
							->where('vendors.vendor_id', '=', $id)
							->select('vendors.*','users.bankname','users.bankacno','users.bankaccountname')
						    ->get();



		$vendorDetails = vendordetails::select('vendordetails.*')
					    ->where('vendordetails.vendor_id', '=', $id)
					    ->get();
		$allfacilitylist=DB::table('facilities')
					->select('facilities.*')
					->get()->toArray();
					
		$vendorfacilitylist = vendorfacilities::select('vendorfacilities.*')
					    ->where('vendorfacilities.vendor_id', '=', $id)
					    ->get()->toArray();	
		$vendorclosingdayslist = vendorclosingdays::select('vendorclosingdays.*')
							->where('vendorclosingdays.vendor_id', '=', $id)
					    	->get();
							
				

		$facility_right_array = array();
		
		foreach($vendorfacilitylist as $vendorfacilitylistkey=>$vendorfacilitylistvalue)
			{  
			   $facility_right_array[] = $vendorfacilitylistvalue['facility'];
			} 

		$allrefundpolicylist=DB::table('refunds')
            ->select('refunds.*')
            ->get();					
					
		return view('AdminVendorProfileEdit',compact('pagetitle','pagesubheading','pageheading','vendorlist','vendorDetails','allstatelist','allcategorieslist','allvenuelist','allfacilitylist','facility_right_array','allrefundpolicylist','allvendorrefferallist','vendorclosingdayslist'));
      	
	}
	public function editvendorprofile(Request $request,$id)
    {
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
           

					$pagetitle = 'Vendor Management';
					$pageheading = 'Vendor Management';
					$pagesubheading = 'Edit Vendor';
				
					$allstatelist=DB::table('states')
						->select('states.*')
						->get();
					
					$allcategorieslist=DB::table('categories')
						->select('categories.*')
						->get();
					
					$allvenuelist=DB::table('venues')
						->select('venues.*')
						->get();
						
					

									$vendorlist =  	 DB::table('vendors')
									->join('users','users.id','vendors.vendor_id')
									->where('vendors.vendor_id', '=', $id)
									->select('vendors.*','users.bankname','users.bankacno','users.bankaccountname')
									->get();

					$vendorDetails = vendordetails::select('vendordetails.*')
									->where('vendordetails.vendor_id', '=', $id)
									->get();
					$allvendorrefferallist=DB::table('users')
									->where('role', '=', 8)
									->select('users.*')
									->get();	

					$allfacilitylist=DB::table('facilities')
								->select('facilities.*')
								->get()->toArray();

					$vendorclosingdayslist = vendorclosingdays::select('vendorclosingdays.*')
							->where('vendorclosingdays.vendor_id', '=', $id)
					    	->get();

					$vendorfacilitylist = vendorfacilities::select('vendorfacilities.*')
									->where('vendorfacilities.vendor_id', '=', $id)
									->get()->toArray();	
									

					$facility_right_array = array();
					
					foreach($vendorfacilitylist as $vendorfacilitylistkey=>$vendorfacilitylistvalue)
						{  
						$facility_right_array[] = $vendorfacilitylistvalue['facility'];
						} 
					
					$allrefundpolicylist=DB::table('refunds')
						->select('refunds.*')
						->get();		
								
					return view('VendorProfileEdit',compact('pagetitle','pagesubheading','pageheading','vendorlist','vendorDetails','allstatelist','allcategorieslist','allvenuelist','allfacilitylist','facility_right_array','allrefundpolicylist','allvendorrefferallist','vendorclosingdayslist'));
		}
		else
		{  
			return redirect('/login');

		}

	
		
      	
	}
	
	public function updatevendor(Request $request,$id)
    {
		$checkbox1 = $request->checkbox1;
		$getsessionrole = Session::get('getsessionrole');
		
	
		
		if($checkbox1=='Yes')
		{
						$validatedData = $request->validate([            
					
							'businessname' => 'required', 
							'refund' => 'required', 
							'address' => 'required', 
							'description' => 'required', 
							'state' => 'required', 
							'business_category' => 'required',
							'whatsapp' => 'required',
							'categoryimage' => 'required',
							'categoryimage2' => 'required',
							'categoryimage3' => 'required',
							'categoryimage4' => 'required',
							'latitude' => 'required',
							'longitude' => 'required',
						],
						[            
							
							'businessname.required' => 'Business Name is required!',
							'refund.required' => 'Refund Policy is required!',
							'address.required' => 'Address is required!',
							'description.required' => 'Description is required!',
							'state.required' => 'State is required!',
							'business_category.required' => 'Business Category is required!',
							'whatsapp.required' => 'Phone Number is required!',
							'categoryimage.required' => 'Gallery is required!',
							'categoryimage2.required' => 'Sub Gallery1 is required!',
							'categoryimage3.required' => 'Sub Gallery2 is required!',
							'categoryimage4.required' => 'Sub Gallery3 is required!',
							'latitude.required' => 'Address is required!',
							'longitude.required' => 'Address is required!',
						
						]);
		}
		else
		{

			
						$validatedData = $request->validate([            
					
							'businessname' => 'required', 
							'refund' => 'required', 
							'address' => 'required', 
							'description' => 'required', 
							'state' => 'required', 
							'business_category' => 'required',
							'whatsapp' => 'required',
							'latitude' => 'required',
							'longitude' => 'required',
						],
						[            
							
							'businessname.required' => 'Business Name is required!',
							'refund.required' => 'Refund Policy is required!',
							'address.required' => 'Business Name is required!',
							'description.required' => 'Description is required!',
							'state.required' => 'State is required!',
							'business_category.required' => 'Business Category is required!',
							'whatsapp.required' => 'Phone Number is required!',
							'latitude.required' => 'Address is required!',
							'longitude.required' => 'Address is required!',
							
						
						]);

						
		}
		

       
		if($getsessionrole==1)
		{
			$vendorrefferalid   = 0;
		}
		else
		{
			$vendorrefferalid = $request->vendorrefferalid;
		}


		
		if($vendorrefferalid==0)
		{
			$vendor_reffer_commisionval = 'N';
		}
		else
		{
			$vendor_reffer_commisionval = 'Y';
		}
		
		
		$businessname = $request->businessname;
		$vloginname = substr($businessname, 0, 5);
		$refund = $request->refund;
        $address = $request->address;
		$latitude = $request->latitude;
		$longitude = $request->longitude;
        $description = $request->description;
		$phonecode = $request->phonecode;
        $whatsapp = $request->whatsapp;
        $moredetails = $request->moredetails;
        $state = $request->state;
        $business_category = $request->business_category;
		$email = $request->email;
		$password = $request->password;
		

        $promo = $request->promo; 
        $imageupload = $request->imageupload; 
        $remember = $request->remember; 
        $sundaystime = $request->sundaystime; 
        $sundayetime = $request->sundayetime; 
        $mondaystime = $request->mondaystime; 
        $mondayetime = $request->mondayetime; 
        $tuesdaystime = $request->tuesdaystime; 
        $tuesdayetime = $request->tuesdayetime; 
        $wednesdaystime = $request->wednesdaystime; 
        $wednesdayetime = $request->wednesdayetime; 
        $thursdaystime = $request->thursdaystime; 
        $thursdayetime = $request->thursdayetime; 
        $fridaystime = $request->fridaystime; 
        $fridayetime = $request->fridayetime; 
        $saturdaystime = $request->saturdaystime; 
        $saturdayetime = $request->saturdayetime;
		
		
        
		

		if ($request->hasFile('categoryimage')) {
            $image = $request->file('categoryimage');
            $category_image1 = time().'.'.$image->getClientOriginalName();
            $destinationPath = public_path('/VendorImages');
            $image->move($destinationPath, $category_image1);
        } else {
            $category_image1 = $request->hdn_category_image;
        }
		
		
		if ($request->hasFile('categoryimage2')) {
            $image2 = $request->file('categoryimage2');
            $category_image2 = time().'.'.$image2->getClientOriginalName();
            $destinationPath2 = public_path('/VendorImages');
            $image2->move($destinationPath2, $category_image2);
        } else {
            $category_image2 = $request->hdn_category_image2;
        }
		
		if ($request->hasFile('categoryimage3')) {
            $image3 = $request->file('categoryimage3');
            $category_image3 = time().'.'.$image3->getClientOriginalName();
            $destinationPath3= public_path('/VendorImages');
            $image3->move($destinationPath3, $category_image3);
        } else {
            $category_image3= $request->hdn_category_image3;
        }
		
		if ($request->hasFile('categoryimage4')) {
            $image4 = $request->file('categoryimage4');
            $category_image4 = time().'.'.$image4->getClientOriginalExtension();
            $destinationPath4= public_path('/VendorImages');
            $image4->move($destinationPath4, $category_image4);
        } else {
            $category_image4= $request->hdn_category_image4;
        }


		

		$vmobile =  $request->phonecode.$request->whatsapp;
		
		$data=array(
            'name'=>$request->businessname,
			'mobile'=>$vmobile,
            'role'=>'3',
			'bankname'=>$request->bankname,
			'bankacno'=>$request->bankacno,
			'bankaccountname'=>$request->bankaccountname,
			'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
       
		$updtquery1 = DB::table('users')->where('id',$id)->update($data);
		
		if($checkbox1=='Yes')
		{
			
			
			$vendordata=array(
				'businessname'=>$businessname,
				'description'=>$description,
				'refund'=>$refund,
				'phonecode'=>$phonecode,
				'whatsapp'=>$whatsapp,
				'address'=>$address,
				'latitude'=>$latitude,
				'longitude'=>$longitude,
				'state'=>$state,
				'business_category'=>$business_category,
				'moredetails' => $moredetails,
				'promo' =>$promo,
				'image' =>'VendorImages/'.$category_image1,
				'image1' =>'VendorImages/'.$category_image2,
				'image2' =>'VendorImages/'.$category_image3,
				'image3' =>'VendorImages/'.$category_image4,
				'vendor_reffer_commisionval' =>$vendor_reffer_commisionval,
				'vendorrefferalid'=>$vendorrefferalid,
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' =>  date("Y-m-d H:i:s"),
			);
				
		}
		else
		{
			$vendordata=array(
				'businessname'=>$businessname,
				'description'=>$description,
				'refund'=>$refund,
				'phonecode'=>$phonecode,
				'whatsapp'=>$whatsapp,
				'address'=>$address,
				'latitude'=>$latitude,
				'longitude'=>$longitude,
				'state'=>$state,
				'business_category'=>$business_category,
				'moredetails' => $moredetails,
				'promo' =>$promo,
				'vendor_reffer_commisionval' =>$vendor_reffer_commisionval,
				'vendorrefferalid'=>$vendorrefferalid,
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' =>  date("Y-m-d H:i:s"),
			);
			
		}

		
        
		$updtquery2 = DB::table('vendors')->where('vendor_id',$id)->update($vendordata);

        $vendordetailsdata=array(
        
		'sundaystime' => $sundaystime,
        'sundayetime' => $sundayetime,
        'mondaystime' => $mondaystime,
        'mondayetime' => $mondayetime,
        'tuesdaystime' => $tuesdaystime,
        'tuesdayetime' => $tuesdayetime,
        'wednesdaystime' => $wednesdaystime,
        'wednesdayetime' => $wednesdayetime,
        'thursdaystime' => $thursdaystime,
        'thursdayetime' => $thursdayetime,
        'fridaystime' => $fridaystime,
        'fridayetime' => $fridayetime,
        'saturdaystime' => $saturdaystime,
        'saturdayetime' => $saturdayetime,
       
		'created_at' =>  date("Y-m-d H:i:s"),
        'updated_at' =>  date("Y-m-d H:i:s"),
        );
		
		
		$updtquery2 = DB::table('vendordetails')->where('vendor_id',$id)->update($vendordetailsdata);
		
	    $delvendorfacilitiesexists = DB::table('vendorfacilities')->where('vendor_id', $id)->delete();
		$delvendorclosingdaysexists = DB::table('vendorclosingdays')->where('vendor_id', $id)->delete();
		
		$Facility =  $request->input('Facility', []);
		$i = 1;
		foreach ($Facility as $index => $unit) 
		{
			$data1=array(
				
				"vendor_id"=> $id,
				"facility" => $Facility[$index]
				
				
			);
		$i++;
		vendorfacilities::insertGetId($data1);		
		}

		
		$closing_days =  $request->input('closing_days', []);
		
		$i = 1;
		foreach ($closing_days as $index => $unit) 
		{
			
					$data1=array(
						
						"vendor_id"=> $id,
						"closingdays" => $closing_days[$index]
						
						
					);
		    
		$i++;
		vendorclosingdays::insertGetId($data1);		
		}
		
		
		return redirect('vendor')->with('success', 'Thanks for submitting Updating Entry');
	}
	
	public function updatevendorprofile(Request $request,$id)
    {
		
		$checkbox1 = $request->checkbox1;
		
		if($checkbox1=='Yes')
		{
						$validatedData = $request->validate([            
					
							'businessname' => 'required', 
							'refund' => 'required', 
							'address' => 'required', 
							'description' => 'required', 
							'state' => 'required', 
							'business_category' => 'required',
							'whatsapp' => 'required',
							'categoryimage' => 'required',
							'categoryimage2' => 'required',
							'categoryimage3' => 'required',
							'categoryimage4' => 'required',
							'latitude' => 'required',
							'longitude' => 'required',
						],
						[            
							
							'businessname.required' => 'Business Name is required!',
							'refund.required' => 'Refund Policy is required!',
							'address.required' => 'Business Name is required!',
							'description.required' => 'Description is required!',
							'state.required' => 'State is required!',
							'business_category.required' => 'Business Category is required!',
							'whatsapp.required' => 'Phone Number is required!',
							'categoryimage.required' => 'Gallery is required!',
							'categoryimage2.required' => 'Sub Gallery1 is required!',
							'categoryimage3.required' => 'Sub Gallery2 is required!',
							'categoryimage4.required' => 'Sub Gallery3 is required!',
							'latitude.required' => 'Address is required!',
							'longitude.required' => 'Address is required!',
						
						]);
		}
		else
		{
						$validatedData = $request->validate([            
					
							'businessname' => 'required', 
							'refund' => 'required', 
							'address' => 'required', 
							'description' => 'required', 
							'state' => 'required', 
							'business_category' => 'required',
							'whatsapp' => 'required',
							'latitude' => 'required',
							'longitude' => 'required',
						],
						[            
							
							'businessname.required' => 'Business Name is required!',
							'refund.required' => 'Refund Policy is required!',
							'address.required' => 'Business Name is required!',
							'description.required' => 'Description is required!',
							'state.required' => 'State is required!',
							'business_category.required' => 'Business Category is required!',
							'whatsapp.required' => 'Phone Number is required!',
							'latitude.required' => 'Address is required!',
							'longitude.required' => 'Address is required!',
							
						
						]);
		}
		
		




		$getsessionrole = Session::get('getsessionrole');
		$businessname = $request->businessname;
		$refund = $request->refund;
        $address = $request->address;
		$latitude = $request->latitude;
		$longitude = $request->longitude;
        $description = $request->description;
		$phonecode = $request->phonecode;
        $whatsapp = $request->whatsapp;
        $moredetails = $request->moredetails;
        $state = $request->state;
        $business_category = $request->business_category;
		$email = $request->email;
		$password = $request->password;
		

        $promo = $request->promo; 
        $imageupload = $request->imageupload; 
        $remember = $request->remember; 
        $sundaystime = $request->sundaystime; 
        $sundayetime = $request->sundayetime; 
        $mondaystime = $request->mondaystime; 
        $mondayetime = $request->mondayetime; 
        $tuesdaystime = $request->tuesdaystime; 
        $tuesdayetime = $request->tuesdayetime; 
        $wednesdaystime = $request->wednesdaystime; 
        $wednesdayetime = $request->wednesdayetime; 
        $thursdaystime = $request->thursdaystime; 
        $thursdayetime = $request->thursdayetime; 
        $fridaystime = $request->fridaystime; 
        $fridayetime = $request->fridayetime; 
        $saturdaystime = $request->saturdaystime; 
        $saturdayetime = $request->saturdayetime;
		
		
        
		if ($request->hasFile('categoryimage')) {
            $image = $request->file('categoryimage');
            $category_image1 = time().'.'.$image->getClientOriginalName();
            $destinationPath = public_path('/VendorImages');
            $image->move($destinationPath, $category_image1);
        } else {
            $category_image1 = $request->hdn_category_image;
        }
		
		
		if ($request->hasFile('categoryimage2')) {
            $image2 = $request->file('categoryimage2');
            $category_image2 = time().'.'.$image2->getClientOriginalName();
            $destinationPath2 = public_path('/VendorImages');
            $image2->move($destinationPath2, $category_image2);
        } else {
            $category_image2 = $request->hdn_category_image2;
        }
		
		if ($request->hasFile('categoryimage3')) {
            $image3 = $request->file('categoryimage3');
            $category_image3 = time().'.'.$image3->getClientOriginalName();
            $destinationPath3= public_path('/VendorImages');
            $image3->move($destinationPath3, $category_image3);
        } else {
            $category_image3= $request->hdn_category_image3;
        }
		
		if ($request->hasFile('categoryimage4')) {
            $image4 = $request->file('categoryimage4');
            $category_image4 = time().'.'.$image4->getClientOriginalExtension();
            $destinationPath4= public_path('/VendorImages');
            $image4->move($destinationPath4, $category_image4);
        } else {
            $category_image4= $request->hdn_category_image4;
        }

		

		$vmobile =  $request->phonecode.$request->whatsapp;
		$data=array(
            'name'=>$request->businessname,
			'mobile'=>$vmobile,
            'role'=>'3',
			'bankname'=>$request->bankname,
			'bankacno'=>$request->bankacno,
			'bankaccountname'=>$request->bankaccountname,
			'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
       
		
		$updtquery1 = DB::table('users')->where('id',$id)->update($data);
		
        
		
		if($checkbox1=='Yes')
		{
			
			
			$vendordata=array(
				'businessname'=>$businessname,
				'description'=>$description,
				'refund'=>$refund,
				'phonecode'=>$phonecode,
				'whatsapp'=>$whatsapp,
				'address'=>$address,
				'latitude'=>$latitude,
				'longitude'=>$longitude,
				'state'=>$state,
				'business_category'=>$business_category,
				'moredetails' => $moredetails,
				'promo' =>$promo,
				'image' =>'VendorImages/'.$category_image1,
				'image1' =>'VendorImages/'.$category_image2,
				'image2' =>'VendorImages/'.$category_image3,
				'image3' =>'VendorImages/'.$category_image4,
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' =>  date("Y-m-d H:i:s"),
			);

				
		}
		else
		{
			$vendordata=array(
				'businessname'=>$businessname,
				'description'=>$description,
				'refund'=>$refund,
				'phonecode'=>$phonecode,
				'whatsapp'=>$whatsapp,
				'address'=>$address,
				'latitude'=>$latitude,
				'longitude'=>$longitude,
				'state'=>$state,
				'business_category'=>$business_category,
				'moredetails' => $moredetails,
				'promo' =>$promo,
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' =>  date("Y-m-d H:i:s"),
			);
			
		}
		
		
       $updtquery2 = DB::table('vendors')->where('vendor_id',$id)->update($vendordata);

        $vendordetailsdata=array(
        
		'sundaystime' => $sundaystime,
        'sundayetime' => $sundayetime,
        'mondaystime' => $mondaystime,
        'mondayetime' => $mondayetime,
        'tuesdaystime' => $tuesdaystime,
        'tuesdayetime' => $tuesdayetime,
        'wednesdaystime' => $wednesdaystime,
        'wednesdayetime' => $wednesdayetime,
        'thursdaystime' => $thursdaystime,
        'thursdayetime' => $thursdayetime,
        'fridaystime' => $fridaystime,
        'fridayetime' => $fridayetime,
        'saturdaystime' => $saturdaystime,
        'saturdayetime' => $saturdayetime,
        'status' => '1',
        'created_at' =>  date("Y-m-d H:i:s"),
        'updated_at' =>  date("Y-m-d H:i:s"),
        );


		

	$updtquery2 = DB::table('vendordetails')->where('vendor_id',$id)->update($vendordetailsdata);
	
	$delvendorfacilitiesexists = DB::table('vendorfacilities')->where('vendor_id', $id)->delete();
	$delvendorclosingdaysexists = DB::table('vendorclosingdays')->where('vendor_id', $id)->delete();
		
		$Facility =  $request->input('Facility', []);
		$i = 1;
		foreach ($Facility as $index => $unit) 
		{
			$data1=array(
				
				"vendor_id"=> $id,
				"facility" => $Facility[$index]
				
				
			);
		$i++;
		vendorfacilities::insertGetId($data1);		
		}
		
		$closing_days =  $request->input('closing_days', []);
		
		$i = 1;
		foreach ($closing_days as $index => $unit) 
		{
			
					$data1=array(
						
						"vendor_id"=> $id,
						"closingdays" => $closing_days[$index]
						
						
					);
		    
		$i++;
		vendorclosingdays::insertGetId($data1);		
		}
		
		
		
		
		
		return redirect('editvendorprofile/'.''.$id)->with('success', 'Thanks for submitting Updating Entry');
	}
	
	/**
     * Display the specified resource.
     *
     * @param  \App\Models\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(vendor $vendor)
    {
        //
    }
}
