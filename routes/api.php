<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/getusers', 'App\Http\Controllers\apicontroller@getusers')->name('getusers');
Route::post('/saveuser', 'App\Http\Controllers\apicontroller@saveuser')->name('saveuser');
Route::post('/sendotp', 'App\Http\Controllers\apicontroller@sendotp')->name('sendotp');
Route::post('/sendsms', 'App\Http\Controllers\apicontroller@sendsms')->name('sendsms');
Route::get('/validateotp', 'App\Http\Controllers\apicontroller@validateotp')->name('validateotp');


Route::get('/gethomecategory', 'App\Http\Controllers\apicontroller@gethomecategory')->name('gethomecategory');
Route::get('/getbanner', 'App\Http\Controllers\apicontroller@getbanner')->name('getbanner');
Route::get('/getsportvenue', 'App\Http\Controllers\apicontroller@getsportvenue')->name('getsportvenue');
Route::get('/mybookedvenue', 'App\Http\Controllers\apicontroller@mybookedvenue')->name('mybookedvenue');




Route::get('/getnoticboard', 'App\Http\Controllers\apicontroller@getnoticboard')->name('getnoticboard');
Route::get('/getcourtbycourtid', 'App\Http\Controllers\apicontroller@getcourtbycourtid')->name('getcourtbycourtid');
Route::get('/getcourtbyvenodrid', 'App\Http\Controllers\apicontroller@getcourtbyvenodrid')->name('getcourtbyvenodrid');
Route::get('/getcourttimebycourtid', 'App\Http\Controllers\apicontroller@getcourttimebycourtid')->name('getcourttimebycourtid');
Route::get('/getbookingsummarybytimeid', 'App\Http\Controllers\apicontroller@getbookingsummarybytimeid')->name('getbookingsummarybytimeid'); 
Route::get('/getvendorprofile', 'App\Http\Controllers\apicontroller@getvendorprofile')->name('getvendorprofile');

Route::get('/getvoucherdetails', 'App\Http\Controllers\apicontroller@getvoucherdetails')->name('getvoucherdetails');
Route::get('/getallvoucherdetails', 'App\Http\Controllers\apicontroller@getallvoucherdetails')->name('getallvoucherdetails');
Route::get('/forgetpassword', 'App\Http\Controllers\apicontroller@forgetpassword')->name('forgetpassword');
Route::post('/changepassword', 'App\Http\Controllers\apicontroller@changepassword')->name('changepassword');
Route::get('/getallbookingdetails', 'App\Http\Controllers\apicontroller@getallbookingdetails')->name('getallbookingdetails');
Route::post('/cancelbookingdetails', 'App\Http\Controllers\apicontroller@cancelbookingdetails')->name('cancelbookingdetails');
Route::get('/getbookingsumary', 'App\Http\Controllers\apicontroller@getbookingsumary')->name('getbookingsumary');
Route::get('/sportsvenuedetails', 'App\Http\Controllers\apicontroller@sportsvenuedetails')->name('sportsvenuedetails');
Route::post('/refferaleditbankdetail', 'App\Http\Controllers\apicontroller@refferaleditbankdetail')->name('refferaleditbankdetail');
Route::post('/refferalwithdrawal', 'App\Http\Controllers\apicontroller@refferalwithdrawal')->name('refferalwithdrawal');
Route::get('/refferalbookingtransation', 'App\Http\Controllers\apicontroller@refferalbookingtransation')->name('refferalbookingtransation');

Route::get('/gethostgames', 'App\Http\Controllers\apicontroller@gethostgames')->name('gethostgames');
Route::post('/hostgameadd', 'App\Http\Controllers\apicontroller@hostgameadd')->name('hostgameadd');
Route::post('/hostgamecancel', 'App\Http\Controllers\apicontroller@hostgamecancel')->name('hostgamecancel');
Route::get('/hostgamefilterby', 'App\Http\Controllers\apicontroller@hostgamefilterby')->name('hostgamefilterby');
Route::post('/hostgamejoin', 'App\Http\Controllers\apicontroller@hostgamejoin')->name('hostgamejoin');
Route::post('/hostgameremove', 'App\Http\Controllers\apicontroller@hostgameremove')->name('hostgameremove');
Route::get('/hostgamesbyid', 'App\Http\Controllers\apicontroller@hostgamesbyid')->name('hostgamesbyid');
Route::get('/hostgamesbyuserid', 'App\Http\Controllers\apicontroller@hostgamesbyuserid')->name('hostgamesbyuserid');


Route::post('/bookingorderbyuser', 'App\Http\Controllers\apicontroller@bookingorderbyuser')->name('bookingorderbyuser');


