<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestMail;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\InfoController;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SegmentationController;

// Route::get('test-password', function () {
// 	echo Hash::make('password');
// });

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

//---------------------------------------------- Info Part -------------------------------------------------//

Route::get('information', 'InfoController@info');
Route::get('teleUpdates', 'InfoController@teleUpdates');

//---------------------------------------------- Administrator Part -------------------------------------------------//

Auth::routes();

Route::get('/addpack', function () {
    return view('admin.addpackage');
});

/*
|--------------------------------------------------------------------------
| Membership programme
|--------------------------------------------------------------------------
*/
Route::get('membership','MembershipController@view_membership');
Route::post('membership/save','MembershipController@store_membership');

Route::get('membership/level/{membership_id}','MembershipController@view_level');
Route::post('membership/level/update/{lvl_id}', 'MembershipController@update_membership_level');

Route::get('export-members/{membership_id}', 'MembershipController@export_members');
Route::get('membership/level/{membership_id}/{level_id}','MembershipController@view');
Route::get('membership/search/{membership_id}/{level_id}', 'MembershipController@search_membership');
Route::get('view/members/{membership_id}/{level_id}/{student_id}', 'MembershipController@track_members');
Route::post('update/members/{membership_id}/{level_id}/{student_id}', 'MembershipController@update_members');
Route::get('import-members/{membership_id}/{level_id}','MembershipController@import');
Route::get('members-format/{membership_id}/{level_id}','MembershipController@export_format');
Route::post('store-import/{membership_id}/{level_id}','MembershipController@store_import');
Route::post('store-members/{membership_id}/{level_id}','MembershipController@store_members');
Route::get('delete-member/{membership_id}/{level_id}/{student_id}', 'MembershipController@destroy');
Route::post('searchbydate/{membership_id}/{level_id}/{student_id}', 'MembershipController@searchbydate');

// Manual Key in Statement , Receipt & Invoice
Route::get('manual-invoice/{membership_id}/{level_id}/{stud_id}', 'MembershipController@manualInvoice');

// Manual Download Statement , Receipt & Invoice
Route::post('manualdownload-invoice/{stud_id}', 'MembershipController@Invoicesave');

// Add Features Product
Route::post('add-features-product', 'MembershipController@addFeaturesProduct');

//Download Invoices & Receipt
Route::get('download-invoice/{level}/{invoice}/{student}', 'MembershipController@downloadInvoices');
Route::get('download-receipt/{level}/{invoice}/{student}', 'MembershipController@downloadReceipt');

//Download Invoices for manual insert
Route::get('download-manual-invoice/{level}/{invoice}/{student}', 'MembershipController@downloadManualInvoices');
//Data Segmentation
Route::get('segmentation','SegmentationController@index')->name('admin-segmentation');
Route::post('addclass','SegmentationController@store');
Route::get('updateclass/{id}','SegmentationController@edit');
Route::get('updatesegmentation/{id}','SegmentationController@updateclass');
Route::get('classdata/{id}','SegmentationController@classdata');

/*
|--------------------------------------------------------------------------
| Voucher
|--------------------------------------------------------------------------
*/
// Admin Side - Voucher Manangement
Route::get('managevoucher','VoucherController@index');
Route::get('managevoucher/create','VoucherController@create');
Route::get('managevoucher/create/getPackage','VoucherController@getPackage'); // Get Package list based on selected Product
Route::post('managevoucher/save','VoucherController@store');
Route::get('voucher/edit/{id}','VoucherController@edit');
Route::get('voucher/edit/getPackageEdit','VoucherController@getPackageEdit'); // Get Package list based on selected Product (Edit Page)
Route::post('voucher/edit/save/{id}','VoucherController@update');
Route::get('voucher/delete/{id}','VoucherController@destroy');

Route::get('viewvoucher','VoucherController@viewvoucher');
Route::get('viewvoucher/{voucher_id}','VoucherController@viewclaimed');
Route::get('viewvoucher/detail/{voucher_id}/{series_no}','VoucherController@detailclaim');
Route::get('completevoucher/{voucher_id}/{series_no}','VoucherController@updateClaimed');
Route::get('delete/claimed/{voucher_id}/{series_no}','VoucherController@deleteClaimed');
Route::post('updatestudent/{stud_id}','VoucherController@updateStudent');
Route::get('export-claimedlist/{voucher_id}','VoucherController@exportClaimed'); //export button

