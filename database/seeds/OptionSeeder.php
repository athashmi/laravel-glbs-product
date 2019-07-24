<?php

use App\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $options = [
			[
				'title' => 'Client ID',
				'key' => 'client_id',
				'module' => 'facebook_api',
				'value' => '472784043251359',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[
				'title' => 'Client ecret',
				'key' => 'client_secret',
				'module' => 'facebook_api',
				'value' => 'a0efff62b3d92d79308b056e3708ef28',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[
				'title' => 'Client Callback URL',
				'key' => 'client_callback_url',
				'module' => 'facebook_api',
				'value' => 'auth/facebook/callback',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[
				'title' => 'Client ID',
				'key' => 'client_id',
				'module' => 'twitter_api',
				'value' => '4b2Kmh7err7SrneHVJkWjnNxh',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[
				'title' => 'Client Secret',
				'key' => 'client_secret',
				'module' => 'twitter_api',
				'value' => 'wbmhvMJSwEqqr9l6ejAHYXGQELaR8OZZQ7J8qyaAPjadFtCNQH',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[
				'title' => 'Client Callback URL',
				'key' => 'client_callback_url',
				'module' => 'twitter_api',
				'value' => 'auth/twitter/callback',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[
				'title' => 'Client ID',
				'key' => 'client_id',
				'module' => 'googleplus_api',
				'value' => '263324683356-dsjekqbujlfd10864ip2u88t041b0i9f.apps.googleusercontent.com',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[
				'title' => 'Client Secret',
				'key' => 'client_secret',
				'module' => 'googleplus_api',
				'value' => 'gUoU9bH8yAcZluQdRViIS7gb',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[
				'title' => 'Client Callback URL',
				'key' => 'client_callback_url',
				'module' => 'googleplus_api',
				'value' => 'auth/googleplus/callback',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[	'title' =>	'API KEY',
				'key' => 	'api_key',
				'module' => 'recaptcha',
				'value' => '6Le014gUAAAAAKKmsGCCOZllhI0cgVH3PPTc8apo',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[	'title' =>	'API Secret',
				'key' => 	'api_secret',
				'module' => 'recaptcha',
				'value' => '6Le014gUAAAAADrpsSUULe4hbijnizj-cHsYcdWS',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[	'title' =>	'API Login ID',
				'key' => 	'api_login_id',
				'module' => 'authorize_net',
				'value' => 	'69ZS2jjmq',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[	'title' =>	'Transaction Key',
				'key' => 	'transaction_key',
				'module' => 'authorize_net',
				'value' => '58Td4LzSxv854qG3',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[
				'title' => 'API Key',
				'key'   => 'api_key',
				'module' => 'easypost',
				'value'	=> 'a2or0tDgk2I9MpLy3ZTmmQ',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[	'title' =>	'Client ID',
				'key' => 	'client_id',
				'module' => 'paypal',
				'value' => 	'AaBdglL8piNy3IGfmWF5cCHfhkfAFFdD6l23AWqb-tBiIwAFKjYWWVbTMVezbWICTSkF0uNsWaZu_K8N',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
			[	'title' =>	'Client Secret',
				'key' => 	'client_secret',
				'module' => 'paypal',
				'value' => 'EILewizfZEERv8J5DvNmqDBNYB_zWlzAVlUb1jMy06JS8cS4qvtpihg7v7MqAiRUMAinKy6qrw0msL-K',
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s'),
			],
		];


		foreach ($options as $key => $value) {
			Option::create($value);
		}

		echo "Options : Done";
    }
}
