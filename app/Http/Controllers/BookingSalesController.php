<?php

namespace App\Http\Controllers;

use App\Models\usermanage;
use App\Models\User;
use App\Models\modulemast1;
use App\Models\staff;
use App\Models\rightsmapping;
use App\Models\userdetailmanage;
use App\Models\venues;
use App\Models\vendor;
use App\Models\vendordetails;
use App\Models\venuescourttimes;
use App\Models\bookingsummaryvendors;
use App\Models\cashbackdetails;
use App\Models\salesactivityvendorlogs;
use App\Models\vendorclosingdays;
use App\Models\booking_with_vendors;
use App\Models\withdrwalreports_with_vendors;
use App\Models\booking_with_vendorsdetails;
use App\Models\withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Imagick;
use SenangPay\SenangPay;

 
// require_once 'vendor/autoload.php';
 //require_once __DIR__ . '/vendor/autoload.php';
// require_once 'C:\xampp\htdocs\sportstigo\vendor/autoload.php';

require_once  base_path() . '/vendor/autoload.php';
use Orbitale\Component\ImageMagick\Command;

use DB;


class BookingSalesController extends Controller
{


	public function processorder(Request $request)
	{


			 /* $merchantId = '644166729208395';
			  $secretKey = '37411-92650033';

			  $senangPay = new SenangPay($merchantId, $secretKey);
			  $paymentUrl = $senangPay->createPayment(
				'SportstigoApplication',
				1000,
				56,
				[
				  'name' => 'TestingUser',
				  'email' => 'vendor230@sportstigo.com',
				  'phone' => '011223344'
				]
			  );

			 //return $paymentUrl;

			 return redirect($paymentUrl);*/

  }

