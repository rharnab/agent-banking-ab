<?php

use Illuminate\Support\Facades\Route;

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



Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Password Change Start 
Route::get('/password-change','PasswordChangeController@index')->name('password-change.index');
Route::post('/password-update', 'PasswordChangeController@updatePassword')->name('password-change.update');

// Password Change End


Route::group(['prefix'=>'matching-score-setup','namespace'=>'PercentageSetup','as'=>'matching.score.setup.'],function(){
    Route::get('/','MatchingPercentageSetup@index')->name('index');
    Route::get('/create','MatchingPercentageSetup@create')->name('create');
    Route::post('/store','MatchingPercentageSetup@store')->name('store');
    Route::get('/edit/{id}','MatchingPercentageSetup@edit')->name('edit');
    Route::post('/update/{id}','MatchingPercentageSetup@update')->name('update');
    Route::delete('/delete/{id}','MatchingPercentageSetup@delete')->name('delete');
});


Route::group(['prefix'=>'parameter-setup/ocr-editable-field','namespace'=>'Parameter','as'=>'parameter-setup.ocr-editable-filed-setup.'],function(){
    Route::get('/','EditableOcrFieldController@index')->name('index');
    Route::get('/create','EditableOcrFieldController@create')->name('create');
    Route::post('/store','EditableOcrFieldController@store')->name('store');
    Route::get('/edit/{id}','EditableOcrFieldController@edit')->name('edit');
    Route::post('/update/{id}','EditableOcrFieldController@update')->name('update');
    Route::delete('/delete/{id}','EditableOcrFieldController@delete')->name('delete');



});



Route::group(['prefix' => 'customer', 'namespace'=> 'customer', 'as'=>'customer.'], function () {
    // redirect to customer search form
    Route::get('customer-search', 'CustomerSearchController@showCustomerSearchForm')->name('show_search_form');
    
    // customer finding with mobile + nid number
    Route::post('customer-search', 'CustomerSearchController@findCustomer')->name('customer_search');
});


Route::group(['prefix' => 'customer/customer-registation', 'namespace'=>'customer', 'as'=> 'customer.registation.'], function () {
    Route::get('index/{mobile_number}/{nid_number?}','customerRegistationController@showCustomerRegistationForm')->name('show_registation_form');
});


Route::group(['prefix' => 'customer/nid-ocr', 'namespace'=>'customer', 'as'=> 'customer.registation.' ], function () {
    Route::post('nid-upload-and-ocr','OcrController@uploadNidImage')->name('upload.nid');
});

Route::group(['prefix' => 'customer/ocr-ammendment', 'namespace'=>'customer', 'as'=> 'customer.registation.' ], function () {
    Route::post('ocr-ammendment', 'ammendmentNidOcrController@ammendmentOcr')->name('ocr.ammendment');
});

Route::group(['prefix'=>'customer/customer-face', 'namespace'=>'customer', 'as'=> 'customer.registation.'], function(){
   Route::post('face-compare', 'FaceImageController@faceCompare')->name('face_compare');
});


Route::group(['prefix' => 'customer', 'namespace'=>'customer', 'as'=> 'customer.verified.'], function () {
    Route::get('all-verified-customer', 'AllVarifiedCustomerController@index')->name('all_verified');
});

Route::group(['prefix' => 'customer', 'namespace'=>'customer', 'as'=> 'customer.'], function () {
    Route::get('profile/{id}','SinglerCustomerProfileController@index')->name('profile');
});



/*****************
 * Role Setup 
 *****************/
Route::group(['prefix' => 'role', 'namespace'=>'Role', 'as'=>'role.'], function () {
    Route::get('index','RoleSetupController@index')->name('index');
    Route::get('create', 'RoleSetupController@create')->name('create');
    Route::post('store', 'RoleSetupController@store')->name('store');
    Route::get('edit/{id}', 'RoleSetupController@edit')->name('edit');
    Route::post('update/{id}', 'RoleSetupController@update')->name('update');
    Route::delete('/delete/{id}','RoleSetupController@delete')->name('delete');
});

/*****************
 * Branch Setup 
 *****************/
