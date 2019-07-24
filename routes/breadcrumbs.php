<?php

// Home
// Breadcrumbs::for('shopaholic', function ($trail) {
//     $trail->push('Shopaholic', route('shopaholic.index'));
// });
Breadcrumbs::for('home', function ($trail) {
    if(Auth::user()->hasRole(['owner','admin','admin']))
    $trail->push('home',route('admin_dashboard'));

    if(Auth::user()->hasRole(['shopaholic']))
       $trail->push('home',route('client_dashboard'));  
});
Breadcrumbs::for('shopaholic', function ($trail) {
	$trail->parent('home');
    $trail->push('shopaholic', route('shopaholic.index'));
});

Breadcrumbs::for('deposit_request', function ($trail) {
	$trail->parent('home');
    $trail->push('Deposit Request', route('wallet_request.deposit_request'));
});
Breadcrumbs::for('withdraw_request', function ($trail) {
	$trail->parent('home');
    $trail->push('WithDraw Request', route('wallet_request.withdraw_request'));
});

Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('home');
    $trail->push('Roles', route('role.index'));
});
Breadcrumbs::for('permission', function ($trail) {
    $trail->parent('home');
    $trail->push('permission', route('permission.index'));
});

Breadcrumbs::for('list', function ($trail) {
    $trail->parent('home');
    $trail->push('Employees', route('employee.index'));
});

Breadcrumbs::for('add_employee', function ($trail) {
    $trail->parent('list');
    $trail->push('Add Employee', route('employee.create'));
});

Breadcrumbs::for('edit_employee', function ($trail) { 
    $trail->parent('list');
    $trail->push('Edit Employee', route('employee.edit',0));
});

Breadcrumbs::for('grid', function ($trail) {
    $trail->parent('home');
    $trail->push('Employee Grids', route('employee.grid'));
});

Breadcrumbs::for('country', function ($trail) {
    $trail->parent('home');
    $trail->push('countries', route('country.index'));
});

Breadcrumbs::for('warehouse', function ($trail) {
    $trail->parent('home');
    $trail->push('warehouses', route('warehouse.index'));
});
Breadcrumbs::for('warehouse_shelves', function ($trail) {
    $trail->parent('warehouse');
    $trail->push('warehouses Shelves', route('warehouse.shelves.index'));
});

Breadcrumbs::for('courier', function ($trail) {
    $trail->parent('home');
    $trail->push('courier', route('courier.index'));
});
Breadcrumbs::for('courier_zone', function ($trail) {
    $trail->parent('courier');
    $trail->push('courier Zone', route('courier.zone.index'));
});
Breadcrumbs::for('calculator', function ($trail) {
    $trail->parent('home');
    $trail->push('Shipping Calculator', route('admin.shipping.calculator'));
});
Breadcrumbs::for('social_login', function ($trail) {
    $trail->parent('home');
    $trail->push('Social Login', route('setting.social-logins'));
});
Breadcrumbs::for('payment_gateways', function ($trail) {
    $trail->parent('home');
    $trail->push('Payment Gateways', route('setting.payment-gateways'));
});
Breadcrumbs::for('recaptcha', function ($trail) {
    $trail->parent('home');
    $trail->push('recaptcha', route('setting.recaptcha'));
});
Breadcrumbs::for('posts', function ($trail) {
    $trail->parent('home');
    $trail->push('Posts', route('blog_post.index'));
});
Breadcrumbs::for('add_post', function ($trail) {
    $trail->parent('posts');
    $trail->push('Add Post', route('blog_post.create'));
});
Breadcrumbs::for('edit_post', function ($trail) {
    $trail->parent('posts');
    $trail->push('Edit Post', route('blog_post.edit',0));
});

Breadcrumbs::for('group', function ($trail) {
    $trail->parent('shopaholic');
    $trail->push('Shopaholic & Country Group', route('group.shopaholic.index'));
});
Breadcrumbs::for('shopaholic_group', function ($trail) {
    $trail->parent('group');
    $trail->push('Add Shopaholic Group', route('group.shopaholic.create'));
});
Breadcrumbs::for('credit_card_info', function ($trail) {
    $trail->parent('shopaholic');
    $trail->push('Credit Card Info', route('creditcard.index'));
});
Breadcrumbs::for('failed_transaction', function ($trail) {
    $trail->parent('shopaholic');
    $trail->push('Failed Transaction', route('shopaholic.failed_transaction'));
});
Breadcrumbs::for('packages', function ($trail) {
    $trail->parent('home');
    //$trail->parent('package');
    $trail->push('Package', route('package.index'));
});
Breadcrumbs::for('package_services', function ($trail) {
     $trail->parent('packages');
    $trail->push('Package Services', route('package.services.index'));
});
Breadcrumbs::for('package_category', function ($trail) {
     $trail->parent('packages');
    $trail->push('Package Categories', route('package.categories.index'));
});
Breadcrumbs::for('request_info', function ($trail) {
     $trail->parent('home');
    $trail->push('Consolidation Request Info', route('consolidation.request_info.index'));
});
Breadcrumbs::for('goods_description', function ($trail) {
     $trail->parent('home');
    $trail->push('Consolidation Goods Description', route('consolidation.goods_description.index'));
});
Breadcrumbs::for('setting_charge', function ($trail) {
     $trail->parent('home');
    $trail->push('Charges', route('setting.charges.index'));
});

Breadcrumbs::for('setting_global', function ($trail) {
     $trail->parent('home');
    $trail->push('Charges', route('setting.global.index'));
});
Breadcrumbs::for('domestic_courier', function ($trail) {
     $trail->parent('home');
    $trail->push('Domestic Courier', route('courier.domestic.index'));
});
/********************* Shopaholic Bread Crumbs *****************************/
Breadcrumbs::for('client_dashboard', function ($trail) {
    $trail->push('Home', route('client_dashboard'));
});


Breadcrumbs::for('wallet', function ($trail) {
    $trail->parent('client_dashboard');
    $trail->push('Wallet', route('wallet.index'));
});

Breadcrumbs::for('shopaholic_calculator', function ($trail) {
    $trail->parent('client_dashboard');
    $trail->push('Shipping Calculator', route('shipping.calculator'));
});

Breadcrumbs::for('shopaholic_profile', function ($trail) {
    $trail->parent('client_dashboard');
    $trail->push('Profile', route('profile.index'));
});


/********************** End Shopaholic BreadCrumbs ***************************/

