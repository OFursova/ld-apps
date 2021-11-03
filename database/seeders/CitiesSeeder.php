<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cities')->delete();

        \DB::table('cities')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'New York',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Los Angeles',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Chicago',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Houston',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Phoenix',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Philadelphia',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'San Antonio',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'San Diego',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Dallas',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'San Jose',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'Austin',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'Jacksonville',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'Fort Worth',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'Columbus',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            14 =>
            array (
                'id' => 15,
                'name' => 'Indiannapolis',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            15 =>
            array (
                'id' => 16,
                'name' => 'Charlotte',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            16 =>
            array (
                'id' => 17,
                'name' => 'San Francisco',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            17 =>
            array (
                'id' => 18,
                'name' => 'Seattle',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            18 =>
            array (
                'id' => 19,
                'name' => 'Denver',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            19 =>
            array (
                'id' => 20,
                'name' => 'Washington',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            20 =>
            array (
                'id' => 21,
                'name' => 'Nashville',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            21 =>
            array (
                'id' => 22,
                'name' => 'Oklahoma City',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'El Paso',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            23 =>
            array (
                'id' => 24,
                'name' => 'Boston',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            24 =>
            array (
                'id' => 25,
                'name' => 'Portland',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            25 =>
            array (
                'id' => 26,
                'name' => 'Las Vegas',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            26 =>
            array (
                'id' => 27,
                'name' => 'Detroit',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            27 =>
            array (
                'id' => 28,
                'name' => 'Memphis',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            28 =>
            array (
                'id' => 29,
                'name' => 'Louisville',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            29 =>
            array (
                'id' => 30,
                'name' => 'Baltimore',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            30 =>
            array (
                'id' => 31,
                'name' => 'Miami',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
            31 =>
            array (
                'id' => 32,
                'name' => 'Oakland',
                'created_at' => '2021-09-16 10:30:51',
                'updated_at' => '2021-09-16 10:30:51',
            ),
        ));
    }
}
