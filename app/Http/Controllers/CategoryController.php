<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'Categories';
            $pageheading = 'Categories';
            $pagebutton = 'Categories';
            return view('CategoryList',compact('pagetitle','pageheading'));
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

	
	public function categorylist(Request $request)
    {

        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
        $pagetitle = 'Category';
        $pageheading = 'Category';
        $categorylist = category::select('categories.*')
						->paginate(4);

		return view('CategoryDetailList',compact('categorylist','pagetitle','pageheading'));
		}
		else
		{ 
		   return redirect('/login');
		}

       
    }
	
	
	
	public function sortingcategorylist(Request $request,$id1,$id2)
    {
       
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'Category';
            $pageheading = 'Category';
            $txtserach = $id1; 
            $sorting = $id2;
            
            //dd($txtserach,$sorting);
            
            
            if($txtserach=='Search')
            {
            $categorylist = category::query()
                        ->orderBy('id',$sorting)
                        ->paginate(4);	
            }
            else
            {	
            //DB::enableQueryLog();
            
                        
            $categorylist = category::where('name', 'LIKE', '%'.$txtserach.'%')
                           ->orderBy('id',$sorting)
                           ->paginate(4);			
                        
            
            //$quries = DB::getQueryLog();
            //dd($quries);
            }			
            
            return view('CategoryDetailList',compact('categorylist','pagetitle','pageheading','txtserach','sorting'));
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
    public function store(Request $request)
    {
       $validatedData = $request->validate([            
           
            'categoryname' => 'required', 
		],
        [            
            
			'categoryname.required' => 'Categoryname Name is required!',
			
        ]);
       
	   if ($request->hasFile('categoryimage')) {
            $image = $request->file('categoryimage');
			
			
            $category_image = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/CategoriesImages');
            $image->move($destinationPath, $category_image);
        } else {
            $category_image = $request->hdn_category_image;
        }   
	
	if ($request->hasFile('categoryimage2')) {
            $image2 = $request->file('categoryimage2');
            $category_image2 = time().'.'.$image2->getClientOriginalExtension();
            $destinationPath2 = public_path('/CategoriesPics');
            $image2->move($destinationPath2, $category_image2);
        } else {
            $category_image2 = $request->hdn_category_image2;
        } 
	
		//dd($category_image,$category_image2);
        $data=array(
            'name' => $request->categoryname,
            'image' => 'CategoriesImages/'.$category_image,
			'image2' => 'CategoriesPics/'.$category_image2,
            'status' => '1',
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );        
        //category::insert($data); 
		
		
		if( category::insert($data) ){
            
			return redirect('category')->with('success', 'Thanks for submitting Category Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		
    }


	public function deletecategory(Request $request, $id )
    {
        
		$pagetitle = 'Category';
        $pageheading = 'Category';
		$delcategoryxists = DB::table('categories')->where('id', $id)->delete();
		
        $categorylist = category::select('categories.*')->paginate(4);	
					
			
		return view('CategoryDetailList',compact('categorylist','pagetitle','pageheading'));
						
		
		//$success1 = $request->session()->put('success', 'Thanks for deleting Staff Entry');		
        //return view('AdminStaffAdd',compact('pagetitle','pagesubheading','pageheading','moduledtlsdd'));
		//return redirect('AdminStaffAdd')->with('success', 'Thanks for deleting Staff Entry');
    }



	public function categoryedit(Request $request, $id )
    {
        
		
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
            $pagetitle = 'Category Managment';
        $pageheading = 'Category Managment';
        $pagesubheading = 'Edit New Category';
		
		$categorylist=DB::table('categories')
				->Where('id',$id)
				->select('categories.*')
				 ->get();			 
					
        return view('CategoryEdit',compact('pagetitle','pagesubheading','pageheading','categorylist'));
		}
		else
		{ 
		   return redirect('/login');
		}

       
    }






    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    
	  public function categoryupdate(Request $request,$id)
	  {
		/*$validatedData = $request->validate([            
           
            'categoryname' => 'required', 
		],
        [            
            
			'categoryname.required' => 'Categoryname Name is required!',
			
        ]);*/

		$categoryname = $request->input('categoryname');
        
		 if ($request->hasFile('categoryimage')) {
            $image = $request->file('categoryimage');
            $category_image = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/CategoriesImages');
            $image->move($destinationPath, $category_image);
        } else {
            $category_image = $request->hdn_category_image;
        }   
	
	     if ($request->hasFile('categoryimage2')) {
            $image2 = $request->file('categoryimage2');
            $category_image2 = time().'.'.$image2->getClientOriginalExtension();
            $destinationPath2 = public_path('/CategoriesPics');
            $image2->move($destinationPath2, $category_image2);
        } else {
            $category_image2 = $request->hdn_category_image2;
        } 
	

		$data=array(
            'name' => $request->categoryname,
            'image' => 'CategoriesImages/'.$category_image,
			'image2' => 'CategoriesPics/'.$category_image2,
            'status' => '1',
            'created_at' =>  date("Y-m-d H:i:s"),
            'updated_at' =>  date("Y-m-d H:i:s"),
        );
		
		
		
        
		$updtquery = DB::table('categories')->where('id',$id)->update($data);

		if( $updtquery ){
            
			return redirect('category')->with('success', 'Thanks for Updating Category Entry');
        }else{
            return redirect()->back()->with('success', 'Oooops..! Something want to wrongs.');
        }
		  
	  }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }
}
