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

class EwalletlistController extends Controller
{
	
	 public function ewalletlist()
    {
        
        
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'EWallet Managment';
			$pageheading = 'EWallet Managment';
			
			$userdetails = User::select('users.*')
								->paginate(4);
								//->get();
					
			return view('EWalletUserList',compact('userdetails','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
    }
	
	
	public function editewallet(Request $request,$id)
    {
	
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'EWallet Managment';
			$pageheading = 'EWallet Managment';
			$pagesubheading = 'Edit EWallet';
			$userdetails=  DB::table('users')
								->where('id', $id)
								->get();
								
			return view('EwalletEdit',compact('pagetitle','pagesubheading','pageheading','userdetails'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
      	
	}
	
	public function updateewallet(Request $request,$id)
	  {
		

		$validatedData = $request->validate([            
           
            'wallet_amount' => 'required', 
			'mobile' => 'required', 
					
			
			
		],
        [            
            
			'wallet_amount.required' => 'wallet_amount is required!',
			'mobile.required' => 'Mobile no is required!',
			
			
        ]);
		
		
		$wallet_amount = $request->wallet_amount;
		
		$wallet_amountdata=array(
            'wallet_amount' => $wallet_amount,
			
         );
		
		$updtquery1 = DB::table('users')->where('id',$request->id)->update($wallet_amountdata);
		
		if( $updtquery1 ){
            
			
			return redirect('editewallet/'.''.$id)->with('success', 'Thanks for Updating E-wallet Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		  
	  }
	
	public function sortingewalletlist(Request $request,$id1,$id2)
    {
       
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'EWallet Managment';
			$pageheading = 'EWallet Managment';
			$txtserach = $id1; 
			$sorting = $id2;
			if($txtserach=='Search')
			{
			$userdetails = User::query()
						->orderBy('id',$sorting)
						->paginate(4);	
			}
			else
			{	
						
			$userdetails = User::where('name', 'LIKE', '%'.$txtserach.'%')
						  ->orWhere('email', 'LIKE', '%'.$txtserach.'%')
						  ->orWhere('mobile', 'LIKE', '%'.$txtserach.'%')
						  ->orderBy('id',$sorting)
						  ->paginate(4);			
						
			
			}			
			
			return view('EWalletUserList',compact('userdetails','pagetitle','pageheading','txtserach','sorting'));
		}
		else
		{ 
		   return redirect('/login');
		}

		
		
    }
	
	
	
	
	
   
}
