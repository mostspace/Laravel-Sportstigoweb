<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\apicontroller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UsermanageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorRefferalController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear_all', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
	Artisan::call('route:cache');
	
    return "Cache Cleared..!";
});


Route::get('/', function () {
    return view('LoginView');
});




/*{ LoginController Start */ 
	Route::get('/login', 'App\Http\Controllers\LoginController@login')->name('login');   
    Route::get('/admin', 'App\Http\Controllers\LoginController@index')->name('admin');
    Route::post('/checkauth', 'App\Http\Controllers\LoginController@checkauth')->name('checkauth');
	Route::post('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');
	Route::get('/logouturl', 'App\Http\Controllers\LoginController@logouturl')->name('logouturl');
/*} LoginController End */

/*{ AdminController Start */
    Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard')->name('dashboard');
    Route::get('/AdminVendorProfile', 'App\Http\Controllers\AdminController@AdminVendorProfile')->name('AdminVendorProfile');
    Route::post('/AdminVendorProfilestore', 'App\Http\Controllers\AdminController@AdminVendorProfilestore')->name('AdminVendorProfilestore');    
    Route::get('/AdminBanner', 'App\Http\Controllers\AdminController@AdminBanner')->name('AdminBanner');
    Route::get('/AdminProfile', 'App\Http\Controllers\AdminController@AdminProfile')->name('AdminProfile'); 
	Route::post('/commisionupdate/{id}', 'App\Http\Controllers\AdminController@commisionupdate')->name('commisionupdate'); 
	Route::get('/forgotpassword', 'App\Http\Controllers\AdminController@forgotpassword')->name('forgotpassword'); 
	Route::post('/change_password', 'App\Http\Controllers\AdminController@change_password')->name('change_password');
	
/*} AdminController End */

/*{ HostController Start */
	Route::get('/hostlist', 'App\Http\Controllers\HostController@hostlist')->name('hostlist');
	Route::get('/hostcreate', 'App\Http\Controllers\HostController@hostcreate')->name('hostcreate'); 
	Route::post('/hostadd', 'App\Http\Controllers\HostController@hostadd')->name('hostadd');
	Route::get('/hostedit/{id}', 'App\Http\Controllers\HostController@hostedit')->name('hostedit');
	Route::get('/hostview/{id}', 'App\Http\Controllers\HostController@hostview')->name('hostview');
	Route::get('/hostdelete/{id}', 'App\Http\Controllers\HostController@hostdelete')->name('hostdelete');
	Route::post('/hostupdate/{id}', 'App\Http\Controllers\HostController@hostupdate')->name('hostupdate');
	
/*{ MembershipController Start */
	Route::get('/membershipcreate', 'App\Http\Controllers\MembershipController@membershipcreate')->name('membershipcreate');
	Route::post('/membershipadd', 'App\Http\Controllers\MembershipController@membershipadd')->name('membershipadd');
	Route::get('/membershiplist', 'App\Http\Controllers\MembershipController@membershiplist')->name('membershiplist');
	
	Route::get('/membershipedit/{id}', 'App\Http\Controllers\MembershipController@membershipedit')->name('membershipedit');

	Route::get('/membershipdelete/{id}', 'App\Http\Controllers\MembershipController@membershipdelete')->name('membershipdelete');
	
	Route::post('/membershipupdate/{id}', 'App\Http\Controllers\MembershipController@membershipupdate')->name('membershipupdate');


/*{ MembershipController End */

/*{ SportsslotController Start */

	Route::get('/sportslotcreate', 'App\Http\Controllers\SportsslotController@sportslotcreate')->name('sportslotcreate');
	Route::get('/spotsslotlist', 'App\Http\Controllers\SportsslotController@spotsslotlist')->name('spotsslotlist');
	Route::post('/spotsslotadd', 'App\Http\Controllers\SportsslotController@spotsslotadd')->name('spotsslotadd');
	Route::get('/sportslotedit/{id}', 'App\Http\Controllers\SportsslotController@sportslotedit')->name('sportslotedit');

	Route::get('/sportslotdelete/{id}', 'App\Http\Controllers\SportsslotController@sportslotdelete')->name('sportslotdelete');
	
	Route::post('/sportslotupdate/{id}', 'App\Http\Controllers\SportsslotController@sportslotupdate')->name('sportslotupdate');
	
   