// Student Side - claiming process
Route::get('voucher/{voucher_id}','VoucherClaimedController@ic_check');
Route::get('voucher/not_found','VoucherClaimedController@notFound');
Route::get('voucher/check/{voucher_id}', 'VoucherClaimedController@checking_ic');
Route::get('voucher/details/{voucher_id}/{stud_id}', 'VoucherClaimedController@voucher_form');
Route::post('voucher/details/save/{voucher_id}/{stud_id}', 'VoucherClaimedController@voucher_save');
Route::get('claimed_success/{voucher_id}/{stud_id}/{series_no}', 'VoucherClaimedController@voucher_success');
Route::get('download-voucher/{voucher_id}/{stud_id}/{series_no}', 'VoucherClaimedController@extract_voucher');

/*
|--------------------------------------------------------------------------
| Sales Report
|--------------------------------------------------------------------------
*/
Route::get('trackprogram', 'ReportsController@trackprogram');
Route::get('trackpackage/{product_id}', 'ReportsController@trackpackage');
Route::post('searchreport/{product_id}', 'ReportsController@search_report')->name('searchreport','[A-Za-z0-9-]+');

/////////////////////////////////////////////////////////////////////////
Route::get('ticketcreate', 'ReportsController@ticketcreate');
/////////////////////////////////////////////////////////////////////////

//buyer
Route::get('view/buyer/{product_id}/{package_id}', 'ReportsController@viewbypackage');
Route::get('delete/{payment_id}/{product_id}/{package_id}', 'ReportsController@destroy');
Route::get('import-customer/{product_id}/{package_id}','ImportExcelController@index');
Route::post('importExcel/{product_id}/{package_id}','ImportExcelController@import');
Route::get('exportExcel/{product_id}/{package_id}', 'ImportExcelController@export');
Route::post('new-customer/save/{product_id}/{package_id}', 'ReportsController@save_customer');
Route::get('viewpayment/{product_id}/{package_id}/{payment_id}/{student_id}', 'ReportsController@trackpayment');
Route::get('delete/{payment_id}/{product_id}/{package_id}', 'ReportsController@destroy');
Route::get('approveacc/{payment_id}/{product_id}/{package_id}/{stud_id}', 'ReportsController@approveaccount');
Route::get('approvesales/{payment_id}/{product_id}/{package_id}/{stud_id}', 'ReportsController@approvesales');
Route::post('updatepayment/{product_id}/{package_id}/{payment_id}/{student_id}', 'ReportsController@updatepayment');
Route::get('purchased-mail/{product_id}/{package_id}/{payment_id}/{stud_id}', 'ReportsController@purchased_mail');
Route::post('exportProgram/{product_id}', 'ReportsController@exportProgram');
Route::get('customer/search/{product_id}/{package_id}', 'ReportsController@search');
Route::get('view/buyer/{product_id}/{package_id}/{attendance}', 'ReportsController@attendance');
Route::post('viewpayment/save/{product_id}/{package_id}/{payment_id}/{stud_id}', 'ReportsController@uploadFile'); //modal upload receipt existing data

//participant
Route::get('view/participant/{product_id}/{package_id}', 'ReportsController@paid_ticket');
Route::post('new-participant/save/{product_id}/{package_id}', 'ReportsController@save_participant');
Route::get('import-participant/{product_id}/{package_id}','ReportsController@import_participant');
Route::post('import/store-participant/{product_id}/{package_id}','ReportsController@store_participant');
Route::get('participant-format/{product_id}/{package_id}', 'ReportsController@participant_format');
Route::get('view/ticket/{product_id}/{package_id}/{ticket_id}', 'ReportsController@track_ticket');
Route::post('view/ticket/save/{product_id}/{package_id}/{ticket_id}', 'ReportsController@update_receipt');
Route::post('ticket/update/{product_id}/{package_id}/{ticket_id}/{student_id}', 'ReportsController@update_ticket');
Route::get('updated-mail/{product_id}/{package_id}/{ticket_id}/{stud_id}', 'ReportsController@updated_mail');
Route::get('delete/ticket/{ticket_id}/{product_id}/{package_id}', 'ReportsController@destroy_ticket');
Route::get('export-participant/{product_id}', 'ReportsController@exportParticipant');
Route::get('participant/search/{product_id}/{package_id}', 'ReportsController@search_participant');

