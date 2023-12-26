<?php

namespace App\Http\Controllers;

use App\Models\state;
use App\Models\refunds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;

class RefundPolicyController extends Controller
{
  
    
	public function deleterefundpolicy(Request $request, $id )
    {
        
			$pagetitle = 'Refund Policy';
			$pageheading = 'Refund Policy';
			$pagebutton = 'Refund Policy';
				
		$delcategoryxists = DB::table('refunds')->where('id', $id)->delete();
		
        $statelist = DB::table('refunds')->paginate(4);				
						
						
        return view('RefundDetailList',compact('statelist','pagetitle','pageheading'));
						
		
		
    }



	public function refundpolicyedit(Request $request, $id )
    {
        
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Refund Policy';
			$pageheading = 'Refund Policy';
			$pagebutton = 'Refund Policy';
		
		$statelist=DB::table('refunds')
				->Where('id',$id)
				->select('refunds.*')
				 ->get();			 
					
        return view('RefundEdit',compact('pagetitle','pageheading','statelist'));
		}
		else
		{ 
		   return redirect('/login');
		}

			
    }
	
	 public function refundpolicyeditupdate(Request $request,$id)
	  {
		

		$name = $request->input('name');
		$refund = $request->input('refund');
		$data=array(
            'name' => $name,
			'refund' => $refund,
            'status' => '1',
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
		
		$updtquery = DB::table('refunds')->where('id',$id)->update($data);

		if( $updtquery ){
            
			return redirect('refundpolicy')->with('success', 'Thanks for Updating Refund Policy Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		  
	  }

	public function refundpolicy()
		{
			$getsessioinid = Session::get('getsessionuserid');
			if($getsessioinid)
			{
				$pagetitle = 'Refund Policy';
				$pageheading = 'Refund Policy';
				$pagebutton = 'Refund Policy';
				return view('RefundList',compact('pagetitle','pageheading'));
			}
			else
			{ 
			return redirect('/login');
			}
			
			
		}	

		public function refundpolicylist(Request $request)
		{
			$getsessioinid = Session::get('getsessionuserid');
			if($getsessioinid)
			{
				$pagetitle = 'Refund Policy';
				$pageheading = 'Refund Policy';
				$pagebutton = 'Refund Policy';
					
				$statelist = DB::table('refunds')->paginate(4);				
								
								
				return view('RefundDetailList',compact('statelist','pagetitle','pageheading'));
			}
			else
			{ 
			return redirect('/login');
			}

			
		}
		
		
	  public function refundsstore(Request $request)
       {
       
	   $validatedData = $request->validate([            
           
            'name' => 'required', 
			'refund' => 'required', 
		],
        [            
            
			'name.required' => 'Refund Policy Description is required!',
			'refund.required' => 'Refund Policy Hours is required!',
			
        ]);
       
	 

        $data=array(
            'name' => $request->name,
			'refund' => $request->refund,
			'status' => '1',
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );        
        
		if( refunds::insert($data) ){
            
			return redirect('refundpolicy')->with('success', 'Thanks for submitting State refundpolicy');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		
    }
	

   
}
