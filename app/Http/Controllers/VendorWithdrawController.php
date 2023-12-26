<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\withdrawals;
use App\Models\rightsmapping;
use App\Models\salesactivityvendorlogs;
use App\Models\userdetailmanage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class VendorWithdrawController extends Controller
{
   
  
    public function vendorwithdrawallist()
    {
		$getsessionuserid= session()->get('getsessionuserid');
   
        $pagetitle = 'Withdrawal Managment';
        $pageheading = 'Withdrawal Managment';
       	
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

		
        $withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							->where('users.id', $getsessionuserid)
							//->where('reportflag', 'N')
							->select('withdrawals.*','users.name as name','users.role as role','users.wallet_amount as wallet_amount')
							->orderBy('withdrawals.withdrawal_id','ASC')
							->paginate(4);
			
			
        return view('VendorWithdrawalList',compact('withdrawaldetails','pagetitle','pageheading'));
    }
	
	
	/*public function vendorapprovewithdrwanrequest(Request $request, $id)
    {
       
		$getsessionuserid= session()->get('getsessionuserid');
		$pagetitle = 'Withdrawal Managment';
        $pageheading = 'Withdrawal Managment';
        $wapproved = DB::table('withdrawals')->Where('withdrawal_id',$id)->Update(['withdrawal_status'=>2]);
		$withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							->where('users.id', $getsessionuserid)
							->select('withdrawals.*','users.name as name','users.role as role')
							->orderBy('withdrawals.withdrawal_id','DESC')
							->paginate(4);
		return view('VendorWithdrawalList',compact('withdrawaldetails','pagetitle','pageheading'));
    }
	public function vendorrejectewithdrwanrequest(Request $request, $id)
    {
       
		$getsessionuserid= session()->get('getsessionuserid');
		$pagetitle = 'Withdrawal Managment';
        $pageheading = 'Withdrawal Managment';
        $wapproved = DB::table('withdrawals')->Where('withdrawal_id',$id)->Update(['withdrawal_status'=>3]);
		$withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							->where('users.id', $getsessionuserid)
							->select('withdrawals.*','users.name as name','users.role as role')
							->orderBy('withdrawals.withdrawal_id','DESC')
							->paginate(4);
		return view('VendorWithdrawalList',compact('withdrawaldetails','pagetitle','pageheading'));
    }*/
	
	
	public function vendordeletewithdrawal(Request $request,$id)
    {
		$getsessionuserid= session()->get('getsessionuserid');
		$pagetitle = 'Withdrawal Managment';
        $pageheading = 'Withdrawal Managment';
		$delwithdral = DB::table('withdrawals')->where('withdrawal_id', $id)->delete();			
		//$delwithdral1 = DB::table('salesactivityvendorlogs')->where('withdrawal_id', $id)->delete();
		
		$withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							->where('users.id', $getsessionuserid)
							//->where('reportflag', 'N')
							->select('withdrawals.*','users.name as name','users.role as role','users.wallet_amount as wallet_amount')
							->orderBy('withdrawals.withdrawal_id','ASC')
							->paginate(4);
		return view('VendorWithdrawalList',compact('withdrawaldetails','pagetitle','pageheading'));
	}	
	
	
	public function vendoraddrequestwithdrawal(Request $request,$id)
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




		$validatedData = $request->validate([            
           
            'wallet_amount' => 'required', 
			'withdrawal_amount' => 'required',
			'withdrawal_amount' => 'required_with:wallet_amount|numeric|lt:wallet_amount'			
			
			
		],
        [            
            
			'wallet_amount.required' => 'wallet_amount is required!',
			'withdrawal_amount.required' => 'withdrawal_amount is required!',
			
        ]);
		
		$data=array(
            'withdrawal_status' => '1',
			'user_id' => $getsessionuserid,
			'bankname' => $request->bankname,
			'bankacno' => $request->bankacno,
			'bankaccountname' => $request->bankaccountname,
			'wallet_amount' => $request->wallet_amount,
			'withdrawal_amount' => $request->withdrawal_amount,
			
            
        );
		
		
		
		
		$inserterequest = withdrawals::insertGetId($data);
		
		/*$data1=array(
            'withdrawal_id' => $inserterequest,
			'withdrawal_status' => '1',
			'user_id' => $getsessionuserid,
			'description' => 'Withdrawal',
			'request' => 'Withdrawal Request',
			'amount' => $request->withdrawal_amount
			
        );*/
		
		//$inserterequest1 = salesactivityvendorlogs::insertGetId($data1);
		
		if( $inserterequest ){
            
			
			return redirect('vendoraddwithdrawal')->with('success', 'Thanks for add withdrawals Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		  
	  }
	
	
	public function vendorupdatewithdrawal(Request $request,$id)
	  {
		
		$getsessioinid = Session::get('getsessionuserid');	
		$validatedData = $request->validate([            
           
            'wallet_amount' => 'required', 
			'withdrawal_amount' => 'required',
			'withdrawal_amount' => 'required_with:wallet_amount|numeric|lt:wallet_amount|min:2|digits_between:1,5'			
			
			
		],
        [            
            
			'wallet_amount.required' => 'wallet_amount is required!',
			'withdrawal_amount.required' => 'withdrawal_amount is required!',
			
        ]);
		
		
		//$wallet_amount = $request->wallet_amount - $request->withdrawal_amount;
		
		$wallet_amountdata=array(
            'wallet_amount' => $request->withdrawal_amount
         );
		
		$data=array(
            'withdrawal_status' => '1',
			'bankname' => $request->bankname,
			'bankacno' => $request->bankacno,
			'bankaccountname' => $request->bankaccountname,
			'withdrawal_amount' => $request->withdrawal_amount,

        );
		
		$data1=array(
            'amount' => $request->withdrawal_amount,
        );

		$updtquery2 = DB::table('withdrawals')->where('withdrawal_id',$id)->update($data);
		
		return redirect('vendoreditwithdrawal/'.''.$id)->with('success', 'Thanks for Updating withdrawals Entry');
		
		/*$deletedatainsertreport = DB::table('withdrawals')->where('user_id', '=',$getsessioinid)->where('bookingno', '=',$request->bookingno)->where('reportflag', '=','Y')->delete();
		$datainsertreport=array(
            'withdrawal_status' => '1',
			'bankname' => $request->bankname,
			'bankacno' => $request->bankacno,
			'bankaccountname' => $request->bankaccountname,
			'withdrawal_amount' => $request->withdrawal_amount,
			'bookingno' => $request->bookingno,
			'onlinesales' => $request->onlinesales,
			'countersales' => $request->countersales,
			'vouchersales' => $request->vouchersales,
			'admin_commision' => $request->admin_commision,
			'user_id'=>$getsessioinid,
			'reportflag'=>'Y',
		);

		$inserterequest1 = withdrawals::insertGetId($datainsertreport);*/

		
		//*$updtquery1 = DB::table('users')->where('id',$request->withdrawaluserid)->update($wallet_amountdata);*/
		
		

		/*if( $updtquery2 ){
            
			
			return redirect('vendoreditwithdrawal/'.''.$id)->with('success', 'Thanks for Updating withdrawals Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }*/
		  
	  }
	  
	
	public function vendoreditwithdrawal(Request $request,$id)
    {
	
		$pagetitle = 'Withdrawal Managment';
        $pageheading = 'Withdrawal Managment';
        $pagesubheading = 'Edit Withdrawal';
	
		
		$withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							->where('withdrawal_id', $id)
							//->where('reportflag', 'N')
							->select('withdrawals.*','users.name as name','users.wallet_amount as wallet_amount','users.id as withdrawaluserid')
							->get();
							
		return view('VendorWithdrawalEdit',compact('pagetitle','pagesubheading','pageheading','withdrawaldetails'));
      	
	}
	
	public function vendoraddwithdrawal(Request $request)
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
			$pagetitle = 'Withdrawal Management';
			$pageheading = 'Withdrawal Management';
			$pagesubheading = 'Add Withdrawal';
		
			
			/*$withdrawaldetails=  DB::table('withdrawals')
								->join('users','users.id','withdrawals.user_id')
								->where('withdrawal_id', $getsessionuserid)
								->select('withdrawals.*','users.name as name','users.wallet_amount as wallet_amount','users.id as withdrawaluserid')
								->get();*/
			$withdrawaldetails=  DB::table('users')
								->where('id', $getsessionuserid)
								->select('users.*')
								->get();	
								
								
			return view('VendorWithdrawalAdd',compact('pagetitle','pagesubheading','pageheading','withdrawaldetails'));
		}
		else
		{ 
		   return redirect('/login');
		}


		
      	
	}
	
	public function vendorsortingwithdrawallist(Request $request,$id1,$id2)
    {
       $getsessionuserid= session()->get('getsessionuserid');
	   if($getsessionuserid)
		{
			  
				$pagetitle = 'Withdrawal Managment';
				$pageheading = 'Withdrawal Managment';
				$txtserach = $id1; 
				$sorting = $id2;
				
				if($txtserach=='Search')
				{
			
							
				$withdrawaldetails=  DB::table('withdrawals')
									->join('users','users.id','withdrawals.user_id')
									->where('users.id', $getsessionuserid)
									//->where('reportflag', 'N')
									->select('withdrawals.*','users.name as name','users.role as role','users.wallet_amount as wallet_amount')
									->orderBy('withdrawals.withdrawal_id',$sorting)
									->paginate(4);				
				}
				else
				{	
				//DB::enableQueryLog();
				
							
				
							
				$withdrawaldetails=  DB::table('withdrawals')
									->join('users','users.id','withdrawals.user_id')
									->where('users.name', 'LIKE', '%'.$txtserach.'%')
									->where('users.id', $getsessionuserid)
									//->where('reportflag', 'N')
									->select('withdrawals.*','users.name as name','users.role as role','users.wallet_amount as wallet_amount')
									->orderBy('withdrawals.withdrawal_id',$sorting)
									->paginate(4);			
				
				//$quries = DB::getQueryLog();
				//dd($quries);
				}			
				
				return view('VendorWithdrawalList',compact('withdrawaldetails','pagetitle','pageheading','txtserach','sorting'));
           
		}
		else
		{ 
		   return redirect('/login');
		}

       
    }
	
	
	
	
	
	
	
	
   
}
