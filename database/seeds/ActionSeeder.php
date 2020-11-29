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
    	$money = ['3 000 000','250 000','3 400', '230 000'];

        $c = [3,4,6,8,9];
    	
    	//$faker = Faker\Factory::create();
    	for ($i=0; $i < 12 ; $i++) 
    	{ 
    		$realType = array_rand($type);
    		$realMoney = array_rand($money);
    		
    		Action::create([
    			'created_date' => $this->randomDate(),
	    		'category_id' => $c[rand(0,4)],
		        'sum' => $money[rand(0,3)],
		        'type' => 'cost',//$type[rand(0,1)],
		        'comment' => Str::random(20),
    		]);
	        
    	}
    
    }

    // Find a randomDate between $start_date and $end_date
    function randomDate()
    {
        // Convert to timetamps
        $min = strtotime('01-01-2020');
        $max = strtotime('29-11-2020');

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d H:i:s', $val);
    }
}
