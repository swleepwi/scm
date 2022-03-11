<?php

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

Route::get('/',function(){
    if(session('pwiscm_logged')) {
        return redirect()->action('PurchaseOrderController@index');
    }
    else{
        return view('login');
    }
});

Route::post('/login/loginaction','Auth\LoginSystemController@LoginAction');

Route::get('/po/management', 'PurchaseOrderController@index');
Route::get('/po/datalist/{start_date?}/{end_date?}/{order_number?}/{po_number?}', 'PurchaseOrderController@dataList');
Route::get('/po/detaildatalist/{po_number}/{order_number?}', 'PurchaseOrderController@detailDataList');
Route::get('/po/sizelist/{po_number}/{seq_number}', 'PurchaseOrderController@listSize');

Route::get('/labelprint/management', 'LabelController@index');
Route::get('/labelprint/datalist/{start_date?}/{end_date?}/{order_number?}/{po_number?}', 'LabelController@dataList');
Route::get('/labelprint/labeldatalist/{po_number}/{seq_number}', 'LabelController@detailByLabel');
Route::get('/labelprint/sizedatalist/{po_number}/{seq_number}/{uk_size}', 'LabelController@detailBySize');
Route::get('/labelprint/makelabel/{po_number}/{seq_number}', 'LabelController@makeLabel');

Route::get('/labelprint/printnow', 'LabelController@prinLabel');
Route::get('/labelprint/printbysizes/{po_number}/{po_sequence}/{size}', 'LabelController@printBySizes');
Route::get('/labelprint/printbylabels/{po_number}/{po_sequence}/{label}', 'LabelController@printByLabels');
Route::get('/labelprint/printall/{po_number}/{po_sequence}', 'LabelController@printAll');
Route::get('/labelprint/printsingle/{po_number}/{po_sequence}/{label}', 'LabelController@printBySingle');

Route::get('/dnview/management', 'DeliveryNoteController@index');
Route::get('/dnview/datalist/{start_date?}/{end_date?}/{order_number?}/{po_number?}', 'DeliveryNoteController@dataList');
Route::get('/dnview/detaildatalist/{out_date}/{out_number}', 'DeliveryNoteController@detailDataList');
Route::get('/dnview/sizelist/{po_number}/{seq_number}', 'DeliveryNoteController@listSize');

Route::get('/dncreate/new/{out_no?}/{out_date?}', 'DeliveryNoteController@create');
Route::post('/dncreate/savemaster', 'DeliveryNoteController@saveMaster');
Route::get('/dncreate/detailcreatelist/{out_date}/{out_number}', 'DeliveryNoteController@detailCrateList');
Route::get('/dncreate/searchpo/{po_number}/{order_number}', 'DeliveryNoteController@searchPOToAdd');
Route::post('/dncreate/adddetail', 'DeliveryNoteController@insertDetailDN');
Route::post('/dncreate/deleteinserted', 'DeliveryNoteController@deleteInserted');
Route::post('/dncreate/deletemaster', 'DeliveryNoteController@deleteMaster');
Route::get('/dncreate/dnprint/{out_no}/{out_date}', 'DeliveryNoteController@DNprint');
Route::get('/dncreate/listsize/{po_number}/{po_seq}/{out_date}/{out_number}/{out_seq}/{buyer}/{gender}', 'DeliveryNoteController@listSize');

Route::get('/barcode/scan', 'BarcodeScanController@index');
Route::get('/barcode/datalist/{start_date?}/{end_date?}/{order_number?}/{po_number?}', 'BarcodeScanController@dataList');
Route::get('/barcode/detailbarcode/{po_number}/{po_sequence}', 'BarcodeScanController@detailBarcodeSize');
Route::get('/barcode/barcodescan', 'BarcodeScanController@barcodeScan');
Route::get('/barcode/scanneddata', 'BarcodeScanController@getScannedData');
Route::post('/barcode/scaninsert', 'BarcodeScanController@scanInsert');
Route::post('/barcode/scandelete', 'BarcodeScanController@scanDelete');


Route::get('/utility/changepassword', 'UtilityController@changePasswordForm');
Route::post('/utility/changpasswordaction', 'UtilityController@changePasswordAction');
Route::get('/utility/logoutapp', 'UtilityController@logoutApp');


Route::post('/dndelete/deleteinserted', 'DNDeleteController@deleteInserted');
Route::post('/dndelete/deletemaster', 'DNDeleteController@deleteMaster');

Route::get('/dndeletelink/deletemaster/{out_date}/{out_no}', 'DNDeleteController@deleteMasterGet');
Route::post('/label/export', 'LabelController@generateImage');

Route::get('/status/index', 'StatusController@index');
Route::get('/status/data', 'StatusController@data');

Auth::routes();