/*{ SportsslotController End */


	
/*{ UsermanageController Start */
    Route::get('/userscreate', 'App\Http\Controllers\UsermanageController@userscreate')->name('userscreate');
	Route::get('/userslist', 'App\Http\Controllers\UsermanageController@index')->name('userslist');
	Route::post('/userssadd', 'App\Http\Controllers\UsermanageController@userssadd')->name('userssadd');
	Route::get('/usersedit/{id}', 'App\Http\Controllers\UsermanageController@usersedit')->name('usersedit');Route::get('/usersview/{id}', 'App\Http\Controllers\UsermanageController@usersview')->name('usersview');
	Route::get('/usersdelete/{id}', 'App\Http\Controllers\UsermanageController@usersdelete')->name('usersdelete');
	Route::post('/usersupdate/{id}', 'App\Http\Controllers\UsermanageController@usersupdate')->name('usersupdate');


	Route::get('/salesagentcreate', 'App\Http\Controllers\SalesAgentController@salesagentcreate')->name('salesagentcreate');
	Route::get('/salesagentlist', 'App\Http\Controllers\SalesAgentController@index')->name('salesagentlist');
	Route::post('/salesagentadd', 'App\Http\Controllers\SalesAgentController@salesagentadd')->name('salesagentadd');
	Route::get('/salesagentedit/{id}', 'App\Http\Controllers\SalesAgentController@salesagentedit')->name('salesagentedit');
	Route::get('/salesagentprofile', 'App\Http\Controllers\SalesAgentController@salesagentprofile')->name('salesagentprofile');
	Route::get('/salesagentdelete/{id}', 'App\Http\Controllers\SalesAgentController@salesagentdelete')->name('salesagentdelete');
	Route::post('/salesagentupdate/{id}', 'App\Http\Controllers\SalesAgentController@salesagentupdate')->name('salesagentupdate');
	Route::post('/salesagentprofileupdate/{id}', 'App\Http\Controllers\SalesAgentController@salesagentprofileupdate')->name('salesagentprofileupdate');
	Route::get('/sortingsalesagent/{id1}/{id2}', 'App\Http\Controllers\SalesAgentController@sortingsalesagent')->name('sortingsalesagent');

	//Route::resource('vendorrefferal', VendorRefferalController::class);
	Route::get('/vendorrefferalcreate', 'App\Http\Controllers\VendorRefferalController@vendorrefferalcreate')->name('vendorrefferalcreate');
	Route::post('/vendorrefferaladd', 'App\Http\Controllers\VendorRefferalController@vendorrefferaladd')->name('vendorrefferaladd');
	Route::post('/venodrrefferalupdate/{id}', 'App\Http\Controllers\VendorRefferalController@venodrrefferalupdate')->name('venodrrefferalupdate');
	Route::get('/vendorrefferallist', 'App\Http\Controllers\VendorRefferalController@index')->name('vendorrefferallist');
	Route::get('/vendorrefferaledit/{id}', 'App\Http\Controllers\VendorRefferalController@vendorrefferaledit')->name('vendorrefferaledit');
	Route::get('/vendorrefferaldelete/{id}', 'App\Http\Controllers\VendorRefferalController@vendorrefferaldelete')->name('vendorrefferaldelete');
	Route::get('/vendorrefferalprofile', 'App\Http\Controllers\VendorRefferalController@vendorrefferalprofile')->name('vendorrefferalprofile');
	Route::post('/vendorrefferalupdate/{id}', 'App\Http\Controllers\VendorRefferalController@vendorrefferalupdate')->name('vendorrefferalupdate');
	



	Route::get('/venuecreate', 'App\Http\Controllers\VenueController@venuecreate')->name('venuecreate');
	Route::get('/venuelist', 'App\Http\Controllers\VenueController@index')->name('venuelist');
	Route::post('/venuesadd', 'App\Http\Controllers\VenueController@venuesadd')->name('venuesadd');
	Route::get('/venueedit/{id}', 'App\Http\Controllers\VenueController@venueedit')->name('venueedit');
	Route::get('/venuedelete/{id}', 'App\Http\Controllers\VenueController@venuedelete')->name('venuedelete');
	Route::post('/venueupdate/{id}', 'App\Http\Controllers\VenueController@venueupdate')->name('venueupdate');
	Route::get('/venuesearch/{id1}/{id2}', 'App\Http\Controllers\VenueController@venuesearch')->name('venuesearch');
	
	
   