// Attendance
Route::get('download/attendance/{product_id}/{package_id}', 'AttendanceController@download_attendance');


/*
|--------------------------------------------------------------------------
| Blasting Email
|--------------------------------------------------------------------------
*/
Route::get('emailblast', 'BlastingController@emailblast');
Route::get('view/{product_id}', 'BlastingController@package');
Route::get('view-event/{product_id}/{package_id}', 'BlastingController@show');
Route::get('blast-participant/{product_id}/{package_id}', 'BlastingController@blast_participant');
Route::get('view-student/{product_id}/{package_id}/{payment_id}/{stud_id}', 'BlastingController@view_student');
Route::get('view-participant/{product_id}/{package_id}/{payment_id}/{stud_id}', 'BlastingController@view_participant');
Route::post('update-mail/{product_id}/{package_id}/{payment_id}/{stud_id}', 'BlastingController@update_mail');
Route::get('send-mail/{product_id}/{package_id}/{payment_id}/{stud_id}', 'BlastingController@send_mail');
Route::get('participant-mail/{product_id}/{package_id}/{payment_id}/{stud_id}', 'BlastingController@participant_mail');
Route::post('update-participant-mail/{product_id}/{package_id}/{payment_id}/{stud_id}', 'BlastingController@update_participant_mail');

Route::post('bulk-email-blast', 'BlastingController@blastBulkEmail')->name('email-bulk-blast');

Route::post('confirmation-email-blast', 'BlastingController@blastConfirmationEmail')->name('email-confirmation-blast');
Route::get('bulkpurchased-mail/{product_id}/{package_id}', 'BlastingController@bulkpurchased_mail');
Route::get('blastconfirmation_mail/{product_id}/{package_id}', 'BlastingController@blastconfirmation_mail');
Route::get('blastConfirmationEmail/{product_id}/{package_id}', 'BlastingController@blastConfirmationEmail');

// send Statement of Account , Invoice , Receipt ke email
Route::get('send-statementmember/{membership_id}/{level_id}/{student_id}', 'BlastingController@send_statementmember');
Route::get('send-invoicemember/{membership_id}/{level_id}/{invoice_id}/{student_id}', 'BlastingController@send_invoicemember');
Route::get('send-manualinvoicemember/{membership_id}/{level_id}/{invoice_id}/{student_id}', 'BlastingController@send_manualinvoicemember');
Route::get('send-receiptmember/{membership_id}/{level_id}/{payment_id}/{student_id}', 'BlastingController@send_receiptmember');

/*
|--------------------------------------------------------------------------
| Manage event
|--------------------------------------------------------------------------
*/
Route::get('product', 'ProductController@viewproduct');
Route::get('addproduct', 'ProductController@create');
Route::post('new-product/save', 'ProductController@store');
Route::get('edit/{id}', 'ProductController@edit');
Route::post('update/{id}',  'ProductController@update');
Route::get('delete/{id}', 'ProductController@destroy');
/*
|--------------------------------------------------------------------------
| Pengesahan Kehadiran
|--------------------------------------------------------------------------
*/
Route::get('pengesahan-pendaftaran/{product_id}/{package_id}', 'AttendanceController@ICdetails');
Route::get('validation/{product_id}/{package_id}', 'AttendanceController@validation');
Route::get('/unregister', function () {
    return view('attendance.unregister');
});
Route::get('pengesahan-maklumat/{product_id}/{package_id}/{stud_id}', 'AttendanceController@detailconfirmation');
Route::get('simpan-maklumat/{product_id}/{package_id}/{stud_id}', 'AttendanceController@simpanmaklumat');





/*
|--------------------------------------------------------------------------
| Manage package
|--------------------------------------------------------------------------
*/
Route::get('addpackage/{id}', 'ProductController@pack');
Route::post('storepack/{id}/{offer_id}', 'ProductController@storepack');
Route::get('package/{id}', 'ProductController@view');
Route::get('editpack/{id}/{productId}', 'ProductController@editpack');
Route::post('updatepack/{id}/{productId}',  'ProductController@updatepack');
Route::get('deletepack/{packageId}', 'ProductController@destroypack');
Route::get('viewpacks/{id}', 'ProductController@show');
Route::get('feature/{id}', 'ProductController@viewpack');

