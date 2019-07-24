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
/*use Hash;
Route::get('hashpassword', function () {
echo Hash::make('123456');
});
 */

//Route::get('/', function () {return view('welcome');})->middleware('auth')->name('/');
//$permissions = App\Permission::select('name')->where('name','like','%permission%')->pluck('name');

 //$perms = collect($permissions)->implode('|');

$permissions=[];
$perms=collect($permissions)->implode('|');

/*print_r($perms);
exit;*/

// Route::get('test-tcp',function(){
// 	broadcast(new \App\Events\WareHouseStausEvent());
// });

Route::group(['prefix' => 'employee','as' => 'employee.','middleware' => ['role:employee|worker', 'auth','verified']], function () use($perms){


		Route::get('dashboard', ['as' => 'employee_dashboard', 'uses' => 'Employee\DashboardController@index']);
		Route::post('upload', ['as' => 'upload', 'uses' => 'Employee\DashboardController@upload']);
		Route::post('taskgeneral', ['as' => 'taskgeneral', 'uses' => 'Employee\DashboardController@taskGeneral']);
		Route::get('get_break_time', ['as' => 'get_break_time', 'uses' => 'Employee\DashboardController@getBreaktime']);
		Route::post('post_break_time', ['as' => 'post_break_time', 'uses' => 'Employee\DashboardController@postBreakTime']);
		Route::post('remarks', ['as' => 'remarks', 'uses' => 'Employee\DashboardController@remarks']);
		Route::post('logout', ['as' => 'logout', 'uses' => 'Employee\DashboardController@logout']);

		Route::post('end_of_day', ['as' => 'end_of_day', 'uses' => 'Employee\DashboardController@endOfDay']);

		Route::group(['prefix' => 'pickup','as' => 'pickup.'], function () use($perms){

			Route::get('/', ['as' => 'index', 'uses' => 'Employee\PickupController@index']);

			Route::post('pick_packages', ['as' => 'pick_packages', 'uses' => 'Employee\PickupController@pickPackages']);

			Route::post('package_status_update', ['as' => 'package_status_update', 'uses' => 'Employee\PickupController@updatePackageStatus']);

			Route::post('end_task', ['as' => 'end_task', 'uses' => 'Employee\PickupController@endTask']);


		});


		Route::group(['prefix' => 'consolidate','as' => 'consolidate.'], function () use($perms){

			Route::get('/', ['as' => 'index', 'uses' => 'Employee\ConsolidateController@index']);
			Route::get('get_consolidatie_request', ['as' => 'get_consolidatie_request', 'uses' => 'Employee\ConsolidateController@getConsolidateRequest']);
			Route::post('pull_consolidate_request', ['as' => 'pull_consolidate_request', 'uses' => 'Employee\ConsolidateController@pullConsolidateRequest']);
			Route::get('packages/{id}', ['as' => 'package_consolidate_request', 'uses' => 'Employee\ConsolidateController@packageConsolidateRequest']);
			Route::get('package_images', ['as' => 'package_images', 'uses' => 'Employee\ConsolidateController@packageImages']);
			Route::post('add_actual_weight', ['as' => 'add_actual_weight', 'uses' => 'Employee\ConsolidateController@addActualWeight']);
			Route::post('package_missing_found', ['as' => 'package_missing_found', 'uses' => 'Employee\ConsolidateController@packageMissingFound']);
			Route::post('check_package_inner_content', ['as' => 'check_package_inner_content', 'uses' => 'Employee\ConsolidateController@checkPackageInnerContent']);
			Route::post('confirm_model', ['as' => 'confirm_model', 'uses' => 'Employee\ConsolidateController@confirmModel']);
			Route::post('end_task', ['as' => 'end_task', 'uses' => 'Employee\ConsolidateController@endTask']);
		});
	});

