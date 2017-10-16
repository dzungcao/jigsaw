<?php

use Illuminate\Database\Seeder;
use App\Models\ContactFormBuilder;
use App\Models\ButtonTemplate;
use App\Models\Application;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);

    	//Master data

    	if(DB::table('users')->count() == 0){
	        DB::table('users')->insert([
	            'name' => 'Anonymous',
	            'email' => 'giaophong@gmail.com',
	            'password' => bcrypt('minhquang06'),
	            'admin'=>1,
	            'manager'=>1,
	            'user'=>1
	        ]);
    	}

        if(DB::table('backgrounds')->count() == 0){
            DB::table('backgrounds')->insert([
                'path' => '1465212135_n2lrnhii.jpg',
                'icon' => '1464934877_i7wkqueu.jpg',
                'active' => 1,
                'guest' => 1
            ]);
            DB::table('backgrounds')->insert([
                'path' => '1465212135_jsu8b35f.jpg',
                'icon' => '1465212135_lcegdsvr.png',
                'active' => 1,
                'guest' => 1
            ]);
            DB::table('backgrounds')->insert([
                'path' => '1465212135_ega6b2r6.jpg',
                'icon' => '1465212135_3wh5b0vo.jpg',
                'active' => 1,
                'guest' => 1
            ]);
        }

    	if(DB::table('fields')->count() == 0){
	        DB::table('fields')->insert([
	            'title' => 'Single line',
	            'type' => 'single_line'
	        ]);
	        DB::table('fields')->insert([
	            'title' => 'Multiple line',
	            'type' => 'multiple_line'
	        ]);
            DB::table('fields')->insert([
                'title' => 'Date',
                'type' => 'date'
            ]);
            DB::table('fields')->insert([
                'title' => 'Dropdown select',
                'type' => 'select'
            ]);
    	}

        if(DB::table('contact_forms')->count() == 0){
            ContactFormBuilder::buildBasicForm();
            ContactFormBuilder::buildAdvancedForm();
        }
        if(DB::table('applications')->count() == 0){
            Application::buildDemoApp();
        }

    	if(DB::table('button_templates')->count() == 0){
            ButtonTemplate::create([
                'name'=>'Bottom-Left',
                'type'=>'bottom_left',
                'font_size'=>'15px',
                'image'=>'bottom-left.jpg'
                ]);
            ButtonTemplate::create([
                'name'=>'Bottom-Right',
                'type'=>'bottom_right',
                'font_size'=>'15px',
                'image'=>'bottom-right.jpg'
                ]);
            ButtonTemplate::create([
                'name'=>'Middle-Left',
                'type'=>'middle_left',
                'font_size'=>'15px',
                'image'=>'middle-left.jpg'
                ]);
            ButtonTemplate::create([
                'name'=>'Middle-Right',
                'type'=>'middle_right',
                'font_size'=>'15px',
                'image'=>'middle-right.jpg'
                ]);
        }
    }
    
}
