<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;
use App\Models\Subject;

class ClassesAndSubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample classes
        $classes = [
            ['name' => 'Grade 1', 'description' => 'First grade students'],
            ['name' => 'Grade 2', 'description' => 'Second grade students'],
            ['name' => 'Grade 3', 'description' => 'Third grade students'],
            ['name' => 'Grade 4', 'description' => 'Fourth grade students'],
            ['name' => 'Grade 5', 'description' => 'Fifth grade students'],
            ['name' => 'Grade 6', 'description' => 'Sixth grade students'],
            ['name' => 'Grade 7', 'description' => 'Seventh grade students'],
            ['name' => 'Grade 8', 'description' => 'Eighth grade students'],
            ['name' => 'Grade 9', 'description' => 'Ninth grade students'],
            ['name' => 'Grade 10', 'description' => 'Tenth grade students'],
        ];

        foreach ($classes as $class) {
            ClassModel::firstOrCreate(
                ['name' => $class['name']], 
                ['description' => $class['description']]
            );
        }

        // Create sample subjects
        $subjects = [
            'Mathematics',
            'English Language',
            'Science',
            'Physics',
            'Chemistry',
            'Biology',
            'History',
            'Geography',
            'Computer Science',
            'Physical Education',
            'Art',
            'Music',
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(['name' => $subject]);
        }

        $this->command->info('Classes and subjects seeded successfully!');
    }
}