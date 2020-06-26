<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Root Admin',
            'description' => 'Overall System Administrator',
            'role_id' => 1,
            'sort_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Administrator',
            'description' => 'Daily System Administrator',
            'role_id' => 2,
            'sort_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Doctor plus',
            'description' => 'Treats Patients',
            'role_id' => 3,
            'sort_id' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Staff plus',
            'description' => 'Facilitates Office Activities',
            'role_id' => 4,
            'sort_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Patient',
            'description' => 'Can be treated and book appintments',
            'role_id' => 5,
            'sort_id' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Company Owner',
            'description' => 'Overall System Administrator Of The Company',
            'role_id' => 6,
            'sort_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Practitioner',
            'description' => 'Treats Patients',
            'role_id' => 3,
            'role_type' => 2,
            'sort_id' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Staff',
            'description' => 'Facilitates Office Activities',
            'role_id' => 4,
            'role_type' => 2,
            'sort_id' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Manager',
            'description' => 'Overall System Administrator Of The Company',
            'role_id' => 6,
            'role_type' => 2,
            'sort_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Doctor',
            'description' => 'Treats Patients',
            'role_id' => 3,
            'role_type' => 3,
            'sort_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