	public function processReturnUrl(Request $request)
	{
		$successmessage = '';
		$order_id = $request->order_id;
		$firstCharacter = substr($order_id, 0, 1);

		$paystatus_id = $request->status_id;
		$transaction_id = $request->transaction_id;
		$msg = $request->msg;
		$hash = $request->hash;
		$updatepaymentdata=array(
			'paystatus'=>'Y',
			'paystatus_id'=>$paystatus_id,
			'transaction_id'=>$transaction_id,
			'msg'=>$msg,
			'hash'=>$hash,

		);

		if($firstCharacter=='B')
		{
			$updtquerypay = DB::table('booking_with_vendors')->where('bookingno',$order_id)->update($updatepaymentdata);


						$bookingrecordsdtls = DB::table('booking_with_vendors')->where('bookingno',$order_id)->first();
						$totalamount = $bookingrecordsdtls->amount;
						$bookingvendor_id = $bookingrecordsdtls->vendor_id;
						$bookinguser_id = $bookingrecordsdtls->user_id;

						//$totalamount

						$commisionmgmt=  DB::table('commisionmgmt')->select('commisionmgmt.*')->first();
						$admin_commisionval = $commisionmgmt->admin_commisionval;
						$Refferal_commisionval = $commisionmgmt->Refferal_commisionval;
						$sales_agent_commisionval = $commisionmgmt->sales_agent_commisionval;
						$Vendor_Reffer_commisionvalue	= $commisionmgmt->Vendor_Reffer_commisionval;



						//Calculating
						$admin_commision_Calculate = ($totalamount * $admin_commisionval) / 100;
						$vednor_fees_Calculate = 	$totalamount - $admin_commision_Calculate;

						$Refferal_commision_Calculate = ($admin_commision_Calculate * $Refferal_commisionval) / 100;
						$sales_agent_commision_Calculate = ($admin_commision_Calculate * $sales_agent_commisionval) / 100;
						$Vendor_Reffer_commision_Calculate = ($admin_commision_Calculate * $Vendor_Reffer_commisionvalue) / 100;
						$sporstigototalcommision_Calculate = $admin_commision_Calculate;
						$netprofit_Calculate =   $vednor_fees_Calculate;
						//Update commisson for above all

						$getexistsadmin =       User::where("role", "=", 1)->where('id', '=', 1)->first();
						$getwallet_amountadmin =   $getexistsadmin->wallet_amount + $admin_commision_Calculate;
						DB::table('users')->where('id', '=', 1)->where('role', '=', 1)->update(['wallet_amount' => $getwallet_amountadmin]); // Update for Admin Wallet

						$getexistsvendor =  User::where("id", "=", $bookingvendor_id)->first();
						$getwallet_amountvendor = $getexistsvendor->wallet_amount + $vednor_fees_Calculate;
						$getvendorcreatedby = $getexistsvendor->createdby;
						DB::table('users')->where('id', '=', $bookingvendor_id)->update(['wallet_amount' => $getwallet_amountvendor]); // Update for Vendor Wallet


						/*$getSalesperson =  User::where("id", "=", $getvendorcreatedby )->first();
						$getSalespersonID = $getSalesperson->id;
						$getexitsrole = $getSalesperson->role;

						if($getexitsrole=='7')
						{
							$getwallet_amountsalesperson = $getSalesperson->wallet_amount + $sales_agent_commision_Calculate;
							DB::table('users')->where('id', '=', $getSalespersonID)->where('role', '=', 7)->update(['wallet_amount' => $getwallet_amountsalesperson]); // Update for SalesAgent Wallet

						}

						if($getexitsrole=='8')
						{
							$getwallet_amountsalesperson = $getSalesperson->wallet_amount + $Vendor_Reffer_commision_Calculate;
							DB::table('users')->where('id', '=', $getSalespersonID)->where('role', '=', 8)->update(['wallet_amount' => $getwallet_amountsalesperson]); // Update for vendor refferal Wallet
						}*/


						   $getSalesperson =  User::where("id", "=", $getvendorcreatedby )->first();
																$getSalespersonID = $getSalesperson->id;
																$getwallet_amountsalesperson = $getSalesperson->wallet_amount + $sales_agent_commision_Calculate;
																DB::table('users')->where('id', '=', $getSalespersonID)->where('role', '=', 7)->update(['wallet_amount' => $getwallet_amountsalesperson]); // Update for SalesAgent Wallet

						    $checkVenodrrefferal =  vendor::where("vendor_id", "=", $bookingvendor_id)->first();
							$checkvendor_createdby=  $checkVenodrrefferal->createdby;
							$checkvendor_salesperson_vendorrefferal=  $checkVenodrrefferal->vendorrefferalid;
							$checkvendor_reffer_commisionval=  $checkVenodrrefferal->vendor_reffer_commisionval;

							if($checkvendor_reffer_commisionval=='Y')
							{
							$getexistsvendorrefferal =  User::where("id", "=", $checkvendor_salesperson_vendorrefferal)->first();
							$getwallet_vendorrefferal  = $getexistsvendorrefferal->wallet_amount + $Vendor_Reffer_commision_Calculate;
														DB::table('users')
														->where('id', '=', $checkvendor_salesperson_vendorrefferal)
														->update(['wallet_amount' => $getwallet_vendorrefferal]);

							}


							//Update Refferal User Commision if exists
							$getuserdetails = DB::table('users')->where('id',$bookinguser_id)->first();
							$getusername = $getuserdetails->name;
							$getuseremail = $getuserdetails->email;
							$getreferral_usercode = $getuserdetails->referral_user;
							$getusermobile = $getuserdetails->mobile;
							$gettotalbook = $getuserdetails->totalbook + 1;


						DB::table('users')->where('id', '=',$bookinguser_id)->update(['totalbook' => $gettotalbook]);


						if($getreferral_usercode)
							{
								$greferral_code = DB::table('users')->where('referral_code',$getreferral_usercode)->get();

								foreach($greferral_code as $rdtls)
								{
									$referral_user_id = $rdtls->id;
									$existearning = $rdtls->earning;
									//$existwallet_amount = $rdtls->wallet_amount;
									$existrefferalcashback = $rdtls->refferalcashback;
									$totexistrefferalcashback  = $existrefferalcashback + $Refferal_commision_Calculate;
									$totexistearning = $existearning + $Refferal_commision_Calculate;

									$updatedata=array('refferalcashback'=>$totexistrefferalcashback,'earning'=>$totexistearning);
									DB::table('users')->where('id', '=', $referral_user_id)->update($updatedata); // Update for Refferal User Commision if exists


									$cashbackdata = array('refferalcashback'=>$totexistrefferalcashback,
														'user_id'=>$referral_user_id,
														'referral_code'=>$getreferral_usercode,
														'admin_commision'=>$Refferal_commision_Calculate
														);


									cashbackdetails::insertGetId($cashbackdata);

								}

							}



							/*$getuserdetails = DB::table('users')->where('id',$bookinguser_id)->first();
							$getusername = $getuserdetails->name;
							$getuseremail = $getuserdetails->email;
							$getreferral_usercode = $getuserdetails->referral_user;
							$getusermobile = $getuserdetails->mobile;
							$gettotalbook = $getuserdetails->totalbook + 1;

							DB::table('users')->where('id', '=',$bookinguser_id)->update(['totalbook' => $gettotalbook]);
							if($getreferral_usercode)
								{
									$greferral_code = DB::table('users')->where('referral_code',$getreferral_usercode)->get();

									foreach($greferral_code as $rdtls)
									{
										$referral_user_id = $rdtls->id;
										$existwallet_amount = $rdtls->wallet_amount;
										$existearning = $rdtls->earning;
										$totexistwallet_amount  = $existwallet_amount + $Refferal_commision_Calculate;
										$totexistearning = $existearning + $Refferal_commision_Calculate;

										$updatedata=array('wallet_amount'=>$totexistwallet_amount,'earning'=>$totexistearning);

										DB::table('users')->where('id', '=', $referral_user_id)->update($updatedata); // Update for Refferal User Commision if exists

									}

								}*/




							//Update Court Count//

								$courtdetails = venues::select('venues.*')->where('venues.vendor_id', '=', $bookingvendor_id)->get()->all();
								foreach($courtdetails as $courtdtls)
								{

											$bookinglist = DB::table('booking_with_vendorsdetails')
														->where('vendor_id', '=', $bookingvendor_id)
														->where('courtid', '=', $courtdtls->id)
														->get();
											$bookingCount = $bookinglist->count();

											DB::table('venues')
											->where('id', $courtdtls->id)
											->where('vendor_id', $bookingvendor_id)
											->update(['bookingcount' => $bookingCount]);
								}





								//Update User Wallet Amount after getting walletmoney 1//

								/*if($request->walletmoney==1)
								{
									//DB::table('users')->where('id', '=', $bookinguser_id)->update(['wallet_amount' => '0']);
								DB::table('users')->where('id', '=', $bookinguser_id)->update(['wallet_amount' => $request->walletamount]);
								}*/
								$successmessage='New Booking Number generated successfully!';



		}

		if($firstCharacter=='I')
		{
			$updtquerypay = DB::table('instructorbookings')->where('instructor_booking_no',$order_id)->update($updatepaymentdata);

			if($paystatus_id==1)
			{

									//Calculating commission

									$instructorratedtls = DB::table('instructorbookings')
														->join('users','users.id','instructorbookings.instructor_id')
														->select('users.instructorrate','instructorbookings.instructor_id','instructorbookings.amount','instructorbookings.admin_commision','instructorbookings.netprofit')
													    ->where('instructor_booking_no',$order_id)->first();

									$instructorratedtls->instructor_id;
									$instructorratedtls->instructorrate;
									$instructorratedtls->amount;
									$instructorratedtls->admin_commision;
									$instructorratedtls->netprofit;


									//Update commisson for admin
									$getexistsadmin =       User::where("role", "=", 1)->where('id', '=', 1)->first();
									$getwallet_amountadmin =   $getexistsadmin->wallet_amount + $instructorratedtls->admin_commision;
									DB::table('users')->where('id', '=', 1)->where('role', '=', 1)->update(['wallet_amount' => $getwallet_amountadmin]); // Update for Admin Wallet

									//Update commisson for instructor
									$getexistsinstructor =       User::where("role", "=", 4)->where('id', '=', $instructorratedtls->instructor_id)->first();
									$getwallet_amountinstructor =   $getexistsinstructor->wallet_amount + $instructorratedtls->netprofit;

									$userdetails1 = array(
										'earning'=>$getwallet_amountinstructor,
										'wallet_amount'=>$getwallet_amountinstructor,
									);
									DB::table('users')->where('users.id',$instructorratedtls->instructor_id)->update($userdetails1);   // Update for instructor Wallet

									$successmessage='Instructor Payment done successfully!';

			}






		}
		if($firstCharacter=='M')
		{
									   $updtquerypay = DB::table('membershipsbyusers')->where('memberbookingno',$order_id)->update($updatepaymentdata);

										$memberrenewaldtls	 = DB::table('memberships')
															->join('membershipsbyusers','membershipsbyusers.membership_id','memberships.membership_id')
															->join('vendors','vendors.vendor_id','memberships.vendor_id')
															->join('users','users.id','membershipsbyusers.user_id')
															->where('memberships.status',1)
															->where('membershipsbyusers.memberbookingno', $order_id)
															->select('membershipsbyusers.id','membershipsbyusers.memberbookingno','users.name as name','vendors.businessname','vendors.address','membershipsbyusers.fromdate','membershipsbyusers.todate','memberships.image','membershipsbyusers.qrcodeimage','memberships.package_name',
															'memberships.package_desc1','memberships.package_desc2','memberships.package_desc3','memberships.package_desc4','memberships.package_desc5','memberships.package_duration','memberships.package_price','memberships.package_discount_price','membershipsbyusers.renew','memberships.status','membershipsbyusers.created_at','membershipsbyusers.paystatus','membershipsbyusers.paystatus_id','membershipsbyusers.transaction_id','membershipsbyusers.msg','membershipsbyusers.hash')
															->first();
										$memberrenewal = $memberrenewaldtls->renew;
										if($memberrenewal==1)
										{

											$package_duration = $memberrenewaldtls->package_duration;
											$fromdate = $memberrenewaldtls->fromdate;
											$todate = $memberrenewaldtls->todate;
											$newDatefrom = date('Y-m-d', strtotime($todate. ' + 1 days'));
											$newDateto = date('Y-m-d', strtotime($newDatefrom. ' + '.$package_duration.' months'));

											$details = array(
												'fromdate'=>$newDatefrom,
												'todate'=>$newDateto,

											);
											$updtnewdate = DB::table('membershipsbyusers')->where('memberbookingno',$order_id)->update($details);

											$successmessage='User Membership has been renewal successfully!';
											//dd($fromdate,$todate,$newDatefrom,$newDateto);

										}
										else
										{
											$successmessage='User Membership register successfully!';
										}




		}


		dd($order_id,$paystatus_id,$transaction_id,$msg,$hash,$successmessage);

		//return view('PaymentSuccess',compact('order_id','paystatus_id','transaction_id','msg','hash','successmessage'));

	}



