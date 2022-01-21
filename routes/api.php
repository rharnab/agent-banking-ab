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


Route::group(['namespace'=>'ApiController', 'middleware'=>'auth:api'],function(){
    // Authentication Information API
    Route::get('auth-info', 'AuthController@authInfo');

    // Self Customer Registration With Mobile + Email  Address [ Mobile is mendatory / email is optional]
    Route::post('registartion','RegistrationController@registration');

    // Customer Nid Upload & OCR
    Route::post('nid-ocr', 'NidUploadController@nidUpload');

    // Ammendment Ocr Controller
    Route::post('ammendment-ocr-data', 'AmmendmentController@ammendmentOcr');

    // Customer Face Matching
    Route::post('face-verification', 'FaceMatchingController@faceVerification');

    // Signature Upload
    Route::post('signature-upload', 'SignatureUploadController@signatureUpload');
    
    // All Branch List
    Route::post('branch-list', 'BranchListController@branchList');

    // All Account Types
    Route::post('account-types', 'AccountTypesController@accountTypes');

    // Review Information 
    Route::post('review-information', 'ReviewInfoController@reviewInfo');

    // Account Opening Form
    Route::post('account-opening', 'AccountOpeningController@accountOpen');

});

 