<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\sportsslotprices;
use App\Models\memberships;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use Illuminate\Http\Request;

use DB;

class SportsslotController extends Controller
{
	
    public function spotsslotadd(Request $request)
    {
		$validatedData = $request->validate([            
           
            'slotname' => 'required', 
            'slotdesc' => 'required',
			'original_price' => 'required',
			'stime' => 'required',
			'etime' => 'required',
            
        ],
        [            
            
			'slotname.required' => 'Slot Name is required!',			
            'slotdesc.required' => 'Slot Description required!',
			'original_price.required' => 'Original Price required!',            
			'stime.required' => 'Start Time required!',            
			'etime.required' => 'End Time required!',            
			
        ]);
		

		$data=array(
            'slotname'=>$request->slotname,
			'slotdesc'=>$request->slotdesc,
			'original_price'=>$request->original_price,
			'discount_price'=>$request->discount_price,
			'stime'=>$request->stime,
			'etime'=>$request->etime,
			'status'=>'1', 
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        
		$insertedId = sportsslotprices::insertGetId($data);
       
		return redirect('sportslotcreate')->with('success', 'Thanks for submitting Sport Slot Entry');	
	}
	
	 public function sportslotupdate(Request $request, $id)
    {
		$validatedData = $request->validate([            
           
            'slotname' => 'required', 
            'slotdesc' => 'required',
			'original_price' => 'required',
			'stime' => 'required',
			'etime' => 'required',
            
        ],
        [            
            
			'slotname.required' => 'Slot Name is required!',			
            'slotdesc.required' => 'Slot Description required!',
			'original_price.required' => 'Original Price required!',            
			'stime.required' => 'Start Time required!',            
			'etime.required' => 'End Time required!',            
			
        ]);
		

		$updatedata=array(
            'slotname'=>$request->slotname,
			'slotdesc'=>$request->slotdesc,
			'original_price'=>$request->original_price,
			'discount_price'=>$request->discount_price,
			'stime'=>$request->stime,
			'etime'=>$request->etime,
			'status'=>$request->status,
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        
		
		$updtquery = DB::table('sportsslotprices')->where('slot_id',$id)->update($updatedata);
       
		return redirect('sportslotcreate')->with('success', 'Thanks for Updating Sport Slot Entry');	
	}
	
	public function spotsslotlist()
    {

        $pagetitle = 'SPORT SLOT';
        $pageheading = 'SPORT SLOT';
        $sportsslotpricesdetails = sportsslotprices::select('sportsslotprices.*')
							->paginate(4);
							//->get();	
					
			
		return view('SportsslotList',compact('sportsslotpricesdetails','pagetitle','pageheading'));
    }

	public function sortingspotsslotlist(Request $request,$id1,$id2)
    {
       
        $pagetitle = 'SPORT SLOT';
        $pageheading = 'SPORT SLOT';
        $txtserach = $id1; 
		$sorting = $id2;
		
		//dd($txtserach,$sorting);
		
		
		if($txtserach=='Search')
		{
		$sportsslotpricesdetails = sportsslotprices::query()
					->orderBy('slot_id',$sorting)
                    ->paginate(4);	
		}
		else
		{	
		//DB::enableQueryLog();
		
					
		$sportsslotpricesdetails = sportsslotprices::where('slotname', 'LIKE', '%'.$txtserach.'%')
					  ->orWhere('slotdesc', 'LIKE', '%'.$txtserach.'%')
					  ->orderBy('slot_id',$sorting)
				      ->paginate(4);			
					
		
		//$quries = DB::getQueryLog();
		//dd($quries);
		}			
		
        return view('SportsslotList',compact('sportsslotpricesdetails','pagetitle','pageheading','txtserach','sorting'));
    }
	
	
	
	
	public function sportslotcreate()
    {
	  	$pagetitle = 'SPORT SLOT';
        $pageheading = 'SPORT SLOT';
        $pagesubheading = 'Add New Sport Slot';
		$sportsslotpricesdetails = 	sportsslotprices::select('sportsslotprices.*')->get();
		return view('SportsslotAdd',compact('pagetitle','pagesubheading','pageheading','sportsslotpricesdetails'));
		
	}
	
	
	public function sportslotedit(Request $request,$id)
    {
	
		$pagetitle = 'SPORT SLOT';
        $pageheading = 'SPORT SLOT';
		
		$sportsslotpricesdetails = sportsslotprices::select('sportsslotprices.*')
							 ->where('sportsslotprices.slot_id', '=', $id)
							 ->paginate(4);
							//->get();	
					
			
		return view('SportsslotEdit',compact('sportsslotpricesdetails','pagetitle','pageheading'));
      	
	}
	
	public function sportslotdelete(Request $request,$id)
    {
		
		$pagetitle = 'SPORT SLOT';
        $pageheading = 'SPORT SLOT';
		$desportslotexists = DB::table('sportsslotprices')->where('slot_id', $id)->delete();			
		
		
        $sportsslotpricesdetails = sportsslotprices::select('sportsslotprices.*')
							->paginate(4);
							//->get();	
					
			
		return view('SportsslotList',compact('sportsslotpricesdetails','pagetitle','pageheading'));
	}	
	
	
	
}