Route::group(['prefix' => 'branch', 'namespace'=>'Parameter', 'as'=>'parameter.branch.'], function () {
    Route::get('index','BranchSetupController@index')->name('index');
    Route::get('create', 'BranchSetupController@create')->name('create');
    Route::post('store', 'BranchSetupController@store')->name('store');
    Route::get('edit/{id}', 'BranchSetupController@edit')->name('edit');
    Route::post('update/{id}', 'BranchSetupController@update')->name('update');
    Route::delete('/delete/{id}','BranchSetupController@delete')->name('delete');
});


/*****************
 * User Setup 
 *****************/
Route::group(['prefix' => 'user', 'namespace'=>'Parameter', 'as'=>'parameter.user.'], function () {
    Route::get('index','UserSetupController@index')->name('index');
    Route::get('create', 'UserSetupController@create')->name('create');
    Route::post('store', 'UserSetupController@store')->name('store');
    Route::get('edit/{id}', 'UserSetupController@edit')->name('edit');
    Route::post('update/{id}', 'UserSetupController@update')->name('update');
    Route::delete('/delete/{id}','UserSetupController@delete')->name('delete');
    Route::get('deactive/{id}', 'UserSetupController@deactive')->name('deactive');
    Route::get('active/{id}', 'UserSetupController@active')->name('active');
});


/*****************
 * Agent Setup
 *****************/
Route::group(['prefix' => 'agent', 'namespace'=>'Parameter', 'as'=>'parameter.agent.'], function () {
    Route::get('index','AgentSetupController@index')->name('index');
    Route::get('create', 'AgentSetupController@create')->name('create');
    Route::post('store', 'AgentSetupController@store')->name('store');
    Route::get('pending', 'AgentSetupController@pending')->name('pending');
    Route::post('authorize/{id}', 'AgentSetupController@authorizeAgent')->name('authorize');
});



/*****************
 * Agent User Setup
 *****************/

Route::group(['prefix' => 'agent/user', 'namespace'=>'Parameter', 'as'=>'parameter.agent.user.'], function () {
    Route::get('index','AgentUserController@index')->name('index');
    Route::get('create', 'AgentUserController@create')->name('create');
    Route::post('store', 'AgentUserController@store')->name('store');
    Route::get('pending', 'AgentUserController@pending')->name('pending');
    Route::post('authorize/{id}', 'AgentUserController@authorizeAgentUser')->name('authorize');
});



/*****************
 * Agent Admin
 *****************/
Route::group(['prefix' => 'agent/my-agent', 'namespace'=>'Agent', 'as'=>'agent.my_agent.'], function () {
    Route::get('index','OwnAgentController@index')->name('index');
});

/*****************
 * Agent User password Reset
 *****************/
Route::group(['prefix' => 'agent/user/password-reset', 'namespace'=>'Agent', 'as'=>'agent.user.password_reset.'], function () {
    Route::get('index','UserPasswordChangeController@index')->name('index');
    Route::post('reset', 'UserPasswordChangeController@reset')->name('reset');
});



/**********************************************
 *  Customer Self Registration
 **********************************************/
    
// Self Registation Page
Route::group(['namespace' => 'SelfRegistration', 'as' => 'self.registation.'],function(){
    Route::get('/{bank_slug}/self-registration', 'CustomerRegistationController@showRegistationPage')->name('showregistationpage');
    Route::post('self-registration', 'CustomerRegistationController@register')->name('register');
});


// Self Registration OTP
Route::group(['prefix' => 'self-registration', 'namespace' => 'SelfRegistration', 'as' => 'self.registation.'], function(){
    Route::get('otp/index/{user_id}', 'OTPController@index')->name('index');
    Route::post('otp-verificatioin', 'OTPController@otpVerification')->name('otp.verification');
    Route::post('resend-otp', 'OTPController@resendOTP')->name('resend.otp');
});

// Self Registration Process Step
Route::group(['prefix' => 'self-registration', 'namespace' => 'SelfRegistration', 'as' => 'self.registation.'], function(){
   
    // self-registration nid upload
    Route::post('nid-upload-ocr','NidOcrController@nidUploadAndOcr')->name('nid_upload_and_ocr');

    // Customer Ocr Data Review
    Route::post('ammendment-ocr-data','AmmendmentOcrController@ammendmentOcrData')->name('ammendment_ocr_data');
    
    // Customer Face Verification with NID face image & Mobile cam photo
    Route::post('face-verification', 'FaceComparisonController@faceImage')->name('face_image');

    
    // Signature Image Upload
    Route::post('signature-upload', 'SignatureController@singnatureUpload')->name('signature_upload');

   // Review & Modify Information for improve matching
    Route::post('review-data', 'ReviewdataController@modifyOcrData')->name('review_data');

    // Account Information Update
    Route::post('account-opening', 'AccountOpeningController@accountOpening')->name('account_opening');

    // Account Opening Info
    Route::post('nominee-setup', 'NomineeSetupController@nomineeSetupController')->name('nominee_setup');


});