Route::group(['prefix' => 'admin'], function () use($perms){
	Route::get('/', function () {
		return redirect('admin/login');
	})->name('admin_root');


	Route::get('info', [
			'as' => 'info',
			function () {
				//dd('kkk');
				return view('info');
			},
		])->middleware('auth');



	Auth::routes();


	Route::group(['middleware' => ['role:admin|owner', 'auth','verified']], function () use($perms){
		Route::get('/dashboard', function () {
					return view('welcome');
				})->middleware('auth')->name('admin_dashboard');
		/************************** Permissions *************************/
		Route::group(['prefix' => 'permission', 'as' => 'permission.', 'middleware'=>["permission:$perms"]], function () {
			Route::get('get', ['as' => 'gets', 'uses' => 'PermissionController@getPermission']);
			Route::get('/', ['as' => 'index', 'uses' => 'PermissionController@index']);
			Route::post('store', ['as' => 'store', 'uses' => 'PermissionController@store']);
			Route::post('delete', ['as' => 'delete', 'uses' => 'PermissionController@delete']);
			Route::get('edit', ['as' => 'edit', 'uses' => 'PermissionController@edit']);
			Route::post('update', ['as' => 'update', 'uses' => 'PermissionController@update']);
		});
		/************************** End Permissions *************************/

		/************************** Roles *************************/
		Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
			Route::get('create', ['as' => 'create', 'uses' => 'RoleController@create']);
			Route::get('/', ['as' => 'index', 'uses' => 'RoleController@index']);
			Route::get('permission', ['as' => 'permission', 'uses' => 'RoleController@getpermission']);
			Route::get('getroles', ['as' => 'getroles', 'uses' => 'RoleController@getRoles']);
			Route::get('edit', ['as' => 'edit', 'uses' => 'RoleController@edit']);
			Route::post('update', ['as' => 'update', 'uses' => 'RoleController@update']);
			Route::post('store', ['as' => 'store', 'uses' => 'RoleController@store']);
			Route::post('delete', ['as' => 'delete', 'uses' => 'RoleController@delete']);
		});
		/************************** End Roles *************************/

		Route::get('/home', 'HomeController@index')->name('home');

		/************************** Employees *************************/
		Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {
			Route::get('/', ['as' => 'index', 'uses' => 'EmployeeController@index']);
			Route::get('grid_index', ['as' => 'grid', 'uses' => 'EmployeeController@gridIndex']);
			Route::get('create', ['as' => 'create', 'uses' => 'EmployeeController@create']);
			Route::post('store', ['as' => 'store', 'uses' => 'EmployeeController@store']);
			Route::get('getemployee', ['as' => 'getemployee', 'uses' => 'EmployeeController@getemployee']);
			Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EmployeeController@edit']);
			Route::post('update', ['as' => 'update', 'uses' => 'EmployeeController@update']);
			Route::post('delete', ['as' => 'delete', 'uses' => 'EmployeeController@delete']);
		});
		/************************** End Employees *************************/

		/************************** Country *************************/
		Route::group(['prefix' => 'country', 'as' => 'country.'], function () {
			Route::get('/', ['as' => 'index', 'uses' => 'CountryController@index']);
			Route::post('update_status', ['as' => 'update_status', 'uses' => 'CountryController@update_status']);
			Route::post('store', ['as' => 'store', 'uses' => 'CountryController@store']);
			Route::get('getcountries', ['as' => 'getcountries', 'uses' => 'CountryController@getcountries']);
			Route::get('edit', ['as' => 'edit', 'uses' => 'CountryController@edit']);
			Route::post('update', ['as' => 'update', 'uses' => 'CountryController@update']);
			Route::post('delete', ['as' => 'delete', 'uses' => 'CountryController@delete']);
		});
		/************************** End Country *************************/

		/************************** Warehouse *************************/
		Route::group(['prefix' => 'warehouse', 'as' => 'warehouse.'], function () {

			Route::group(['prefix' => 'shelves', 'as' => 'shelves.'], function () {
				Route::get('/', ['as' => 'index', 'uses' => 'WarehouseController@ShelvesIndex']);
				Route::get('getshelves/{id}', ['as' => 'getshelves', 'uses' => 'WarehouseController@getShelves']);
				Route::post('insertshelf', ['as' => 'insertshelf', 'uses' => 'WarehouseController@insertShelf']);
				Route::post('editshelf', ['as' => 'editshelf', 'uses' => 'WarehouseController@editShelf']);
				Route::post('updateshelf', ['as' => 'updateshelf', 'uses' => 'WarehouseController@updateShelf']);
				Route::post('updatestatus', ['as' => 'updatestatus', 'uses' => 'WarehouseController@updateStatusShelf']);
				Route::post('deleteshelf', ['as' => 'deleteshelf', 'uses' => 'WarehouseController@deleteShelf']);
			});
			Route::get('/', ['as' => 'index', 'uses' => 'WarehouseController@index']);
			Route::post('update_status', ['as' => 'update_status', 'uses' => 'WarehouseController@update_status']);
			Route::post('store', ['as' => 'store', 'uses' => 'WarehouseController@store']);
			Route::get('getwarehouses', ['as' => 'getwarehouses', 'uses' => 'WarehouseController@getwarehouses']);
			Route::get('edit', ['as' => 'edit', 'uses' => 'WarehouseController@edit']);
			Route::post('update', ['as' => 'update', 'uses' => 'WarehouseController@update']);

			Route::post('delete', ['as' => 'delete', 'uses' => 'WarehouseController@delete']);
		});
		/************************** End Warehouse *************************/

		/************************** Shopaholics *************************/
		Route::group(['prefix' => 'shopaholics', 'as' => 'shopaholic.'], function () {
			Route::get('/', ['as' => 'index', 'uses' => 'ShopaholicController@index']);
			Route::get('getshopaholics', ['as' => 'getshopaholics', 'uses' => 'ShopaholicController@getshopaholics']);

			Route::get('details/{id}', ['as' => 'shopaholic-details', 'uses' => 'ShopaholicController@getShopaholicDetails']);
			Route::get('failed-transaction',['as' => 'failed_transaction', 'uses' => 'ShopaholicController@failedTransaction']);
			Route::get('get-failed-transaction',['as' => 'get_failed_transaction', 'uses' => 'ShopaholicController@getFailedTransaction']);

			Route::get('user-profile/{id}', ['as' => 'shopaholic-profile', 'uses' => 'ShopaholicController@shopaholicProfile']);
			Route::get('edituserprofile', ['as' => 'edituserprofile', 'uses' => 'ShopaholicController@editShopaholicPrimaryInfo']);
			Route::post('updateuserprofile', ['as' => 'updateuserprofile', 'uses' => 'ShopaholicController@updateShopaholicPrimaryInfo']);
			Route::get('editshopaholicaddres', ['as' => 'editshopaholicaddres', 'uses' => 'ShopaholicController@editShopaholicAddres']);

			Route::get('ajaxaddress', ['as' => 'ajaxaddress', 'uses' => 'ShopaholicController@shopaholicAjaxAddress']);
			Route::get('ajax_search_address', ['as' => 'ajax_search_address', 'uses' => 'ShopaholicController@shopaholicSearchAjaxAddress']);

			Route::post('update_shopaholic_profile_address', ['as' => 'update_shopaholic_profile_address', 'uses' => 'ShopaholicController@updateShopaholicProfileAddress']);
			Route::get('user-profile/wallet/{user_id}', ['as' => 'shopaholic-profile-wallet', 'uses' => 'ShopaholicController@ajaxGetShopaholicTransactions']);
			Route::post('get-shopaholic-wallet', ['as' => 'get-shopaholic-wallet', 'uses' => 'WalletController@getShopaholicWalletDetail']);
			Route::post('update-shopaholic-wallet', ['as' => 'update-shopaholic-wallet', 'uses' => 'WalletController@updateShopaholicWallet']);

		});
		/************************** Fakhar Code*************************/

Route::group(['prefix' => 'docs', 'as' => 'docs.'], function () {
	Route::group(['prefix' => 'developers', 'as' => 'developers.'], function () {
			Route::get('list', ['as' => 'list', 'uses' => 'DocsController@index']);
			Route::get('create', ['as' => 'create', 'uses' => 'DocsController@create']);
			Route::post('store-doc', ['as' => 'store-doc', 'uses' => 'DocsController@store']);
			Route::post('update', ['as' => 'update', 'uses' => 'DocsController@update']);
			Route::get('edit{id}', ['as' => 'edit', 'uses' => 'DocsController@edit']);
			Route::get('getdocs', ['as' => 'getdocs', 'uses' => 'DocsController@getdocs']);
	});
});
	/************************** End Fakhar Code *************************/

		/************************** End Shopaholics *************************/

		Route::group(['prefix' => 'settings', 'as' => 'setting.'], function () {
			Route::group(['prefix' => 'charges', 'as' => 'charges.'], function () {
				Route::get('/', ['as' => 'index', 'uses' => 'ChargeController@index']);
				Route::get('getcharges', ['as' => 'getcharges', 'uses' => 'ChargeController@getCharges']);
				Route::post('store', ['as' => 'store', 'uses' => 'ChargeController@store']);
				Route::get('edit', ['as' => 'edit', 'uses' => 'ChargeController@edit']);
				Route::post('update', ['as' => 'update', 'uses' => 'ChargeController@update']);
				Route::post('delete', ['as' => 'delete', 'uses' => 'ChargeController@delete']);
			});


			Route::group(['prefix' => 'global', 'as' => 'global.'], function () {
				Route::get('/', ['as' => 'index', 'uses' => 'GlobalSettingsController@index']);
				Route::get('getsettings', ['as' => 'getsettings', 'uses' => 'GlobalSettingsController@getSettings']);
				Route::post('store', ['as' => 'store', 'uses' => 'GlobalSettingsController@store']);
				Route::get('edit', ['as' => 'edit', 'uses' => 'GlobalSettingsController@edit']);
				Route::post('update', ['as' => 'update', 'uses' => 'GlobalSettingsController@update']);
				Route::post('delete', ['as' => 'delete', 'uses' => 'GlobalSettingsController@delete']);
			});

			Route::get('/', ['as' => 'social-logins', 'uses' => 'SettingController@socialLogins']);

			Route::get('getsettings', ['as' => 'getsettings', 'uses' => 'SettingController@getsettings']);

			Route::post('update', ['as' => 'social-logins.update', 'uses' => 'SettingController@updateSocialLogins']);

			Route::get('payment-gateways', ['as' => 'payment-gateways', 'uses' => 'SettingController@paymentGateways']);
			Route::post('payment-gateways', ['as' => 'payment-gateways.update', 'uses' => 'SettingController@updatePaymentGateways']);

			Route::get('recaptcha', ['as' => 'recaptcha', 'uses' => 'SettingController@recaptcha']);
			Route::post('recaptcha', ['as' => 'recaptcha.update', 'uses' => 'SettingController@updateRecaptcha']);
		});

		

		Route::group(['prefix' => 'requests', 'as' => 'wallet_request.'], function () {
			Route::get('deposit', ['as' => 'deposit_request', 'uses' => 'WalletController@depositRequest']);
			Route::get('withdraw', ['as' => 'withdraw_request', 'uses' => 'WalletController@withDrawRequest']);
			Route::get('getdepositRequest', ['as' => 'getdepositRequest', 'uses' => 'WalletController@getdepositRequest']);
			Route::get('getwithdrawrequest', ['as' => 'getwithdrawrequest', 'uses' => 'WalletController@getwithdrawRequest']);
			Route::post('process', ['as' => 'process', 'uses' => 'WalletController@processRequest']);
		});

		Route::group(['prefix' => 'courier', 'as' => 'courier.'], function () {
			Route::group(['prefix' => 'zone', 'as' => 'zone.'], function () {
				Route::get('/', ['as' => 'index', 'uses' => 'CourierController@index']);
				Route::get('getcourier', ['as' => 'getcouriers', 'uses' => 'CourierController@getCourierZone']);
				Route::post('deletecountry', ['as' => 'deletecountry', 'uses' => 'CourierController@deleteCountry']);
				Route::get('edit', ['as' => 'edit', 'uses' => 'CourierController@edit']);
				Route::post('update', ['as' => 'update', 'uses' => 'CourierController@update']);
				Route::post('insert', ['as' => 'insert', 'uses' => 'CourierController@insertCourierZone']);
				Route::post('deletezone', ['as' => 'deletezone', 'uses' => 'CourierController@deleteZone']);

			});
			Route::group(['prefix' => 'domestic', 'as' => 'domestic.'], function () {
				Route::get('/', ['as' => 'index', 'uses' => 'DomesticCourierController@index']);
				Route::get('getdomesticcourier', ['as' => 'getdomesticcourier', 'uses' => 'DomesticCourierController@getDomesticCourier']);
				Route::post('store', ['as' => 'store', 'uses' => 'DomesticCourierController@store']);
				Route::get('edit', ['as' => 'edit', 'uses' => 'DomesticCourierController@edit']);
				Route::post('update', ['as' => 'update', 'uses' => 'DomesticCourierController@update']);
				Route::post('delete', ['as' => 'delete', 'uses' => 'DomesticCourierController@delete']);
			});
			Route::get('/', ['as' => 'index', 'uses' => 'CourierController@courier']);
			Route::get('getcourier', ['as' => 'getcourier', 'uses' => 'CourierController@getCourier']);
			Route::post('insert', ['as' => 'insert', 'uses' => 'CourierController@insertCourier']);
			Route::get('edit', ['as' => 'edit', 'uses' => 'CourierController@editCourier']);
			Route::post('update', ['as' => 'update', 'uses' => 'CourierController@updateCourier']);
			Route::post('delete', ['as' => 'delete', 'uses' => 'CourierController@deleteCourier']);
			Route::post('importrate', ['as' => 'importrate', 'uses' => 'CourierController@importRates']);
		});


		  Route::group(['prefix' => 'shipping', 'as' => 'admin.shipping.'], function () {
			Route::get('calculator', ['as' => 'calculator', 'uses' => 'ShippingController@shippingCalculator']);
			Route::post('getshippingrate', ['as' => 'getshippingrate', 'uses' => 'ShippingController@ajaxShippingCalculator']);

			Route::get('cronJob', ['as' => 'cron.calculate', 'uses' => 'Cron\ShippingCostController@calculate']);
		});

		  Route::group(['prefix' => 'post', 'as' => 'blog_post.'], function () {
			Route::get('/', ['as' => 'index', 'uses' => 'BlogPostController@index']);
			Route::get('getblogpost', ['as' => 'getblogpost', 'uses' => 'BlogPostController@getBlogPost']);
			Route::get('create',['as' => 'create', 'uses' => 'BlogPostController@create']);
			Route::post('imgstore',['as' => 'imgstore', 'uses' => 'BlogPostController@imageStore']);
			Route::post('store',['as' => 'store', 'uses' => 'BlogPostController@store']);
			Route::post('assignpost/{type}',['as' => 'assignpost', 'uses' => 'BlogPostController@assignPost']);
			Route::post('assigneditpost',['as' => 'assigneditpost', 'uses' => 'BlogPostController@assignEditPost']);
			Route::get('searchuser',['as' => 'searchuser', 'uses' => 'BlogPostController@searchUser']);
			Route::post('changestatus',['as' => 'changestatus', 'uses' => 'BlogPostController@changeStatus']);
			Route::get('edit/{id}',['as' => 'edit', 'uses' => 'BlogPostController@edit']);
			Route::post('update',['as' => 'update', 'uses' => 'BlogPostController@update']);
			Route::post('delete',['as' => 'delete', 'uses' => 'BlogPostController@delete']);
			Route::get('view/{id}',['as' => 'view', 'uses' => 'BlogPostController@viewPost']);
		});

		Route::group(['prefix' => 'group', 'as' => 'group.'], function () {
			Route::group(['prefix' => 'shopaholic', 'as' => 'shopaholic.'], function () {
				Route::get('/', ['as' => 'index', 'uses' => 'GroupController@shopaholicIndex']);
				Route::get('getgroup', ['as' => 'getgroup', 'uses' => 'GroupController@shopaholicGetGroup']);
				Route::get('create', ['as' => 'create', 'uses' => 'GroupController@shopaholicCreate']);
				Route::post('store', ['as' => 'store', 'uses' => 'GroupController@shopaholicStore']);
			});
		});

		Route::group(['prefix' => 'shopaholic', 'as' => 'creditcard.'], function () {
			Route::get('credit-card', ['as' => 'index', 'uses' => 'CreditCardController@index']);
			Route::get('getcreditcardinfo', ['as' => 'getcreditcardinfo', 'uses' => 'CreditCardController@getCreditCardinfo']);
			Route::post('verify',['as' => 'verify','uses' => 'CreditCardController@verifyCreditCard']);
			Route::post('block',['as' => 'block','uses' => 'CreditCardController@blockCreditCard']);
		});
		Route::group(['prefix' => 'package', 'as' => 'package.'], function () {
			Route::get('/',['as' => 'index', 'uses' => 'PackageController@index']);
			Route::get('getpackagelist',['as' => 'getpackagelist', 'uses' => 'PackageController@getPackageList']);
			Route::get('create',['as' => 'create', 'uses' => 'PackageController@create']);
			Route::post('store',['as' => 'store', 'uses' => 'PackageController@store']);

			Route::group(['prefix' => 'unassigned', 'as' => 'unassigned.'], function () {
				Route::get('/',['as' => 'index','uses' => 'PackageAssignController@index']);

				Route::get('/get_shopaholic',['as' => 'get_shopaholic_for_ocr','uses' => 'PackageAssignController@getShopaholicsForOcr']);

				Route::post('import_tracking_numbers',['as' => 'import_tracking_numbers','uses' => 'PackageAssignController@importTrackingNumbers']);


				Route::post('trac_num_auto_complete',['as' => 'trac_num_auto_complete','uses' => 'PackageAssignController@trackingNumberAutoComplete']);

				Route::post('assign_package',['as' => 'assign_package','uses' => 'PackageAssignController@assign']);

			});



			Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
				Route::get('/',['as' => 'index','uses' => 'PackageServiceController@index']);
				Route::get('getpackageservices/{type}',['as' => 'getpackageservices','uses' => 'PackageServiceController@getPackageServices']);
				Route::post('store',['as' => 'store','uses' => 'PackageServiceController@store']);
				Route::post('edit',['as' => 'edit','uses' => 'PackageServiceController@edit']);
				Route::post('update',['as' => 'update','uses' => 'PackageServiceController@update']);
				Route::post('changestatus',['as' => 'changestatus','uses' => 'PackageServiceController@changeStatus']);
				Route::post('delete',['as' => 'delete','uses' => 'PackageServiceController@delete']);
			});
			Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
				Route::get('/',['as' => 'index','uses' => 'PackageCategoryController@index']);
				Route::get('getpackagecategories',['as' => 'getpackagecategories','uses' => 'PackageCategoryController@getPackageCategories']);
				Route::post('store',['as' => 'store','uses' => 'PackageCategoryController@store']);
				Route::get('edit',['as' => 'edit','uses' => 'PackageCategoryController@edit']);
				Route::post('update',['as' => 'update','uses' => 'PackageCategoryController@update']);
				Route::post('delete',['as' => 'delete','uses' => 'PackageCategoryController@delete']);
			});

		});
		Route::group(['prefix' => 'consolidation', 'as' => 'consolidation.'], function () {
			Route::group(['prefix' => 'request-info', 'as' => 'request_info.'], function () {
				Route::get('/',['as' => 'index', 'uses' => 'ConsolidationRequestInfoController@index']);
				Route::get('getRequestInfos',['as' => 'getRequestInfos', 'uses' => 'ConsolidationRequestInfoController@getRequestInfos']);
				Route::post('store',['as' => 'store', 'uses' => 'ConsolidationRequestInfoController@store']);
				Route::post('delete',['as' => 'delete', 'uses' => 'ConsolidationRequestInfoController@delete']);
			});
			Route::group(['prefix' => 'goods-description', 'as' => 'goods_description.'], function () {
				Route::get('/',['as' => 'index', 'uses' => 'ConsolidationGoodsController@index']);
				Route::get('getgoodsdescription',['as' => 'getgoodsdescription', 'uses' => 'ConsolidationGoodsController@getGoodsDescription']);
				Route::post('store',['as' => 'store', 'uses' => 'ConsolidationGoodsController@store']);
				Route::get('edit',['as' => 'edit', 'uses' => 'ConsolidationGoodsController@edit']);
				Route::post('update',['as' => 'update', 'uses' => 'ConsolidationGoodsController@update']);
				Route::post('delete',['as' => 'delete', 'uses' => 'ConsolidationGoodsController@delete']);
			});
			Route::group(['prefix' => 'shipment', 'as' => 'shipment.'], function () {
				Route::get('/',['as' => 'index', 'uses' => 'ConsolidationController@index']);
				Route::get('getConsolidatePackage/{type}',['as' => 'getConsolidatePackage', 'uses' => 'ConsolidationController@getConsolidatePackage']);
				Route::get('review-request/{id}',['as' => 'review_request', 'uses' => 'ConsolidationController@reviewRequest']);
				Route::get('get_review_request_package',['as' => 'get_review_request_package', 'uses' => 'ConsolidationController@getReviewRequestPackage']);
				Route::post('add_actual_weight',['as' => 'add_actual_weight', 'uses' => 'ConsolidationController@addActualWeight']);
				Route::get('edit_actual_weight',['as' => 'edit_actual_weight', 'uses' => 'ConsolidationController@editActualWeight']);
				Route::post('update_actual_weight',['as' => 'update_actual_weight', 'uses' => 'ConsolidationController@updateActualWeight']);
				Route::get('getpendingpayment',['as' => 'getpendingpayment', 'uses' => 'ConsolidationController@getPendingPayment']);
				Route::get('get_processing',['as' => 'get_processing', 'uses' => 'ConsolidationController@getProcessing']);
				Route::post('assign_employee',['as' => 'assign_employee', 'uses' => 'ConsolidationController@assignEmployee']);
				Route::post('pickup_pool',['as' => 'pickup_pool', 'uses' => 'ConsolidationController@pickUpPool']);
				Route::get('get_pickup_pool',['as' => 'get_pickup_pool', 'uses' => 'ConsolidationController@gePickUpPool']);
				Route::post('out_pickup_pool',['as' => 'out_pickup_pool', 'uses' => 'ConsolidationController@outPickUpPool']);
				Route::get('get_on_hold',['as' => 'get_on_hold', 'uses' => 'ConsolidationController@getOnHold']);
				Route::get('label_printing/{id}',['as' => 'label_printing', 'uses' => 'ConsolidationController@label_printing']);
				Route::post('on_hold_request',['as' => 'on_hold_request', 'uses' => 'ConsolidationController@onHoldRequest']);
				Route::post('re_open_request',['as' => 're_open_request', 'uses' => 'ConsolidationController@reOpenRequest']);

				Route::post('delete',['as' => 'delete', 'uses' => 'ConsolidationController@delete']);


			});
		});


		Route::group(['prefix' => 'payment-method', 'as' => 'payment.'], function () {
			Route::get('/', ['as' => 'index', 'uses' => 'PaymentMethodController@index']);
			Route::get('get_payment_methods', ['as' => 'get_payment_methods', 'uses' => 'PaymentMethodController@getPaymentMethods']);
			Route::post('store', ['as' => 'store', 'uses' => 'PaymentMethodController@store']);
			Route::post('update_status', ['as' => 'update_status', 'uses' => 'PaymentMethodController@updateStatus']);
			Route::get('edit', ['as' => 'edit', 'uses' => 'PaymentMethodController@edit']);
			Route::post('update', ['as' => 'update', 'uses' => 'PaymentMethodController@update']);
			Route::post('delete', ['as' => 'delete', 'uses' => 'PaymentMethodController@delete']);
		});




	});

});

