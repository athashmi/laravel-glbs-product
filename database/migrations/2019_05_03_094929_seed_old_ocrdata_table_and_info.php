<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedOldOcrdataTableAndInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $filesInFolder  = \File::files(database_path('old-db-tables'));
        
         //dd(pathinfo($path));
            $path = database_path('old-db-tables');
            

           
            $file_name = 'ocr_data.sql';

            $file = $path.'/ocr_data.sql';
                
            $size = \File::size($file);

                //dd($size);

            $ext = pathinfo($file_name)['extension'];
            $tbl_name =  pathinfo($file_name)['filename'];

            if (!Schema::hasTable($tbl_name) && $ext == 'sql') {
                    if($size < 10000000):
                        DB::unprepared(file_get_contents($file));
                    else:

                    exec("mysql -u ".env('DB_USERNAME')." -p".env('DB_PASSWORD')." ".env('DB_DATABASE')." < $file");
                    endif;
                }

            /*DB::statement('Update ocr_data set status="UNASSIGNED" where status="assigned" order by created_at desc limit 300');


            DB::statement("
                        INSERT INTO `package_custom_categories` (`id`, `title`, `key`, `created_at`, `updated_at`) VALUES
                        (1, 'T-Shirts', 't-shirts', '2019-03-28 03:42:21', '2019-03-29 03:27:47'),
                        (2, 'Baby Shoes', 'baby_shoes', '2019-03-29 03:27:56', '2019-03-29 03:27:56'),
                        (3, 'Shoes', 'shoes', '2019-03-29 03:28:04', '2019-03-29 03:28:04'),
                        (4, 'Watch', 'watch', '2019-03-29 03:28:13', '2019-03-29 03:28:13'),
                        (5, 'Perfum', 'perfum', '2019-03-29 03:28:18', '2019-03-29 03:28:18'),
                        (6, 'Laptop', 'laptop', '2019-03-29 03:28:28', '2019-03-29 03:28:28'),
                        (7, 'Mobile', 'mobile', '2019-03-29 03:28:34', '2019-03-29 03:28:34')");

            DB::statement("
                INSERT INTO `package_services` (`id`, `title`, `description`, `key`, `status`, `type`, `amount`, `created_at`, `updated_at`) VALUES
                (1, 'Package content photo during Consolidation', 'Package content photo during Consolidation', 'package_content_photo_during_consolidation', 'active', 'free', NULL, '2019-03-22 08:37:22', '2019-03-22 08:52:23'),
                (2, 'Package Consolidation', 'Package Consolidation', 'package_consolidation', 'active', 'free', NULL, '2019-03-22 08:37:35', '2019-03-22 08:37:35'),
                (3, 'Repacking', 'Repacking', 'repacking', 'active', 'free', NULL, '2019-03-22 08:37:43', '2019-03-22 08:37:43'),
                (4, 'Testing', 'Testing', 'testing', 'active', 'free', NULL, '2019-03-22 08:53:15', '2019-03-22 08:53:15'),
                (5, 'Split', 'Split', 'split', 'active', 'paid', '20.00', '2019-03-22 08:57:39', '2019-03-22 08:57:39'),
                (6, 'Detail Photos', 'Detail Photos', 'detail_photos', 'active', 'paid', '20.00', '2019-03-22 08:57:55', '2019-03-22 08:57:55'),
                (7, 'Return', 'Return', 'return', 'active', 'paid', '30.00', '2019-03-22 08:58:13', '2019-03-22 08:58:13'),
                (8, 'Test Device', 'Test Device', 'test_device', 'active', 'paid', '40.00', '2019-03-22 08:58:31', '2019-03-22 08:58:31')");

             DB::statement("INSERT INTO `consolidation_request_infos` (`id`, `title`, `key`, `description`, `created_at`, `updated_at`) VALUES
(5, 'Do you want to Insure this Package ?', 'Do_you_want_to_Insure_this_Package_?', 'Do you want to Insure this Package ?', '2019-04-07 23:00:15', '2019-04-07 23:00:15'),
(6, 'Does this Package contain Batteries ?', 'Does_this_Package_contain_Batteries_?', 'Does this Package contain Batteries ?', '2019-04-07 23:00:30', '2019-04-07 23:00:30'),
(7, 'Send as Gift ?', 'Send_as_Gift_?', 'Send as Gift ?', '2019-04-07 23:00:42', '2019-04-07 23:00:42'),
(8, 'Is dangerous goods ?', 'Is_dangerous_goods_?', 'Is dangerous goods ?', '2019-04-07 23:00:53', '2019-04-07 23:00:53')");*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