/*
|--------------------------------------------------------------------------
| Manage offer
|--------------------------------------------------------------------------
*/
Route::get('view-offer', 'OfferController@view');
Route::post('new-offer/save', 'OfferController@create');
Route::post('update-offer/save/{offer_id}', 'OfferController@update');
Route::get('delete-offer/{offer_id}', 'OfferController@delete');

/*
|--------------------------------------------------------------------------
| Collection ID
|--------------------------------------------------------------------------
*/
Route::get('collection-id', 'ProductController@collection_id');
Route::post('new-collection/save', 'ProductController@new_collection');
Route::post('update-collection/save/{collection_id}', 'ProductController@update_collection');
Route::get('delete-collection/{collection_id}', 'ProductController@delete_collection');


/*
|--------------------------------------------------------------------------
| Manage profile
|--------------------------------------------------------------------------
*/
Route::get('manageprofile','AdminController@profile');
Route::post('updateprofile/{id}','AdminController@manageprofile');

/*
|--------------------------------------------------------------------------
| Manage user
|--------------------------------------------------------------------------
*/
Route::get('dashboard', 'AdminController@dashboard');
Route::get('manageuser', 'AdminController@manage');
Route::get('managerole', 'AdminController@managerole');
Route::post('addrole', 'AdminController@addrole');
Route::get('details/{id}', 'AdminController@details');
Route::post('updaterole/{id}', 'AdminController@updaterole');
Route::get('deleterole/{id}', 'AdminController@deleterole');
Route::get('create', 'AdminController@create');
Route::post('adduser', 'AdminController@adduser');
Route::get('update/{id}', 'AdminController@update')->name('updateUser');
Route::post('updateuser/{id}', 'AdminController@updateuser');
Route::get('deleteuser/{id}', 'AdminController@destroy');


//---------------------------------------------- Customer Part -------------------------------------------------//

/*
|--------------------------------------------------------------------------
| Customer registration
|--------------------------------------------------------------------------
*/

Route::get('/', 'HomeController@viewproduct');
Route::get('showpackage/{id}', 'HomeController@view');
// Route::get('pendaftaran/{product_id}/{package_id}/{user_invite}', 'HomeController@register_user_invite');
Route::get('pendaftaran/{product_id}/{package_id}', 'HomeController@register');
Route::get('verification/{product_id}/{package_id}', 'HomeController@detailsic');
Route::get('verification/ARBAlumni/{product_id}/{package_id}', 'HomeController@detailAlumni');

/*
|--------------------------------------------------------------------------
| Customer profile
|--------------------------------------------------------------------------
*/

// Route::get('customer_profiles', 'ExistCustomerController@customerProfiles');
// Route::get('customer_profiles/{id}', 'ExistCustomerController@customerProfile');
// Route::get('customers', 'ExistCustomerController@customers');
Route::get('customer_profiles', 'customerProfileController@customerProfiles');
Route::get('customer_profiles/{id}', 'customerProfileController@customerProfile')->name('customerProfile');
Route::post('update_cust/{id}', 'customerProfileController@customerUpdate');
Route::post('add_comment/{id}', 'customerProfileController@customerAddComment');
Route::get('customer_details', 'customerProfileController@customerDetails');
Route::get('customer_surveyform', 'customerProfileController@customerSurveyForm')->name('customerSurveyForm');
Route::get('business_surveyform/{product_id}', 'customerProfileController@businessSurveyForm')->name('businessSurveyForm');
//Route::get('customer-invite', 'customerProfileController@customerInvite')->name('staff.customer-invite');;