Route::get('/refferalcreate', 'App\Http\Controllers\RefferalController@refferalcreate')->name('refferalcreate');
Route::get('/refferallist', 'App\Http\Controllers\RefferalController@index')->name('refferallist');
Route::post('/refferaladd', 'App\Http\Controllers\RefferalController@refferaladd')->name('refferaladd');
Route::get('/refferaledit/{id}', 'App\Http\Controllers\RefferalController@refferaledit')->name('refferaledit');
Route::get('/refferalview/{id}', 'App\Http\Controllers\RefferalController@refferalview')->name('refferalview');
Route::get('/refferaldelete/{id}', 'App\Http\Controllers\RefferalController@refferaldelete')->name('refferaldelete');
Route::post('/refferalupdate/{id}', 'App\Http\Controllers\RefferalController@refferalupdate')->name('refferalupdate');

Route::get('/buddylist', 'App\Http\Controllers\BuddyController@buddylist')->name('buddylist');


Route::get('/ewalletlist', 'App\Http\Controllers\EwalletlistController@ewalletlist')->name('ewalletlist');
Route::get('/editewallet/{id}', 'App\Http\Controllers\EwalletlistController@editewallet')->name('editewallet');
Route::post('/updateewallet/{id}', 'App\Http\Controllers\EwalletlistController@updateewallet')->name('updateewallet');

Route::get('/withdrawallist', 'App\Http\Controllers\WithdrawController@withdrawallist')->name('withdrawallist');
Route::get('/approvewithdrwanrequest/{id}', 'App\Http\Controllers\WithdrawController@approvewithdrwanrequest')->name('approvewithdrwanrequest');	
Route::get('/rejectewithdrwanrequest/{id}', 'App\Http\Controllers\WithdrawController@rejectewithdrwanrequest')->name('rejectewithdrwanrequest');
Route::get('/deletewithdrawal/{id}', 'App\Http\Controllers\WithdrawController@deletewithdrawal')->name('deletewithdrawal');
Route::get('/editwithdrawal/{id}', 'App\Http\Controllers\WithdrawController@editwithdrawal')->name('editwithdrawal');
Route::post('/updatewithdrawal/{id}', 'App\Http\Controllers\WithdrawController@updatewithdrawal')->name('updatewithdrawal');

Route::get('/vendorwithdrawallist', 'App\Http\Controllers\VendorWithdrawController@vendorwithdrawallist')->name('vendorwithdrawallist');
Route::get('/vendorapprovewithdrwanrequest/{id}', 'App\Http\Controllers\VendorWithdrawController@vendorapprovewithdrwanrequest')->name('vendorapprovewithdrwanrequest');	
Route::get('/vendorrejectewithdrwanrequest/{id}', 'App\Http\Controllers\VendorWithdrawController@vendorrejectewithdrwanrequest')->name('vendorrejectewithdrwanrequest');
Route::get('/vendordeletewithdrawal/{id}', 'App\Http\Controllers\VendorWithdrawController@vendordeletewithdrawal')->name('vendordeletewithdrawal');
Route::get('/vendoreditwithdrawal/{id}', 'App\Http\Controllers\VendorWithdrawController@vendoreditwithdrawal')->name('vendoreditwithdrawal');
Route::get('/vendoraddwithdrawal', 'App\Http\Controllers\VendorWithdrawController@vendoraddwithdrawal')->name('vendoraddwithdrawal');





Route::post('/vendoraddrequestwithdrawal/{id}', 'App\Http\Controllers\VendorWithdrawController@vendoraddrequestwithdrawal')->name('vendoraddrequestwithdrawal');

Route::post('/vendorupdatewithdrawal/{id}', 'App\Http\Controllers\VendorWithdrawController@vendorupdatewithdrawal')->name('vendorupdatewithdrawal');
Route::get('/vendorsortingwithdrawallist/{id1}/{id2}', 'App\Http\Controllers\VendorWithdrawController@vendorsortingwithdrawallist')->name('vendorsortingwithdrawallist');


