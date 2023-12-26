<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\booking_with_vendors;
use App\Models\booking_with_vendorsdetails;
use App\Models\withdrwalreports_with_vendors;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use App\Models\withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Carbon\Carbon;


class ReportsController extends Controller
{

	public function vendorreport(Request $request)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}

		if($getsessioinid)
		{


			$pagetitle = 'Sales Report';
			$pageheading = 'Sales Report';


			if($getsessionrole==1)
			{
			  //Admin Level

					$totalAmountinAccount=DB::table('users')
					->Where('users.role',3)
					->sum('wallet_amount');

					//dd($totalAmountinAccount);

					$curdate = date('Y-m-d');



					$todaysalesviamobile = DB::table("booking_with_vendors")->whereDate('booking_with_vendors.created_at',$curdate)->where('paymethod',1)->where('paystatus','Y')->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->whereDate('booking_with_vendors.created_at',$curdate)->where('paymethod',2)->where('paystatus','Y')->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('paystatus','Y')->sum('sporstigototalcommision');
					$SalesagentCommision ='';
					$netprofit =            DB::table("booking_with_vendors")->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


					$bookingtransactiondtls	= DB::table('booking_with_vendors')
										->join('users','users.id','booking_with_vendors.vendor_id')
										->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
										//->where('paystatus','Y')
										//->orwhere('paystatus','R')
										->whereIn('paystatus', ['Y','R'])
										->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
										->orderBy('booking_with_vendors.booking_id','DESC')
										//->get();
										->paginate(5);

			}


			else if($getsessionrole==7)
			{


								$totalAmountinAccount=DB::table('users')
								->Where('users.role',7)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');


					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');
					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sales_agent_commision');

					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');




					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											 ->where('users.createdby',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);


		/*echo "<pre>";
		print_r($bookingtransactiondtls);
		echo "</pre>";
		exit;*/



			}

			else if($getsessionrole==8)
			{

				$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
				$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;

				//dd($vendorrefferalcreatedby);


								$totalAmountinAccount=DB::table('users')
								->Where('users.role',8)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paystatus','Y')
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');

					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('Vendor_Reffer_commision');


					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);

			}

			else
			{
				//Vendor Level

					/*$totalAmountinAccount=DB::table('users')
								->Where('users.id',$getsessioinid)
								->select('users.*')
								->get()->first();*/

								$totalAmountinAccount=DB::table('users')
								->Where('users.role',3)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->where('paystatus_id',1)->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('sporstigototalcommision');
					$SalesagentCommision ='';
					$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->Where('booking_with_vendors.vendor_id',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);
			}







			return view('ReportVendor',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','bookingtransactiondtls'));

		}
		else
		{
		   return redirect('/login');
		}



    }



	public function salesreportbyvendor(Request $request,$fromdate,$todate)
	{

        $fromtime=Carbon::parse($fromdate)->format('H:i:s');
        $fromdate=Carbon::parse($fromdate)->format('Y-m-d');

        $totime=Carbon::parse($todate)->format('H:i:s');
        $todate=Carbon::parse($todate)->format('Y-m-d');

        // dd($fromtime,$totime);
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

            $getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
            $getsessioinid = $getVendorDetails->createdby;
            $getsessionrole = $getVendorDetails->role;

		}



		if($getsessioinid)
		{


			$pagetitle = 'Sales Report';
			$pageheading = 'Sales Report';


			if($getsessionrole==1)
			{
			  //Admin Level

					$totalAmountinAccount=DB::table('users')
					->Where('users.role',3)
					->sum('wallet_amount');

					//dd($totalAmountinAccount);

					$curdate = date('Y-m-d');



					$todaysalesviamobile = DB::table("booking_with_vendors")->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('paystatus','Y')->sum('sporstigototalcommision');
					$netprofit =            DB::table("booking_with_vendors")->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SalesagentCommision ='';

					$bookingtransactiondtls	= DB::table('booking_with_vendors')
										->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('booking_with_vendors.date', '>=', $fromdate)
										->Where('booking_with_vendors.date','<=', $todate)
                                        ->whereTime('booking_with_vendors.created_at', '>=', $fromtime)
                                        ->whereTime('booking_with_vendors.created_at', '<=', $totime)
										//->where('paystatus','Y')
										//->orwhere('paystatus','R')
										->whereIn('paystatus', ['Y','R'])
										->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
										->orderBy('booking_with_vendors.booking_id','DESC')
										//->get();
										->paginate(5);

			}
			else if($getsessionrole==7)
			{
								$totalAmountinAccount=DB::table('users')
								->Where('users.role',7)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');
					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sales_agent_commision');

					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('booking_with_vendors.date', '>=', $fromdate)
										   	->Where('booking_with_vendors.date','<=', $todate)
                                           	->whereTime('booking_with_vendors.created_at', '>=', $fromtime)
                                        	->whereTime('booking_with_vendors.created_at', '<=', $totime)
										   //->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);

			}



			else if($getsessionrole==8)
			{

				$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
				$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;


								$totalAmountinAccount=DB::table('users')
								->Where('users.role',8)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');

					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('Vendor_Reffer_commision');


					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paystatus','Y')
											->where('users.createdby',$vendorrefferalcreatedby)
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paystatus','Y')
											->where('users.createdby',$vendorrefferalcreatedby)
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('booking_with_vendors.date', '>=', $fromdate)
 											->Where('booking_with_vendors.date','<=', $todate)
											 ->whereTime('booking_with_vendors.created_at', '>=', $fromtime)
											 ->whereTime('booking_with_vendors.created_at', '<=', $totime)
											 //->where('paystatus','Y')
											 //->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);

			}


			else
			{
				//Vendor Level

					/*$totalAmountinAccount=DB::table('users')
								->Where('users.id',$getsessioinid)
								->select('users.*')
								->get()->first();*/

								$totalAmountinAccount=DB::table('users')
								->Where('users.role',3)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('sporstigototalcommision');
					$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SalesagentCommision ='';


					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('booking_with_vendors.date', '>=', $fromdate)
											->Where('booking_with_vendors.date','<=', $todate)
											->whereTime('booking_with_vendors.created_at', '>=', $fromtime)
                                        	->whereTime('booking_with_vendors.created_at', '<=', $totime)
											->Where('booking_with_vendors.vendor_id',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);
			}




			return view('ReportVendor',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','bookingtransactiondtls'));

		}
		else
		{
		   return redirect('/login');
		}




	}





	public function vendoronlinesalesreport(Request $request)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}

		if($getsessioinid)
		{


		$pagetitle = 'Sales Report';
        $pageheading = 'Sales Report';


		if($getsessionrole==1)
		{
		  //Admin Level

				$totalAmountinAccount=DB::table('users')
				->Where('users.role',3)
				->sum('wallet_amount');

				//dd($totalAmountinAccount);

				$curdate = date('Y-m-d');



				$todaysalesviamobile = DB::table("booking_with_vendors")->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
				$todaysalesviacounter = DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
				$SporstigoCommision =   DB::table("booking_with_vendors")->where('paystatus','Y')->sum('sporstigototalcommision');
				$SalesagentCommision ='';
				$netprofit =            DB::table("booking_with_vendors")->where('paystatus','Y')->sum('netprofit');
				$todaytotalsales =      DB::table("booking_with_vendors")->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


				$bookingtransactiondtls	= DB::table('booking_with_vendors')
									->join('users','users.id','booking_with_vendors.vendor_id')
									->where('paymethod',1)
									//->where('paystatus','Y')
									//->orwhere('paystatus','R')
									->whereIn('paystatus', ['Y','R'])
									->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
									->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
									->orderBy('booking_with_vendors.booking_id','DESC')
									//->get();
									->paginate(5);

		}


		else if($getsessionrole==7)
		{
							$totalAmountinAccount=DB::table('users')
							->Where('users.role',7)
							->Where('users.id',$getsessioinid)
							->sum('wallet_amount');

				$curdate = date('Y-m-d');

				$todaysalesviamobile =   DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$getsessioinid)
										->where('paystatus','Y')
										->whereDate('booking_with_vendors.created_at',$curdate)
										->where('paymethod',1)->sum('amount');

				$todaysalesviacounter = DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$getsessioinid)
										->where('paystatus','Y')
										->whereDate('booking_with_vendors.created_at',$curdate)
										->where('paymethod',2)->sum('amount');

				$SporstigoCommision =    DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$getsessioinid)
										->where('paystatus','Y')
										->sum('sporstigototalcommision');
				$SalesagentCommision =    DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$getsessioinid)
										->where('paystatus','Y')
										->sum('sales_agent_commision');

				$netprofit =            DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$getsessioinid)
										->where('paystatus','Y')
										->sum('netprofit');

				$todaytotalsales =       DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$getsessioinid)
										->where('paystatus','Y')
										->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



				$bookingtransactiondtls	= DB::table('booking_with_vendors')
										->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('paymethod',1)
										->where('users.createdby',$getsessioinid)
										//->where('paystatus','Y')
										//->orwhere('paystatus','R')
										->whereIn('paystatus', ['Y','R'])
										->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
										->orderBy('booking_with_vendors.booking_id','DESC')
										//->get();
										->paginate(5);

		}
		else if($getsessionrole==8)
		{

			$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
			$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;


							$totalAmountinAccount=DB::table('users')
							->Where('users.role',8)
							->Where('users.id',$getsessioinid)
							->sum('wallet_amount');

				$curdate = date('Y-m-d');

				$todaysalesviamobile =   DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$vendorrefferalcreatedby)
										->where('paystatus','Y')
										->whereDate('booking_with_vendors.created_at',$curdate)
										->where('paymethod',1)->sum('amount');

				$todaysalesviacounter = DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$vendorrefferalcreatedby)
										->where('paystatus','Y')
										->whereDate('booking_with_vendors.created_at',$curdate)
										->where('paymethod',2)->sum('amount');

				$SporstigoCommision =    DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$vendorrefferalcreatedby)
										->where('paystatus','Y')
										->sum('sporstigototalcommision');

				$SalesagentCommision =    DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$vendorrefferalcreatedby)
										->where('paystatus','Y')
										->sum('Vendor_Reffer_commision');


				$netprofit =            DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$vendorrefferalcreatedby)
										->where('paystatus','Y')
										->sum('netprofit');

				$todaytotalsales =       DB::table("booking_with_vendors")
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('users.createdby',$vendorrefferalcreatedby)
										->where('paystatus','Y')
										->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



				$bookingtransactiondtls	= DB::table('booking_with_vendors')
										->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('paymethod',1)
										->where('users.createdby',$vendorrefferalcreatedby)
										//->where('paystatus','Y')
										//->orwhere('paystatus','R')
										->whereIn('paystatus', ['Y','R'])
										->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
										->orderBy('booking_with_vendors.booking_id','DESC')
										//->get();
										->paginate(5);

		}
		else
		{
			//Vendor Level

				/*$totalAmountinAccount=DB::table('users')
							->Where('users.id',$getsessioinid)
							->select('users.*')
							->get()->first();*/

							$totalAmountinAccount=DB::table('users')
							->Where('users.role',3)
							->Where('users.id',$getsessioinid)
							->sum('wallet_amount');

				$curdate = date('Y-m-d');

				$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
				$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
				$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('sporstigototalcommision');
				$SalesagentCommision ='';
				$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('netprofit');
				$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



				$bookingtransactiondtls	= DB::table('booking_with_vendors')
										->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('paymethod',1)
										->Where('booking_with_vendors.vendor_id',$getsessioinid)
										//->where('paystatus','Y')
										//->orwhere('paystatus','R')
										->whereIn('paystatus', ['Y','R'])
										->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
										->orderBy('booking_with_vendors.booking_id','DESC')
										//->get();
										->paginate(5);
		}

		return view('ReportVendoronlinesales',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','bookingtransactiondtls'));
		}
		else
		{
		   return redirect('/login');
		}


    }

	public function vendoronlinesalesreportfilter(Request $request,$fromdate,$todate)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}


		if($getsessioinid)
		{

			$pagetitle = 'Sales Report';
			$pageheading = 'Sales Report';


			if($getsessionrole==1)
			{
			  //Admin Level

					$totalAmountinAccount=DB::table('users')
					->Where('users.role',3)
					->sum('wallet_amount');

					//dd($totalAmountinAccount);

					$curdate = date('Y-m-d');



					$todaysalesviamobile = DB::table("booking_with_vendors")->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('paystatus','Y')->sum('sporstigototalcommision');
					$SalesagentCommision ='';
					$netprofit =            DB::table("booking_with_vendors")->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


					$bookingtransactiondtls	= DB::table('booking_with_vendors')
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('paymethod',1)
										->where('booking_with_vendors.date', '>=', $fromdate)
										->Where('booking_with_vendors.date','<=', $todate)
										//->where('paystatus','Y')
										//->orwhere('paystatus','R')
										->whereIn('paystatus', ['Y','R'])
										->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
										->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
										->orderBy('booking_with_vendors.booking_id','DESC')
										//->get();
										->paginate(5);

			}


			else if($getsessionrole==7)
			{
								$totalAmountinAccount=DB::table('users')
								->Where('users.role',7)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');
					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sales_agent_commision');

					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paymethod',1)
											->where('booking_with_vendors.date', '>=', $fromdate)
											->Where('booking_with_vendors.date','<=', $todate)
											->where('users.createdby',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);

			}
			else if($getsessionrole==8)
			{

				$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
				$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;


								$totalAmountinAccount=DB::table('users')
								->Where('users.role',8)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');

					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('Vendor_Reffer_commision');


					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paymethod',1)
											->where('booking_with_vendors.date', '>=', $fromdate)
 											->Where('booking_with_vendors.date','<=', $todate)
											 //->where('paystatus','Y')
											 //->orwhere('paystatus','R')
											 ->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);

			}
			else
			{
				//Vendor Level

					/*$totalAmountinAccount=DB::table('users')
								->Where('users.id',$getsessioinid)
								->select('users.*')
								->get()->first();*/

								$totalAmountinAccount=DB::table('users')
								->Where('users.role',3)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('sporstigototalcommision');
					$SalesagentCommision ='';
					$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paymethod',1)
											->where('booking_with_vendors.date', '>=', $fromdate)
											->Where('booking_with_vendors.date','<=', $todate)
											->Where('booking_with_vendors.vendor_id',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);
			}

			return view('ReportVendoronlinesales',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','bookingtransactiondtls'));
		}
		else
		{
		   return redirect('/login');
		}



    }





    public function vendorcountersalesreport(Request $request)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}


		if($getsessioinid)
		{

			$pagetitle = 'Sales Report';
			$pageheading = 'Sales Report';


			if($getsessionrole==1)
			{
			  //Admin Level

					$totalAmountinAccount=DB::table('users')
					->Where('users.role',3)
					->sum('wallet_amount');

					//dd($totalAmountinAccount);

					$curdate = date('Y-m-d');



					$todaysalesviamobile = DB::table("booking_with_vendors")->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('paystatus','Y')->sum('sporstigototalcommision');
					$SalesagentCommision ='';
					$netprofit =            DB::table("booking_with_vendors")->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


					$bookingtransactiondtls	= DB::table('booking_with_vendors')
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('paymethod',2)
										//->where('paystatus','Y')
										//->orwhere('paystatus','R')
										->whereIn('paystatus', ['Y','R'])
										->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
										->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
										->orderBy('booking_with_vendors.booking_id','DESC')
										//->get();
										->paginate(5);

			}


			else if($getsessionrole==7)
			{
								$totalAmountinAccount=DB::table('users')
								->Where('users.role',7)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');
					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sales_agent_commision');

					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paymethod',2)
											->where('users.createdby',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);

			}
			else if($getsessionrole==8)
			{

				$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
				$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;


								$totalAmountinAccount=DB::table('users')
								->Where('users.role',8)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');

					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('Vendor_Reffer_commision');


					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paymethod',2)
											->where('users.createdby',$vendorrefferalcreatedby)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);

			}

			else
			{
				//Vendor Level

					/*$totalAmountinAccount=DB::table('users')
								->Where('users.id',$getsessioinid)
								->select('users.*')
								->get()->first();*/

								$totalAmountinAccount=DB::table('users')
								->Where('users.role',3)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('sporstigototalcommision');
					$SalesagentCommision ='';
					$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paymethod',2)
											->Where('booking_with_vendors.vendor_id',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);
			}


			return view('ReportVendorcountersales',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','bookingtransactiondtls'));
		}
		else
		{
		   return redirect('/login');
		}


    }

	public function vendorcountersalesreportfilter(Request $request,$fromdate,$todate)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}
		if($getsessioinid)
		{

			$pagetitle = 'Sales Report';
			$pageheading = 'Sales Report';


			if($getsessionrole==1)
			{
			  //Admin Level

					$totalAmountinAccount=DB::table('users')
					->Where('users.role',3)
					->sum('wallet_amount');

					//dd($totalAmountinAccount);

					$curdate = date('Y-m-d');



					$todaysalesviamobile = DB::table("booking_with_vendors")->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('paystatus','Y')->sum('sporstigototalcommision');
					$SalesagentCommision ='';
					$netprofit =            DB::table("booking_with_vendors")->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


					$bookingtransactiondtls	= DB::table('booking_with_vendors')
										->join('users','users.id','booking_with_vendors.vendor_id')
										->where('paymethod',2)
										->where('booking_with_vendors.date', '>=', $fromdate)
										->Where('booking_with_vendors.date','<=', $todate)
										//->where('paystatus','Y')
										//->orwhere('paystatus','R')
										->whereIn('paystatus', ['Y','R'])
										->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
										->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
										->orderBy('booking_with_vendors.booking_id','DESC')
										//->get();
										->paginate(5);

			}


			else if($getsessionrole==7)
			{
								$totalAmountinAccount=DB::table('users')
								->Where('users.role',7)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');
					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sales_agent_commision');

					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paymethod',2)
											->where('booking_with_vendors.date', '>=', $fromdate)
											->Where('booking_with_vendors.date','<=', $todate)
											->where('users.createdby',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);

			}
			else if($getsessionrole==8)
			{

				$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
				$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;


								$totalAmountinAccount=DB::table('users')
								->Where('users.role',8)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');

					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('Vendor_Reffer_commision');


					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paymethod',2)
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('booking_with_vendors.date', '>=', $fromdate)
 											->Where('booking_with_vendors.date','<=', $todate)
											 //->where('paystatus','Y')
											 //->orwhere('paystatus','R')
											 ->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);

			}
			else
			{
				//Vendor Level

					/*$totalAmountinAccount=DB::table('users')
								->Where('users.id',$getsessioinid)
								->select('users.*')
								->get()->first();*/

								$totalAmountinAccount=DB::table('users')
								->Where('users.role',3)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('sporstigototalcommision');
					$SalesagentCommision ='';
					$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('paymethod',2)
											->where('booking_with_vendors.date', '>=', $fromdate)
											->Where('booking_with_vendors.date','<=', $todate)
											->Where('booking_with_vendors.vendor_id',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.*','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.stime','booking_with_vendorsdetails.etime','booking_with_vendorsdetails.price','users.name as name','booking_with_vendorsdetails.checkinstatus')
											->orderBy('booking_with_vendors.booking_id','DESC')
											//->get();
											->paginate(5);
			}

			return view('ReportVendorcountersales',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','bookingtransactiondtls'));
		}
		else
		{
		   return redirect('/login');
		}


    }



	public function vendorvoucherreport(Request $request)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}

		if($getsessioinid)
		{

			$pagetitle = 'Sales Report';
			$pageheading = 'Sales Report';


			if($getsessionrole==1)
			{
			  //Admin Level

					$totalAmountinAccount=DB::table('users')
					->Where('users.role',3)
					->sum('wallet_amount');

					//dd($totalAmountinAccount);

					$curdate = date('Y-m-d');
					$SalesagentCommision ='';
					$todaysalesviamobile = DB::table("booking_with_vendors")->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('paystatus','Y')->sum('sporstigototalcommision');
					$netprofit =            DB::table("booking_with_vendors")->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');

					$allvoucherlist=DB::table('vouchers')
					->where('createdby', '=', $getsessioinid)
					->select('vouchers.*')
					->orderBy('vouchers.id','DESC')
					->paginate(5);



					$allvendorlist=DB::table('vendors')
						->where('status', '=', 1)
						->select('vendors.*')
						->get();
			}

			else if($getsessionrole==7)
			{
								$totalAmountinAccount=DB::table('users')
								->Where('users.role',7)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');

					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sales_agent_commision');

					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


					$allvoucherlist=       DB::table('vouchers')
											->join('users','users.id','vouchers.vendor_code')
											->join('vendors','vendors.vendor_id','vouchers.createdby')
											->where('vendors.createdby',$getsessioinid)
											->select('vouchers.*')
											->orderBy('vouchers.id','DESC')
											->paginate(10);



					$allvendorlist=DB::table('vendors')
												->where('status', '=', 1)
												->select('vendors.*')
												->get();

			}


			else if($getsessionrole==8)
			{

				$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
				$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;


								$totalAmountinAccount=DB::table('users')
								->Where('users.role',8)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');

					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('Vendor_Reffer_commision');


					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


					$allvoucherlist=       DB::table('vouchers')
											->join('users','users.id','vouchers.vendor_code')
											->join('vendors','vendors.vendor_id','vouchers.createdby')
											->where('vendors.createdby',$vendorrefferalcreatedby)
											->select('vouchers.*')
											->orderBy('vouchers.id','DESC')
											->paginate(10);



					$allvendorlist=DB::table('vendors')
												->where('status', '=', 1)
												->select('vendors.*')
												->get();


			}

			else
			{
				//Vendor Level

					/*$totalAmountinAccount=DB::table('users')
								->Where('users.id',$getsessioinid)
								->select('users.*')
								->get()->first();*/

								$totalAmountinAccount=DB::table('users')
								->Where('users.role',3)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('sporstigototalcommision');
					$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SalesagentCommision ='';


					$allvoucherlist=DB::table('vouchers')
					->where('createdby', '=', $getsessioinid)
					->select('vouchers.*')
					->orderBy('vouchers.id','DESC')
					->paginate(10);



					$allvendorlist=DB::table('vendors')
						->where('status', '=', 1)
						->select('vendors.*')
						->get();
			}


			return view('ReportVoucher',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','allvoucherlist','allvendorlist'));
		}
		else
		{
		   return redirect('/login');
		}




    }



	public function vendorvoucherreportfilter(Request $request,$fromdate,$todate)
	{
		//dd($fromdate,$todate);
		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}

		if($getsessioinid)
		{


			$pagetitle = 'Sales Report';
			$pageheading = 'Sales Report';


			if($getsessionrole==1)
			{
							//Admin Level
							$totalAmountinAccount=DB::table('users')
							->Where('users.role',3)
							->sum('wallet_amount');

							$curdate = date('Y-m-d');
							$SalesagentCommision ='';
							$todaysalesviamobile = DB::table("booking_with_vendors")->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
							$todaysalesviacounter = DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
							$SporstigoCommision =   DB::table("booking_with_vendors")->where('paystatus','Y')->sum('sporstigototalcommision');
							$netprofit =            DB::table("booking_with_vendors")->where('paystatus','Y')->sum('netprofit');
							$todaytotalsales =      DB::table("booking_with_vendors")->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


							$allvoucherlist=DB::table('vouchers')
							->where('voucher_date', '>=', $fromdate)
							->Where('voucher_date','<=', $todate)
							->select('vouchers.*')
							->orderBy('vouchers.id','DESC')
							->paginate(5);



							$allvendorlist=DB::table('vendors')
								->where('status', '=', 1)
								->select('vendors.*')
								->get();
			}

			else if($getsessionrole==7)
			{
								$totalAmountinAccount=DB::table('users')
								->Where('users.role',7)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');
					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sales_agent_commision');

					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



				 $allvoucherlist=       DB::table('vouchers')
											->join('users','users.id','vouchers.vendor_code')
											->join('vendors','vendors.vendor_id','vouchers.createdby')
											->where('vendors.createdby',$getsessioinid)
											->where('vouchers.voucher_date', '>=', $fromdate)
											->Where('vouchers.voucher_date','<=', $todate)
											->select('vouchers.*')
											->orderBy('vouchers.id','DESC')
											->paginate(10);



					$allvendorlist=DB::table('vendors')
												->where('status', '=', 1)
												->select('vendors.*')
												->get();

			}
			else if($getsessionrole==8)
			{

				$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
				$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;


								$totalAmountinAccount=DB::table('users')
								->Where('users.role',8)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->where('paystatus','Y')->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->where('paystatus','Y')->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');

					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('Vendor_Reffer_commision');


					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


					$allvoucherlist=       DB::table('vouchers')
											->join('users','users.id','vouchers.vendor_code')
											->join('vendors','vendors.vendor_id','vouchers.createdby')
											->where('vendors.createdby',$vendorrefferalcreatedby)
											->where('vouchers.voucher_date', '>=', $fromdate)
											->Where('vouchers.voucher_date','<=', $todate)
											->select('vouchers.*')
											->orderBy('vouchers.id','DESC')
											->paginate(10);



					$allvendorlist=DB::table('vendors')
												->where('status', '=', 1)
												->select('vendors.*')
												->get();


			}
			else
			{
				//Vendor Level
				$totalAmountinAccount=DB::table('users')
								->Where('users.role',3)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

				$curdate = date('Y-m-d');
				$SalesagentCommision ='';
				$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
				$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
				$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('sporstigototalcommision');
				$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('netprofit');
				$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');


				$allvoucherlist=DB::table('vouchers')
							->where('createdby', '=', $getsessioinid)
							->where('voucher_date', '>=', $fromdate)
							->Where('voucher_date','<=', $todate)
							->select('vouchers.*')
							->orderBy('vouchers.id','DESC')
							->paginate(5);



							$allvendorlist=DB::table('vendors')
								->where('status', '=', 1)
								->select('vendors.*')
								->get();
			}



			return view('ReportVoucher',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','allvoucherlist','allvendorlist'));
		}
		else
		{
		   return redirect('/login');
		}



	}



	public function vendorwithdrawreport(Request $request)
    {

		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}

		if($getsessioinid)
		{


			$pagetitle = 'Sales Report';
			$pageheading = 'Sales Report';


			if($getsessionrole==1)
			{
								$totalAmountinAccount=DB::table('users')
												->Where('users.role',3)
												->sum('wallet_amount');

								$curdate = date('Y-m-d');

								$todaysalesviamobile = DB::table("booking_with_vendors")->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
								$todaysalesviacounter = DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
								$SporstigoCommision =   DB::table("booking_with_vendors")->where('paystatus','Y')->sum('sporstigototalcommision');
								$netprofit =            DB::table("booking_with_vendors")->where('paystatus','Y')->sum('netprofit');
								$todaytotalsales =      DB::table("booking_with_vendors")->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
								$SalesagentCommision ='';
								$totalwithdrawal=  DB::table("withdrawals")->where('withdrawal_status',2)->select('withdrawals.withdrawal_amount');


								$bookingtransactiondtls	= DB::table('booking_with_vendors')
										//->where('paystatus','Y')
										//->orwhere('paystatus','R')
										->whereIn('paystatus', ['Y','R'])
									 ->select('booking_with_vendors.created_at as created_at','booking_with_vendors.paymethod as paymethod','booking_with_vendors.amount as amount','booking_with_vendors.voucher_sales as voucher_sales',
									 'booking_with_vendors.admin_commision as admin_commision','booking_with_vendors.vednor_fees as vednor_fees','booking_with_vendors.sales_agent_commision as sales_agent_commision')
									 ->orderBy('booking_with_vendors.created_at','ASC')
									 ->paginate(5);



								$withdrawaldetails =  DB::table('withdrawals')
								->join('users','users.id','withdrawals.user_id')
								->where('withdrawal_status',2)
								->select('withdrawals.created_at as created_at','withdrawals.wallet_amount as wallet_amount','withdrawals.withdrawal_amount as withdrawal_amount','withdrawals.balance as balance','withdrawals.withdrawal_status as withdrawal_status','withdrawals.reportflag as reportflag','users.name as name')
								->orderBy('withdrawals.bookingno','ASC')
								->paginate(5);

			}

			else if($getsessionrole==7)
			{
								$totalAmountinAccount=DB::table('users')
								->Where('users.role',7)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');
					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sales_agent_commision');

					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');

					$totalwithdrawal=  DB::table("withdrawals")->where('user_id',$getsessioinid)->where('withdrawal_status',2)->select('withdrawals.withdrawal_amount');

					$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.created_at as created_at','booking_with_vendors.paymethod as paymethod','booking_with_vendors.amount as amount','booking_with_vendors.voucher_sales as voucher_sales',
											'booking_with_vendors.admin_commision as admin_commision','booking_with_vendors.vednor_fees as vednor_fees','booking_with_vendors.sales_agent_commision as sales_agent_commision')
											->orderBy('booking_with_vendors.created_at','ASC')
											->paginate(5);

						$withdrawaldetails =  	DB::table('withdrawals')
									->join('users','users.id','withdrawals.user_id')
									->where('withdrawals.user_id', $getsessioinid)
									->where('withdrawal_status',2)
									->select('withdrawals.created_at as created_at','withdrawals.wallet_amount as wallet_amount','withdrawals.withdrawal_amount as withdrawal_amount','withdrawals.balance as balance','withdrawals.withdrawal_status as withdrawal_status','withdrawals.reportflag as reportflag','users.name as name')
									->orderBy('withdrawals.bookingno','ASC')
									->paginate(5);


			}

			else if($getsessionrole==8)
			{

				$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
				$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;


								$totalAmountinAccount=DB::table('users')
								->Where('users.role',8)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

					$curdate = date('Y-m-d');

					$todaysalesviamobile =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',1)->sum('amount');

					$todaysalesviacounter = DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)
											->where('paymethod',2)->sum('amount');

					$SporstigoCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('sporstigototalcommision');

					$SalesagentCommision =    DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('Vendor_Reffer_commision');


					$netprofit =            DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->sum('netprofit');

					$todaytotalsales =       DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$vendorrefferalcreatedby)
											->where('paystatus','Y')
											->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



					$totalwithdrawal=  DB::table("withdrawals")->where('user_id',$getsessioinid)->where('withdrawal_status',2)->select('withdrawals.withdrawal_amount');

					$bookingtransactiondtls	= DB::table('booking_with_vendors')
																	->join('users','users.id','booking_with_vendors.vendor_id')
																	->where('users.createdby',$getsessioinid)
																	//->where('paystatus','Y')
																	//->orwhere('paystatus','R')
																	->whereIn('paystatus', ['Y','R'])
																	->select('booking_with_vendors.created_at as created_at','booking_with_vendors.paymethod as paymethod','booking_with_vendors.amount as amount','booking_with_vendors.voucher_sales as voucher_sales',
																	'booking_with_vendors.admin_commision as admin_commision','booking_with_vendors.vednor_fees as vednor_fees','booking_with_vendors.sales_agent_commision as sales_agent_commision')
																	->orderBy('booking_with_vendors.created_at','ASC')
																	->paginate(5);

					$withdrawaldetails =  	DB::table('withdrawals')
															->join('users','users.id','withdrawals.user_id')
															->where('withdrawals.user_id', $getsessioinid)
															->where('withdrawal_status',2)
															->select('withdrawals.created_at as created_at','withdrawals.wallet_amount as wallet_amount','withdrawals.withdrawal_amount as withdrawal_amount','withdrawals.balance as balance','withdrawals.withdrawal_status as withdrawal_status','withdrawals.reportflag as reportflag','users.name as name')
															->orderBy('withdrawals.bookingno','ASC')
															->paginate(5);

			}

			else
			{

			$totalAmountinAccount=DB::table('users')
								->Where('users.role',3)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

			$curdate = date('Y-m-d');

					$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('sporstigototalcommision');
					$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->sum('netprofit');
					$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
					$SalesagentCommision ='';
					$totalwithdrawal=  DB::table("withdrawals")->where('user_id',$getsessioinid)->where('withdrawal_status',2)->select('withdrawals.withdrawal_amount');


			$bookingtransactiondtls	= DB::table('booking_with_vendors')
									 ->where('booking_with_vendors.vendor_id', $getsessioinid)
									 //->where('paystatus','Y')
									//	->orwhere('paystatus','R')
									->whereIn('paystatus', ['Y','R'])
									 ->select('booking_with_vendors.created_at as created_at','booking_with_vendors.paymethod as paymethod','booking_with_vendors.amount as amount','booking_with_vendors.voucher_sales as voucher_sales',
									 'booking_with_vendors.admin_commision as admin_commision','booking_with_vendors.vednor_fees as vednor_fees','booking_with_vendors.sales_agent_commision as sales_agent_commision')
									 ->orderBy('booking_with_vendors.created_at','ASC')
									 ->paginate(5);


									 /*echo '<pre>bookingtransactiondtls ';
									 print_r($bookingtransactiondtls);
									 echo '</pre>';*/



			$withdrawaldetails =  DB::table('withdrawals')
								->join('users','users.id','withdrawals.user_id')
								->where('withdrawals.user_id', $getsessioinid)
								->where('withdrawal_status',2)
								->select('withdrawals.created_at as created_at','withdrawals.wallet_amount as wallet_amount','withdrawals.withdrawal_amount as withdrawal_amount','withdrawals.balance as balance','withdrawals.withdrawal_status as withdrawal_status','withdrawals.reportflag as reportflag','users.name as name')
								->orderBy('withdrawals.bookingno','ASC')
								->paginate(5);

								/*echo '<pre>withdrawaldetails ';
								print_r($withdrawaldetails);
								echo '</pre>';*/





			}
			return view('ReportWithdrawal',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','withdrawaldetails','totalwithdrawal','bookingtransactiondtls'));
		}
		else
		{
		   return redirect('/login');
		}


    }


	public function vendorwithdrawreportfilter(Request $request,$fromdate,$todate)
    {

		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}
		if($getsessioinid)
		{


			$pagetitle = 'Sales Report';
			$pageheading = 'Sales Report';

			if($getsessionrole==1)
			{
								$totalAmountinAccount=DB::table('users')
												->Where('users.role',3)
												->sum('wallet_amount');

								$curdate = date('Y-m-d');

								$todaysalesviamobile = DB::table("booking_with_vendors")->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
								$todaysalesviacounter = DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
								$SporstigoCommision =   DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->sum('sporstigototalcommision');
								$netprofit =            DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->sum('netprofit');
								$todaytotalsales =      DB::table("booking_with_vendors")->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
								$SalesagentCommision ='';
								$totalwithdrawal=  DB::table("withdrawals")->where('withdrawal_status',2)->select('withdrawals.withdrawal_amount');

								$bookingtransactiondtls	= DB::table('booking_with_vendors')
													->where('booking_with_vendors.created_at', '>=', $fromdate)
													->Where('booking_with_vendors.created_at','<=', $todate)
													//->where('paystatus','Y')
													//->orwhere('paystatus','R')
													->whereIn('paystatus', ['Y','R'])
													->select('booking_with_vendors.created_at as created_at','booking_with_vendors.paymethod as paymethod','booking_with_vendors.amount as amount','booking_with_vendors.voucher_sales as voucher_sales',
													'booking_with_vendors.admin_commision as admin_commision','booking_with_vendors.vednor_fees as vednor_fees','booking_with_vendors.sales_agent_commision as sales_agent_commision')
													->orderBy('booking_with_vendors.created_at','ASC')
													->paginate(5);

								  $withdrawaldetails =  DB::table('withdrawals')
											   ->join('users','users.id','withdrawals.user_id')
											    ->where('withdrawals.created_at', '>=', $fromdate)
												->Where('withdrawals.created_at','<=', $todate)
												->where('withdrawal_status',2)
											   ->select('withdrawals.created_at as created_at','withdrawals.wallet_amount as wallet_amount','withdrawals.withdrawal_amount as withdrawal_amount','withdrawals.balance as balance','withdrawals.withdrawal_status as withdrawal_status','withdrawals.reportflag as reportflag','users.name as name')
											   ->orderBy('withdrawals.bookingno','ASC')
											   ->paginate(5);


				}
				else if($getsessionrole==7)
				{
									$totalAmountinAccount=DB::table('users')
									->Where('users.role',7)
									->Where('users.id',$getsessioinid)
									->sum('wallet_amount');

						$curdate = date('Y-m-d');

						$todaysalesviamobile =   DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$getsessioinid)
												->where('paystatus','Y')
												->whereDate('booking_with_vendors.created_at',$curdate)
												->where('paymethod',1)->sum('amount');

						$todaysalesviacounter = DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$getsessioinid)
												->where('paystatus','Y')
												->whereDate('booking_with_vendors.created_at',$curdate)
												->where('paymethod',2)->sum('amount');

						$SporstigoCommision =    DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$getsessioinid)
												->where('paystatus','Y')
												->sum('sporstigototalcommision');
						$SalesagentCommision =   DB::table("booking_with_vendors")
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('paystatus','Y')
											->sum('sales_agent_commision');

						$netprofit =            DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$getsessioinid)
												->where('paystatus','Y')
												->sum('netprofit');

						$todaytotalsales =       DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$getsessioinid)
												->where('paystatus','Y')
												->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');

						$totalwithdrawal=  DB::table("withdrawals")->where('user_id',$getsessioinid)->where('withdrawal_status',2)->select('withdrawals.withdrawal_amount');

						$bookingtransactiondtls	= DB::table('booking_with_vendors')
											->join('users','users.id','booking_with_vendors.vendor_id')
											->where('users.createdby',$getsessioinid)
											->where('booking_with_vendors.created_at', '>=', $fromdate)
											->Where('booking_with_vendors.created_at','<=', $todate)
											//->where('paystatus','Y')
											//->orwhere('paystatus','R')
											->whereIn('paystatus', ['Y','R'])
											->select('booking_with_vendors.created_at as created_at','booking_with_vendors.paymethod as paymethod','booking_with_vendors.amount as amount','booking_with_vendors.voucher_sales as voucher_sales',
											'booking_with_vendors.admin_commision as admin_commision','booking_with_vendors.vednor_fees as vednor_fees','booking_with_vendors.sales_agent_commision as sales_agent_commision')
											->orderBy('booking_with_vendors.created_at','ASC')
											->paginate(5);

						   $withdrawaldetails =  DB::table('withdrawals')
											   ->join('users','users.id','withdrawals.user_id')
											   ->where('withdrawals.created_at', '>=', $fromdate)
											   ->Where('withdrawals.created_at','<=', $todate)
											   ->where('withdrawals.user_id', $getsessioinid)
											   ->where('withdrawal_status',2)
											   ->select('withdrawals.created_at as created_at','withdrawals.wallet_amount as wallet_amount','withdrawals.withdrawal_amount as withdrawal_amount','withdrawals.balance as balance','withdrawals.withdrawal_status as withdrawal_status','withdrawals.reportflag as reportflag','users.name as name')
											   ->orderBy('withdrawals.bookingno','ASC')
											   ->paginate(5);

				}


				else if($getsessionrole==8)
				{

					$vendorrefferalcreatedbylist = DB::table('users')->Where('users.role',8)->Where('users.id',$getsessioinid)->get()->first();
					$vendorrefferalcreatedby = $vendorrefferalcreatedbylist->createdby;


									$totalAmountinAccount=DB::table('users')
									->Where('users.role',8)
									->Where('users.id',$getsessioinid)
									->sum('wallet_amount');

						$curdate = date('Y-m-d');

						$todaysalesviamobile =   DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$vendorrefferalcreatedby)
												->where('paystatus','Y')
												->whereDate('booking_with_vendors.created_at',$curdate)
												->where('paymethod',1)->sum('amount');

						$todaysalesviacounter = DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$vendorrefferalcreatedby)
												->where('paystatus','Y')
												->whereDate('booking_with_vendors.created_at',$curdate)
												->where('paymethod',2)->sum('amount');

						$SporstigoCommision =    DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$vendorrefferalcreatedby)
												->where('paystatus','Y')
												->sum('sporstigototalcommision');

						$SalesagentCommision =    DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$vendorrefferalcreatedby)
												->where('paystatus','Y')
												->sum('Vendor_Reffer_commision');


						$netprofit =            DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$vendorrefferalcreatedby)
												->where('paystatus','Y')
												->sum('netprofit');

						$todaytotalsales =       DB::table("booking_with_vendors")
												->join('users','users.id','booking_with_vendors.vendor_id')
												->where('users.createdby',$vendorrefferalcreatedby)
												->where('paystatus','Y')
												->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');



						$totalwithdrawal=  DB::table("withdrawals")->where('user_id',$getsessioinid)->where('withdrawal_status',2)->select('withdrawals.withdrawal_amount');

						$bookingtransactiondtls	= DB::table('booking_with_vendors')
																		->join('users','users.id','booking_with_vendors.vendor_id')
																		->where('users.createdby',$getsessioinid)
																		//->where('paystatus','Y')
																		//->orwhere('paystatus','R')
																		->whereIn('paystatus', ['Y','R'])
																		->select('booking_with_vendors.created_at as created_at','booking_with_vendors.paymethod as paymethod','booking_with_vendors.amount as amount','booking_with_vendors.voucher_sales as voucher_sales',
																		'booking_with_vendors.admin_commision as admin_commision','booking_with_vendors.vednor_fees as vednor_fees','booking_with_vendors.sales_agent_commision as sales_agent_commision')
																		->orderBy('booking_with_vendors.created_at','ASC')
																		->paginate(5);

						$withdrawaldetails =  	DB::table('withdrawals')
																->join('users','users.id','withdrawals.user_id')
																->where('withdrawals.created_at', '>=', $fromdate)
											   					->Where('withdrawals.created_at','<=', $todate)
																->where('withdrawals.user_id', $getsessioinid)
																->where('withdrawal_status',2)
																->select('withdrawals.created_at as created_at','withdrawals.wallet_amount as wallet_amount','withdrawals.withdrawal_amount as withdrawal_amount','withdrawals.balance as balance','withdrawals.withdrawal_status as withdrawal_status','withdrawals.reportflag as reportflag','users.name as name')
																->orderBy('withdrawals.bookingno','ASC')
																->paginate(5);

				}


			else
			{

			$totalAmountinAccount=DB::table('users')
								->Where('users.role',3)
								->Where('users.id',$getsessioinid)
								->sum('wallet_amount');

			$curdate = date('Y-m-d');

			$todaysalesviamobile = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',1)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
			$todaysalesviacounter = DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
			$SporstigoCommision =   DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->sum('sporstigototalcommision');
			$netprofit =            DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->sum('netprofit');
			$todaytotalsales =      DB::table("booking_with_vendors")->where('vendor_id',$getsessioinid)->where('paymethod',2)->where('paystatus','Y')->whereDate('booking_with_vendors.created_at',$curdate)->sum('amount');
			$SalesagentCommision ='';
			$totalwithdrawal=  DB::table("withdrawals")->where('user_id',$getsessioinid)->where('withdrawal_status',2)->select('withdrawals.withdrawal_amount');


			$bookingtransactiondtls	= DB::table('booking_with_vendors')
													->where('booking_with_vendors.created_at', '>=', $fromdate)
													->Where('booking_with_vendors.created_at','<=', $todate)
													->Where('booking_with_vendors.vendor_id',$getsessioinid)
													//->where('paystatus','Y')
													//->orwhere('paystatus','R')
													->whereIn('paystatus', ['Y','R'])
													->select('booking_with_vendors.created_at as created_at','booking_with_vendors.paymethod as paymethod','booking_with_vendors.amount as amount','booking_with_vendors.voucher_sales as voucher_sales',
													'booking_with_vendors.admin_commision as admin_commision','booking_with_vendors.vednor_fees as vednor_fees','booking_with_vendors.sales_agent_commision as sales_agent_commision')
													->orderBy('booking_with_vendors.created_at','ASC')
													->paginate(5);

			$withdrawaldetails =  DB::table('withdrawals')
											   ->join('users','users.id','withdrawals.user_id')
											   ->where('withdrawals.created_at', '>=', $fromdate)
											   ->Where('withdrawals.created_at','<=', $todate)
											   ->where('withdrawals.user_id', $getsessioinid)
											   ->where('withdrawal_status',2)
											   ->select('withdrawals.created_at as created_at','withdrawals.wallet_amount as wallet_amount','withdrawals.withdrawal_amount as withdrawal_amount','withdrawals.balance as balance','withdrawals.withdrawal_status as withdrawal_status','withdrawals.reportflag as reportflag','users.name as name')
											   ->orderBy('withdrawals.bookingno','ASC')
											   ->paginate(5);

			}

			return view('ReportWithdrawal',compact('pagetitle','pageheading','totalAmountinAccount','todaysalesviacounter','SporstigoCommision','SalesagentCommision','netprofit','todaytotalsales','todaysalesviamobile','withdrawaldetails','totalwithdrawal','bookingtransactiondtls','todate'));
		}
		else
		{
		   return redirect('/login');
		}


    }


	public function vendormembership(Request $request)
    {

		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');
		$pagetitle = 'Sales Report';
		$pageheading = 'Sales Report';

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}

		if($getsessioinid)
		{

									if($getsessionrole==1)
									{

															$membershipsdetails =  DB::table('memberships')
															->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
															->join('vendors','vendors.vendor_id','membershipsbyusers.vendor_id')
															->join('users','users.id','membershipsbyusers.user_id')
															->where('memberships.status',1)
															->select('memberships.*','users.name as name','vendors.businessname','membershipsbyusers.fromdate','membershipsbyusers.todate','membershipsbyusers.created_at')
															->orderBy('memberships.membership_id','ASC')
															->paginate(5);

									}

									else
									{

															$membershipsdetails =  DB::table('memberships')
															->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
															->join('vendors','vendors.vendor_id','membershipsbyusers.vendor_id')
															->join('users','users.id','membershipsbyusers.user_id')
															->where('memberships.status',1)
															->where('memberships.vendor_id', $getsessioinid)
															->select('memberships.*','users.name as name','vendors.businessname','membershipsbyusers.fromdate','membershipsbyusers.todate','membershipsbyusers.created_at')
															->orderBy('memberships.membership_id','ASC')
															->paginate(5);






									}
							return view('ReportMembership',compact('pagetitle','pageheading','membershipsdetails'));
		}
		else
		{
		   					return redirect('/login');
		}





    }


	public function vendormembershipfilter(Request $request,$fromdate,$todate)
    {

		$getsessioinid = Session::get('getsessionuserid');
		$getsessionrole = Session::get('getsessionrole');
		$getsessionusertype = Session::get('getsessionusertype');
		$pagetitle = 'Sales Report';
		$pageheading = 'Sales Report';

		if($getsessionusertype=='Vendor')
		{

								$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
								$getsessioinid = $getVendorDetails->createdby;
								$getsessionrole = $getVendorDetails->role;

		}

		if($getsessioinid)
		{

									if($getsessionrole==1)
									{

															$membershipsdetails =  DB::table('memberships')
															->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
															->join('vendors','vendors.vendor_id','membershipsbyusers.vendor_id')
															->join('users','users.id','membershipsbyusers.user_id')
															->where('memberships.status',1)
															->where('membershipsbyusers.created_at', '>=', $fromdate)
															->Where('membershipsbyusers.created_at','<=', $todate)
															->select('memberships.*','users.name as name','vendors.businessname','membershipsbyusers.fromdate','membershipsbyusers.todate','membershipsbyusers.created_at')
															->orderBy('memberships.membership_id','ASC')
															->paginate(5);

									}

									else
									{

															$membershipsdetails =  DB::table('memberships')
															->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
															->join('vendors','vendors.vendor_id','membershipsbyusers.vendor_id')
															->join('users','users.id','membershipsbyusers.user_id')
															->where('memberships.status',1)
															->where('membershipsbyusers.created_at', '>=', $fromdate)
															->Where('membershipsbyusers.created_at','<=', $todate)
															->where('memberships.vendor_id', $getsessioinid)
															->select('memberships.*','users.name as name','vendors.businessname','membershipsbyusers.fromdate','membershipsbyusers.todate','membershipsbyusers.created_at')
															->orderBy('memberships.membership_id','ASC')
															->paginate(5);






									}
							return view('ReportMembership',compact('pagetitle','pageheading','membershipsdetails'));
		}
		else
		{
		   					return redirect('/login');
		}





    }


	public function instructorreport(Request $request)
    {
		 $getsessioinid = Session::get('getsessionuserid');
		 $getsessionrole = Session::get('getsessionrole');
		 $getsessionusertype = Session::get('getsessionusertype');
		 $pagetitle = 'Sales Report';
		 $pageheading = 'Sales Report';


			if($getsessionusertype=='Vendor')
			{

									$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
									$getsessioinid = $getVendorDetails->createdby;
									$getsessionrole = $getVendorDetails->role;

			}

		if($getsessioinid)
		{


			if($getsessionrole==1)
			{
			  //Admin Level


			  $instructordetails =  DB::table('instructor')
			  ->join('instructorbookings','instructorbookings.instructor_id','instructor.instructor_id')
			  ->join('categories','categories.id','instructor.sportcategory')
			  ->where('instructor.status',1)
			  ->select('instructor.user_name','instructor.sportcenter','categories.name','instructor.status','instructorbookings.instructor_booking_no',
			  		  'instructorbookings.username','instructorbookings.time','instructorbookings.date','instructorbookings.amount',
					  	'instructorbookings.admin_commision','instructorbookings.netprofit','instructorbookings.bookingstatus','instructorbookings.paystatus_id','instructorbookings.created_at')
			  ->orderBy('instructorbookings.instructor_booking_id','ASC')
			  ->paginate(5);


			}


			return view('ReportInstructor',compact('pagetitle','pageheading','instructordetails'));

		}
		else
		{
		   return redirect('/login');
		}



    }

	public function instructorreportfilter(Request $request,$fromdate,$todate)
    {
		 $getsessioinid = Session::get('getsessionuserid');
		 $getsessionrole = Session::get('getsessionrole');
		 $getsessionusertype = Session::get('getsessionusertype');
		 $pagetitle = 'Sales Report';
		 $pageheading = 'Sales Report';


			if($getsessionusertype=='Vendor')
			{

									$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
									$getsessioinid = $getVendorDetails->createdby;
									$getsessionrole = $getVendorDetails->role;

			}

		if($getsessioinid)
		{


			if($getsessionrole==1)
			{
			  //Admin Level


			  $instructordetails =  DB::table('instructor')
			  ->join('instructorbookings','instructorbookings.instructor_id','instructor.instructor_id')
			  ->join('categories','categories.id','instructor.sportcategory')
			  ->where('instructor.status',1)
			  ->where('instructorbookings.created_at', '>=', $fromdate)
			  ->Where('instructorbookings.created_at','<=', $todate)
			  ->select('instructor.user_name','instructor.sportcenter','categories.name','instructor.status','instructorbookings.instructor_booking_no',
			  		  'instructorbookings.username','instructorbookings.time','instructorbookings.date','instructorbookings.amount',
					  	'instructorbookings.admin_commision','instructorbookings.netprofit','instructorbookings.bookingstatus','instructorbookings.paystatus_id','instructorbookings.created_at')
			  ->orderBy('instructorbookings.instructor_booking_id','ASC')
			  ->paginate(5);


			}


			return view('ReportInstructor',compact('pagetitle','pageheading','instructordetails'));

		}
		else
		{
		   return redirect('/login');
		}



    }


}

