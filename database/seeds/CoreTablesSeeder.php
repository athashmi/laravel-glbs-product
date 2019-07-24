<?php

use Illuminate\Database\Seeder;

class CoreTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//$this->consolidation_goods_descriptions();
        //$this->charges();
       //$this->couriers();
        //$this->package_custom_categories();
       // $this->package_services();
        $this->payment_methods();
        $this->tasks();

    	
    }


    function consolidation_goods_descriptions()
    {
    	DB::statement(
        "INSERT INTO `consolidation_goods_descriptions` (`id`, `title`, `description`, `amount`, `allowed_carriers`, `created_at`, `updated_at`, `type`, `key`) VALUES
			(1, '> 30ML PERFUMES', 'Perfumes', '10.00', '[2, 3, 4]', '2019-05-16 09:23:59', '2019-05-21 18:13:00', 'liquid', '>_30ML_PERFUMES'),
			(2, 'BATTERIES PI965', 'Lithium ion batteries in compliance with Section II of PI965', '21.00', '[1]', '2019-05-16 09:24:30', '2019-05-21 18:12:44', 'battery', 'BATTERIES_PI965'),
			(3, 'VAPE DEVICES', 'VAPE DEVICES', '70.00', '[2]', '2019-05-16 09:24:48', '2019-05-16 09:24:48', 'liquid', 'VAPE_DEVICES'),
			(4, 'BATTERIES PI966', 'Lithium ion batteries in compliance with Section II of PI966', '30.00', '[2]', '2019-05-16 09:25:12', '2019-05-16 09:25:12', 'battery', 'BATTERIES_PI966'),
			(5, 'VAPE LIQUIDS', 'VAPE LIQUIDS', '30.00', '[2]', '2019-05-16 09:25:25', '2019-05-16 09:25:25', 'liquid', 'VAPE_LIQUIDS'),
			(6, 'BATTERIES PI967', 'Lithium ion batteries in compliance with Section II of PI967', '40.00', '[2]', '2019-05-16 09:25:52', '2019-05-16 09:25:52', 'battery', 'BATTERIES_PI967'),
			(7, 'BATTERIES PI969', 'Lithium metal batteries in compliance with section II of PI969', '40.00', '[2]', '2019-05-16 09:26:13', '2019-05-16 09:26:13', 'battery', 'BATTERIES_PI969');");

    }

    function charges()
    {
    	DB::statement("INSERT INTO `charges` (`id`, `title`, `key`, `amount`, `applicable_module`, `created_at`, `updated_at`) VALUES
			(1, 'Shipping Charges', 'shipping_charges', '0.00', '{\"name\": [\"consolidation\"]}', '2019-05-21 12:46:15', '2019-05-21 12:46:15'),
			(2, 'Processing Charges', 'processing_charges', '5.00', '{\"name\": [\"consolidation\"]}', '2019-05-21 12:46:33', '2019-05-21 12:46:33'),
			(3, 'Express Processing Charges', 'express_processing_pharges', '15.00', '{\"name\": [\"consolidation\"]}', '2019-05-21 12:46:42', '2019-05-21 12:46:42')");
    }


    function couriers()
    {
    	DB::table('couriers')->truncate();

    	DB::statement("INSERT INTO `couriers` (`id`, `title`, `status`, `name`, `created_at`, `updated_at`, `type`, `image_name`, `details`) VALUES
			(1, 'DHL', 'active', 'dhl', '2019-02-08 06:58:22', '2019-02-12 05:18:58', 'international', 'dhlExpress.png', '{\"easy_post\": \"dhlexpress_expressworldwidenondoc\"}'),
			(2, 'Fedex Priority', 'active', 'fedex_priority', '2019-02-08 06:58:22', '2019-02-08 06:58:22', 'international', 'INTERNATIONAL_PRIORITY.png', '{\"easy_post\": \"fedex_international_priority\"}'),
			(3, 'Fedex Economy', 'active', 'fedex_economy', '2019-02-08 06:58:22', '2019-02-08 06:58:22', 'international', 'INTERNATIONAL_ECONOMY.png', '{\"easy_post\": \"fedex_international_economy\"}'),
			(4, 'UPS Expedited', 'active', 'ups_expedited', '2019-02-08 06:58:22', '2019-02-08 06:58:22', 'international', 'Expedited.png', '{\"easy_post\": \"ups_expedited\"}'),
			(5, 'UPS Saver', 'active', 'ups_saver', '2019-02-08 06:58:22', '2019-02-08 06:58:22', 'international', 'UPSSaver.png', '{\"easy_post\": \"ups_upssaver\"}'),
			(6, 'UPS Express', 'active', 'ups_express', '2019-02-08 06:58:22', '2019-02-08 06:58:22', 'international', 'Express.png', NULL),
			(7, 'Airbnex Direct', 'active', 'airbnx_direct', '2019-02-08 06:58:22', '2019-02-08 06:58:22', 'international', 'Express.png', NULL),
			(8, 'Airbnex In-Direct', 'active', 'airbnx_indirect', '2019-02-08 06:58:22', '2019-02-08 06:58:22', 'international', 'Express.png', NULL),
			(9, 'Aramax First Pound', 'active', 'aramax_first_pound', '2019-02-08 06:58:22', '2019-02-08 06:58:22', 'international', 'Express.png', NULL),
			(15, 'Mohsin Baig', 'active', 'Mohsin', '2019-03-20 09:11:52', '2019-03-20 09:12:14', 'domestic', 'Express.png', NULL),
			(16, 'Usman', 'active', 'Usman Warraich', '2019-03-20 09:27:15', '2019-03-20 09:27:15', 'domestic', 'Express.png', NULL),
			(17, 'USPS', 'active', 'usps_express', NULL, NULL, 'international', 'Express.png', '{\"easy_post\": \"usps_expressmailinternational\"}'),
			(18, 'USPS', 'active', 'usps_priority', NULL, NULL, 'international', 'PriorityMailInternational.png', '{\"easy_post\": \"usps_prioritymailinternational\"}'),
			(19, 'USPS', 'active', 'usps_parcelselect', NULL, NULL, 'international', 'FirstClassPackageInternationalService.png', NULL),
			(20, 'UPS Ground', 'active', 'ups_ground', '2019-02-08 06:58:22', '2019-02-08 06:58:22', 'international', 'ups.png', NULL);");
    }

    function package_custom_categories()
    {
    	DB::statement("INSERT INTO `package_custom_categories` (`id`, `title`, `key`, `created_at`, `updated_at`) VALUES
		(1, 'T-Shirts', 't-shirts', '2019-03-28 03:42:21', '2019-03-29 03:27:47'),
		(2, 'Baby Shoes', 'baby_shoes', '2019-03-29 03:27:56', '2019-03-29 03:27:56'),
		(3, 'Shoes', 'shoes', '2019-03-29 03:28:04', '2019-03-29 03:28:04'),
		(4, 'Watch', 'watch', '2019-03-29 03:28:13', '2019-03-29 03:28:13'),
		(5, 'Perfum', 'perfum', '2019-03-29 03:28:18', '2019-03-29 03:28:18'),
		(6, 'Laptop', 'laptop', '2019-03-29 03:28:28', '2019-03-29 03:28:28'),
		(7, 'Mobile', 'mobile', '2019-03-29 03:28:34', '2019-03-29 03:28:34');


		");
    }

    function package_services()
    {
    	DB::statement("INSERT INTO `package_services` (`id`, `title`, `description`, `key`, `status`, `type`, `amount`, `created_at`, `updated_at`) VALUES
			(1, 'Package content photo during Consolidation', 'Package content photo during Consolidation', 'package_content_photo_during_consolidation', 'active', 'free', NULL, '2019-03-22 08:37:22', '2019-03-22 08:52:23'),
			(2, 'Package Consolidation', 'Package Consolidation', 'package_consolidation', 'active', 'free', NULL, '2019-03-22 08:37:35', '2019-03-22 08:37:35'),
			(3, 'Repacking', 'Repacking', 'repacking', 'active', 'free', NULL, '2019-03-22 08:37:43', '2019-03-22 08:37:43'),
			(4, 'Testing', 'Testing', 'testing', 'active', 'free', NULL, '2019-03-22 08:53:15', '2019-03-22 08:53:15'),
			(5, 'Split', 'Split', 'split', 'active', 'paid', '20.00', '2019-03-22 08:57:39', '2019-03-22 08:57:39'),
			(6, 'Detail Photos', 'Detail Photos', 'detail_photos', 'active', 'paid', '20.00', '2019-03-22 08:57:55', '2019-03-22 08:57:55'),
			(7, 'Return', 'Return', 'return', 'active', 'paid', '30.00', '2019-03-22 08:58:13', '2019-03-22 08:58:13'),
			(8, 'Test Device', 'Test Device', 'test_device', 'active', 'paid', '40.00', '2019-03-22 08:58:31', '2019-03-22 08:58:31');");
    }


    function payment_methods()
    {
    	DB::statement("INSERT INTO `payment_methods` (`id`, `name`, `key`, `charges_type`, `charges`, `image_name`, `applicable_module`, `created_at`, `updated_at`, `status`) VALUES
				(1, 'PayPal', 'paypal', 'fixed', '10.00', 'PayPal-1559045433-20190528051033139.png', 'global', '2019-05-28 12:10:33', '2019-05-28 12:10:33', 'active'),
				(2, 'Transfer Vise', 'transfer_vise', 'percentile', '20.00', 'Transfer Vise-1559045485-20190528051125676.png', 'global', '2019-05-28 12:11:25', '2019-05-28 12:11:25', 'active');");
    }

    function tasks()
    {
    	DB::statement("INSERT INTO `tasks` (`id`, `title`, `max_time`, `created_at`, `updated_at`) VALUES
			(1, 'upload', NULL, NULL, NULL),
			(2, 'pick', NULL, NULL, NULL),
			(3, 'consolidation', NULL, NULL, NULL),
			(4, 'outgoing', NULL, NULL, NULL),
			(5, 'support', NULL, NULL, NULL),
			(6, 'cleanUp', NULL, NULL, NULL),
			(7, 'bathroom', NULL, NULL, NULL),
			(8, 'break', 15, NULL, NULL),
			(9, 'EndOfWork', NULL, NULL, NULL),
			(10, 'remarks', NULL, NULL, NULL),
			(11, 'idle', NULL, NULL, NULL);");
    }

    
}
