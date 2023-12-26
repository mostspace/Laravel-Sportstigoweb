<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\booking_with_vendors;
use App\Models\booking_with_vendorsdetails;
use Illuminate\Support\Facades\Session;
use DB;
class QrCodeController extends Controller
{
    public function index()
    {
        $getsessioinid = Session::get('getsessionuserid');		
		$getsessionrole = Session::get('getsessionrole');
      
        $bookingtransactiondtls	=     DB::table('booking_with_vendors')
										->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
										->Where('booking_with_vendors.bookingno','10004')
										->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price')
										->orderBy('booking_with_vendors.booking_id','DESC')
										 ->get();
										
                        echo "<pre>";
						print_r($bookingtransactiondtls);
						echo "</pre>"; 
        
       
        return view('qrcode',compact('bookingtransactiondtls'));
    }
}
