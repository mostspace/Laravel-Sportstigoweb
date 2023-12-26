<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\rightsmapping;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\booking_with_vendors;
use DB;


class AdminController extends Controller
{

    public function __construct()
    {
        if(!Session::has('username')){
            return redirect('/admin');
        }
        if (!Auth::check()) echo 'NOasdasd';
        // echo '<pre>';
        // print_r("asdasdsdasdasdasd");
        // echo '</pre>';
        // exit();
    }


    public function dashboard(){
        $getsessioinid = Session::get('getsessionuserid');
        
		if($getsessioinid)
		{
            $pagetitle = 'Dashboard';
            $pageheading = 'Dashboard';
            $getsessionuserid = Session::get('getsessionuserid');
            $getsessionrole = Session::get('getsessionrole');
            $getsessioncreatedby = Session::get('getsessioncreatedby');
            
            $getsessionusertype = Session::get('getsessionusertype');
            $role =  $getsessionrole;
            
                            if ($getsessionrole==0)
                            {
                                
                                return view('LoginView',compact('pagetitle','pageheading','role'));
                            }
                            else if ($getsessionrole==1)
                            {
                                
                                return view('AdminDashboard',compact('pagetitle','pageheading','role'));
                            }
                            else if ($getsessionrole==7)
                            {
                                
                                return view('RefferalDashboard',compact('pagetitle','pageheading','role'));
                            }
                            else if ($role==8)
						    {
							
							     return view('VendorRefferalDashboard',compact( 'role'));
					    	}
                            else if ($getsessionrole==3)
                            {
                                
                                
                                $bookingdtls= DB::table('booking_with_vendors')
											->where('booking_with_vendors.vendor_id',$getsessioinid)
											->select('booking_with_vendors.*')
											->orderBy('booking_with_vendors.booking_id','DESC')
											->get();
											
							    $bookingcheckdetails	= DB::table('booking_with_vendors')
													->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
													->where('booking_with_vendors.vendor_id',$getsessioinid)
                                                    ->where('booking_with_vendorsdetails.checkinstatus',1)
													->select('booking_with_vendorsdetails.*','booking_with_vendors.username','booking_with_vendors.mobileno','booking_with_vendors.paymethod')
													->orderBy('booking_with_vendors.booking_id','DESC')
													->get();
                                
                                return view('VendorDashboard',compact('pagetitle','pageheading','role','bookingdtls','bookingcheckdetails'));
                            }
                            else if ($getsessionrole==4)
                            {
                                
                                return view('InstructorDashboard',compact('pagetitle','pageheading','role'));
                            }
                            else if ($getsessionrole==5)
                            {
                                
                                return view('HostDashboard',compact('pagetitle','pageheading','role'));
                            }
                            else if ($getsessionrole==6)
                            {
                                
                                $staffmoduledetails = rightsmapping::select('rightsmapping.*')
                                    ->where('rightsmapping.userid', '=', $getsessionuserid)
                                    ->get();
                            
                                return view('StaffDashboard',compact( 'role','staffmoduledetails'));
                            }
		}
		else
		{ 
		   return redirect('/login');
		}

        
		
    }

    public function AdminVendorProfile(){

        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'Vendor Profile Edit';
            $pageheading = 'Vendor';
            return view('AdminVendorProfile',compact('pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

        
    }

    public function AdminBanner(){

        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'Banner';
            $pageheading = 'Banner';
            
            
            $allvendorlist=DB::table('vendors')
                ->where('status', '=', 1)
                ->select('vendors.*')
                ->get();
            
            return view('AdminBannerView',compact('pagetitle','pageheading','allvendorlist'));
		}
		else
		{ 
		   return redirect('/login');
		}

        
    }

    public function AdminProfile(){

        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'Admin Managment';
            $pageheading = 'Admin Managment';
            
            $getsessionuserid = Session::get('getsessionuserid');
            
            /*$userlist=DB::table('users')
                    ->Where('id',$getsessionuserid)
                     ->select('users.*')
                     ->get();
            $commisionmgmt=DB::table('commisionmgmt')
                     ->select('commisionmgmt.*')
                     ->get();*/
                     
            $commisionmgmt=DB::table('commisionmgmt')
                ->join('users','users.id','commisionmgmt.userid')
                ->select('commisionmgmt.*','users.name as name','users.email as email','users.password as password','users.original_password as original_password')
                ->get();
                     
            //dd($commisionmgmt);		 
            return view('AdminProfileView',compact('pagetitle','pageheading','commisionmgmt'));
		}
		else
		{ 
		   return redirect('/login');
		}

        
    }
    