/**********************************************
 *  Account Opening Request
 **********************************************/
Route::group(['prefix' => 'admin/account-opening', 'namespace' => 'Admin', 'as'=> 'admin.account_opening.'],function(){
    // show all account opening request
    Route::get('all-request','AccountOpeningController@allRequest')->name('all_request');

    // single account opening request details page
    Route::get('/single-request/{id}', 'AccountOpeningController@singleRequest')->name('single_request');

    // single account opening request details page
    Route::GET('/accept-account-opening-request/{id}', 'AccountOpeningRequestAcceptController@acceptAccountOpeningRequest')->name('accept_request');
});

/**********************************************
 *  Account Opening Request Decline
 **********************************************/
Route::group(['prefix' => 'admin/account-opening', 'namespace' => 'Admin', 'as'=> 'admin.account_opening.'],function(){
    // single account opening request details page
    Route::GET('/decline-account-opening-request/{id}', 'AccountOpeningRequestDeclineController@declineAccountOpeningRequest')->name('decline_request');

    // EC Compare With Self Account Opening Request
    Route::post('/ec-compare', 'EcComparisonController@ecCompare')->name('ec_compare');
    
    // EC Face Compare with Customer Camera Image
    Route::post('/ec-face-compare', 'EcComparisonController@ecFaceCompare')->name('ec_image_compare');
    

});



/**********************************************
 *  My Account Opening Request 
 **********************************************/
Route::group(['prefix' => 'my-request/', 'namespace' => 'SelfRegistration', 'as'=>'outside.customer.'], function(){
    Route::GET('index','MyRequestController@requestView')->name('request_view');
});

/**********************************************
 *  My Account Opening Request 
 **********************************************/
Route::group(['prefix' => 'my-request/', 'namespace' => 'SelfRegistration', 'as'=>'outside.customer.'], function(){
    Route::GET('edit','ResendRequestController@showEditPage')->name('show_edit_page');
    Route::POST('resend-request/{id}', 'ResendRequestController@resendRequest')->name('resend_request');
});




/**********************************************
 *  Branch Registration
 **********************************************/
Route::group(['prefix'=>'branch-registration', 'namespace' => 'BranchRegistration', 'as'=>'branch.registration.'], function(){

    // search customer
    Route::get('customer-search', 'CustomerSearchController@showCustomerSearchForm')->name('show_customer_search_form');

    // customer finding with mobile + nid number
    Route::post('customer-search', 'CustomerSearchController@findCustomer')->name('customer_search');

    // customer registration 
    Route::get('index/{mobile_number}/{nid_number?}','customerRegistationController@showCustomerRegistationForm')->name('show_registation_form');

    // Nid Front & Back part upload & ocr
    Route::post('nid-upload-and-ocr','NidOCRController@uploadNidImage')->name('nid_ocr');

    // Nid ocr-ammendment
    Route::post('nid-ocr-ammendment', 'ammendmentNidOcrController@ammendmentOcr')->name('nid_ocr.ammendment');

    // Customer Face compare with her ec-face image & webcam face image
    Route::post('webcam-face-compare', 'WebcamFaceCompare@faceCompare')->name('webcam_face_compare');

    // Customer Face compare with her ec-face image & uplaod face image
    Route::post('upload-image-face-compare', 'uploadFaceCompare@uploadFaceCompare')->name('upload_face_compare');


    // Redirect To Account Opening Form
    Route::get('/account-opening/{id?}', 'AccountOpeningController@showAccountOpeningForm')->name('account_opening_form');

    // Account Opening Information Saved
    Route::post('/save-accont-opening-info/{id}','AccountOpeningController@saveAccountOpeningRequest')->name('save_account_opening_request');


    // Find out account type product
    Route::post('/find-product','AccountOpeningController@findProduct')->name('find_product');
});


/**********************************************
 *  Pending Request Authorization
 **********************************************/