	public function bookingsales()
    {

		// echo "assadasdsad";
		// echo '<pre> 123';
		// print_r(__DIR__);
		// echo '</pre>';

		// echo '<pre>';
		// print_r(base_path() . '/vendor/autoload.php');
		// echo '</pre>';
		// exit();

		// exit();
		$getsessioinid = Session::get('getsessionuserid');
		$pagetitle = 'BOOKING';
		$pageheading = 'BOOKING';
		if($getsessioinid)
					{

							return view('Booking_Vendor',compact('pagetitle','pageheading'));
					}
					else
					{
							return redirect('/login');
					}


    }

	public function checkinsales()
    {
        $getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'CHECKIN';
			$pageheading = 'CHECKIN';

			return view('Booking_Checkin',compact('pagetitle','pageheading'));
		}
		else
		{
		   return redirect('/login');
		}


    }


	public function bookingcheck()
    {
        $getsessioinid = Session::get('getsessionuserid');

		if($getsessioinid)
		{
			$pagetitle = 'CHECKIN WITH BOOKING NO';
			$pageheading = 'CHECKIN WITH BOOKING NO';

			return view('Booking_Checkin_Record',compact('pagetitle','pageheading'));
		}
		else
		{
		   return redirect('/login');
		}



    }
	public function bookingqrcodecheck()
    {

		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$pagetitle = 'CHECKIN WITH QRCODE';
			$pageheading = 'CHECKIN WITH QRCODE';

			return view('Booking_Checkin_QRCode_Record',compact('pagetitle','pageheading'));
		}
		else
		{
		   return redirect('/login');
		}


    }
	/*public function getcourttime(Request $request)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$array_court = explode(',', $_POST['courseids']);


		$venuescourttimes = DB::table('venuescourttimes')->whereIn('court_id', $array_court)->where('vendor_id', '=', $getsessioinid)->get()->all();



		$courthtml_content = '';
		$coursetimingarray = array();
		foreach($venuescourttimes as $venuescourttimeskey=>$venuescourttimesvalue){
			$coursetimingarray[$venuescourttimesvalue->court_id]['id'][] = $venuescourttimesvalue->id;
			$coursetimingarray[$venuescourttimesvalue->court_id]['time'][] = $venuescourttimesvalue->stime;
		}

		foreach($coursetimingarray as $coursetimingarraykey=>$coursetimingarrayvalue){
			$i = 0;
			foreach($coursetimingarrayvalue['id'] as $coursetimingarraykey1=>$coursetimingarrayvalue1){
				$idvalue = $coursetimingarrayvalue['id'][$i];
				$timevalue = $coursetimingarrayvalue['time'][$i];
				$courthtml_content .= '<div class="custom-timebox timebox ">
				  <input type="checkbox" name="timebox" id="'.$idvalue.'">
				  <label class="custom-label d-flex align-items-center '.$idvalue.'" for="'.$idvalue.'">
				  '.date("g:ia", strtotime($timevalue)).'
				  </label>
				  </div>';
				$i++;
			}
			$courthtml_content .= '<div class="seperater"></div>';
		}
		echo json_encode($courthtml_content);

	}*/
	public function getcloseingdays(Request $request)
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


								$vendorcloseingdays = vendorclosingdays::select('vendorclosingdays.*')
								->where('vendorclosingdays.vendor_id', '=', $getsessioinid)
								->where('vendorclosingdays.closingdays','<>', Null)
								->get();

								 $vendorcloseingdayscount = $vendorcloseingdays->count();
								 if($vendorcloseingdayscount>0)
								 {
												$vendorclosingdayslist = vendorclosingdays::select('vendorclosingdays.*')
												->where('vendorclosingdays.vendor_id', '=', $getsessioinid)
												->where('vendorclosingdays.closingdays','<>', Null)
												->get()->toArray();






												foreach($vendorclosingdayslist as $vendorclosingdayslistkey=>$vendorclosingdayslistvalue)
												{

												$vendorclosingdayslist_array[] = $vendorclosingdayslistvalue['closingdays'];
												}

												$days='';
												foreach ($vendorclosingdayslist_array as $vendorclosingdayslist_value)
												{
												 $days =  $days.''.$vendorclosingdayslist_value.',';
												}
												$closeingdays  = substr_replace($days ,"",-1);
												$closeingdaysformat = "[".trim($closeingdays)."]";

												echo json_encode($closeingdays);

								 }
								 else
								 {

									$closeingdays = '';
									$closeingdaysformat = "[".trim($closeingdays)."]";
									echo json_encode($closeingdays);
								 }





	}


	public function checkregisteruser(Request $request,$mobileno)
	{
		$userlist=     DB::table('users')
						->Where('mobile',$mobileno)
						->select('users.*')
						->get();

		$usercount = $userlist->count();
		$data1 = array();


		if($usercount>0)
		{
			$username =   $userlist[0]->name;
			$mobileno =   $userlist[0]->mobile;
			$userid =   $userlist[0]->id;
			$email =   $userlist[0]->email;

			$data1[0] = $usercount;
			$data1[1] = $username;
			$data1[2] = $mobileno;
			$data1[3] = $userid;
			$data1[4] = $email;
			echo json_encode($data1);
		}
		else
		{   $data1[0] = $usercount;
			$data1[1] = '';
			$data1[2] = '';
			$data1[3] = '';
			$data1[4] = '';

			echo json_encode($data1);
		}

	}
	public function getcourtdetails(Request $request,$id)
    {



		$pagetitle = 'CHECKIN';
        $pageheading = 'CHECKIN';
		$getsessioinid = Session::get('getsessionuserid');
		$request->session()->put('getsessiondate', $id);
		$getselectedday = date('l', strtotime($id));
		$request->session()->put('getsessiondday', $getselectedday);

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






        $courtdetails = venues::select('venues.*')
					   ->where('venues.vendor_id', '=', $getsessioinid)
					   //->where('venues.courtdate', '=', $id)
					   ->orderBy('name','ASC')
					   ->get()->all();

					  // print_r($courtdetails);




								$htmlcontent = '';

									foreach($courtdetails as $courtdtls){




								 $totalvendorcourtrecords = DB::table("venuescourttimes")->where('court_id',$courtdtls->id)->where('vendor_id',$getsessioinid)->count();
								 $totalbookingrecords = DB::table("venuescourttimes")->where('court_id',$courtdtls->id)->where('vendor_id',$getsessioinid)->where('bookstatus','1')->sum('bookstatus');

									$htmlcontent .= '<div class="bs-box d-flex align-items-center justify-content-around mb-4">
                                      <div class="d-flex align-items-center selectcourt'.$courtdtls->id.'">';
										if( $courtdtls->image ){

											$image_path = asset($courtdtls->image);

									   $htmlcontent .= '<div class="bs-imgbox">
											<img src="'.$image_path.'" width="140px" height="120px"  alt="Blog-image" />
                                        </div>';
										}
                                        $htmlcontent .= '<div class="bs-title ml-2">
	                                        <h4 class="cname"><b>Name : '.$courtdtls->name.'</b></h5>
										    <h4 class="ph">Desc : '.$courtdtls->courtdesc.'</h5>
											<h4 class="cprice">Normal Price : RM '.$courtdtls->normalprice.' : Per Hour/Slot</h5>
											<h4 class="cprice">Discount Price : RM '.$courtdtls->courtprice.' : Per Hour/Slot</h5>


                                        </div>
                                      </div>';

										//if( ($courtdtls->bookingcount < 9) )

										if($totalvendorcourtrecords!=$totalbookingrecords)

										{
										$htmlcontent .= '<div class="custom-timebox courtbox">
											  <input type="checkbox" name="courtname" data-id="'.$courtdtls->id.'" onclick="handleClick(this)" id="selectcourt'.$courtdtls->id.'">
                                              <label class="custom-label d-flex align-items-center" for="selectcourt'.$courtdtls->id.'">Select</label>
                                              <h5 class="d-flex justify-content-center">Price: RM '.$courtdtls->courtprice.'
										</div></h5>
										<div class="pax-box">
										<button type="button" class="pax-btn" onclick="increaseQty('.$courtdtls->id.')" >+</button><label id="'.$courtdtls->id.'_qty" class="person-qty" data-value="1">1</label><button onclick="decreaseQty('.$courtdtls->id.')" type="button" data-id="'.$courtdtls->id.'" class="pax-btn">-</button>
										</div>
										';

									    }

										else{

								         $htmlcontent .= '<div class="custom-timebox courtbox">
											  <input type="checkbox" name="courtname" id="selectfull'.$courtdtls->id.'" class="booked">
											  <label class="custom-label d-flex align-items-center" for="selectfull'.$courtdtls->id.'">Full</label>
										</div>';
										}
                                    $htmlcontent .= '</div>';
                                    }


					   echo json_encode($htmlcontent);

		//return $courtdetails;




    }

	public function getcourttime(Request $request)
    {
		$getsessioinid = Session::get('getsessionuserid');
		$getsessiondday = Session::get('getsessiondday');
		$getsessionusertype = Session::get('getsessionusertype');
		$array_court = explode(',', $_POST['courseids']);






		 if($getsessionusertype=='Vendor')
		 {

			$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
			$getsessioinid = $getVendorDetails->createdby;

		}
		else
		{
			$getsessioinid = Session::get('getsessionuserid');
		}


		 $courthtml_content = '';
		 $count = 0;




		foreach($array_court as $value)
		{

				$array_courtid = $value;
				$venuescourttimes = DB::table('venuescourttimes')
									->where('court_id', '=', $array_courtid)
									->where('vendor_id', '=', $getsessioinid)
									->where('days', '=', $getsessiondday)
									->get()->all();

				$i = 0;
				$coursename = $venuescourttimes[$i]->name;
				$courseid = $venuescourttimes[$i]->id;
				$courthtml_content .= "<b>Time Slot For ".$coursename.'</b> :- <div id="timeItem'.$courseid.'" class="timeItem d-flex flex-wrap align-items-center justify-content-center" >';




				foreach($venuescourttimes as $vcourttimes)
				{


					if( ($vcourttimes->bookstatus == 1) )
					{

					$courthtml_content .= '<div class="custom-timebox timebox ">


						<input type="checkbox" name="timebox" data-id="'.$vcourttimes->id.'" onclick="handleCourttimeClick(this)" id="selectcourt'.$vcourttimes->id.'" class="booked">

						<label class="custom-label d-flex align-items-center '.$vcourttimes->id.'" for="selectcourt'.$vcourttimes->id.'">
						'.date("g:ia", strtotime($vcourttimes->stime)).'-'.date("g:ia", strtotime($vcourttimes->etime)).'
						</label>
						</div>';
					}
					else
					{
						$courthtml_content .= '<div class="custom-timebox timebox ">


						<input type="checkbox" name="timebox" data-id="'.$vcourttimes->id.'" onclick="handleCourttimeClick(this)" id="selectcourt'.$vcourttimes->id.'">

						<label class="custom-label d-flex align-items-center '.$vcourttimes->id.'" for="selectcourt'.$vcourttimes->id.'">
						'.date("g:ia", strtotime($vcourttimes->stime)).'-'.date("g:ia", strtotime($vcourttimes->etime)).'
						</label>
						</div>';

					}



						$i++;
				}
						$courthtml_content .= '</div>';
						$count++;
		}

		echo json_encode($courthtml_content);

	}




	public function getcourttimesummay(Request $request)
	{

		$getsessioinid = Session::get('getsessionuserid');
		$getsessionloginname = Session::get('getsessionloginname');
		$getsessiondate = Session::get('getsessiondate');
		$array_court = explode(',', $_POST['courseids']);
		$noOfpersonsArr = json_decode($request->courtPersons, TRUE);
		$deletebookingsummaryvendors =   DB::table('bookingsummaryvendors')->where('vendor_id', '=',$getsessioinid)->delete();

		$getsessionusertype = Session::get('getsessionusertype');
		if($getsessionusertype=='Vendor')
		{

			$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
			$getsessioinid = $getVendorDetails->createdby;

			$getVendorname =  User::where("id", "=", $getVendorDetails->createdby)->first();
			$getsessionloginname = $getVendorname->name;
		}
		else
		{
			$getsessionloginname = Session::get('getsessionloginname');
			$getsessioinid = Session::get('getsessionuserid');
		}




		$count = 0;

		foreach($array_court as $value)
		{

		$array_courttimeid = $value;
		$venuescourttimes =  DB::table('venuescourttimes')
							->join('venues','venues.id','venuescourttimes.court_id')
							->where('venuescourttimes.id', '=', $array_courttimeid)
							->where('venuescourttimes.vendor_id', '=',$getsessioinid)
							->select('venuescourttimes.court_id as court_id',
									'venuescourttimes.vendor_id as vendor_id',
									'venuescourttimes.name as name',
									'venuescourttimes.timedesc as timedesc',
									'venuescourttimes.days as days',
									'venuescourttimes.stime as stime',
									'venuescourttimes.etime as etime',
									'venuescourttimes.id as timeid',
									'venuescourttimes.price as courtprice')
							->get();

				//date_default_timezone_set('Asia/Kolkata');
				date_default_timezone_set('Asia/Kuala_Lumpur');
				foreach($venuescourttimes as $vcourttimes)
				{

					$data1=array(
					'vendor_id'=>$vcourttimes->vendor_id,
					'court_id'=>$vcourttimes->court_id,
					'name'=>$vcourttimes->name,
					'timedesc'=>$vcourttimes->timedesc,
					'days'=>$vcourttimes->days,
					"stime" =>$vcourttimes->stime,
					"etime" =>$vcourttimes->etime,
					'price'=>$vcourttimes->courtprice,
					"timeid" =>$vcourttimes->timeid,
					"checkindate" =>$getsessiondate,
					'bookstatus'=>'0',
					'created_at' =>  date("Y-m-d H:i:s"),
					'updated_at' =>  date("Y-m-d H:i:s"),
					'pax' => !empty($noOfpersonsArr[$vcourttimes->court_id]) ? $noOfpersonsArr[$vcourttimes->court_id] : 1
					);
					bookingsummaryvendors::insertGetId($data1);


				}

		}

		$bookingsummary =  DB::table('bookingsummaryvendors')
							->where('vendor_id', '=',$getsessioinid)
							->select('bookingsummaryvendors.name as name','bookingsummaryvendors.checkindate as checkindate','bookingsummaryvendors.price as price','bookingsummaryvendors.stime as stime','bookingsummaryvendors.etime as etime', 'bookingsummaryvendors.court_id as court_id', 'bookingsummaryvendors.pax as pax')
							->get();




		$courthtml_content = '';
		$courthtml_content = '<p>Venue Name : '.$getsessionloginname.'</p>';
		$price=0;
		foreach($bookingsummary as $bsummary)
		{
			//$etime = strtotime($bsummary->stime)+ 60;
			$rowTotal = $bsummary->price * $bsummary->pax;
			$courthtml_content .= '<div class="custom-border mb-3 mt-3"></div>
                                      <h6>'.$bsummary->name.' | Total: '.$bsummary->pax.' pax</h6>

									  <p>Checkin Date / Time :
									  '.\Carbon\Carbon::parse($bsummary->stime)->format('h.ia').'
									  /
									  '.\Carbon\Carbon::parse($bsummary->checkindate)->format('d.m.Y').'
									  </p>

									  <p>Checkout Date / Time :
									  '.\Carbon\Carbon::parse($bsummary->etime)->format('h.ia').'
									  /
									  '.\Carbon\Carbon::parse($bsummary->checkindate)->format('d.m.Y').'
									  </p>
                                      <p class="text-green" data-pax="'.$bsummary->pax.'" data-row-total="'.$rowTotal.'">RM '.number_format($rowTotal + $rowTotal*7.5/100,2).'</p>
									  
									  </div>';

			$price += $rowTotal;
		}

        $price =$price*7.5/100  + $price;
        $price = number_format($price,2);

		$courthtml_content .= '<hr><div><p class="text-green">Total Amount: RM '.$price.'</p> </div>';

		$data1 = array();
		$data1[0] = $courthtml_content;
		$data1[1] = '<hr><h5><div><font color="green">Total Amount: RM '.$price.' </font></h5></div>';
		echo json_encode($data1);





	}

	public function payatcounter(Request $request)
	{


		 $paymentmethodid = $_POST['paymentmethodid'];


		$getsessioinid = Session::get('getsessionuserid');
		$getsessionloginname = Session::get('getsessionloginname');
		$getsessiondate = Session::get('getsessiondate');



		$getsessionusertype = Session::get('getsessionusertype');
		if($getsessionusertype=='Vendor')
		{

			$getVendorDetails =  User::where("id", "=", $getsessioinid)->first();
			$getsessioinid = $getVendorDetails->createdby;
			$getVendorname =  User::where("id", "=", $getVendorDetails->createdby)->first();
			$getsessionloginname = $getVendorname->name;
		}
		else
		{
			$getsessionloginname = Session::get('getsessionloginname');
			$getsessioinid = Session::get('getsessionuserid');
		}





		$paystatus = 'N';
		if($paymentmethodid=='1')
		{
			$paystatus = 'N';
			$getmobileno = $request->getmobileno;
			$getusername = $request->getusername;
			$getuserid = $request->getuserid;
			$getemail = $request->getemail;


		}
		else
		{
			$paystatus = 'Y';
			$getmobileno = '';
			$getusername = '';
			$getuserid =  0;
			$getemail = '';
		}







		$randomNumber = rand(1000000000,9999999999);

		$maxbookingno = 'B'.$randomNumber;

		$checkexistmaxbookingno = DB::table('booking_with_vendors')
								->where('bookingno', '=', $maxbookingno)
								->select('booking_with_vendors.bookingno')
								->get()->count();

		if($checkexistmaxbookingno==1)
		{
			$randomNumber = rand(1000000000,9999999999);
			$maxbookingno = 'B'.$randomNumber;
		}



		/*$maxbookingno = DB::table('booking_with_vendors')->max('bookingno');
		if($maxbookingno==''){
				$maxbookingno = '10001';
			}
		else{
				$maxbookingno = $maxbookingno + 1;
			}*/





		$bookingsummary =  DB::table('bookingsummaryvendors')
							->where('vendor_id', '=',$getsessioinid)
							->select('bookingsummaryvendors.*')
							->distinct()->get();
		$totalamount=0;
		$courtbookcount=0;
		foreach($bookingsummary as $bdata)
				{
                    $price = $bdata->price + $bdata->price*7.5/100;
                    $price = number_format($price,2);

					$data1=array(
					'bookingno'=>$maxbookingno,
					'vendor_id'=>$bdata->vendor_id,
					'courtid'=>$bdata->court_id,
					'courtname'=>$bdata->name,
					"timedesc" =>$bdata->timedesc,
					"days" =>$bdata->days,
					"stime" =>$bdata->stime,
					"etime" =>$bdata->etime,
					"price" =>$price,
					"date"  =>$getsessiondate,
					"pax" => $bdata->pax

					);
					$totalamount = $totalamount + ($bdata->price * $bdata->pax);

					booking_with_vendorsdetails::insertGetId($data1);
					$bookstatus =array('bookstatus'=>'1');
					$updatebookslot =  DB::table('venuescourttimes')
									   ->where('vendor_id',$bdata->vendor_id)
									   ->where('court_id',$bdata->court_id)
									   ->where('timedesc',$bdata->timedesc)
									   ->where('days',$bdata->days)
									   ->where('stime',$bdata->stime)
									   ->where('etime',$bdata->etime)
									   ->update($bookstatus);

				}

		//$totalamount

		$commisionmgmt=  DB::table('commisionmgmt')
					     ->select('commisionmgmt.*')
						 ->first();
		$admin_commisionval = $commisionmgmt->admin_commisionval;
		$Refferal_commisionval = $commisionmgmt->Refferal_commisionval;
		$sales_agent_commisionval = $commisionmgmt->sales_agent_commisionval;
		$Vendor_Reffer_commisionvalue	= $commisionmgmt->Vendor_Reffer_commisionval;



		//Calculating
		$admin_commision_Calculate = ($totalamount * $admin_commisionval) / 100;
		$vednor_fees_Calculate = 	$totalamount - $admin_commision_Calculate;

		$Refferal_commision_Calculate = ($admin_commision_Calculate * $Refferal_commisionval) / 100;
		$sales_agent_commision_Calculate = ($admin_commision_Calculate * $sales_agent_commisionval) / 100;

		$Vendor_Reffer_commision_Calculate = ($admin_commision_Calculate * $Vendor_Reffer_commisionvalue) / 100;

		$sporstigototalcommision_Calculate = $admin_commision_Calculate;
		$netprofit_Calculate =   $vednor_fees_Calculate;

		/*$checkvendorreffercommison =  vendor::where("vendor_id", "=", $getsessioinid)->first();
		$checkvendorreffercommisonID=  $checkvendorreffercommison->vendorrefferalid;
		$checkvendorreffercommisonValue=  $checkvendorreffercommison->vendor_reffer_commisionval;


		if(($checkvendorreffercommisonID==0) && ($checkvendorreffercommisonValue=='N'))
		{
			$Vendor_Reffer_commision_Calculate = 0;
		}
		else
		{

			$Vendor_Reffer_commision_Calculate = ($admin_commision_Calculate * $Vendor_Reffer_commisionvalue) / 100;

		}	*/



		/*$sporstigototalcommision_Calculate = $admin_commision_Calculate + $Refferal_commision_Calculate  + $sales_agent_commision_Calculate  + $Vendor_Reffer_commision_Calculate;
		/*$netprofit_Calculate = $totalamount - $sporstigototalcommision_Calculate;


		/*echo "calculating";
		echo "<br>";
		print_r("admin_commision_Calculate=".$admin_commision_Calculate);echo "<br>";
		print_r('vednor_fees_Calculate='.$vednor_fees_Calculate);echo "<br>";
		print_r('Refferal_commision_Calculate='.$Refferal_commision_Calculate);echo "<br>";
		print_r('sales_agent_commision_Calculate='.$sales_agent_commision_Calculate);echo "<br>";
		print_r('Vendor_Reffer_commision_Calculate='.$Vendor_Reffer_commision_Calculate);echo "<br>";
		echo "<br>";*/


		$qrcodeimage = 'qrcodeimages/'.$maxbookingno.'.png';
		$data2=array(
					'bookingno'=>$maxbookingno,
					'vendor_id'=>$getsessioinid,
					'user_id'=>$getuserid,
					'username'=>$getusername,
					'email'=>$getemail,
					'mobileno'=>$getmobileno,
					'paymethod'=>$paymentmethodid,
					'amount'=>$totalamount,
					'vednor_fees'=>$vednor_fees_Calculate,
					'admin_commision'=>$admin_commision_Calculate,
					'Refferal_commision'=>$Refferal_commision_Calculate,
					'sales_agent_commision'=>$sales_agent_commision_Calculate,
					'Vendor_Reffer_commision'=>$Vendor_Reffer_commision_Calculate,
					'sporstigototalcommision'=>$sporstigototalcommision_Calculate,
					'netprofit'=>$netprofit_Calculate,
					'qrcodeimage'=>$qrcodeimage,
					'date'  =>$getsessiondate,
					'paystatus'=>$paystatus,

					);
		booking_with_vendors::insertGetId($data2);

		//Generated QRCODE
		$bookingtransactiondtls	= DB::table('booking_with_vendors')
									->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
									->where('booking_with_vendors.bookingno',$maxbookingno)
									->select('booking_with_vendors.bookingno','booking_with_vendors.mobileno','booking_with_vendors.date as bookingdate','booking_with_vendors.amount','booking_with_vendorsdetails.courtname','booking_with_vendorsdetails.price')
									->get();

		$JSONdata = json_encode($maxbookingno);
	    //QrCode::size(200)->generate($JSONdata,public_path('qrcodeimages/'.$qrcodeimage));
		QrCode::size(200)->format('png')->generate($JSONdata , public_path($qrcodeimage));

		if($paymentmethodid=='2')
		 {


						//Update commisson for above all

						$getexistsadmin =       User::where("role", "=", 1)->where('id', '=', 1)->first();
						$getwallet_amountadmin =   $getexistsadmin->wallet_amount + $admin_commision_Calculate;
						DB::table('users')->where('id', '=', 1)->where('role', '=', 1)->update(['wallet_amount' => $getwallet_amountadmin]); // Update for Admin Wallet

						$getexistsvendor =  User::where("id", "=", $getsessioinid)->first();
						$getwallet_amountvendor = $getexistsvendor->wallet_amount + $vednor_fees_Calculate;
						$getvendorcreatedby = $getexistsvendor->createdby;
						DB::table('users')->where('id', '=', $getsessioinid)->update(['wallet_amount' => $getwallet_amountvendor]); // Update for Vendor Wallet

						$getSalesperson =  User::where("id", "=", $getvendorcreatedby )->first();
						$getSalespersonID = $getSalesperson->id;
						$getexitsrole = $getSalesperson->role;

						if($getexitsrole=='7')
						{
							$getwallet_amountsalesperson = $getSalesperson->wallet_amount + $sales_agent_commision_Calculate;
							DB::table('users')->where('id', '=', $getSalespersonID)->where('role', '=', 7)->update(['wallet_amount' => $getwallet_amountsalesperson]); // Update for SalesAgent Wallet

						}

						if($getexitsrole=='8')
						{
							$getwallet_amountsalesperson = $getSalesperson->wallet_amount + $Vendor_Reffer_commision_Calculate;
							DB::table('users')->where('id', '=', $getSalespersonID)->where('role', '=', 8)->update(['wallet_amount' => $getwallet_amountsalesperson]); // Update for vendor refferal Wallet
						}
		}


	    /*$checkVenodrrefferal =  vendor::where("vendor_id", "=", $getsessioinid)->first();
	    $checkvendor_createdby=  $checkVenodrrefferal->createdby;
		$checkvendor_salesperson_vendorrefferal=  $checkVenodrrefferal->vendorrefferalid;
	    $checkvendor_reffer_commisionval=  $checkVenodrrefferal->vendor_reffer_commisionval;

	    if($checkvendor_reffer_commisionval=='Y')
	    {
		$getexistsvendorrefferal =  User::where("id", "=", $checkvendor_salesperson_vendorrefferal)->first();
		$getwallet_vendorrefferal  = $getexistsvendorrefferal->wallet_amount + $Vendor_Reffer_commision_Calculate;
									DB::table('users')
									->where('id', '=', $checkvendor_salesperson_vendorrefferal)
									->update(['wallet_amount' => $getwallet_vendorrefferal]);

	    }*/

		//Update Refferal User Commision if exists

		 /*if($paymentmethodid=='1')
		 {

						$getuserdetails = DB::table('users')->where('id',$getuserid)->first();
						$getusername = $getuserdetails->name;
						$getreferral_usercode = $getuserdetails->referral_user;

						$gettotalbook = $getuserdetails->totalbook + 1;
						DB::table('users')->where('id', '=',$getuserid)->update(['totalbook' => $gettotalbook]);


					  if($getreferral_usercode)
						{
							$greferral_code = DB::table('users')->where('referral_code',$getreferral_usercode)->get();

							foreach($greferral_code as $rdtls)
							{
								 $referral_user_id = $rdtls->id;
								 $existearning = $rdtls->earning;
								 //$existwallet_amount = $rdtls->wallet_amount;
								 $existrefferalcashback = $rdtls->refferalcashback;
								 $totexistrefferalcashback  = $existrefferalcashback + $Refferal_commision_Calculate;
								 $totexistearning = $existearning + $Refferal_commision_Calculate;

								 $updatedata=array('refferalcashback'=>$totexistrefferalcashback,'earning'=>$totexistearning);
								 DB::table('users')->where('id', '=', $referral_user_id)->update($updatedata); // Update for Refferal User Commision if exists


								$cashbackdata = array('refferalcashback'=>$totexistrefferalcashback,
													   'user_id'=>$referral_user_id,
													   'referral_code'=>$getreferral_usercode,
													   'admin_commision'=>$Refferal_commision_Calculate
													 );


								cashbackdetails::insertGetId($cashbackdata);

							}

						}
		  }*/





	 /*echo "updateing user wallet_amount";
	 echo "<br>";
	 print_r("getwallet_amountadmin=".$getwallet_amountadmin);echo "<br>";
	 print_r('getwallet_amountvendor='.$getwallet_amountvendor);echo "<br>";
	 print_r('getwallet_amountsalesperson='.$getwallet_amountsalesperson);echo "<br>";
	 print_r('getwallet_vendorrefferal='.$getwallet_vendorrefferal);echo "<br>";
	 echo "<br>";*/

	 if($paymentmethodid=='2')
	 {
	 		//Update Court Count//

				$courtdetails = venues::select('venues.*')
					   ->where('venues.vendor_id', '=', $getsessioinid)
					   ->get()->all();


					foreach($courtdetails as $courtdtls)
					{

					$bookinglist = DB::table('booking_with_vendorsdetails')
								  ->where('vendor_id', '=', $getsessioinid)
								  ->where('courtid', '=', $courtdtls->id)
						          ->get();
					$bookingCount = $bookinglist->count();

									DB::table('venues')
									->where('id', $courtdtls->id)
									->where('vendor_id', $getsessioinid)
									->update(['bookingcount' => $bookingCount]);
					}

	}



				$deletebookingsummaryvendors = DB::table('bookingsummaryvendors')->where('vendor_id', '=',$getsessioinid)->delete();

				/** Start senangPay Payment Integration*/

				/*if($paymentmethodid=='1')
				{

							$merchantId = '134167042037647';
							$secretKey = '5163-519';

							$senangPay = new SenangPay($merchantId, $secretKey);
							$paymentUrl = $senangPay->createPayment(
							'SportstigoApplication',
							$totalamount,
							$maxbookingno,
							[
								'name' => $request->getusername,
								'email' => $request->getemail,
								'phone' => '+'.$request->getmobileno
							]
							);

							//return redirect($paymentUrl);
							echo json_encode($paymentUrl);
			     }*/



				/** End senangPay Payment Integration*/
				if($paymentmethodid=='1')
				{

									  $courthtml_content = '';
									  $courthtml_content .= '<div class="main-section pt-4 pb-4">
									  <div class="container">
										<div class="boxes row ">
										  <div class="col-md-4 ml-0">
											<div class="black-box">
											  <div><span class="main-text">Booking</span></div>
											  <div><span class="sub-text">Book Your Sports</span></div>
											</div>
										  </div>
										</div>
									  </div>
									  <div class="custom-border mt-4"></div>
									<div class="container">
										<div class="row text-center">
										  <div class="col-lg-12 mt-4 mb-2">
											  <h2 class="text-center"><strong>THANK YOU</strong></h2>
											  <a href="'.route("bookingcheck").'"> <button type="submit" class="booking-btn mt-3 mb-3">Booking No: '.$maxbookingno.'</button></a>
											  <p class="text-black"><strong>login to sportstigo. Mobile Apps and check This booking Info at “Booking” Menu and make payment.<br>Make sure you login with your registered mobile no</strong></p>
											  <a href="'.route("dashboard").'"><center><button type="button" class="theme-btn">BACK TO ADMIN</button></center></a>
										  </div>
										</div>
									  </div>
									  <div class="custom-border mt-4"></div>
									</div>


								  </div>';

								 echo json_encode($courthtml_content);
				}

				if($paymentmethodid=='2')
				{

									  $courthtml_content = '';
									  $courthtml_content .= '<div class="main-section pt-4 pb-4">
									  <div class="container">
										<div class="boxes row ">
										  <div class="col-md-4 ml-0">
											<div class="black-box">
											  <div><span class="main-text">Booking</span></div>
											  <div><span class="sub-text">Book Your Sports</span></div>
											</div>
										  </div>
										</div>
									  </div>
									  <div class="custom-border mt-4"></div>
									<div class="container">
										<div class="row text-center">
										  <div class="col-lg-12 mt-4 mb-2">
											  <h2 class="text-center"><strong>THANK YOU</strong></h2>
											  <a href="'.route("bookingcheck").'"> <button type="submit" class="booking-btn mt-3 mb-3">Booking No: '.$maxbookingno.'</button></a>
											  <p class="text-black"><strong>Kindly request client to login Sportstigo app and make payment.<br>Booking Status only will be Confirmed Once payment is made/Successfull! </strong></p>
											  <p class="text-black"><strong>Mohon pelanggan log masuk aplikasi Sportstigo dan buat pembayaran. Status tempahan akan disahkan Setelah pembayaran dibuat/berjaya! </strong></p>
											  <p class="text-black"><strong>请要求客户登录 Sportstigo 应用程序并付款。只有付款/成功后才会确认预订状态 !</strong></p>
											  <p class="text-black"><strong>ஸ்போர்ட்ஸ்டிகோ செயலியில் உள்நுழைந்து பணம் செலுத்துமாறு வாடிக்கையாளரைக் கேளுங்கள்.பணம் செலுத்தப்பட்டதும்/வெற்றிகரமானதும் மட்டுமே முன்பதிவு நிலை உறுதிப்படுத்தப்படும்</strong></p>
											  <a href="'.route("dashboard").'"><center><button type="button" class="theme-btn">Back to Home</button></center></a>
										  </div>
										</div>
									  </div>
									  <div class="custom-border mt-4"></div>
									</div>


								  </div>';

								 echo json_encode($courthtml_content);
				}






	}





	public function checkwithbookingno(Request $request)
	{

		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$bookingno = $request->bookingno;
			$bookingdetails=DB::table('booking_with_vendors')
				->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
				->Where('booking_with_vendors.bookingno',$request->bookingno)
				->Where('booking_with_vendors.vendor_id',$getsessioinid)
				->Where('booking_with_vendors.paystatus','Y')

				->select('booking_with_vendors.*','booking_with_vendorsdetails.*')
				->get();

		   $paymethoddtls=DB::table('booking_with_vendors')
						->Where('booking_with_vendors.bookingno',$request->bookingno)
						->Where('booking_with_vendors.vendor_id',$getsessioinid)
						->Where('booking_with_vendors.paystatus','Y')
						->select('booking_with_vendors.paymethod','booking_with_vendors.qrcodeimage','booking_with_vendors.bookingno')
						->first();

						DB::table('booking_with_vendors')->where('bookingno', '=', $bookingno)->update(['checkinstatus' => 1]); // Update for Checkin

		 return view('Booking_Checkin_Record',compact('bookingdetails','paymethoddtls'));

		}
		else
		{
		   return redirect('/login');
		}


	}

	public function checkwithbookingnoqrcode(Request $request)
	{
		$getsessioinid = Session::get('getsessionuserid');
		if($getsessioinid)
		{
			$bookingno =  str_replace('"', '', $request->text);

			$request->session()->put('getsessionbookingno', $bookingno);
			$bookingdetails=DB::table('booking_with_vendors')
				->join('booking_with_vendorsdetails','booking_with_vendorsdetails.bookingno','booking_with_vendors.bookingno')
				->Where('booking_with_vendors.bookingno',$bookingno)
				->Where('booking_with_vendors.vendor_id',$getsessioinid)
				->Where('booking_with_vendors.paystatus','Y')
				->select('booking_with_vendors.*','booking_with_vendorsdetails.*')
				->get();

		    $paymethoddtls=DB::table('booking_with_vendors')
						->Where('booking_with_vendors.bookingno',$bookingno)
						->Where('booking_with_vendors.vendor_id',$getsessioinid)
						->Where('booking_with_vendors.paystatus','Y')
						->select('booking_with_vendors.paymethod','booking_with_vendors.qrcodeimage','booking_with_vendors.bookingno')
						->first();
			DB::table('booking_with_vendors')->where('bookingno', '=', $bookingno)->update(['checkinstatus' => 1]); // Update for Checkin

		 return view('Booking_Checkin_QRCode_Record',compact('bookingdetails','paymethoddtls','bookingno'));
		}
		else
		{
		   return redirect('/login');
		}




	}

	public function postcheckin(Request $request)
	{
        $updtsuccess = DB::table('booking_with_vendorsdetails')->where('id', '=',$request->bookingid)->update(['checkinstatus' => 1]);
		echo json_encode($updtsuccess);
	}

}

