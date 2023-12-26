<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\hostgames;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class HostController extends Controller
{
    
	
	public function hostlist()
    {

        
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Host Managment';
			$pageheading = 'Host Managment';
			/*$userdetails = User::select('users.*')
								->where('users.role', '=', 5)
								->get();*/
			$userdetails = hostgames::select('hostgames.*')->paginate(4);						
						
				
			return view('HostList',compact('userdetails','pagetitle','pageheading'));	 
		}
		else
		{ 
		   return redirect('/login');
		}
		
    }
	
	public function sortinghostlist(Request $request,$id1,$id2)
    {
       
		
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Host Managment';
			$pageheading = 'Host Managment';
			$txtserach = $id1; 
			$sorting = $id2;
			
			//dd($txtserach,$sorting);
			
			
			if($txtserach=='Search')
			{
			$userdetails = hostgames::query()
						->orderBy('host_id',$sorting)
						->paginate(4);	
			}
			else
			{	
			//DB::enableQueryLog();
			
						
			$userdetails = hostgames::where('host_game_name', 'LIKE', '%'.$txtserach.'%')
						  ->orWhere('host_game_name', 'LIKE', '%'.$txtserach.'%')
						  ->orWhere('totalplayer', 'LIKE', '%'.$txtserach.'%')
						  ->orderBy('host_id',$sorting)
						  ->paginate(4);			
						
			
			//$quries = DB::getQueryLog();
			//dd($quries);
			}		
	
			return view('HostList',compact('userdetails','pagetitle','pageheading','txtserach','sorting'));
		}
		else
		{ 
		   return redirect('/login');
		}
		
    }
	
	
	
	
	public function hostcreate()
    {
		$pagetitle = 'Host Managment';
        $pageheading = 'Host Managment';
        $pagesubheading = 'Add New Host';
		
		$userdetails = 	hostgames::select('hostgames.*')
					  //->where('users.role', '=', 1)
					->get();
		
		
		
        return view('AdminHostAdd',compact('pagetitle','pagesubheading','pageheading','userdetails'));
		
	}
	public function hostedit(Request $request,$id)
    {
		
		
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'Host Managment';
			$pageheading = 'Host Managment';
			$pagesubheading = 'Edit Host';
		
			$userdetails = 	hostgames::select('hostgames.*')
						  ->where('hostgames.host_id', '=', $id)
						->get();

			$allvendorlist=DB::table('vendors')
						->where('status', '=', 1)
						->select('vendors.*')
						->get();			


						
			return view('AdminHostEdit',compact('pagetitle','pagesubheading','pageheading','userdetails','allvendorlist'));
		}
		else
		{ 
		   return redirect('/login');
		}
		
		
		
	}
	public function hostview(Request $request,$id)
    {
		$pagetitle = 'Host Managment';
        $pageheading = 'Host Managment';
        $pagesubheading = 'View Host';
	
		$userdetails = 	hostgames::select('hostgames.*')
					  ->where('hostgames.host_id', '=', $id)
					->get();
					
		return view('AdminHostView',compact('pagetitle','pagesubheading','pageheading','userdetails'));
	}
	public function hostdelete(Request $request,$id)
    {
		$pagetitle = 'Host Managment';
        $pageheading = 'Host Managment';
		$delhostexists = DB::table('hostgames')->where('host_id', $id)->delete();			
		
		$userdetails = hostgames::select('hostgames.*')->paginate(4);						
					
			
		return view('HostList',compact('userdetails','pagetitle','pageheading'));
	}
	public function hostadd(Request $request)
    {
		
		$validatedData = $request->validate([            
           
            'host_game_name' => 'required', 
            'description' => 'required',
			'venuename'=> 'required',
			'gamestartdate' => 'required', 
            'gameenddate' => 'required',
			'hostcreatedby'=> 'required',
			'totalplayer'=> 'required',
            
        ],
        [            
            
			'host_game_name.required' => 'Host Name is required!',			
            'description.required' => 'Description is required!',            
			'venuename.required' => 'Location is required!', 
			'gamestartdate.required' => 'Start Date is required!',			
            'gameenddate.required' => 'End Date is required!',            
			'hostcreatedby.required' => 'Host Created by required!',			
			'totalplayer.required' => 'Total Join People is required!',			
			
        ]);
		

		$data=array(
            'host_game_name'=>$request->host_game_name,
            'gamestartdate'=>$request->gamestartdate,
			'gameenddate'=>$request->gameenddate,
            'description'=>$request->description,
			'venuename'=>$request->venuename,
			'hostcreatedby'=>$request->hostcreatedby,
			'totalplayer'=>$request->totalplayer,
			'category'=>'0',
			'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
        
		$insertedId = hostgames::insertGetId($data);
       
		return redirect('hostcreate')->with('success', 'Thanks for submitting Host Entry');	
		
		
	}
	public function hostupdate(Request $request,$id)
    {
		
		$validatedData = $request->validate([            
           
            'host_game_name' => 'required', 
            'description' => 'required',
			'venuename'=> 'required',
			'gamestartdate' => 'required', 
            'gameenddate' => 'required',
			'hostcreatedby'=> 'required',
			'totalplayer'=> 'required',
            
        ],
        [            
            
			'host_game_name.required' => 'Host Name is required!',			
            'description.required' => 'Description is required!',            
			'venuename.required' => 'Location is required!', 
			'gamestartdate.required' => 'Start Date is required!',			
            'gameenddate.required' => 'End Date is required!',            
			'hostcreatedby.required' => 'Host Created by required!',			
			'totalplayer.required' => 'Total Join People is required!',			
			
        ]);

		$updatedata=array('host_game_name'=>$request->host_game_name,'description'=>$request->description,'venuename'=>$request->venuename,'gamestartdate'=>$request->gamestartdate,
		'gameenddate'=>$request->gameenddate,'hostcreatedby'=>$request->hostcreatedby,'totalplayer'=>$request->totalplayer,'bookingcheck'=>$request->bookingcheck);
		$updtquery = DB::table('hostgames')->where('host_id',$id)->update($updatedata);
		
       
		//return redirect('hostedit')->with('success', 'Thanks for updating Host Entry');	
		return redirect('hostedit/'.''.$id)->with('success', 'Thanks for updating Host Entry');
		
	}
	
	
	
	

	
}
