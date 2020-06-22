<?php

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Course::class, 25)->create()->each(function ($course) {
            $course->students()->save(App\Student::select('id')->orderByRaw("RAND()")->first());
        });
    }
}