Route::get('storage/{filename}', function ($filename) {
	//return Storage::get(config('constants.img_folder') . '/' . $filename);

	 $path = Storage::get(config('constants.img_folder') . '/' .$filename);
            return \Image::make($path)->response();
})->name('img_file');

Route::group(['middleware' => ['role:shopaholic','auth','verified'],'prefix' => 'shopaholic'], function () {


	Route::get('/', ['as' => 'client_dashboard', 'uses' => 'FrontEnd\DashboardController@index']);

	Route::group(['prefix' => 'wallet', 'as' => 'wallet.'], function () {
			Route::get('/', ['as' => 'index', 'uses' => 'FrontEnd\WalletController@index']);
			Route::get('gettransaction', ['as' => 'gettransaction', 'uses' => 'FrontEnd\WalletController@getTransactionRecord']);
			Route::post('deposit_money', ['as' => 'deposit', 'uses' => 'FrontEnd\WalletController@depositMoney']);
			Route::post('withdraw_money', ['as' => 'withdraw', 'uses' => 'FrontEnd\WalletController@withdrawMoney']);
		});



	Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
			Route::get('/', ['as' => 'index', 'uses' => 'FrontEnd\ProfileController@index']);
			Route::post('address_store', ['as' => 'store', 'uses' => 'FrontEnd\ProfileController@addressStore']);
			Route::post('primary_info_update', ['as' => 'primary.info.update', 'uses' => 'FrontEnd\ProfileController@primaryInfoUpdate']);

			Route::get('address_edit', ['as' => 'address_edit', 'uses' => 'FrontEnd\ProfileController@ajaxAddressEdit']);
			Route::post('address_update', ['as' => 'address_update', 'uses' => 'FrontEnd\ProfileController@addressUpdate']);

			Route::post('address_delete', ['as' => 'address_delete', 'uses' => 'FrontEnd\ProfileController@ajaxAddressDelete']);

			Route::get('ajaxaddress', ['as' => 'ajaxaddress', 'uses' => 'ShopaholicController@shopaholicAjaxAddress']);

		});


	Route::group(['prefix' => 'creditCard', 'as' => 'credit_card.'], function () {
			 Route::post('verify', ['as' => 'verify', 'uses' => 'FrontEnd\CreditCardController@AddCreditCard']);
			 Route::post('credit_card_all', ['as' => 'credit_card_all', 'uses' => 'FrontEnd\CreditCardController@creditCardJson']);
			 Route::post('verify/card', ['as' => 'verify_card', 'uses' => 'FrontEnd\CreditCardController@verifyCard']);
			 Route::post('credit-card-exist', ['as' => 'credit-card-exist', 'uses' => 'FrontEnd\CreditCardController@creditCardExist']);
			 Route::post('deposit-credit-card', ['as' => 'deposit-credit-card', 'uses' => 'FrontEnd\CreditCardController@depositCreditCard']);
			 Route::post('refund-credit-card', ['as' => 'refund-credit-card', 'uses' => 'FrontEnd\CreditCardController@refundTransaction']);
		});
	Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function () {
			Route::post('deposit', ['as' => 'deposit', 'uses' => 'FrontEnd\PaypalController@createShopaholicDepositPayment']);
			Route::get('confirm_deposit', ['as' => 'confirm_deposit', 'uses' => 'FrontEnd\PaypalController@confirmShopaholicDepositPayment']);
			Route::post('refund_deposit', ['as' => 'refund_deposit', 'uses' => 'FrontEnd\PaypalController@refundShopaholicDepositPayment']);

		});

	Route::group(['prefix' => 'shipping', 'as' => 'shipping.'], function () {
			Route::get('shipping-calculator', ['as' => 'calculator', 'uses' => 'FrontEnd\ShippingController@shippingCalculator']);
			Route::post('get-rates', ['as' => 'ajaxgetrates', 'uses' => 'FrontEnd\ShippingController@ajaxShippingCalculator']);
			Route::post('get-shipper-detail', ['as' => 'ajaxgetshipperdetail', 'uses' => 'FrontEnd\ShippingController@getCarrierDetail']);

		});

	Route::group(['prefix' => 'post', 'as' => 'frontend.post.'], function () {
		Route::get('getpost', ['as' => 'getpost', 'uses' => 'FrontEnd\BlogPostController@getdata']);
	});

	Route::group(['prefix' => 'storage', 'as' => 'storage.'], function () {
		Route::get('/packages/{type}', ['as' => 'index', 'uses' => 'FrontEnd\PackageController@index']);

	Route::get('/ajax-storage-packages', ['as' => 'ajax-storage-packages', 'uses' => 'FrontEnd\PackageController@ajaxPackagesJson']);

		Route::get('getmystoragepackage', ['as' => 'getmystoragepackage', 'uses' => 'FrontEnd\PackageController@getMyStoragePackage']);


		Route::get('getpackagedetails', ['as' => 'getpackagedetails', 'uses' => 'FrontEnd\PackageController@getPackageDetails']);

		Route::post('splitpackage', ['as' => 'splitpackage', 'uses' => 'FrontEnd\PackageController@splitPackage']);

		Route::post('returnpackagefile', ['as' => 'returnpackagefile', 'uses' => 'FrontEnd\PackageController@returnPackageFile']);

		Route::post('freeserviepackage', ['as' => 'freeserviepackage', 'uses' => 'FrontEnd\PackageController@postFreeServicePackage']);

		Route::post('paidservicespackage', ['as' => 'paidservicespackage', 'uses' => 'FrontEnd\PackageController@postPaidServicesPackage']);

		Route::post('packagedescription', ['as' => 'packagedescription', 'uses' => 'FrontEnd\PackageController@packageDescription']);

		Route::get('exist_package_custom_value', ['as' => 'exist_package_custom_value', 'uses' => 'FrontEnd\PackageController@existPackageCustomValue']);
		Route::post('packagecustomvalue', ['as' => 'packagecustomvalue', 'uses' => 'FrontEnd\PackageController@packageCustomValue']);


		Route::post('services/{type}', ['as' => 'services', 'uses' => 'FrontEnd\PackageController@packageServices']);
	});
	Route::group(['prefix' => 'consolidate', 'as' => 'frontend.consolidate.'], function () {
		Route::get('getConsolidateInfo', ['as' => 'get_consolidate_info', 'uses' => 'FrontEnd\ConsolidateController@getConsolidateInfo']);
		Route::post('save', ['as' => 'save', 'uses' => 'FrontEnd\ConsolidateController@save']);

		Route::get('get_consolidation_requests/{type?}', ['as' => 'get_consolidation_requests', 'uses' => 'FrontEnd\ConsolidateController@getRequests']);

		Route::get('get_review_request', ['as' => 'get_review_request', 'uses' => 'FrontEnd\ConsolidateController@getReviewRequest']);
		Route::get('get_all_custom_value', ['as' => 'get_all_custom_value', 'uses' => 'FrontEnd\ConsolidateController@getAllCustomValue']);
		Route::get('{id}/checkout', ['as' => 'get_checkout', 'uses' => 'FrontEnd\ConsolidateController@checkout']);
		Route::post('checkout',['as' => 'post_checkout', 'uses' => 'FrontEnd\ConsolidateController@checkoutSubmit']);
		Route::get('confirm_deposit',['as' => 'confirm_deposit', 'uses' => 'FrontEnd\ConsolidateController@confirmDeposit']);


	});

});