// Newstudent
Route::get('maklumat-pembeli/{product_id}/{package_id}/{get_ic}', 'NewCustomerController@createStepOne');
Route::post('store1/{product_id}/{package_id}', 'NewCustomerController@postCreateStepOne');
Route::get('maklumat-tiket/{product_id}/{package_id}', 'NewCustomerController@createStepTwo');
Route::post('store2/{product_id}/{package_id}', 'NewCustomerController@postCreateStepTwo');
Route::get('pengesahan-pembelian/{product_id}/{package_id}', 'NewCustomerController@createStepThree');
Route::get('jenis-pembayaran/{product_id}/{package_id}', 'NewCustomerController@createStepFour');
Route::post('store4/{product_id}/{package_id}', 'NewCustomerController@postCreateStepFour');
Route::get('payment-method/{product_id}/{package_id}', 'NewCustomerController@payment_method');
Route::get('maklumat-kad/{product_id}/{package_id}', 'NewCustomerController@card_payment');
Route::post('storeCard/{product_id}/{package_id}', 'NewCustomerController@postCardMethod');
Route::get('data-fpx/{product_id}/{package_id}', 'NewCustomerController@pay_billplz');
Route::get('callback-payment/{product_id}/{package_id}', 'NewCustomerController@callback_payment');
Route::get('redirect-payment/{product_id}/{package_id}', 'NewCustomerController@redirect_payment');
Route::get('maklumat-pembayaran/{product_id}/{package_id}', 'NewCustomerController@manual_payment'); // manual payment form
Route::post('store-manual/{product_id}/{package_id}', 'NewCustomerController@manual_paymentprocess'); // manual payment process
Route::get('maklumat-free/{product_id}/{package_id}', 'NewCustomerController@manual_payment'); // free payment form
Route::get('store-free/{product_id}/{package_id}', 'NewCustomerController@free_paymentprocess'); // free payment process
Route::get('store-paid/{product_id}/{package_id}', 'NewCustomerController@paid_paymentprocess'); // paid payment process

// Existedstudent
Route::get('langkah-pertama/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@stepOne');
Route::post('save1/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@saveStepOne');
Route::get('langkah-kedua/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@stepTwo');
Route::post('save2/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@saveStepTwo');
Route::get('langkah-ketiga/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@stepThree');
Route::get('langkah-keempat/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@stepFour');
Route::post('save4/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@saveStepFour');
Route::get('pay-method/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@pay_method');
Route::get('data-stripe/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@stripe_payment');
Route::post('saveStripe/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@saveStripeMethod');
Route::get('data-billplz/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@billplz_payment');
Route::get('callback-billplz/{product_id}/{package_id}', 'ExistCustomerController@callback_billplz');
Route::get('redirect-billplz/{product_id}/{package_id}', 'ExistCustomerController@redirect_billplz');
Route::get('data-manual/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@manual_payment'); // manual payment form
Route::post('save-manual/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@save_manual_payment'); // manual payment process
Route::get('save-free/{product_id}/{package_id}', 'ExistCustomerController@save_free_paymentprocess'); // free payment process
Route::get('save-paid/{product_id}/{package_id}', 'ExistCustomerController@save_paid_paymentprocess'); // paid payment process

// Thank you page
Route::get('pendaftaran-berjaya/{product_id}','HomeController@thankyou');
Route::get('pendaftaran-tidak-berjaya','HomeController@failed_payment');



/*
|--------------------------------------------------------------------------
| Update Participant
|--------------------------------------------------------------------------
*/
Route::get('pendaftaran-peserta/{product_id}', 'HomeController@check_ic');
Route::get('pendaftaran-peserta/verify/{product_id}', 'HomeController@verify_ic');
Route::get('updateform/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@participant_form');
Route::post('updateforms/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@register_bulk'); // If no offer/bulk ticket
Route::post('get1free1same/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@register_get1free1same'); // If get 1 free 1 same ticket
Route::get('exportInvoice/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@exportInvoice');
Route::get('exportReceipt/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@exportReceipt');
Route::get('thankyou-update/{product_id}','HomeController@thankyou_update'); // Thank you page
Route::get('exceedlimit','HomeController@participant_form');// Exceed update limit page 

/*
|--------------------------------------------------------------------------
| Upgrade Package by buyer
|--------------------------------------------------------------------------
*/
Route::get('upgrade-package/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@choose_package');
Route::post('save-upgrade/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@save_package');
Route::get('upgrade-details/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@details_upgrade');
Route::post('save-details/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@save_details');
Route::get('pay-upgrade/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@pay_upgrade');
Route::post('save-payment/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@save_payment');
Route::get('choose-method/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@choose_method');
Route::get('card-method/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@card_method');
Route::post('save-stripe/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@save_stripe');
Route::get('pay-billplz/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@billplz_pay');
Route::get('redirect-pay/{product_id}/{package_id}/{stud_id}/{payment_id}', 'UpgradeController@redirect_pay');
Route::get('naik-taraf-berjaya', 'UpgradeController@success_upgrade');