Route::get('/noticboard', 'App\Http\Controllers\NoticBoardController@noticboard')->name('noticboard');
Route::get('/noticlist', 'App\Http\Controllers\NoticBoardController@noticlist')->name('noticlist');
Route::post('/savereditequestnotice/{id}', 'App\Http\Controllers\NoticBoardController@savereditequestnotice')->name('savereditequestnotice');
Route::post('/saverequestnotice', 'App\Http\Controllers\NoticBoardController@saverequestnotice')->name('saverequestnotice');
Route::get('/noticedit/{id}', 'App\Http\Controllers\NoticBoardController@noticedit')->name('noticedit');
Route::get('/noticdelete/{id}', 'App\Http\Controllers\NoticBoardController@noticdelete')->name('noticdelete');

Route::get('/bannerlist', 'App\Http\Controllers\BannerController@bannerlist')->name('bannerlist');
Route::post('/bannerstore', 'App\Http\Controllers\BannerController@bannerstore')->name('bannerstore');	
Route::get('/bannerdelete/{id}', 'App\Http\Controllers\BannerController@bannerdelete')->name('bannerdelete');
Route::get('/banneredit/{id}', 'App\Http\Controllers\BannerController@banneredit')->name('banneredit');
Route::post('/bannerupdate/{id}', 'App\Http\Controllers\BannerController@bannerupdate')->name('bannerupdate');
    
	   
	Route::get('/instructorslist', 'App\Http\Controllers\InstructorController@instructorslist')->name('instructorslist');
	Route::get('/instructors', 'App\Http\Controllers\InstructorController@create')->name('instructors');    
	Route::post('/instructorsadd', 'App\Http\Controllers\InstructorController@store')->name('instructorsadd');
	Route::get('/instructoredit/{id}', 'App\Http\Controllers\InstructorController@edit')->name('instructoredit');
	Route::get('/instructordelete/{id}', 'App\Http\Controllers\InstructorController@instructordelete')->name('instructordelete');
	Route::post('/instructorsupdate/{id}', 'App\Http\Controllers\InstructorController@instructorsupdate')->name('instructorsupdate');
	Route::get('/instructorapproved/{id}', 'App\Http\Controllers\InstructorController@instructorapproved')->name('instructorapproved');	
	Route::get('/instructorrejected/{id}', 'App\Http\Controllers\InstructorController@instructorrejected')->name('instructorrejected');		

	
	
	Route::get('/stafflist', 'App\Http\Controllers\UsermanageController@stafflist')->name('stafflist');        
	Route::get('/staff', 'App\Http\Controllers\UsermanageController@create')->name('staff');    
    Route::post('/staffadd', 'App\Http\Controllers\UsermanageController@store')->name('staffadd');
	Route::post('/staffupdate/{id}', 'App\Http\Controllers\UsermanageController@update')->name('staffupdate');
	Route::get('/staffedit/{id}', 'App\Http\Controllers\UsermanageController@edit')->name('staffedit');    
	Route::get('/staffview/{id}', 'App\Http\Controllers\UsermanageController@view')->name('staffview');
	Route::get('/staffdelete/{id}', 'App\Http\Controllers\UsermanageController@deletestaff')->name('staffdelete');  
	
	
	Route::get('/vendorstaff', 'App\Http\Controllers\UsermanageController@vendorstaff')->name('vendorstaff');    
	Route::post('/vendorstaffadd', 'App\Http\Controllers\UsermanageController@vendorstaffadd')->name('vendorstaffadd'); 
	Route::get('/vendorstafflist', 'App\Http\Controllers\UsermanageController@vendorstafflist')->name('vendorstafflist');
	Route::get('/vendorstaffedit/{id}', 'App\Http\Controllers\UsermanageController@vendorstaffedit')->name('vendorstaffedit'); 
	Route::get('/vendorstaffeditprofile', 'App\Http\Controllers\UsermanageController@vendorstaffeditprofile')->name('vendorstaffeditprofile'); 
	Route::get('/vendorstaffdelete/{id}', 'App\Http\Controllers\UsermanageController@vendorstaffdelete')->name('vendorstaffdelete'); 
	Route::post('/vendorstaffupdate/{id}', 'App\Http\Controllers\UsermanageController@vendorstaffupdate')->name('vendorstaffupdate');            
	

    Route::resource('users', UsermanageController::class); 
	
	/* Sorting */
	Route::get('/sortingstafflist/{id1}/{id2}', 'App\Http\Controllers\UsermanageController@sortingstafflist')->name('sortingstafflist');
	Route::get('/vendorsortingstafflist/{id1}/{id2}', 'App\Http\Controllers\UsermanageController@vendorsortingstafflist')->name('vendorsortingstafflist');
	
	Route::get('/sortinguserlist/{id1}/{id2}', 'App\Http\Controllers\UsermanageController@sortinguserlist')->name('sortinguserlist');
	
	Route::get('/sortingcategorylist/{id1}/{id2}', 'App\Http\Controllers\CategoryController@sortingcategorylist')->name('sortingcategorylist');
	
	Route::get('/sortinginstructorslist/{id1}/{id2}', 'App\Http\Controllers\InstructorController@sortinginstructorslist')->name('sortinginstructorslist');
	
	Route::get('/sortingvendorlist/{id1}/{id2}', 'App\Http\Controllers\VendorController@sortingvendorlist')->name('sortingvendorlist');
	
	Route::get('/sortinghostlist/{id1}/{id2}', 'App\Http\Controllers\HostController@sortinghostlist')->name('sortinghostlist');
	
	Route::get('/sortingbuddylist/{id1}/{id2}', 'App\Http\Controllers\BuddyController@sortingbuddylist')->name('sortingbuddylist');
	
	Route::get('/sortingnoticlist/{id1}/{id2}', 'App\Http\Controllers\NoticBoardController@sortingnoticlist')->name('sortingnoticlist');
	
	Route::get('/sortingrefferallist/{id1}/{id2}', 'App\Http\Controllers\RefferalController@sortingrefferallist')->name('sortingrefferallist');
	
	Route::get('/sortingwithdrawallist/{id1}/{id2}/{id3}', 'App\Http\Controllers\WithdrawController@sortingwithdrawallist')->name('sortingwithdrawallist');
	
	Route::get('/sortingewalletlist/{id1}/{id2}', 'App\Http\Controllers\EwalletlistController@sortingewalletlist')->name('sortingewalletlist');
	
	Route::get('/sortingvenuelist/{id1}/{id2}', 'App\Http\Controllers\VenueController@sortingvenuelist')->name('sortingvenuelist');
	
	Route::get('/sortingmembershiplist/{id1}/{id2}', 'App\Http\Controllers\MembershipController@sortingmembershiplist')->name('sortingmembershiplist');
	
	Route::get('/sortingspotsslotlist/{id1}/{id2}', 'App\Http\Controllers\SportsslotController@sortingspotsslotlist')->name('sortingspotsslotlist');
	
	Route::get('/sortingstatelist/{id1}/{id2}', 'App\Http\Controllers\StateController@sortingstatelist')->name('sortingstatelist');
	
	
   /* End Sorting */
	
	
