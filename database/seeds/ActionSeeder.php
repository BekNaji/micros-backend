<?php

use Illuminate\Database\Seeder;
use App\Action;
use Illuminate\Support\Str;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$type = ['gain','cost'];
    	$money = ['5 000','12 000 000','3 400', '230 000'];


    	
    	//$faker = Faker\Factory::create();
    	for ($i=0; $i < 50 ; $i++) 
    	{ 
    		$realType = array_rand($type);
    		$realMoney = array_rand($money);
    		$randDate = new DateTime();
			$randDate->setTime(mt_rand(0, 23), mt_rand(0, 59));
        	$randDate->format("Y-m-d h:i:s");
    		Action::create([
    			'created_date' => $randDate,
	    		'category_id' => rand(1,5),
		        'sum' => $money[rand(0,3)],
		        'type' => $type[rand(0,1)],
		        'comment' => Str::random(20),
    		]);
	        
    	}
        


    }
}