    // public function AdminVendor(){
    //     return view('AdminVendorManage');
    // }
	
	public function commisionupdate(Request $request,$id)
	{
		$pagetitle = 'Admin Managment';
        $pageheading = 'Admin Managment';
		
		
		$updatedata=array('admin_commisionval'=>$request->admin_commisionval,'Refferal_commisionval'=>$request->Refferal_commisionval,'sales_agent_commisionval'=>$request->sales_agent_commisionval,'Vendor_Reffer_commisionval'=>$request->Vendor_Reffer_commisionval);
		$updtquery = DB::table('commisionmgmt')->where('userid',$id)->update($updatedata);
		
		
		$commisionmgmt=DB::table('commisionmgmt')
            ->join('users','users.id','commisionmgmt.userid')
			->select('commisionmgmt.*','users.name as name','users.email as email','users.password as password','users.original_password as original_password')
			->get();
				 
		//dd($commisionmgmt);		 
		//return view('AdminProfileView',compact('pagetitle','pageheading','commisionmgmt'));
		return redirect('AdminProfile')->with('success', 'Thanks for updating Entry');
		
    }   
	   
	
	

    public function AdminVendorProfilestore(Request $request){
       

        $businessname = $request->businessname;
        $refund = $request->refund;
        $address = $request->address;
        $description = $request->description;
        $whatsapp = $request->whatsapp;
        $moredetails = $request->moredetails;
        $state = $request->state;
        $business_category = $request->business_category;

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
        $closing_days = implode(",",$request->closing_days);

        

       

    }

    public function forgotpassword(request $request){

        $pagetitle = 'Forgot Password';
        $pageheading = 'Forgot Password';
        return view('forgotpassword',compact('pagetitle','pageheading'));
        
        }

        public function change_password(request $request){

            $request->validate([
                    //'c_password' => ['required', new MatchOldPassword],
                    'email' => ['required'],
                    'old_password' => ['required','min:6'],
                    'nw_password' => ['required','min:6'],
                    'cm_password' => ['required','min:6'],
                    //'cm_password' => ['same:password'],
            ],
            [            
                'email.required' => 'User ID/Email is required!',    
                'old_password.required' => 'Old Password is required!',
                'nw_password.required' => 'Password is required!',
                'cm_password.required' => 'Confirm Password is required!',
                
            ]);
          
             if($request->nw_password!=$request->cm_password)  
             {
                return back()->with("error", "New Password and Confrim Password Doesn't match!");
             } 
             else
             {
                
                
                    $userlist=DB::table('users')
                        ->Where('email',$request->email)
                        ->Where('original_password',$request->old_password)
                        ->Where('status','1')
                        ->select('users.*')
                        ->get();
		            $usercount = $userlist->count();
                   
                    
                    if($usercount>0)
                    {

                        $updatedata=array(
                            
                            'password'=>$request->nw_password,
                            'original_password'=>$request->nw_password,
                            
                        );
                        $updatedata['password'] = bcrypt($updatedata['password']);
                        $updtquery = DB::table('users')->where('email',$request->email)->update($updatedata);
                        return back()->with("status", "Password Change Successfully...");


                    }
                    else
                    {
                        return back()->with("error", "User not exists or wrong old password !...");  
                    }
                
                return back()->with("status", "Password Change SuccessFully.....");
                //return redirect()->back()->with('success','Password Change SuccessFully.....');
             }

               
           
            }