Route::group(['prefix' => 'pending-request', 'namespace' => 'Admin', 'as'=>'pending.request.'], function(){

    // Show All Pending Reqeust
    Route::get('all-request', 'PendingRequestAuthorizeController@showAllPendingRequest')->name('all_request');

    // view single pending request details
    Route::get('view-details/{id}', 'PendingRequestAuthorizeController@viewSingleRequestDetails')->name('view_single_request');

    // Accept Pending Request
    Route::get('/accept-request/{id}', 'PendingRequestAcceptController@acceptPendingRequest')->name('accept_pending_request');

});


/**********************************************
 *  Show All Verified customer
 **********************************************/
Route::group(['prefix' => 'verified-customer', 'namespace' => 'Admin', 'as'=>'verified.customer.'], function(){
  
    // all verified customer list
    Route::get('/all-verified-customer', 'AllVarifiedCustomerController@allVerifiedCustomer')->name('show_list');

    // view single customer view
    Route::get('/customer-view/{id}', 'AllVarifiedCustomerController@customerView')->name('customer_view');

});





/**********************************************
 * Product Setup
 **********************************************/
Route::group(['prefix' => 'product', 'namespace' => 'SuperAdmin\ParameterSetup', 'as'=>'product.parament_setup.'], function(){
    // Show All  Product List
    Route::get('index', 'ProductController@index')->name('index');
    Route::get('create', 'ProductController@create')->name('create');
    Route::post('store', 'ProductController@store')->name('store');
    Route::get('pending', 'ProductController@pending')->name('pending');
    Route::post('authorize/{id}', 'ProductController@authorizeProduct')->name('authorize');
});


/**********************************************
 * Gl Mapping
 **********************************************/
Route::group(['prefix' => 'gl-mapping', 'namespace' => 'SuperAdmin', 'as'=>'gl_mapping.'], function(){
    // Show All  Product List
    Route::get('index', 'GlMappingController@index')->name('index');
    Route::get('create', 'GlMappingController@create')->name('create');
    Route::post('store', 'GlMappingController@store')->name('store');
    Route::get('pending', 'GlMappingController@pending')->name('pending');
    Route::post('authorize/{id}', 'GlMappingController@authorizeGlMapping')->name('authorize');
});



####################################################
## Company Account Setup
####################################################
Route::group(['prefix'=>'gl-setup', 'namespace'=> 'chart_of_account', 'as'=>'account_setup.'], function(){
    Route::get('index', 'AccountSetupController@index')->name('index');
    Route::get('create', 'AccountSetupController@create')->name('create');
    Route::post('store', 'AccountSetupController@store')->name('store');
    Route::post('search-parent-account','AccountSetupController@searchParentAccount')->name('search.parent.account');
    Route::get('pending', 'AccountSetupController@pendingAccountSetup')->name('pending');
    Route::post('authorize/{id}', 'AccountSetupController@authorizeAccountSetup')->name('authorize');
    Route::post('delete/{id}', 'AccountSetupController@deleteAccount')->name('delete');
    Route::get('tree-view', 'AccountSetupController@treeView')->name('tree_view');
    Route::get('edit/{id}', 'AccountSetupController@edit')->name('edit');
    Route::post('update/{id}', 'AccountSetupController@update')->name('update');
});


####################################################
## Employee Setup
####################################################
Route::group(['prefix'=>'employee-setup', 'namespace'=> 'chart_of_account', 'as'=>'employee_setup.'], function(){
    Route::get('index', 'EmployeeController@index')->name('index');
    Route::get('create', 'EmployeeController@create')->name('create');
    Route::post('store', 'EmployeeController@store')->name('store');
    Route::post('search-user-email-phone', 'EmployeeController@searchEmailPhone')->name('search_email_phone');
    Route::get('edit/{id}', 'EmployeeController@edit')->name('edit');
    Route::post('update/{id}', 'EmployeeController@update')->name('update');
    Route::get('pending', 'EmployeeController@pending')->name('pending');
    Route::post('authorize/{id}', 'EmployeeController@authorizeEmployee')->name('authorize');   
});



/**********************************************
 * Gl Mapping
 **********************************************/
Route::group(['prefix' => 'password-reset', 'namespace' => 'SuperAdmin', 'as'=>'super_admin.password_reset.'], function(){
    Route::get('index', 'PasswordResetController@index')->name('index');
    Route::post('reset', 'PasswordResetController@reset')->name('reset');
});



/**********************************************
 * Limit Modify
 **********************************************/
