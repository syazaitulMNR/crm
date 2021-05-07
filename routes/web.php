<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestMail;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;

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

//---------------------------------------------- Administrator Part -------------------------------------------------//

Auth::routes();

Route::get('/addproduct', function () {
    return view('admin.addproduct');
});

Route::get('/addpack', function () {
    return view('admin.addpackage');
});

Route::get('/addstudent', function () {
    return view('students.adddetails');
});


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
// Route::get('/superadmin', 'AdminController@index');
Route::get('manageuser', 'AdminController@manage');
Route::get('managerole', 'AdminController@managerole');
Route::post('addrole', 'AdminController@addrole');
Route::get('details/{id}', 'AdminController@details');
Route::post('updaterole/{id}', 'AdminController@updaterole');
Route::get('deleterole/{id}', 'AdminController@deleterole');
Route::get('create', 'AdminController@create');
Route::post('adduser', 'AdminController@adduser');
Route::get('update/{id}', 'AdminController@update');
Route::post('updateuser/{id}', 'AdminController@updateuser');
Route::get('deleteuser/{id}', 'AdminController@destroy');
Route::get('database-management','ImportExcelController@index');
Route::post('importExcel','ImportExcelController@import');
Route::get('exportExcel', 'ImportExcelController@export');

/*
|--------------------------------------------------------------------------
| Manage event
|--------------------------------------------------------------------------
*/
Route::get('product', 'ProductController@viewproduct');
Route::post('addproduct', 'ProductController@create');
Route::get('edit/{id}', 'ProductController@edit');
Route::post('update/{id}',  'ProductController@update');
Route::get('delete/{id}', 'ProductController@destroy');

/*
|--------------------------------------------------------------------------
| Manage package
|--------------------------------------------------------------------------
*/
Route::get('addpackage/{id}', 'ProductController@pack');
Route::post('storepack/{id}', 'ProductController@storepack');
Route::get('package/{id}', 'ProductController@view');
Route::get('editpack/{id}/{productId}', 'ProductController@editpack');
Route::post('updatepack/{id}/{productId}',  'ProductController@updatepack');
Route::get('deletepack/{packageId}', 'ProductController@destroypack');
Route::get('viewpacks/{id}', 'ProductController@show');
Route::get('feature/{id}', 'ProductController@viewpack');

/*
|--------------------------------------------------------------------------
| Manage student
|--------------------------------------------------------------------------
*/
Route::post('student/details', 'StudentController@details');
Route::get('viewstudents', 'StudentController@viewstudents');
Route::get('viewdetails/{id}',  'StudentController@viewdetails');
Route::get('sendmail/{id}/{payment_id}',  'StudentController@sendEmail');
Route::post('editdetails/{id}', 'StudentController@editdetails');
Route::get('deletestudent/{id}', 'StudentController@destroystud');

/*
|--------------------------------------------------------------------------
| Blasting Email
|--------------------------------------------------------------------------
*/
Route::get('emailblast', 'BlastingController@emailblast');
Route::get('view-event/{product_id}', 'BlastingController@show');

Route::get('send-bulk-mail', 'BlastingController@sendBulkMail');

/*
|--------------------------------------------------------------------------
| Manage report
|--------------------------------------------------------------------------
*/
Route::get('trackcustomer', 'ReportsController@trackcustomer');
Route::get('trackprogram', 'ReportsController@trackprogram');
Route::get('trackpackage/{product_id}', 'ReportsController@trackpackage');
Route::get('viewbypackage/{product_id}/{package_id}', 'ReportsController@viewbypackage');
Route::get('viewpayment/{product_id}/{package_id}/{payment_id}/{student_id}', 'ReportsController@trackpayment');
Route::post('updatepayment/{product_id}/{package_id}/{payment_id}/{student_id}', 'ReportsController@updatepayment');
Route::get('exportProgram/{product_id}', 'ReportsController@exportProgram');


//---------------------------------------------- Customer Part -------------------------------------------------//

/*
|--------------------------------------------------------------------------
| Customer registration
|--------------------------------------------------------------------------
*/
Route::get('/', 'HomeController@viewproduct');
Route::get('showpackage/{id}', 'HomeController@view');
Route::get('pendaftaran/{product_id}/{package_id}', 'HomeController@register');
Route::get('verification/{product_id}/{package_id}', 'HomeController@detailsic');