/*
|--------------------------------------------------------------------------
| Upgrade Package by ticket
|--------------------------------------------------------------------------
*/
Route::get('upgrade/{product_id}', 'UpgradeController@check_ic');
Route::get('not-participant/{product_id}', 'UpgradeController@not_participant');
Route::get('upgrade/verify/{product_id}', 'UpgradeController@verify_ic');
Route::get('upgrade-ticket/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@upgrade_ticket');
Route::post('store-upgrade/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@store_package');
Route::get('ticket-details/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@ticket_details');
Route::post('store-details/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@store_details');
Route::get('upgrade-payment/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@upgrade_payment');
Route::post('store-payment/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@store_payment');
Route::get('payment-option/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@payment_option');
Route::get('card-option/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@card_option');
Route::post('store-stripe/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@store_stripe');
Route::get('billplz-option/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@billplz_option');
Route::get('redirect-page/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@redirect_page');
Route::get('naik-taraf-berjaya', 'UpgradeController@success_upgrade');
Route::get('manual-option/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@manual_option');
Route::post('store-manual/{product_id}/{package_id}/{ticket_id}', 'UpgradeController@save_manual_option');

/*
|--------------------------------------------------------------------------
| E-Certificate
|--------------------------------------------------------------------------
*/
Route::get('e-cert/{product_id}', 'CertController@ic_check');
Route::get('verify/{product_id}', 'CertController@checking_ic');
Route::get('check-cert/{product_id}/{stud_id}', 'CertController@checking_cert');
Route::get('certificate/{product_id}/{stud_id}', 'CertController@extract_cert');

/*
|--------------------------------------------------------------------------
| E-Certificate
|--------------------------------------------------------------------------
*/
Route::post('uploadCheque/{membership_id}/{level_id}/{student_id}','MembershipController@uploadcheque');

/*
|--------------------------------------------------------------------------
| Log Out
|--------------------------------------------------------------------------
*/
Route::get('logout', 'Auth\LoginController@logout');





//---------------------------------------------- Testing Part -------------------------------------------------//
Route::get('try-export', 'TestController@export');
Route::get('sendbasicemail','TestController@basic_email');
Route::get('payment', 'TestController@index');
Route::post('payment-process', 'TestController@process');
Route::get('test/email', function(){
  
	$send_mail = 'iqbalkisas6@gmail.com';
  
    dispatch(new App\Jobs\PengesahanJob($send_mail));
  
    dd('send mail successfully !!');
});

Route::get('/test/bulkmail', 'TestEmailController@testBulkEmails');

Route::get("/emailtemplate", 'EmailTemplate@index');
Route::get("/emailtemplate/search", 'EmailTemplate@search')->name('emailSearch');
Route::get("/emailtemplate/add", 'EmailTemplate@add');
Route::post("/emailtemplate/add", 'EmailTemplate@create');
Route::get("/emailtemplate/show/{id}", 'EmailTemplate@show');
Route::get("/emailtemplate/edit/{id}", 'EmailTemplate@edit');
Route::put("/emailtemplate/edit/{id}", 'EmailTemplate@update');
Route::get("/emailtemplate/delete/{id}", 'EmailTemplate@del');
Route::delete("/emailtemplate/delete/{id}", 'EmailTemplate@remove');

Route::get("/smstemplate", 'SmsTemplate@index');
Route::get("/smstemplate/add", 'SmsTemplate@add');
Route::post("/smstemplate/add", 'SmsTemplate@create');
Route::get("/smstemplate/edit/{id}", 'SmsTemplate@edit');
Route::put("/smstemplate/edit/{id}", 'SmsTemplate@update');
Route::get("/smstemplate/delete/{id}", 'SmsTemplate@del');
Route::delete("/smstemplate/delete/{id}", 'SmsTemplate@remove');

Route::get("/smsblast", 'SmsBulk@index');
Route::get("/smsblast/{group_id}", 'SmsBulk@show');
Route::get('/download-phoneno-template', 'SmsBulk@export');
Route::get("/smsblast/add", 'SmsBulk@add');
Route::post("/smsblast/send", 'SmsBulk@create');
Route::post("/smsblast/send_bulk", 'SmsBulk@create_bulk');
Route::get("/smsblast/edit/{id}", 'SmsBulk@edit');
Route::put("/smsblast/edit/{id}", 'SmsBulk@update');
Route::get("/smsblast/delete/{id}", 'SmsBulk@del');
Route::delete("/smsblast/delete/{id}", 'SmsBulk@remove');