Route::group(['prefix' => 'agent/user-limit-modify', 'namespace' => 'Agent', 'as'=>'agent.limit_modify.'], function(){
    Route::get('index', 'LimitModifyController@index')->name('index');
    Route::get('edit/{id}', 'LimitModifyController@edit')->name('edit');
    Route::post('update/{id}', 'LimitModifyController@update')->name('update');
});


/**********************************************
 * Existing User Accout Opening
 **********************************************/
Route::group(['prefix' => 'agent/existing-user', 'namespace' => 'AgentUser', 'as'=>'exits.user.account_open.'], function(){
    Route::get('index', 'ExistingUserAccountOpeningContoller@index')->name('index');
    // customer finding with mobile + nid number
    Route::post('customer-search', 'ExistingUserAccountOpeningContoller@findCustomer')->name('customer_search');
});


/**********************************************
 * Report Section Start
 **********************************************/

Route::group(['prefix' => 'report', 'namespace' => 'Report', 'as'=>'report.'], function(){

         Route::get('productlist', 'ReportController@productlist')->name('productlist');
         Route::get('branchlist', 'ReportController@branchlist')->name('branchlist');
         Route::get('listofgl', 'ReportController@listofgl')->name('listofgl');
         Route::get('productMapping', 'ReportController@productMapping')->name('productMapping');
         Route::get('user_list', 'ReportController@user_list')->name('user_list');
         Route::get('user_edit_log', 'ReportController@user_edit_log')->name('user_edit_log');
});



//Utility Bill

Route::group(['prefix' => 'utility-bill', 'namespace' => 'Utilitybill', 'as'=>'Utilitybill.'],  function(){

         Route::get('wasa', 'UtilitybillController@wasa')->name('wasa');
         Route::get('wasaaction', 'UtilitybillController@wasagetdata')->name('wasaaction');

         Route::get('dpdc', 'UtilitybillController@dpdc')->name('dpdc');
         Route::get('dpdcaction', 'UtilitybillController@dpdcaction')->name('dpdcaction');

         Route::get('titas', 'UtilitybillController@titas')->name('titas');
         Route::get('titasaction', 'UtilitybillController@titasaction')->name('titasaction');

         Route::get('desco', 'UtilitybillController@desco')->name('desco');
         Route::get('descoaction', 'UtilitybillController@descoaction')->name('descoaction');

         Route::get('schoolfees', 'UtilitybillController@schoolfees')->name('schoolfees');
         Route::get('creditcardbill', 'UtilitybillController@creditcardbill')->name('creditcardbill');
       
});


//sanction Screen

Route::group(['prefix' => 'parameter-setup', 'namespace' => 'Sanctionscreen', 'as'=>'Sanctionscreen.'], function(){

         Route::get('sanctionscreen', 'SanctionscreenController@sanctionscreen')->name('sanctionscreen');
         Route::get('sanctionscreenlistupload', 'SanctionscreenController@sanctionscreenlistupload')->name('sanctionscreenlistupload');
              
});


Route::get('account_list', 'Account\AccountController@accountlist');
/**********************************************
 * Report Section End
 **********************************************/



 /**********************************************
 * Transaction Section Start
 **********************************************/
 Route::post('/amount/inowrd', 'AmountInWordController@numberConverToWord')->name('amount.inword');
 Route::post('/amount/find', 'AmountInWordController@accountNoFind')->name('account_no.find');

Route::group(['prefix' => 'agent-user/transaction/cash', 'namespace' => 'AgentUser\Transaction', 'as'=>'agent_user.transaction.cash.'], function(){
    Route::get('create', 'CashTransactionController@create')->name('create');
    Route::post('store', 'CashTransactionController@store')->name('store');
    Route::get('authorize-list', 'CashTransactionController@authorizeList')->name('authorize_list');
    Route::post('authorize-transaction/{id}', 'CashTransactionController@authorizeTransaction')->name('authorize_transaction');
});

 /**********************************************
 * Transaction Section End
 **********************************************/


 
 /**********************************************
 * Fund Transfer Section Start
 **********************************************/
Route::group(['prefix' => 'agent-user/transaction/transfer', 'namespace' => 'AgentUser\Transaction', 'as'=>'agent_user.transaction.transfer.'], function(){
    Route::get('create', 'FunTransferTransactionController@create')->name('create');
    Route::post('store', 'FunTransferTransactionController@store')->name('store');
    Route::get('pending-authorization', 'FunTransferTransactionController@pendingList')->name('pending');
    Route::post('authorize-transaction/{id}', 'FunTransferTransactionController@authorizeTransaction')->name('authorize_transaction');
});








  /**********************************************
 * Cash Transaction Report
 **********************************************/

