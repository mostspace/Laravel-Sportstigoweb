<?php

namespace App\Http\Controllers;

use App\Models\voucher;
use App\Models\User;
use App\Models\vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;



class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
    public function index()
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
			
			
			$pagetitle = 'Voucher';
			$pageheading = 'Voucher';
			
			$pagesubheading = '';
			
				/*$vouchercode = DB::table('vouchers')->max('voucher_code');
				if($vouchercode==null)
				{
					$vouchercode = '10000'; 
				}
				else		 
				{
					$vouchercode = $vouchercode + 1;
				}*/
			   
				$randomNumber = rand();
				$vouchercode = $randomNumber;
				
				$checkexistvouchercode = DB::table('vouchers')
										->where('voucher_code', '=', $vouchercode)
										->select('vouchers.voucher_code')
										->get()->count();
				
				if($checkexistvouchercode==1)
				{
					$randomNumber = rand();
				    $vouchercode = $randomNumber;
				}
				

				
				$allvoucherlist=DB::table('vouchers')
				->where('createdby', '=', $getsessioinid)
				->select('vouchers.*')
				->orderBy('vouchers.id','DESC')
				->get();
				
				
				
			   $allvendorlist=DB::table('vendors')
				->where('status', '=', 1)
				->select('vendors.*')
				->get();		
			
			return view('VoucherList',compact('pagetitle','pageheading','pagesubheading','vouchercode','allvoucherlist','allvendorlist'));
		}
		else
		{ 
		   return redirect('/login');
		   
		}
		
		
    }
	
	
	public function saverequestvoucher( Request $request )
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



		
		$validatedData = $request->validate([            
           
            'voucher_date' => 'required', 
            'voucher_code' => 'required',   
			'voucher_from_date' => 'required', 
            'voucher_to_date' => 'required',
			'voucher_discount' => 'required',
			'voucher_type' => 'required',
			'amount' => 'required',
			//'voucher_is_expired_date' => 'accepted',
			'voucher_from_date'    => 'required|date',
			'voucher_to_date'      => 'required|date|after:voucher_from_date',
                     
        ],
        [            
            
			'voucher_type.required' => 'Type Of Voucher is required!',			
            'voucher_date.required' => 'Voucher date is required!',
			'voucher_code.required' => 'Generate Voucher code is required!',            
			'voucher_from_date.required' => 'Voucher from date is required!',            
			'voucher_to_date.required' => 'Voucher to date is required!',
			'voucher_discount.required' => 'Discount is required!',
			'amount.required' => 'Amount is required!',
			
        ]);
		
		
		if($request->has('voucher_is_expired_date')){
          $voucher_is_expired_date = 1;  
        }else{
           $voucher_is_expired_date = 0;   
        }
		
	
		$voucher_type = $request->input('voucher_type');
		
		if($voucher_type=='allvendor')
		{
			
			$voucher_applicable = 1;
			$vendor_code = '';
			
			$data=array(
            'voucher_date' => $request->input('voucher_date'),
			'voucher_code' => $request->input('voucher_code'),
			'voucher_from_date' => $request->input('voucher_from_date'),
			'voucher_to_date' => $request->input('voucher_to_date'),
			'voucher_total_usage' => $request->input('voucher_total_usage'),
			'voucher_discount' => $request->input('voucher_discount'),
			'amount' => $request->input('amount'),
			'voucher_applicable' => $voucher_applicable,
			'status'=>'1',
			'vendor_code'=>'',
			'createdby'=>$getsessioinid, 
			'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
             );
			
			$insertedId = voucher::insertGetId($data);
			
			
			
		}
		else if($voucher_type=='loginvendor')
		{
			$voucher_applicable = 3;

			
			
			$data=array(
            'voucher_date' => $request->input('voucher_date'),
			'voucher_code' => $request->input('voucher_code'),
			'voucher_from_date' => $request->input('voucher_from_date'),
			'voucher_to_date' => $request->input('voucher_to_date'),
			'voucher_total_usage' => $request->input('voucher_total_usage'),
			'voucher_discount' => $request->input('voucher_discount'),
			'amount' => $request->input('amount'),
			'voucher_applicable' => $voucher_applicable,
			'status'=>'1',
			'vendor_code'=>$getsessioinid,
			'createdby'=>$getsessioinid, 
			'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
             );
			
			$insertedId = voucher::insertGetId($data);
			
			
		}
		else
		{
			
			
			$voucher_applicable = 2;
			//$vendor_code = json_encode($request->input('vendor_name'));
			
			$vendor_code =  $request->input('vendor_name', []);
		
			$i = 1;
			foreach ($vendor_code as $index => $unit) 
			{
				$data=array(
				 'voucher_date' => $request->input('voucher_date'),
				'voucher_code' => $request->input('voucher_code'),
				'voucher_from_date' => $request->input('voucher_from_date'),
				'voucher_to_date' => $request->input('voucher_to_date'),
				'voucher_total_usage' => $request->input('voucher_total_usage'),
				'voucher_discount' => $request->input('voucher_discount'),
				'amount' => $request->input('amount'),
				'voucher_applicable' => $voucher_applicable,
				'status'=>'1',
				'vendor_code'=>$vendor_code[$index],
				'createdby'=>$getsessioinid, 
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' =>  date("Y-m-d H:i:s"),
				 );
				
				
			$i++;
			$insertedId = voucher::insertGetId($data);		
			}
			
		
			
		}
	    
		/*$voucher_date = $request->input('voucher_date');
		$voucher_code = $request->input('voucher_code');
		$voucher_from_date = $request->input('voucher_from_date');
		$voucher_to_date = $request->input('voucher_to_date');
		$voucher_total_usage = $request->input('voucher_total_usage');
		$voucher_discount = $request->input('voucher_discount');
		$amount = $request->input('amount');
		
		$voucher = new voucher();
		$voucher->voucher_applicable = $voucher_applicable;
		$voucher->status = 1;
		$voucher->voucher_date = $voucher_date;
		$voucher->voucher_code = $voucher_code;
		$voucher->voucher_from_date = $voucher_from_date;
		$voucher->voucher_to_date = $voucher_to_date;
		$voucher->voucher_is_expired_date = $voucher_is_expired_date;
		$voucher->voucher_total_usage = $voucher_total_usage;
		$voucher->voucher_discount = $voucher_discount;
		$voucher->vendor_code = $vendor_code;
		$voucher->amount = $amount;*/
		
		
		/*if( $voucher->save() ){
            
			return redirect('voucher')->with('success', 'Thanks for submitting Voucher Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }*/
		
		return redirect('voucher')->with('success', 'Thanks for submitting Voucher Entry');
		
	}
	
	
	
	public function voucherdelete(Request $request, $id )
    {
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
				$pagetitle = 'Voucher';
				$pageheading = 'Voucher';
				
				$pagesubheading = '';
				
				$delvoucherxists = DB::table('vouchers')->where('id', $id)->delete();
				
				$vouchercode = DB::table('vouchers')->max('voucher_code');
					if($vouchercode==null)
					{
						$vouchercode = '10000'; 
					}
					else		 
					{
						$vouchercode = $vouchercode + 1;
					}
				
					
				$allvoucherlist=DB::table('vouchers')
						->where('createdby', '=', $getsessioinid)
						->select('vouchers.*')
						->orderBy('vouchers.id','DESC')
						->get();
					
					
					
				$allvendorlist=DB::table('vendors')
					->where('status', '=', 1)
					->select('vendors.*')
					->get();
					return view('VoucherList',compact('pagetitle','pageheading','pagesubheading','vouchercode','allvoucherlist','allvendorlist'));

		  }
		  	else
			{ 
			return redirect('/login');
			
			}
			
		
		
		
		
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(voucher $voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, voucher $voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(voucher $voucher)
    {
        //
    }
}