/*} UsermanageController End */

/*{ VendorController Start */
    Route::resource('vendor', VendorController::class);
	Route::post('/savevendor', 'App\Http\Controllers\VendorController@savevendor')->name('savevendor');	
	
	Route::get('/vendorlist', 'App\Http\Controllers\VendorController@vendorlist')->name('vendorlist');
	Route::get('/vendorlist/featuredVendorList', 'App\Http\Controllers\FeaturedVendorController@index')->name('featuredVendorList');
	Route::post('/vendorlist/featuredVendorList', 'App\Http\Controllers\FeaturedVendorController@updateOrder');
	Route::post('/vendorlist/featuredVendorList/add/{id}', 'App\Http\Controllers\FeaturedVendorController@addFeatureVendor')->name('addFeatureVendor');
	Route::post('/vendorlist/featuredVendorList/delete/{id}', 'App\Http\Controllers\FeaturedVendorController@deleteFeatureVendor')->name('deleteFeatureVendor');
	Route::get('/vendorapproved/{id}', 'App\Http\Controllers\VendorController@vendorapproved')->name('vendorapproved');	
	Route::get('/vendorrejected/{id}', 'App\Http\Controllers\VendorController@vendorrejected')->name('vendorrejected');	
	Route::get('/deletevendor/{id}', 'App\Http\Controllers\VendorController@deletevendor')->name('deletevendor');
	Route::get('/editvendor/{id}', 'App\Http\Controllers\VendorController@editvendor')->name('editvendor');
	Route::get('/editvendorprofile/{id}', 'App\Http\Controllers\VendorController@editvendorprofile')->name('editvendorprofile');
		
	Route::post('/updatevendor/{id}', 'App\Http\Controllers\VendorController@updatevendor')->name('updatevendor');
	Route::post('/updatevendorprofile/{id}', 'App\Http\Controllers\VendorController@updatevendorprofile')->name('updatevendorprofile');
		
	