Route::group(['prefix' => 'report/cash', 'namespace' => 'Report', 'as'=>'report.cash.'], function(){
    Route::get('date-range-statement', 'CashTansactionReport@dateRangeStatement')->name('date_range');
});



Route::group(['prefix' => 'transfer', 'namespace'=>'FundTransfer', 'as'=>'transfer.fund.'], function () {
    Route::get('index','TransferController@index')->name('index');
    Route::get('create', 'TransferController@create')->name('create');
    Route::post('store', 'TransferController@store')->name('store');
    Route::put('update/{id}', 'TransferController@update')->name('update');
});
















  /**********************************************
 * Customer Name Searching Report
 **********************************************/
Route::group(['prefix'=>'report/transaction', 'namespace'=>'Report\AgentUser\Searching', 'as'=>'report.agent_user.searching.'], function(){
    Route::get('customer-search/index', 'CustomerSearchController@index')->name('customer_search.index');
    Route::post('customer-search/search', 'CustomerSearchController@search')->name('customer_search.search');
    Route::get('cheque-requisition-status/index', 'ChequeRequisionStatusController@index')->name('cheque_requisition_status.index');
    Route::post('cheque-requisition-status/search', 'ChequeRequisionStatusController@search')->name('cheque_requisition_status.search');
});



  /**********************************************
 * Check Statement 
 **********************************************/
Route::group(['prefix'=>'report/statement', 'namespace'=>'Report\AgentUser\Statement', 'as'=>'report.agent_user.statement.'], function(){
    Route::get('mini-statement/index', 'MinistatementController@index')->name('mini_statement.index');
    Route::post('mini-statement/search', 'MinistatementController@search')->name('mini_statement.search');
    Route::get('date-range-statement/index', 'DateRangeStatementController@index')->name('date_range_statement.index');
    Route::post('date-range-statement/search', 'DateRangeStatementController@search')->name('date_range_statement.search');
});



/**********************************************
 * Account List Controller
 **********************************************/
Route::group(['prefix'=>'report/account-list', 'namespace'=>'Report\AgentUser', 'as'=>'report.agent_user.account_list.'], function(){
    Route::get('index', 'AccountListController@index')->name('index');
    Route::post('search', 'AccountListController@search')->name('search');
});


/**********************************************
 * Transfer Transaction Controller
 **********************************************/
Route::group(['prefix'=>'report/account-list', 'namespace'=>'Report\AgentUser\Transaction', 'as'=>'report.agent_user.transasction.'], function(){
    Route::get('transfer/index', 'TransferTransactionController@index')->name('transfer.index');
    Route::post('transfer/search', 'TransferTransactionController@search')->name('transfer.search');
    Route::get('cash-transaction', 'CashTransaction@index')->name('cash.index');
    Route::post('cash-search', 'CashTransaction@search')->name('cash.search');
});


/**********************************************
 * Balance Enquery
 **********************************************/
Route::get('ballance/ballance-enquery','Ballance\BallanceController@ballance_enquiry')->name('ballance-enquery');
Route::post('balance/balance-enquery', 'Ballance\BallanceController@searchBalance')->name('balance.search');


/**********************************************
 * Utility Reprot
 **********************************************/
Route::group(['prefix' => 'Report/utility-bill', 'namespace' => 'Report', 'as'=>'report.'], function(){
    Route::get('schoolfees', 'UtilitybillControllerReport@schoolfees')->name('schoolfees');
});
Route::post('schoolfees_submit', 'Utilitybill\UtilitybillController@schoolfees_submit');


/**********************************************
 * Head Office Account List Controller
 **********************************************/

Route::group(['prefix'=>'report/account-list/head-office', 'namespace'=>'Report\HeadOffice', 'as'=>'report.head_office.account_list.'], function(){
    Route::get('index', 'AccountListController@index')->name('index');
    Route::post('search', 'AccountListController@search')->name('search');
});





/**********************************************
 * Commission Section Start
 **********************************************/
 
 
 

