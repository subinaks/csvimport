<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class ModuleTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('modules')->insert([
            [
                'module' => 'Academic',
                'module_id' => 1,
            ],
            [
                'module' => 'AcademicMisc',
                'module_id' => 11,
            ],
            [
                'module' => 'Hostel',
                'module_id' => 2,
            ],
            [
                'module' => 'HostelMic',
                'module_id' => 22,
            ],
            [
                'module' => 'Transport',
                'module_id' => 3,
            ],
            [
                'module' => 'TransportMISC',
                'module_id' => 33,
            ],
           
           
        ]);
    }
}
