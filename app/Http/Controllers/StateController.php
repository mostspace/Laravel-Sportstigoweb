<?php

namespace App\Http\Controllers;

use App\Models\state;
use App\Models\refunds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class StateController extends Controller
{
  
    public function index()
    {
        
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'States';
            $pageheading = 'States';
            $pagebutton = 'States';
            return view('StateList',compact('pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

        
    }

	

    
    public function store(Request $request)
    {
       
	   $validatedData = $request->validate([            
           
            'statename' => 'required', 
		],
        [            
            
			'statename.required' => 'Statename Name is required!',
			
        ]);
       
	 

        $data=array(
            'name' => $request->statename,
			'status' => '1',
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );        
        
		
		
		if( state::insert($data) ){
            
			return redirect('state')->with('success', 'Thanks for submitting State Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		
    }
	
	public function Statedetaillist(Request $request)
    {
		
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'States';
            $pageheading = 'States';
            $pagebutton = 'States';
                
            $statelist = DB::table('states')->paginate(4);				
                            
                            
            return view('StateDetailList',compact('statelist','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

        
    }
	
	
	
	public function sortingstatelist(Request $request,$id1,$id2)
    {
       
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'States';
            $pageheading = 'States';
            $txtserach = $id1; 
            $sorting = $id2;
            
            //dd($txtserach,$sorting);
            
            
            if($txtserach=='Search')
            {
            $statelist = state::query()
                        ->orderBy('id',$sorting)
                        ->paginate(4);	
            }
            else
            {	
            //DB::enableQueryLog();
            
                        
            $statelist = state::where('name', 'LIKE', '%'.$txtserach.'%')
                           ->orderBy('id',$sorting)
                           ->paginate(4);			
                        
            
            //$quries = DB::getQueryLog();
            //dd($quries);
            }			
            
            return view('StateDetailList',compact('statelist','pagetitle','pageheading','txtserach','sorting'));
		}
		else
		{ 
		   return redirect('/login');
		}

        
    }
	
	public function deletestate(Request $request, $id )
    {
        
		$pagetitle = 'States';
        $pageheading = 'States';
		$pagebutton = 'States';
		$delcategoryxists = DB::table('states')->where('id', $id)->delete();
		
        $statelist = DB::table('states')->paginate(4);				
						
						
        return view('StateDetailList',compact('statelist','pagetitle','pageheading'));
						
		
		
    }



	public function stateedit(Request $request, $id )
    {
        
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'State Managment';
            $pageheading = 'State Managment';
            $pagesubheading = 'Edit State';
            
            $statelist=DB::table('states')
                    ->Where('id',$id)
                    ->select('states.*')
                     ->get();			 
                        
            return view('StateEdit',compact('pagetitle','pagesubheading','pageheading','statelist'));
		}
		else
		{ 
		   return redirect('/login');
		}
		
    }
	
	 public function stateupdate(Request $request,$id)
	  {
		

		$statename = $request->input('name');
		$data=array(
            'name' => $statename,
            'status' => '1',
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
		
		$updtquery = DB::table('states')->where('id',$id)->update($data);

		if( $updtquery ){
            
			return redirect('state')->with('success', 'Thanks for Updating Satte Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		  
	  }

	
	

   
}