Route::get('/checkpayment', 'App\Http\Controllers\apicontroller@checkpayment')->name('checkpayment');
Route::post('/updateuserprofile', 'App\Http\Controllers\apicontroller@updateuserprofile')->name('updateuserprofile');
Route::post('/updateuserpictures', 'App\Http\Controllers\apicontroller@updateuserpictures')->name('updateuserpictures');
Route::get('/getallcategory', 'App\Http\Controllers\apicontroller@getallcategory')->name('getallcategory');
Route::get('/getallstate', 'App\Http\Controllers\apicontroller@getallstate')->name('getallstate');
Route::get('/getusersdetailsbyid', 'App\Http\Controllers\apicontroller@getusersdetailsbyid')->name('getusersdetailsbyid');


/*Instructor API */
Route::post('/saveinstructor', 'App\Http\Controllers\apicontroller@saveinstructor')->name('saveinstructor');
Route::get('/getinstructor', 'App\Http\Controllers\apicontroller@getinstructor')->name('getinstructor');
Route::get('/getinstructordetailsbyid', 'App\Http\Controllers\apicontroller@getinstructordetailsbyid')->name('getinstructordetailsbyid');
Route::post('/instructorhireme', 'App\Http\Controllers\apicontroller@instructorhireme')->name('instructorhireme');
Route::get('/instructorbookingdetailsbyinstructorid', 'App\Http\Controllers\apicontroller@instructorbookingdetailsbyinstructorid')->name('instructorbookingdetailsbyinstructorid');
Route::get('/instructorbookingdetailsbyuserid', 'App\Http\Controllers\apicontroller@instructorbookingdetailsbyuserid')->name('instructorbookingdetailsbyuserid');
Route::post('/instructorbookingstatus', 'App\Http\Controllers\apicontroller@instructorbookingstatus')->name('instructorbookingstatus');
Route::get('/instructorpanel', 'App\Http\Controllers\apicontroller@instructorpanel')->name('instructorpanel');
Route::get('/instructorwithdrawaldetails', 'App\Http\Controllers\apicontroller@instructorwithdrawaldetails')->name('instructorwithdrawaldetails');
Route::get('/getinstructorbookingdetails', 'App\Http\Controllers\apicontroller@getinstructorbookingdetails')->name('getinstructorbookingdetails');



Route::post('/updateinstructorprofile', 'App\Http\Controllers\apicontroller@updateinstructorprofile')->name('updateinstructorprofile');

Route::get('/getallinstructorbooking', 'App\Http\Controllers\apicontroller@getallinstructorbooking')->name('getallinstructorbooking');

Route::post('/instructoreditbankdetail', 'App\Http\Controllers\apicontroller@instructoreditbankdetail')->name('instructoreditbankdetail');
Route::post('/instructorwithdrawal', 'App\Http\Controllers\apicontroller@instructorwithdrawal')->name('instructorwithdrawal');

Route::post('/userroleupdate', 'App\Http\Controllers\apicontroller@userroleupdate')->name('userroleupdate');

Route::get('/getbooking', 'App\Http\Controllers\apicontroller@getbooking')->name('getbooking');

Route::get('/gethomepagedtls', 'App\Http\Controllers\apicontroller@gethomepagedtls')->name('gethomepagedtls');

Route::get('/getbooking3', 'App\Http\Controllers\apicontroller@getbooking3')->name('getbooking3');
Route::get('/getbooking4', 'App\Http\Controllers\apicontroller@getbooking4')->name('getbooking4');
Route::get('/getbooking5', 'App\Http\Controllers\apicontroller@getbooking5')->name('getbooking5');



Route::get('/nearestsports', 'App\Http\Controllers\apicontroller@nearestsports')->name('nearestsports');
Route::get('/nearesthost', 'App\Http\Controllers\apicontroller@nearesthost')->name('nearesthost');


Route::get('/getmemberships', 'App\Http\Controllers\apicontroller@getmemberships')->name('getmemberships');
Route::get('/getmembershipsbyid', 'App\Http\Controllers\apicontroller@getmembershipsbyid')->name('getmembershipsbyid');
Route::post('/membershipsbyusers', 'App\Http\Controllers\apicontroller@membershipsbyusers')->name('membershipsbyusers');
Route::get('/membershipscheckbyuser', 'App\Http\Controllers\apicontroller@membershipscheckbyuser')->name('membershipscheckbyuser');
Route::get('/membershipsrenewal', 'App\Http\Controllers\apicontroller@membershipsrenewal')->name('membershipsrenewal');



Route::get('/checkvendorbookcourt', 'App\Http\Controllers\apicontroller@checkvendorbookcourt')->name('checkvendorbookcourt');
Route::post('/contactus', 'App\Http\Controllers\apicontroller@contactus')->name('contactus');
Route::get('/cashbackdetailsbyid', 'App\Http\Controllers\apicontroller@cashbackdetailsbyid')->name('cashbackdetailsbyid');

// get All vendor products against vendor Id

Route::get('/get_all_vendorProducts1/{id}', 'App\Http\Controllers\Api\getAllVendorProductsController@getAllVendorProducts');


//Route::group(['prefix' => 'all_vendor_product'],function($router) {
	
//  Route::get('/getall-compaign-types', [getAllCompaignController::class, 'getAllCompaignTypes']);
 //});

