<?php

namespace App\Http\Controllers;

use App\Models\FeaturedVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeaturedVendorController extends Controller
{
    
    public function index()
    {
        $pagetitle = 'Featured Vendor Management';
		$pageheading = 'Featured Vendor Management';
        $featured_vendor = DB::table('vendors')
			->join('featured_vendors', 'featured_vendors.vendor_id', 'vendors.vendor_id')
			->join('users','users.id','vendors.vendor_id')
			->select('vendors.*', 'featured_vendors.position', 'users.email as email')
			->orderBy('featured_vendors.position')
            ->get();
        return view('FeaturedVendor',compact('featured_vendor','pagetitle','pageheading'));
    }

    public function updateOrder(Request $request)
    {
        $vendors = FeaturedVendor::all();

        foreach ($vendors as $vendor) {
            $position = $vendor->position;

            foreach ($request->order as $order) {
                if ($order['id'] == $position) {
                    $vendor->update(['position' => $order['position']]);
                }
            }
        }

        $featured_vendor = DB::table('vendors')
            ->join('featured_vendors', 'featured_vendors.vendor_id', 'vendors.vendor_id')
            ->join('users','users.id','vendors.vendor_id')
            ->select('vendors.*', 'featured_vendors.position', 'users.email as email')
            ->orderBy('featured_vendors.position')
            ->get()
            ->toJson();
        
        return response($featured_vendor, 200);
    }

    public function addFeatureVendor(Request $request, $id) {
        $last_id = FeaturedVendor::orderBy('position', 'DESC')->first()->position ?? 0;
        $featuredVendor = array('position' => $last_id + 1, 'vendor_id' => $id);
        FeaturedVendor::create($featuredVendor);
        return response("Added Successfully", 200);
    }

    public function deleteFeatureVendor(Request $request, $id) {
        $requested_vendor = FeaturedVendor::where('vendor_id', $id)->get()->first();
        $vendors = FeaturedVendor::all();

        foreach ($vendors as $vendor) {
            if ($vendor->position > $requested_vendor->position) {
                    $vendor->update(['position' => $vendor->position - 1]);
            }
        }

        $requested_vendor->delete();
        return response("Delete Successfully", 200);
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FeaturedVendor  $featuredVendor
     * @return \Illuminate\Http\Response
     */
    public function show(FeaturedVendor $featuredVendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeaturedVendor  $featuredVendor
     * @return \Illuminate\Http\Response
     */
    public function edit(FeaturedVendor $featuredVendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeaturedVendor  $featuredVendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeaturedVendor $featuredVendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeaturedVendor  $featuredVendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeaturedVendor $featuredVendor)
    {
        //
    }
}