########################   account commission set up ############################################
Route::group(['prefix'=>'commission-setup', 'namespace'=>'commission\account', 'as'=>'commission_setup.account.'], function(){

    Route::get('account-open-commission', 'accountCommissionController@index')->name('index');
    Route::get('commission-create', 'accountCommissionController@create')->name('create');
    Route::post('commission-create', 'accountCommissionController@store')->name('store');
    Route::get('commission-update/{id}', 'accountCommissionController@edit')->name('edit');
    Route::post('commission-update/{id}', 'accountCommissionController@update')->name('update');
     
});


########################   transaction commission set up ############################################

Route::group(['prefix'=>'commission-setup', 'namespace'=>'commission\transaction', 'as'=>'commission_setup.transaction.'], function(){

    Route::get('transaction-commission', 'transactionController@index')->name('index');
    Route::get('transaction-commission-create', 'transactionController@create')->name('create');
    Route::post('transaction-commission-create', 'transactionController@store')->name('store');
    Route::get('transaction-commission-update/{id}', 'transactionController@edit')->name('edit');
    Route::post('transaction-commission-update/{id}', 'transactionController@update')->name('update');


});


########################   bill commission set up ############################################

Route::group(['prefix'=>'commission-setup', 'namespace'=>'commission\bill', 'as'=>'commission_setup.bill.'], function(){

    Route::get('bill-commission', 'billController@index')->name('index');
    Route::get('bill-commission-create', 'billController@create')->name('create');
    Route::post('bill-commission-create', 'billController@store')->name('store');
    Route::get('bill-commission-update/{id}', 'billController@edit')->name('edit');
    Route::post('bill-commission-update/{id}', 'billController@update')->name('update');


});

########################   statement commission set up ############################################

Route::group(['prefix'=>'commission-setup', 'namespace'=>'commission\statement', 'as'=>'commission_setup.statement.'], function(){

    Route::get('statement-commission', 'statementController@index')->name('index');
    Route::get('statement-commission-create', 'statementController@create')->name('create');
    Route::post('statement-commission-create', 'statementController@store')->name('store');
    Route::get('statement-commission-update/{id}', 'statementController@edit')->name('edit');
    Route::post('statement-commission-update/{id}', 'statementController@update')->name('update');


});




 

####################################################
## Report
####################################################

Route::group(['prefix'=>'report', 'namespace'=>'report\commission', 'as'=>'commission.'], function(){

    Route::get('account-open', 'CommissionController@account_open')->name('account_open');
    Route::get('show-account-open-commission', 'CommissionController@show_account_open_commission')->name('show_account_open');
    //for account
    Route::get('account-open-commission-report', 'CommissionController@acc_open_details')->name('account_open.details');
    Route::get('account-open-commission-details-report', 'CommissionController@acc_open_details_report')->name('show_account_open_datils');

    //for transction
    Route::get('transaction-summary', 'CommissionController@transaction_summary')->name('transaction_summary');
    Route::get('transaction-summary-report', 'CommissionController@transaction_summary_report')->name('transaction_summary_report');
    Route::get('transaction-details', 'CommissionController@transaction_details')->name('transaction_details');
    Route::get('transaction-details-report', 'CommissionController@transaction_details_report')->name('transaction_details_report');

    //for bill
    Route::get('bill-summary', 'CommissionController@bill_summary')->name('bill_summary');
    Route::get('bill-summary-report', 'CommissionController@bill_summary_report')->name('bill_summary_report');
    Route::get('bill-details', 'CommissionController@bill_details')->name('bill_details');
    Route::get('bill-details-report', 'CommissionController@bill_details_report')->name('bill_details_report');

    //for statement

    Route::get('statement', 'CommissionController@statement_summary')->name('statement_summary');
    Route::get('statement-summary-report', 'CommissionController@statement_summary_report')->name('statement_summary_report');
    Route::get('statement-details', 'CommissionController@statement_details')->name('statement_details');
    Route::get('statement-details-report', 'CommissionController@statement_details_report')->name('statement_details_report');    

});


Route::get('agent-user-report', 'report\user_and_security\UserAndSecurityController@user_report')->name('agent_user.user_report');
Route::post('agent-user-report', 'report\user_and_security\UserAndSecurityController@user_report_details')->name('agent_user.user_report_details');

Route::get('log-report', 'report\ReportController@log_report')->name('modify.log_report');
Route::post('log-report', 'report\ReportController@limit_report')->name('modify.limit_report');


/*--------------------------------------------ramjan-------------------------------------------------------*/