// Newstudent
Route::get('maklumat-pembeli/{product_id}/{package_id}/{get_ic}', 'NewCustomerController@createStepOne');
Route::post('store1/{product_id}/{package_id}', 'NewCustomerController@postCreateStepOne');
Route::get('maklumat-tiket/{product_id}/{package_id}', 'NewCustomerController@createStepTwo');
Route::post('store2/{product_id}/{package_id}', 'NewCustomerController@postCreateStepTwo');
Route::get('pengesahan-pembelian/{product_id}/{package_id}', 'NewCustomerController@createStepThree');
// Route::post('store3/{product_id}/{package_id}', 'NewCustomerController@postCreateStepThree');
Route::get('jenis-pembayaran/{product_id}/{package_id}', 'NewCustomerController@createStepFour');
Route::post('store4/{product_id}/{package_id}', 'NewCustomerController@postCreateStepFour');
Route::get('payment-method/{product_id}/{package_id}', 'NewCustomerController@payment_method');
Route::get('maklumat-kad/{product_id}/{package_id}', 'NewCustomerController@card_payment');
Route::post('storeCard/{product_id}/{package_id}', 'NewCustomerController@postCardMethod');
Route::get('data-fpx/{product_id}/{package_id}', 'NewCustomerController@pay_billplz');
Route::get('redirect-payment', 'NewCustomerController@redirect_payment');
// Route::get('fpx-bank/{product_id}/{package_id}', 'NewCustomerController@fpx_payment');
// Route::get('storeFpx/{product_id}/{package_id}', 'NewCustomerController@postFpxMethod');
// Route::get('regnewstudent/{product_id}/{package_id}/{get_ic}', 'NewCustomerController@newstudent');
// Route::post('registernew/{product_id}/{package_id}', 'NewCustomerController@storestd');

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
Route::get('redirect-billplz', 'ExistCustomerController@redirect_billplz');
// Route::get('data-fpx/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@fpx_payment');
// Route::get('saveFpx/{product_id}/{package_id}/{stud_id}', 'ExistCustomerController@saveFpxMethod');
// Route::get('regstudent/{product_id}/{package_id}/{stud_id}', 'ExistStudentController@existedstudent');
// Route::post('register/{product_id}/{package_id}/{stud_id}', 'ExistStudentController@updatestd');

// Thank you page
Route::get('pendaftaran-berjaya','HomeController@thankyou');


/*
|--------------------------------------------------------------------------
| Update Participant
|--------------------------------------------------------------------------
*/
Route::get('updateform/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@participant_form');
//if bulk ticket
Route::post('updateforms/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@add_participant');
//if get 1 free 1 offer ticket
// Route::post('updateforms/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@register_get1free1');

Route::get('exportInvoice/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@exportInvoice');
Route::get('exportReceipt/{product_id}/{package_id}/{stud_id}/{payment_id}', 'HomeController@exportReceipt');
// Thank you page
Route::get('thankyou-update','HomeController@thankyou_update');
// Exceed limit page 
Route::get('exceedlimit','HomeController@participant_form');

Route::get('products/{product_id}/{package_id}', 'NewRegisterController@index')->name('products.index');

/*
|--------------------------------------------------------------------------
| Upgrade Package
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
Route::get('redirect-pay', 'UpgradeController@redirect_pay');
Route::get('naik-taraf-berjaya', 'UpgradeController@success_upgrade');

/*
|--------------------------------------------------------------------------
| E-Certificate
|--------------------------------------------------------------------------
*/
Route::get('e-cert/{product_id}', 'CertController@ic_check');
Route::get('verify/{product_id}', 'CertController@checking_ic');
Route::get('get-cert/{product_id}/{stud_id}', 'CertController@get_cert');













//---------------------------------------------- Testing Part -------------------------------------------------//
Route::get('try','HomeController@try');
Route::get('sendmail', 'HomeController@tryemail');
Route::get('sendbasicemail','TestController@basic_email');

Route::get('payment', 'TestController@index');
Route::post('payment-process', 'TestController@process');

Route::get('test/email', function(){
  
	$send_mail = 'zarina4.11@gmail.com';
  
    dispatch(new App\Jobs\PengesahanJob($send_mail));
  
    dd('send mail successfully !!');
});