Route::get("/smsschedule", 'SMSScheduleController@index');
Route::post("/smsschedule/add", 'SMSScheduleController@save');
Route::get("/smsschedule/edit/{id}", 'SMSScheduleController@edit');
Route::put("/smsschedule/edit/{id}", 'SMSScheduleController@update');
Route::get("/smsschedule/delete/{id}", 'SMSScheduleController@del');
Route::delete("/smsschedule/delete/{id}", 'SMSScheduleController@remove');

Route::prefix('student')->group(function() 
{
	Route::get('/','StudentPortal@redirectLogin');
	Route::get('/login','StudentPortal@loginForm')->name('student.login');
	Route::post('/login', 'StudentPortal@login')->name('student.login.submit');
	Route::get('/logout', 'StudentPortal@logout')->name('student.logout');

	// Reset at login
	Route::get('/login/reset-password', 'StudentPortal@resetPasswordForm')->name('login.reset-password');
	Route::post('/login/reset-password', 'StudentPortal@resetnewpassword')->name('login.reset-password.submit');

	// Check current password - Dashboard
	Route::get('/form-current-password', 'StudentPortal@showCheckPassword')->name('form_check_password');
	Route::post('/check-current-password', 'StudentPortal@checkCurrentPassword')->name('check-current-password');

	// Reset new password - Dashboard
	Route::get('/form-reset-password', 'StudentPortal@showResetPassword')->name('form_reset_password');
	Route::post('/reset-password', 'StudentPortal@resetPassword')->name('reset-password');

	Route::get('/dashboard', 'StudentPortal@show')->name('student.dashboard');
	Route::get('/bussiness-event-details', 'StudentPortal@registerForm')->name('student.regForm');
	Route::post('/bussiness-form', 'StudentPortal@bussinessForm');
	Route::get('/list-invoice', 'StudentPortal@listInvoice')->name('student.listInvoice');

	//download invoice kat list-invoice
	Route::get('/invoice-download/{level}/{invoice}/{student}','StudentPortal@downloadInvoice')->name('invoice-download');
	Route::get('/invoice-receipt/{level}/{payment}/{student}','StudentPortal@downloadResit')->name('receipt-download');

	// download manual invoice untuk user
	Route::get('download-manual-invoice/{level}/{invoice}/{student}', 'StudentPortal@downloadManualUserInvoices');

	//add new download statement 
	Route::get('/statement-format','StudentPortal@exportstatement_format')->name('statement-format');

	//add new resit 
	Route::get('/receipt/{level_id}/{payment_id}/{stud_id}','StudentPortal@downloadResit')->name('emails.resitmember');

	// shauqi add new routes
	
	Route::get('/invite-list', 'StudentPortal@showList')->name('student.invite_list');
	Route::get('/event-link', 'StudentPortal@showLink')->name('student.link');
	Route::get('/link-detail/{product_id}', 'StudentPortal@linkDetail')->name('student.link_detail');
	Route::get('/list-invoice/search', 'StudentPortal@searchInvoice')->name('student.searchInvoice');
	Route::get('/list-bill/{level}/{invoice}/{student}', 'StudentPortal@linkBill')->name('student.linkBill');
	Route::get('/receive-payment/{stud}/{level}/{invoice}', 'StudentPortal@receivepayment')->name('student.receivePayment');
	Route::get('/success_payment', 'InvoiceController@success');
	Route::get('/fail_payment', 'InvoiceController@fail');

	// Invoices & Receipt
	Route::get('invoices-receipt', 'StudentPortal@invoicesAndreceipt')->name('invoices.receipt');
	Route::get('invoices-receipt/inv', 'StudentPortal@invoices')->name('invoices-receipt.invoices');
	Route::get('invoices-receipt/receipt', 'StudentPortal@receipt')->name('invoices-receipt.receipt');
	
});

Route::prefix('staff')->group(function() {
	Route::get('/login','UserPortalController@showLoginForm')->name('staff.login');
	Route::post('/login', 'UserPortalController@login')->name('staff.login.submit');
	Route::post('/logout', 'UserPortalController@logout')->name('staff.logout');
	Route::get('/dashboard', 'UserPortalController@index')->name('staff.dashboard');
	Route::get('/event-link', 'UserPortalController@showLink')->name('staff.link');
	Route::get('/link-detail/{product_id}', 'UserPortalController@linkDetail')->name('staff.link_detail');
	// Route::get('/link', 'UserPortalController@getLink')->name('staff.link');
});

