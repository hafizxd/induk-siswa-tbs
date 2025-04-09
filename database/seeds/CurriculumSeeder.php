<?php

use App\Curriculum;
use App\Period;
use Illuminate\Database\Seeder;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cur =  Curriculum::create([
            'name' => 'Kurikulum Default',
            'is_active' => 1
        ]);

        $cur->curriculumScoreCols()->create([
            'name' => 'Nilai Mapel', 
            'order_no' => 1
        ]);

        for ($i = 0; $i < 3; $i++) {
            $cur->periods()->createMany([[
                'year' => date('Y') - $i,
                'class' => 'VII'
            ], [
                'year' => date('Y') - $i,
                'class' => 'VIII'
            ], [
                'year' => date('Y') - $i,
                'class' => 'IX'
            ]]);
        }
    }
}
