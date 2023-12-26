<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;


class BannerController extends Controller
{
    

	public function bannerlist()
    {

        
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'Banner';
            $pageheading = 'Banner';
            $bannerslist = banners::select('banners.*')->paginate(4);	
                        
                
            return view('BannerList',compact('bannerslist','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}
        
        
    }
	
	
	
	
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bannerstore(Request $request)
    {
       $validatedData = $request->validate([            
           
            'bannerimage' => 'required',
            'bannertype' => 'required', 
			//'secondbannerimage' => 'required', 
			
			
			
		],
        [            
            
			'bannerimage.required' => 'Banner is required!',
            'bannertype.required' => 'Banner Type is required!',
			//'secondbannerimage.required' => 'Secondary Banner is required!',
			
			
        ]);
       
	   if ($request->hasFile('bannerimage')) {
            $image = $request->file('bannerimage');
            $category_image = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/BannerImages');
            $image->move($destinationPath, $category_image);
        } else {
            $category_image = $request->hdn_bannerimage;
        } 
		
	/*if ($request->hasFile('secondbannerimage')) {
            $image2 = $request->file('secondbannerimage');
            $category_image2 = time().'.'.$image2->getClientOriginalExtension();
            $destinationPath2 = public_path('/BannerImages');
            $image2->move($destinationPath2, $category_image2);
        } else {
            $category_image2 = $request->hdn_secondbannerimage;
        }*/		

        $data=array(
            'bannertype' => $request->bannertype,
			'bannertitle' => 'Slider Banner',
            'bannerpath' => $request->url1,
            'vendor_code' => $request->vendor_code,
            'bannerimage' => 'BannerImages/'.$category_image,
			/*'secondbannerpath' => $request->url2,
            'secondvendor_code' => $request->secondvendor_code,
            'secondbannerimage' => 'BannerImages/'.$category_image2,*/
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );        
        //category::insert($data); 
		
		
		$allvendorlist=DB::table('vendors')
		    ->where('status', '=', 1)
            ->select('vendors.*')
            ->get();
		
        //return view('AdminBannerView',compact('pagetitle','pageheading','allvendorlist'));
		
		if( banners::insert($data) ){
            
			return redirect('AdminBanner')->with('success', 'Thanks for submitting Banner Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		
    }

	 public function bannerupdate(Request $request,$id)
    {
		
        $validatedData = $request->validate([            
           
            'bannerimage' => 'required',
            'bannertype' => 'required', 
			//'secondbannerimage' => 'required', 
			
			
			
		],
        [            
            
			'bannerimage.required' => 'Banner is required!',
            'bannertype.required' => 'Banner Type is required!',
			//'secondbannerimage.required' => 'Secondary Banner is required!',
			
			
        ]);
	   
	   
	   if ($request->hasFile('bannerimage')) {
            $image = $request->file('bannerimage');
            $category_image = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/BannerImages');
            $image->move($destinationPath, $category_image);
        } else {
            $category_image = $request->hdn_bannerimage;
        } 
		
	/*if ($request->hasFile('secondbannerimage')) {
            $image2 = $request->file('secondbannerimage');
            $category_image2 = time().'.'.$image2->getClientOriginalExtension();
            $destinationPath2 = public_path('/BannerImages');
            $image2->move($destinationPath2, $category_image2);
        } else {
            $category_image2 = $request->hdn_secondbannerimage;
        }*/
        
        

      

        $data=array(
            'bannertype' => $request->bannertype,
			'bannertitle' => 'Slider Banner',
            'bannerpath' => $request->url1,
            'vendor_code' => $request->vendor_code,
            'bannerimage' => 'BannerImages/'.$category_image,
			/*'secondbannerpath' => $request->url2,
            'secondvendor_code' => $request->secondvendor_code,
            'secondbannerimage' => 'BannerImages/'.$category_image2,*/
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );        
        //category::insert($data); 
		
		
		$allvendorlist=DB::table('vendors')
		    ->where('status', '=', 1)
            ->select('vendors.*')
            ->get();
		
        //return view('AdminBannerView',compact('pagetitle','pageheading','allvendorlist'));
		
		$updtquery = DB::table('banners')->where('id',$id)->update($data);

		if( $updtquery ){
            
			return redirect('AdminBanner')->with('success', 'Thanks for Updating Banner Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		
    }


	

	public function bannerdelete(Request $request, $id )
    {
        
		
		$pagetitle = 'Banner';
        $pageheading = 'Banner';
		
		$delcategoryxists = DB::table('banners')->where('id', $id)->delete();
        $bannerslist = banners::select('banners.*')->paginate(4);	
					
		return view('BannerList',compact('bannerslist','pagetitle','pageheading'));
		
		
    }



	public function banneredit(Request $request, $id )
    {
        
		
		
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
           
        $pagetitle = 'Banner';
        $pageheading = 'Banner';
        $pagesubheading = 'Edit Banner';
		
		$bannerslist=DB::table('banners')
				->Where('id',$id)
				->select('banners.*')
				 ->get();
				 
		$allvendorlist=DB::table('vendors')
		    ->where('status', '=', 1)
            ->select('vendors.*')
            ->get();		 
					
        return view('AdminBannerEdit',compact('pagetitle','pagesubheading','pageheading','bannerslist','allvendorlist'));
		}
		else
		{ 
		   return redirect('/login');
		}
        
    }






    

}