/******************* Use/Shpaholics Dashboard Frontend************/

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

	Route::get('/', ['as' => 'index', 'uses' => 'FrontEnd\ShopaholicsController@index']);



	Route::get('rates', ['as' => 'rates', 'uses' => 'ShippingController@shippingCalculator']);

});
/******************* End  Use/Shpaholics Dashboard Frontend************/

Route::get('/', 'FrontEnd\FrontController@index');
Route::get('shipping/rates', 'FrontEnd\FrontController@shippingRates');
//Route::get('assisted/purchase', 'FrontEnd\FrontController@assistedPurchase');
Route::get('business/solutions', 'FrontEnd\FrontController@businessSolutions');
Route::get('faqs', 'FrontEnd\FrontController@faqs');

//social media logins begins
// Route::get('login-with-facebook','FrontEnd\FrontController@loginWithFacebook');
// Route::get('login-with-google','FrontEnd\FrontController@loginWithGoogle');
// Route::get('login-with-twitter','FrontEnd\FrontController@loginWithTwitter');
//social media logins end Here

Auth::routes(['verify' => true]);
Route::get('forgot/password','FrontEnd\FrontController@forgotPassword');
Route::get('auth/facebook', 'AuthSocialLoginController@redirectToFacebook');
Route::get('auth/facebook/callback', 'AuthSocialLoginController@handleFacebookCallback');
Route::get('auth/twitter', 'AuthSocialLoginController@redirectToTwitter');
Route::get('auth/twitter/callback', 'AuthSocialLoginController@handleTwitterCallback');
Route::get('auth/googleplus', 'AuthSocialLoginController@redirectToGoolePlus');
Route::get('auth/googleplus/callback', 'AuthSocialLoginController@handleGoolePlusCallback');



Route::get('test-broadcast', function(){
    broadcast(new \App\Events\WareHouseStausEvent);
});


Route::get('routes_list', function() {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
        echo "<td width='10%'><h4>HTTP Method</h4></td>";
        echo "<td width='10%'><h4>Route</h4></td>";
        echo "<td width='80%'><h4>Name</h4></td>";
        echo "<td width='80%'><h4>Corresponding Action</h4></td>";

    echo "</tr>";
    foreach ($routeCollection as $value) {
    	//dd( $value);
        echo "<tr>";
            echo "<td>" . $value->methods()[0] . "</td>";
            echo "<td>" . $value->uri() . "</td>";
            echo "<td>" . $value->getName() . "</td>";
            echo "<td>" . $value->getActionName() . "</td>";

        echo "</tr>";
    }
    echo "</table>";
});

Route::get('all-shipment',function(){
	 \EasyPost\EasyPost::setApiKey('y4HNPR7IVaSFphhKI2Ye3Q');
	$shipments = \EasyPost\Shipment::all(array(
	  "page_size" => 2,
	  "start_datetime" => "2016-01-02T08:50:00Z"
	));
	dd($shipments);
});