Route::prefix('invite')->group(function() {
	Route::get('/{id}', 'UserPortalController@invite');
});

Route::get("customer-support", 'CustomerSupport@index');

//Route::get("studentportal", 'StudentPortal@index');

Route::get('/zoom', 'ZoomController@index');
Route::get('/zoom/search', 'ZoomController@search')->name('zoomSearch');
Route::get('/zoom/add', 'ZoomController@create');
Route::post('/zoom/add', 'ZoomController@store');
Route::get('/zoom/edit/{zoom}', 'ZoomController@edit');
Route::put('/zoom/edit/{zoom}', 'ZoomController@update');
Route::get('/zoom/delete/{zoom}', 'ZoomController@del');
Route::delete('/zoom/delete/{zoom}', 'ZoomController@destroy');
Route::get('/zoom/{zoom}/{webinar}', 'ZoomController@showParticipants');
Route::get('/zoom/participantSearch/{zoom}/{webinar}', 'ZoomController@participantSearch')->name('participantSearch');

Route::post("/ajax", 'ChatAPI@index');

Route::get("/sample-client", 'SampleChat@index');

// Bussiness Details
Route::get('business_details/{ticket_id}', 'HomeController@showIC');
Route::post('ticket-verification/{ticket_id}', 'HomeController@ICValidation');
Route::get('user-details/{ticket_id}', 'HomeController@userDetails');
Route::get('next-details/{ticket_id}', 'HomeController@businessForm');
Route::post('save-business-details/{ticket_id}', 'HomeController@saveBusinessDetails');
Route::post('save-user-details/{ticket_id}', 'HomeController@saveUserDetails');
Route::get('pendaftaran-berjaya-ticket','HomeController@thankyouTicket');
Route::get('export-surveyform/{product_id}','HomeController@exportsurveyform');
Route::get('export-test','HomeController@exporttest');
Route::get('surveyform','HomeController@surveyform');

//check invoice template email
Route::get('check_invoice', 'InvoiceController@show');

// shauqi add for student invite customer
Route::get('invite-customer/{user_id}', 'HomeController@inviteCustomerForm');
Route::post('save-customer', 'HomeController@saveinviteCustomer');
Route::get('invite-customer-thankyou', 'HomeController@inviteCustomerThankyou');

Route::get('/sample-customer', 'SampleCustomer@index');

// route untuk kehadiran offline event
Route::get('/maklumat-peserta/{product_id}/{package_id}', 'AttendanceController@maklumatPeserta');
Route::get('/ic-peserta/{product_id}/{package_id}', 'AttendanceController@icPeserta');
Route::get('/data-peserta/{product_id}/{package_id}/{ticket_id}/{payment_id}/{ic}', 'AttendanceController@dataPeserta');
Route::get('/kehadiran-peserta/{product_id}/{package_id}/{ticket_id}/{payment_id}/{ic}', 'AttendanceController@pengesahanKehadiranPeserta');
Route::group(['middleware' => 'auth'], function () {
	// Route::get('/data-peserta/{product_id}/{package_id}/{ticket_id}/{payment_id}/{ic}', 'AttendanceController@adminDataPeserta');
    Route::get('/kehadiran-peserta/{product_id}/{package_id}/{ticket_id}/{payment_id}/{ic}', 'AttendanceController@pengesahanKehadiranPeserta');
});
// Route::get('/kehadiran-peserta/{product_id}/{package_id}/{ticket_id}/{payment_id}/{ic}', 'AttendanceController@pengesahanKehadiranPeserta');

Route::get('ic', function () {

	$students = \App\Student::all();
	foreach ($students as $student) 
	{
		if ($student->gender == NULL){
		if (is_numeric($student->ic))
		{
			if (strlen($student->ic) == 12)
			{
				if($student->ic % 2 == 0){
		
				$student->gender = "Perempuan";
				$student->save();
				}
				else if ($student->ic % 2 == 1) {

				$student->gender = "Lelaki";
				$student->save();
			}
			}
			else {
			}
		}
		}
	}
});
