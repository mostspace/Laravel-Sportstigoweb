<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\memberships;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;

class MembershipController extends Controller
{
	
    public function membershipadd(Request $request)
    {
		
		$getsessioinid = Session::get('getsessionuserid');
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


		if($getsessioinid)
		{
         
			$validatedData = $request->validate([            
           
				'package_name' => 'required', 
				'package_price' => 'required',
				'package_discount_price' => 'required',
				'categoryimage' => 'required',
				
			],
			[            
				
				'package_name.required' => 'Package Name is required!',			
				'package_price.required' => 'Package Original Price required!',
				'package_discount_price.required' => 'Package Discount Price required!',
				'categoryimage.required' => 'Gallery is required!',            
				
			]);
			
			if ($request->hasFile('categoryimage')) {
				$image = $request->file('categoryimage');
				$category_image1 = time().'.'.$image->getClientOriginalExtension();
				$destinationPath = public_path('/MembershipImages');
				$image->move($destinationPath, $category_image1);
			} else {
				$category_image1 = $request->hdn_category_image;
			}
	
	
			$data=array(
				'vendor_id'=>$getsessioinid,
				'package_name'=>$request->package_name,
				'package_desc1'=>$request->package_desc1,
				'package_desc2'=>$request->package_desc2,
				'package_desc3'=>$request->package_desc3,
				'package_desc4'=>$request->package_desc4,
				'package_desc5'=>$request->package_desc5,
				'package_duration'=>$request->package_duration,
				'package_price'=>$request->package_price,
				'package_discount_price'=>$request->package_discount_price,
				'image' =>'MembershipImages/'.$category_image1,
				'status'=>'1', 
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' =>  date("Y-m-d H:i:s"),
			);
			
			$insertedId = memberships::insertGetId($data);
		   
			return redirect('membershipcreate')->with('success', 'Thanks for submitting Membership Entry');	
		}
		else
		{ 
		   return redirect('/login');
		}
		
		
	}
	
	 public function membershipupdate(Request $request, $id)
    {
		
		
		$validatedData = $request->validate([            
           
            'package_name' => 'required', 
            'package_price' => 'required',
			'package_discount_price' => 'required',
			'categoryimage' => 'required',
            
        ],
        [            
            
			'package_name.required' => 'Package Name is required!',			
            'package_price.required' => 'Package Original Price required!',
			'package_discount_price.required' => 'Package Discount Price required!', 
			'categoryimage.required' => 'Gallery is required!',	           
			
        ]);
		
		if ($request->hasFile('categoryimage')) {
            $image = $request->file('categoryimage');
            $category_image1 = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/MembershipImages');
            $image->move($destinationPath, $category_image1);
        } else {
            $category_image1 = $request->hdn_category_image;
        }


		$updatedata=array(
            'package_name'=>$request->package_name,
			'package_desc1'=>$request->package_desc1,
			'package_desc2'=>$request->package_desc2,
			'package_desc3'=>$request->package_desc3,
			'package_desc4'=>$request->package_desc4,
			'package_desc5'=>$request->package_desc5,
			'package_duration'=>$request->package_duration,
			'package_price'=>$request->package_price,
            'package_discount_price'=>$request->package_discount_price,
			'image' =>'MembershipImages/'.$category_image1,
			'status'=>$request->status,
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        
		
		$updtquery = DB::table('memberships')->where('membership_id',$id)->update($updatedata);
       
		return redirect('membershipcreate')->with('success', 'Thanks for Updating Membership Entry');	
	}
	
	public function membershiplist()
    {

        
		$getsessioinid = Session::get('getsessionuserid');
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
		
		
		if($getsessioinid)
		{
			$pagetitle = 'MEMBERSHIP MANAGEMENT';
			$pageheading = 'MEMBERSHIP MANAGEMENT';
			$membershipsdetails = memberships::select('memberships.*')
								->where('memberships.vendor_id', '=', $getsessioinid)	
								->paginate(4);
								//->get();	
						
				
			return view('MembershipList',compact('membershipsdetails','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}


		
    }

	public function sortingmembershiplist(Request $request,$id1,$id2)
    {
       
        $pagetitle = 'MEMBERSHIP MANAGEMENT';
        $pageheading = 'MEMBERSHIP MANAGEMENT';
        $txtserach = $id1; 
		$sorting = $id2;
		$getsessioinid = Session::get('getsessionuserid');
		//dd($txtserach,$sorting);
		
		
		if($txtserach=='Search')
		{
		$membershipsdetails = memberships::query()
					->orderBy('membership_id',$sorting)
                    ->paginate(4);	
		}
		else
		{	
		//DB::enableQueryLog();
		
					
		/*$membershipsdetails = memberships::where('memberships.vendor_id', '=', $getsessioinid)				  
							->where('package_name', 'LIKE', '%'.$txtserach.'%')
							->where('package_price', 'LIKE', '%'.$txtserach.'%')
					  		->orderBy('membership_id',$sorting)
				      		->paginate(4);	*/
							
							  DB::enableQueryLog();	
							  $membershipsdetails = memberships::where('memberships.vendor_id', '=', $getsessioinid)
							  ->where('package_name', 'LIKE', '%'.$txtserach.'%')
							  //->orwhere('package_price', 'LIKE', '%'.$txtserach.'%')
							  ->orderBy('membership_id',$sorting)
							  ->paginate(4);	
							 
					
		
		//$quries = DB::getQueryLog();
		//dd($quries);
		}			
		
        return view('MembershipList',compact('membershipsdetails','pagetitle','pageheading','txtserach','sorting'));
    }
	
	
	
	
	public function membershipcreate()
    {
	  	$pagetitle = 'PACKAGE / MEMBERSHIP MANAGEMENT';
        $pageheading = 'PACKAGE / MEMBERSHIP MANAGEMENT';
        $pagesubheading = 'Add New Membership';
		$membershipsdetails = 	memberships::select('memberships.*')->get();
		return view('MembershipAdd',compact('pagetitle','pagesubheading','pageheading','membershipsdetails'));
		
	}
	
	
	public function membershipedit(Request $request,$id)
    {
	
		$pagetitle = 'MEMBERSHIP MANAGEMENT';
        $pageheading = 'MEMBERSHIP MANAGEMENT';
		
		$membershipsdetails = memberships::select('memberships.*')
							 ->where('memberships.membership_id', '=', $id)
							 ->paginate(4);
							//->get();	
					
			
		return view('MembershipEdit',compact('membershipsdetails','pagetitle','pageheading'));
      	
	}
	
	public function membershipdelete(Request $request,$id)
    {
		$getsessioinid = Session::get('getsessionuserid');
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


		$pagetitle = 'MEMBERSHIP MANAGEMENT';
        $pageheading = 'MEMBERSHIP MANAGEMENT';
		$demembershipsexists = DB::table('memberships')->where('membership_id', $id)->delete();			
		
		
        $membershipsdetails = memberships::select('memberships.*')
							->where('memberships.vendor_id', '=', $getsessioinid)	
							->paginate(4);
							//->get();	
					
			
		return view('MembershipList',compact('membershipsdetails','pagetitle','pageheading'));
	}	
	
	
	
}