/*} VendorController End */

/*{ CategoryController Start */
    Route::resource('category', CategoryController::class);
	Route::get('/categorylist', 'App\Http\Controllers\CategoryController@categorylist')->name('categorylist');
	Route::get('/deletecategory/{id}', 'App\Http\Controllers\CategoryController@deletecategory')->name('deletecategory');
	Route::get('/categoryedit/{id}', 'App\Http\Controllers\CategoryController@categoryedit')->name('categoryedit');    
    Route::post('/categoryupdate/{id}', 'App\Http\Controllers\CategoryController@categoryupdate')->name('categoryupdate');    	
	
	Route::resource('state', StateController::class);
	Route::get('/Statedetaillist', 'App\Http\Controllers\StateController@Statedetaillist')->name('Statedetaillist');
	Route::get('/deletestate/{id}', 'App\Http\Controllers\StateController@deletestate')->name('deletestate');
	Route::get('/stateedit/{id}', 'App\Http\Controllers\StateController@stateedit')->name('stateedit');    
    Route::post('/stateupdate/{id}', 'App\Http\Controllers\StateController@stateupdate')->name('stateupdate');
	
	
	Route::get('/refundpolicy', 'App\Http\Controllers\RefundPolicyController@refundpolicy')->name('refundpolicy');
	
	Route::get('/refundpolicylist', 'App\Http\Controllers\RefundPolicyController@refundpolicylist')->name('refundpolicylist');
	Route::get('/deleterefundpolicy/{id}', 'App\Http\Controllers\RefundPolicyController@deleterefundpolicy')->name('deleterefundpolicy');
	Route::get('/refundpolicyedit/{id}', 'App\Http\Controllers\RefundPolicyController@refundpolicyedit')->name('refundpolicyedit');    
    Route::post('/refundpolicyeditupdate/{id}', 'App\Http\Controllers\RefundPolicyController@refundpolicyeditupdate')->name('refundpolicyeditupdate');
	Route::post('/refundsstore', 'App\Http\Controllers\RefundPolicyController@refundsstore')->name('refundsstore');
	
	
	
/*} CategoryController End */

/*{ VoucherController Start */
    // Route::get('/voucher', 'App\Http\Controllers\VoucherController@index')->name('voucher');
    Route::resource('voucher', VoucherController::class);
	//Route::post('/voucher', 'App\Http\Controllers\VoucherController@index')->name('voucher');
	Route::post('/saverequestvoucher', 'App\Http\Controllers\VoucherController@saverequestvoucher')->name('saverequestvoucher');
	
	Route::get('/voucherdelete/{id}', 'App\Http\Controllers\VoucherController@voucherdelete')->name('voucherdelete');
	
	
/*} VoucherController End */

/* BookingController Strat*/

Route::get('/bookingsales', 'App\Http\Controllers\BookingSalesController@bookingsales')->name('bookingsales');
Route::get('/bookingcheck', 'App\Http\Controllers\BookingSalesController@bookingcheck')->name('bookingcheck');
Route::get('/bookingqrcodecheck', 'App\Http\Controllers\BookingSalesController@bookingqrcodecheck')->name('bookingqrcodecheck');
Route::get('/checkinsales', 'App\Http\Controllers\BookingSalesController@checkinsales')->name('checkinsales');
Route::get('/getcourtdetails/{id}', 'App\Http\Controllers\BookingSalesController@getcourtdetails')->name('getcourtdetails');
Route::get('/checkregisteruser/{id}', 'App\Http\Controllers\BookingSalesController@checkregisteruser')->name('checkregisteruser');
Route::get('/getcloseingdays', 'App\Http\Controllers\BookingSalesController@getcloseingdays')->name('getcloseingdays');

Route::post('/getcourttime', 'App\Http\Controllers\BookingSalesController@getcourttime')->name('getcourttime');
Route::post('/getcourttimesummay', 'App\Http\Controllers\BookingSalesController@getcourttimesummay')->name('getcourttimesummay');