            public function get_order_counts($id)
            {

                $getsessioinid = Session::get('getsessionuserid');
                
                $id ;
                $id = $_GET['id'];
                $countdatavale=DB::table('booking_with_vendors')->where('booking_with_vendors.vendor_id',$getsessioinid)->count();
                $datavalue['count_value'] = $countdatavale;

                 $bookingdtls= DB::table('booking_with_vendors')
                            ->where('booking_with_vendors.vendor_id',$getsessioinid)
                            ->Where('booking_with_vendors.paystatus','Y')
                            ->select('booking_with_vendors.*')
                            ->orderBy('booking_with_vendors.booking_id','DESC')
                            ->get();
                
                $bookingcheckdetails = DB::table('booking_with_vendors')
                                      ->where('booking_with_vendors.vendor_id',$getsessioinid)
                                      ->where('booking_with_vendorsdetails.checkinstatus',1)
                                        ->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
                                        ->select('booking_with_vendorsdetails.*','booking_with_vendors.username','booking_with_vendors.mobileno','booking_with_vendors.paymethod')
                                        ->orderBy('booking_with_vendors.booking_id','DESC')
                                        ->get();

                        $htmlcontent = '';
                        $htmlcontent2 = '';

                        $htmlcontent .= '<table class="vendor table table-striped" border="0">
                                    <thead>
                                    <tr>
                                        <th scope="col">DATE</th>
                                        <th scope="col">TIME</th>
                                        <th scope="col">USER</th>
                                        <th scope="col">MOBILENO</th>
                                        <th scope="col">TOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>';
                                
                                    if(isset($bookingdtls))
                                    {
                                    if(count($bookingdtls) > 0)
                                    {
                                        foreach($bookingdtls as $bdtls)
                                        {
                                    
                                                $htmlcontent .= '<tr>
                                                    <td>'.\Carbon\Carbon::parse($bdtls->date)->format('d.m.Y').'</td>
                                                    <td>'.\Carbon\Carbon::parse($bdtls->created_at)->format('h.i a').'</td>
                                                    <td>'.$bdtls->username.'</td>
                                                    <td>'.$bdtls->mobileno.'</td>
                                                    <td>RM '.$bdtls->amount.'</td>
                                                    </tr>';
                                    
                                        }
                                    }
                                }
                                    
                          
                          
                        $htmlcontent2 .= '</tbody></table>';  
                
                

                        $htmlcontent2 .= '<table class="vendor table table-striped" border="0">
                                <thead>
                                <tr>
                                <th scope="col">DATE</th>
                                <th scope="col">CHECKIN TIME</th>
                                <th scope="col">SLOT TIME</th>
                                <th scope="col">MOBILENO</th>
                                <th scope="col">DESC</th>
                                </tr>
                                </thead>
                                <tbody>';
                            
                                if(isset($bookingcheckdetails))
                                {
                                if(count($bookingcheckdetails) > 0)
                                {
                                    foreach($bookingcheckdetails as $bdtls)
                                    {
                                
                                            $htmlcontent2 .= '<tr>
                                                <td>'.\Carbon\Carbon::parse($bdtls->date)->format('d.m.Y').'</td>
                                                <td>'.\Carbon\Carbon::parse($bdtls->created_at)->format('h.i a').'</td>
                                                <td>'.\Carbon\Carbon::parse($bdtls->stime)->format('h.i a').'</td>
                                                <td>'.$bdtls->mobileno.'</td>
                                                <td>'.$bdtls->courtname.'</td>
                                                </tr>';
                                
                                    }
                                }
                            }
                                
                                
                                
                        $htmlcontent2 .= '</tbody></table>'; 

                        $data = array();
                        $data[0] = $countdatavale;
                        $data[1] = $htmlcontent;
                        $data[2] = $htmlcontent2;
                        echo json_encode($data);
              }
    
}
