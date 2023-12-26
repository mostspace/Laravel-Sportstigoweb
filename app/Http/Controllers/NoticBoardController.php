<?php

namespace App\Http\Controllers;

use App\Models\voucher;
use App\Models\vendor;
use App\Models\User;
use App\Models\noticeboards;
use Illuminate\Http\Request;
use DB;

use Session;

class NoticBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	
	public function noticboard()
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
			$pagetitle = 'Send Message';
			$pageheading = 'Contact Us';
			$pagesubheading = 'Send Message';
			
			$allvendorlist=DB::table('vendors')
				->where('status', '=', 1)
				->select('vendors.*')
				->get();
			
			return view('Noticboard',compact('pagetitle','pagesubheading','pageheading','allvendorlist'));
		}
		else
		{ 
		   return redirect('/login');
		}


		
		
		
	  
	}  
	
	
     public function noticlist()
    {
		
		$pagetitle = 'NOTICE LIST';
		$pageheading = 'NOTICE LIST';

		$getsessioinid = Session::get('getsessionuserid');
		$getsessioinrole = Session::get('getsessionrole');
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



		if($getsessioinrole==1)
		{
			
			//$noticdetails = noticeboards::select('noticeboards.*')->paginate(4);
			$noticdetails	= DB::table('noticeboards')
			->join('users','users.id','noticeboards.createdby')
			->select('noticeboards.notice_id','noticeboards.title','noticeboards.message','noticeboards.vendor_id','noticeboards.vendortype','noticeboards.created_at','noticeboards.messagesendto','users.name as createdby')
			->paginate(4);

			return view('NoticList',compact('noticdetails','pagetitle','pageheading'));

		}
		if($getsessioinrole==3)
		{
			/*$noticdetails = noticeboards::select('noticeboards.*')
			->where('createdby', '=', $getsessioinid)
			->orwhere('vendor_id', '=', $getsessioinid)
			->paginate(4);*/
			
			
			$noticdetails	= DB::table('noticeboards')
							->join('users','users.id','noticeboards.createdby')
							->where('noticeboards.createdby',$getsessioinid)
							->orwhere('noticeboards.vendor_id', '=', $getsessioinid)
							->select('noticeboards.notice_id','noticeboards.title','noticeboards.message','noticeboards.vendor_id','noticeboards.vendortype','noticeboards.created_at','noticeboards.messagesendto','users.name as createdby')
							->paginate(4);

			
		
			return view('NoticList',compact('noticdetails','pagetitle','pageheading'));

		}
		if($getsessioinrole==6)
		{
			/*$noticdetails = noticeboards::select('noticeboards.*')
			->where('createdby', '=', $getsessioinid)
			->orwhere('vendor_id', '=', $getsessioinid)
			->paginate(4);*/

			$noticdetails	= DB::table('noticeboards')
							->join('users','users.id','noticeboards.createdby')
							->where('noticeboards.createdby',$getsessioinid)
							->orwhere('noticeboards.vendor_id', '=', $getsessioinid)
							->select('noticeboards.notice_id','noticeboards.title','noticeboards.message','noticeboards.vendor_id','noticeboards.vendortype','noticeboards.created_at','noticeboards.messagesendto','users.name as createdby')
							->paginate(4);


			return view('NoticList',compact('noticdetails','pagetitle','pageheading'));

		}
		if($getsessioinrole==7)
		{
			/*$noticdetails = noticeboards::select('noticeboards.*')
			->where('createdby', '=', $getsessioinid)
			->orwhere('vendor_id', '=', $getsessioinid)
			->paginate(4);*/

			$noticdetails	= DB::table('noticeboards')
							->join('users','users.id','noticeboards.createdby')
							->where('noticeboards.createdby',$getsessioinid)
							->orwhere('noticeboards.vendor_id', '=', $getsessioinid)
							->select('noticeboards.notice_id','noticeboards.title','noticeboards.message','noticeboards.vendor_id','noticeboards.vendortype','noticeboards.created_at','noticeboards.messagesendto','users.name as createdby')
							->paginate(4);


			return view('NoticList',compact('noticdetails','pagetitle','pageheading'));

		}


		else
		{ 
		   return redirect('/login');
		}

		dd($getsessioinrole);




		
		

        
    }
	
	
	public function sortingnoticlist(Request $request,$id1,$id2)
    {
       
		$pagetitle = 'NOTICE LIST';
        $pageheading = 'NOTICE LIST';
        $txtserach = $id1; 
		$sorting = $id2;
		$getsessioinid = Session::get('getsessionuserid');
		$getsessioinrole = Session::get('getsessionrole');
		//dd($txtserach,$sorting);
		
		if($getsessioinrole==1)
		{
		
			if($txtserach=='Search')
				{
				$noticdetails = noticeboards::query()
								->orderBy('notice_id',$sorting)
								->paginate(4);	
				}
				else
				{
							$noticdetails = noticeboards::where('title', 'LIKE', '%'.$txtserach.'%')
							->orWhere('message', 'LIKE', '%'.$txtserach.'%')
							->orderBy('notice_id',$sorting)
							->paginate(4);			
				}

				return view('NoticList',compact('noticdetails','pagetitle','pageheading','txtserach','sorting'));
		}
		if($getsessioinrole==3)
		{
			
			
			if($txtserach=='Search')
				{
				$noticdetails = noticeboards::query()
							->where('createdby', '=', $getsessioinid)
							->orwhere('vendor_id', '=', $getsessioinid)
							->orderBy('notice_id',$sorting)
							->paginate(4);	
				}
				else
				{
					$noticdetails = noticeboards::where('title', 'LIKE', '%'.$txtserach.'%')
					->orWhere('message', 'LIKE', '%'.$txtserach.'%')
					->orwhere('vendor_id', '=', $getsessioinid)
					->where('createdby', '=', $getsessioinid)
					->orderBy('notice_id',$sorting)
					->paginate(4);	
						
				}
			return view('NoticList',compact('noticdetails','pagetitle','pageheading','txtserach','sorting'));

		}
		else
		{

			return redirect('/login');
		}


		}			
		
		
	public function saverequestnotice( Request $request )
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
           
            'title' => 'required', 
            'subject' => 'required',
			'voucher_type' => 'required',			
		],
        [            
            
			'title.required' => 'Title is required!',			
            'subject.required' => 'Message is required!',
			'voucher_type.required' => 'Vendor Selection is required!',
			
        ]);
		
		
		$vendor_type = $request->input('voucher_type');
		
		
		if($vendor_type=='allvendor')
		{
			$voucher_applicable = 1;
			$vendor_code = '';
			
			$data=array(
            'title'=>$request->title,
            'message'=>$request->subject,
			'vendortype'=>$vendor_type,
			'messagesendto'=> 'All Vendor',
            'vendor_id'=>$vendor_code,
			'createdby'=>$getsessioinid, 
			'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
             );
			
			$insertedId = noticeboards::insertGetId($data);
		}
		else if($vendor_type=='admin')
		{
			$voucher_applicable = 1;
			$vendor_code = '';
			
			$data=array(
            'title'=>$request->title,
            'message'=>$request->subject,
			'vendortype'=>$vendor_type,
            'vendor_id'=>'1',
			'messagesendto'=>'Admin',
			'createdby'=>$getsessioinid, 
			'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
             );
			
			$insertedId = noticeboards::insertGetId($data);
		}
		else
		{
			$voucher_applicable = 2;
			//$vendor_code = json_encode($request->input('vendor_name'));
			
			$vendor_code =  $request->input('vendor_name', []);
		
			$i = 1;
			foreach ($vendor_code as $index => $unit) 
			{
				
				
				$vnamelist =  DB::table('vendors')
						 ->where('vendors.vendor_id',$vendor_code[$index])
						 ->select('vendors.businessname')
						 ->first();
				
				
				$data=array(
				'title'=>$request->title,
				'message'=>$request->subject,
				'vendortype'=>$vendor_type,
				'vendor_id'=>$vendor_code[$index],
				'messagesendto'=>$vnamelist->businessname,
				'createdby'=>$getsessioinid, 
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' =>  date("Y-m-d H:i:s"),
				 );
				
				
			$i++;
			$insertedId = noticeboards::insertGetId($data);		
			}
			
		}
		
	    
        
		//$insertedId = noticeboards::insertGetId($data);
       
		return redirect('noticboard')->with('success', 'Thanks for submitting Notice Entry');
		
	}
	
	public function savereditequestnotice(Request $request,$id)
    {
		
		$validatedData = $request->validate([            
           
            'title' => 'required', 
            'subject' => 'required',
			'voucher_type' => 'required',			
		],
        [            
            
			'title.required' => 'Title is required!',			
            'subject.required' => 'Message is required!',
			'voucher_type.required' => 'Vendor Selection is required!',
			
        ]);
		
		
		$vendor_type = $request->input('voucher_type');
		
		
		if($vendor_type=='allvendor')
		{
			$voucher_applicable = 1;
			$vendor_code = '';
		}
		else if($vendor_type=='admin')
		{
			 
			 $vendor_code = '1';
		}	
		else
		{
			$voucher_applicable = 2;
			$vendor_code = json_encode($request->input('vendor_name'));
		}
		
		
		
		$updatedata=array('title'=>$request->title,'message'=>$request->subject,'vendortype'=>$request->voucher_type,'vendor_id'=>$vendor_code);
		$updtquery = DB::table('noticeboards')->where('notice_id',$id)->update($updatedata);
		
		return redirect('noticboard')->with('success', 'Thanks for updateing Notice Entry');
		
	}	
	
	
	
	public function noticdelete(Request $request,$id)
    {
		$pagetitle = 'NOTICE LIST';
        $pageheading = 'NOTICE LIST';
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
		
		$delnoticexists = DB::table('noticeboards')->where('notice_id', $id)->delete();			
		
		$noticdetails = noticeboards::select('noticeboards.*')
						->where('createdby', '=', $getsessioinid)
						->orwhere('vendor_id', '=', $getsessioinid)
						->paginate(4);

        return view('NoticList',compact('noticdetails','pagetitle','pageheading'));
	}	
	
	public function noticedit(Request $request,$id)
    {
	
		$pagetitle = 'NOTICE LIST';
        $pageheading = 'NOTICE LIST';
        $pagesubheading = 'Edit Notice';
	
		$noticdetails = 	 noticeboards::select('noticeboards.*')
							->where('noticeboards.notice_id', '=', $id)
							->get();
		$allvendorlist=DB::table('vendors')
		    ->where('status', '=', 1)
            ->select('vendors.*')
            ->get();					
					
		
					
		return view('Noticboardedit',compact('pagetitle','pagesubheading','pageheading','noticdetails','allvendorlist'));
      	
	}
	
	
}