Route::post('/postcheckin', 'App\Http\Controllers\BookingSalesController@postcheckin')->name('postcheckin');
Route::post('/payatcounter', 'App\Http\Controllers\BookingSalesController@payatcounter')->name('payatcounter');
Route::get('/processReturnUrl', 'App\Http\Controllers\BookingSalesController@processReturnUrl')->name('processReturnUrl');


Route::post('/checkwithbookingno', 'App\Http\Controllers\BookingSalesController@checkwithbookingno')->name('checkwithbookingno');
Route::post('/checkwithbookingnoqrcode', 'App\Http\Controllers\BookingSalesController@checkwithbookingnoqrcode')->name('checkwithbookingnoqrcode');


  
/*ReportControlller*/

Route::get('/instructorreport', 'App\Http\Controllers\ReportsController@instructorreport')->name('instructorreport');
Route::get('/vendorreport', 'App\Http\Controllers\ReportsController@vendorreport')->name('vendorreport');
Route::get('/vendorwithdrawreport', 'App\Http\Controllers\ReportsController@vendorwithdrawreport')->name('vendorwithdrawreport');
Route::get('/vendoronlinesalesreport', 'App\Http\Controllers\ReportsController@vendoronlinesalesreport')->name('vendoronlinesalesreport');
Route::get('/vendorcountersalesreport', 'App\Http\Controllers\ReportsController@vendorcountersalesreport')->name('vendorcountersalesreport');
Route::get('/vendorvoucherreport', 'App\Http\Controllers\ReportsController@vendorvoucherreport')->name('vendorvoucherreport');
Route::get('/vendormembership', 'App\Http\Controllers\ReportsController@vendormembership')->name('vendormembership');

Route::get('/salesreportbyvendor/{id1}/{id2}', 'App\Http\Controllers\ReportsController@salesreportbyvendor')->name('salesreportbyvendor');
Route::get('/vendorwithdrawreportfilter/{id1}/{id2}', 'App\Http\Controllers\ReportsController@vendorwithdrawreportfilter')->name('vendorwithdrawreportfilter');
Route::get('/vendoronlinesalesreportfilter/{id1}/{id2}', 'App\Http\Controllers\ReportsController@vendoronlinesalesreportfilter')->name('vendoronlinesalesreportfilter');
Route::get('/vendorcountersalesreportfilter/{id1}/{id2}', 'App\Http\Controllers\ReportsController@vendorcountersalesreportfilter')->name('vendorcountersalesreportfilter');
Route::get('/vendorvoucherreportfilter/{id1}/{id2}', 'App\Http\Controllers\ReportsController@vendorvoucherreportfilter')->name('vendorvoucherreportfilter');
Route::get('/vendormembershipfilter/{id1}/{id2}', 'App\Http\Controllers\ReportsController@vendormembershipfilter')->name('vendormembershipfilter');
Route::get('/instructorreportfilter/{id1}/{id2}', 'App\Http\Controllers\ReportsController@instructorreportfilter')->name('instructorreportfilter');

Route::get('/generate-qrcode', 'App\Http\Controllers\QrCodeController@index')->name('generate-qrcode');

Route::get('/generate-barcode', 'App\Http\Controllers\ProductController@index')->name('generate.barcode');

/*{ apicontroller Start [For Mobile API] */    
    Route::get('/getusers', [apicontroller::class, 'getusers']);	
/*} apicontroller End */

Route::get('get_order_counts/{id}','App\Http\Controllers\AdminController@get_order_counts')->name('get_order_counts');


//products routes

Route::get('/product/delete/{id}', 'App\Http\Controllers\AddNewProductsController@ProductDelete');

Route::get('/product/edit/{id}', 'App\Http\Controllers\AddNewProductsController@ProductEdit');

Route::post('/product/update/{id}', 'App\Http\Controllers\AddNewProductsController@ProductUpdate');


Route::get('/add-products', 'App\Http\Controllers\AddNewProductsController@ProductLayout')->name('addProducts');

Route::post('/add_new_products', 'App\Http\Controllers\AddNewProductsController@addNewProduct');

Route::get('/product/Listing', 'App\Http\Controllers\AddNewProductsController@ProductListing');

Route::get('/booking-calender', 'App\Http\Controllers\BookingCalenderController@index')->name('booking.calender');



