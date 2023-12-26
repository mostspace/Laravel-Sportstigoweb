<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\withdrawals;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use App\Models\salesactivityvendorlogs;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use DB;

class WithdrawController extends Controller
{
   
    public function withdrawallist()
    {

        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Withdrawal Managment';
			$pageheading = 'Withdrawal Managment';
					   
			$withdrawaldetails=  DB::table('withdrawals')
								->join('users','users.id','withdrawals.user_id')
								//->where('reportflag', 'N')
								->select('withdrawals.*','users.name as name','users.role as role','users.wallet_amount as wallet_amount')
								->orderBy('withdrawals.withdrawal_id','ASC')
								->paginate(4);
				
				
			return view('WithdrawalList',compact('withdrawaldetails','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
    }
	
	
	public function approvewithdrwanrequest(Request $request, $id)
    {
       
		
		
        $wapproved = DB::table('withdrawals')->Where('withdrawal_id',$id)->Update(['withdrawal_status'=>2]);
		
		
		$withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							//->where('reportflag', 'N')
							->select('withdrawals.*','users.name as name','users.role as role','users.wallet_amount as wallet_amount')
							->orderBy('withdrawals.withdrawal_id','ASC')
							->paginate(4);
		
	return view('WithdrawalList',compact('withdrawaldetails','pagetitle','pageheading'));
		
		
		
		
    }
	
	
	public function deletewithdrawal(Request $request,$id)
    {
		$pagetitle = 'Withdrawal Managment';
        $pageheading = 'Withdrawal Managment';
		$delwithdral = DB::table('withdrawals')->where('withdrawal_id', $id)->delete();			
		//$delwithdral1 = DB::table('salesactivityvendorlogs')->where('withdrawal_id', $id)->delete();			
		
		$withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							//->where('reportflag', 'N')
							->select('withdrawals.*','users.name as name','users.role as role','users.id as id'.'users.wallet_amount as wallet_amount')
							->orderBy('withdrawals.withdrawal_id','ASC')
							->paginate(4);
		return view('WithdrawalList',compact('withdrawaldetails','pagetitle','pageheading'));
	}	
	
	
	public function updatewithdrawal(Request $request,$id)
	  {
		
		
		$getsessioinid = Session::get('getsessionuserid');		
		$validatedData = $request->validate([            
           
            'wallet_amount' => 'required', 
			'withdrawal_amount' => 'required',
			//'withdrawal_amount' => 'required_with:wallet_amount|numeric|lt:wallet_amount|min:2|digits_between:1,5'			
			'withdrawal_amount' => 'required_with:wallet_amount|numeric|lt:wallet_amount'			
			
			
		],
        [            
            
			'wallet_amount.required' => 'wallet_amount is required!',
			'withdrawal_amount.required' => 'withdrawal_amount is required!',
			
        ]);
		
		
		$wallet_amount = $request->wallet_amount - $request->withdrawal_amount;
		
		
		$wallet_amountdata=array(
            'wallet_amount' => $wallet_amount
         );

		 $earning_amountdata=array(
            'earning' => $wallet_amount,
			//'wallet_amount' => $request->withdrawal_amount
         );
		
		$data=array(
            'withdrawal_status' => '2',
			'withdrawal_amount' => $request->withdrawal_amount,
			'balance' => $wallet_amount,
			'reportflag'=> 'Y',
           
        );
		
		

		$data1=array(
            'amount' => $request->withdrawal_amount,
			'withdrawal_status' => '2',
        );
		
		if($request->userrole==4)
		{
			
			
			$updtquery1 = DB::table('users')->where('id',$request->withdrawaluserid)->update($earning_amountdata);

			
		}
		else
		{
			$updtquery1 = DB::table('users')->where('id',$request->withdrawaluserid)->update($wallet_amountdata);
		}
		
		
		$updtquery2 = DB::table('withdrawals')->where('withdrawal_id',$id)->update($data);

		$updtqueryreport = DB::table('withdrawals')->where('bookingno',$request->bookingno)->update($data);

		
		
		return redirect('editwithdrawal/'.''.$id)->with('success', 'Thanks for Updating withdrawals Entry');
		  
	  }

	  
	  public function rejectewithdrwanrequest(Request $request, $id)
    {
       
		$pagetitle = 'Withdrawal Managment';
        $pageheading = 'Withdrawal Managment';
		
      
		$getwithdrawaluserlist = DB::table('withdrawals')->select('withdrawals.user_id as user_id','withdrawals.wallet_amount as wallet_amount','withdrawals.withdrawal_amount as withdrawal_amount')->where('withdrawal_id',$id)->get();
		$getexitwithdrawaluserid = $getwithdrawaluserlist[0]->user_id;
	    $getexitwithdrawalwallet_amount= $getwithdrawaluserlist[0]->wallet_amount;
		$getexitwithdrawalwithdrawal_amount= $getwithdrawaluserlist[0]->withdrawal_amount;
		
		$getexistrolelist = DB::table('users')->select('users.role as role')->where('id',$getexitwithdrawaluserid)->get();
		$getuserrole = $getexistrolelist[0]->role;

		if($getuserrole==4)
		{
			$exituserwalleramountlist = DB::table('users')->select('users.earning')->where('id',$getexitwithdrawaluserid)->get();
			$exituserearning = $exituserwalleramountlist[0]->earning;
			$finalupdatewalletamt = $getexitwithdrawalwithdrawal_amount + $exituserearning;
			$finalupdatewalletamt = $finalupdatewalletamt - $getexitwithdrawalwithdrawal_amount;
			DB::table('users')->Where('id',$getexitwithdrawaluserid)->Update(['earning'=>$finalupdatewalletamt]);
		}
		if($getuserrole!==4)
		{
			
			$exituserwalleramountlist = DB::table('users')->select('users.wallet_amount as wallet_amount')->where('id',$getexitwithdrawaluserid)->get();
			$exituserwalleramount = $exituserwalleramountlist[0]->wallet_amount;
			$finalupdatewalletamt = $getexitwithdrawalwithdrawal_amount + $exituserwalleramount;
			$finalupdatewalletamt = $finalupdatewalletamt - $getexitwithdrawalwithdrawal_amount;
			
			DB::table('users')->Where('id',$getexitwithdrawaluserid)->Update(['wallet_amount'=>$finalupdatewalletamt]);

				
		}
		

		$updadata=array(
            'withdrawal_status' => '3',
			'balance' => '0',
			'reportflag' => 'N',
			
        );

		$wapproved = DB::table('withdrawals')->Where('withdrawal_id',$id)->Update($updadata);
		
		$withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							//->where('reportflag', 'N')
							->select('withdrawals.*','users.name as name','users.role as role','users.wallet_amount as wallet_amount')
							->orderBy('withdrawals.withdrawal_id','ASC')
							->paginate(4);

		return view('WithdrawalList',compact('withdrawaldetails','pagetitle','pageheading'));
    }
	
	
	public function editwithdrawal(Request $request,$id)
    {
	
		$pagetitle = 'Withdrawal Managment';
        $pageheading = 'Withdrawal Managment';
        $pagesubheading = 'Edit Withdrawal';
	
		
		$withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							->where('withdrawal_id', $id)
							//->where('reportflag', 'N')
							->select('withdrawals.*','users.name as name','users.wallet_amount as wallet_amount','users.role as role','users.earning as earning','users.id as withdrawaluserid')
							->get();
							
		return view('WithdrawalEdit',compact('pagetitle','pagesubheading','pageheading','withdrawaldetails'));
      	
	}
	
	public function sortingwithdrawallist(Request $request,$id1,$id2,$id3)
    {
       
        
		
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Withdrawal Managment';
        $pageheading = 'Withdrawal Managment';
        $txtserach = $id1; 
		$sorting = $id2;
		$utype = $id3;
		
		if($txtserach=='Search')
		{
	
					  
		$withdrawaldetails=  DB::table('withdrawals')
							->join('users','users.id','withdrawals.user_id')
							->where('users.role', $utype)
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
							->where('users.role', $utype)
							//->where('reportflag', 'N')
							->select('withdrawals.*','users.name as name','users.role as role','users.wallet_amount as wallet_amount')
							->orderBy('withdrawals.withdrawal_id',$sorting)
							->paginate(4);			
		
		//$quries = DB::getQueryLog();
		//dd($quries);
		}			
		
        return view('WithdrawalList',compact('withdrawaldetails','pagetitle','pageheading','txtserach','sorting','utype'));
           
		}
		else
		{ 
		   return redirect('/login');
		}
		
		
    }
	
	
	
	
	
	
	
	
   
}
