<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades;
use App\User;
use App\student;

use Illuminate\Database\Eloquent\Model;

use League\Csv\Reader;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call('UserTableSeeder');
        $this->command->info('User table seeded');

        $this->call('StudentTableSeeder');
        $this->command->info('Student table seeded');


    }
}


class UserTableSeeder extends Seeder {

    public function run()
    {

        DB::table('users')->truncate();
        $skip = 0;
        $reader = Reader::createFromPath(base_path().'/database/seeds/students.csv');
        foreach($reader as $index => $row){
            if($skip) {
                User::create(['name' => $row[0], 'password' => Hash::make($row[2]), 'email' => $row[3]]);
            }
            else{
                $skip = 1;
            }
        }
    }
}

class StudentTableSeeder extends Seeder{
    public function run()
    {

        DB::table('students')->truncate();
        $skip = 0;
        $reader = Reader::createFromPath(base_path().'/database/seeds/students.csv');
        foreach($reader as $index => $row){
            if($skip) {
                student::create(['teamStyle' => $row[4], 'c' => $row[5], 'java' => $row[6], 'python'=> $row[7]]);
            }
            else{
                $skip = 1;
            }
        }
    }

}
