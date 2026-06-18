<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            ['title' => 'Finalize Q3 Marketing Report', 'description' => 'Compile all marketing data and create final presentation for Q3 results.', 'priority' => 'urgent', 'status' => 'in_progress', 'category' => 'work', 'due_date' => now()->addDays(2)],
            ['title' => 'Weekly Team Standup', 'description' => 'Prepare agenda and updates for the weekly team standup meeting.', 'priority' => 'high', 'status' => 'todo', 'category' => 'work', 'due_date' => now()->addDay()],
            ['title' => 'Morning Workout Routine', 'description' => '30 minutes cardio + strength training.', 'priority' => 'medium', 'status' => 'done', 'category' => 'health', 'completed_at' => now()],
            ['title' => 'Read "Deep Work" Book', 'description' => 'Finish chapters 4-6 and take notes on key insights.', 'priority' => 'low', 'status' => 'in_progress', 'category' => 'learning', 'due_date' => now()->addWeek()],
            ['title' => 'Pay Credit Card Bill', 'description' => 'Monthly credit card payment due.', 'priority' => 'urgent', 'status' => 'todo', 'category' => 'finance', 'due_date' => now()->subDay()],
            ['title' => 'Grocery Shopping', 'description' => 'Buy vegetables, fruits, milk, and other essentials.', 'priority' => 'medium', 'status' => 'todo', 'category' => 'personal', 'due_date' => now()->addDays(2)],
            ['title' => 'Fix Login Bug', 'description' => 'Investigate and fix the authentication issue reported by QA team.', 'priority' => 'urgent', 'status' => 'done', 'category' => 'work', 'completed_at' => now()->subDay()],
            ['title' => 'Design New Dashboard UI', 'description' => 'Create wireframes and mockups for the new dashboard redesign.', 'priority' => 'high', 'status' => 'in_progress', 'category' => 'work', 'due_date' => now()->addDays(5)],
            ['title' => 'Online Python Course', 'description' => 'Complete modules 7-10 of the Python for Data Science course.', 'priority' => 'medium', 'status' => 'todo', 'category' => 'learning', 'due_date' => now()->addDays(14)],
            ['title' => 'Dentist Appointment', 'description' => 'Annual checkup and cleaning at Dr. Smith.', 'priority' => 'high', 'status' => 'todo', 'category' => 'health', 'due_date' => now()->addDays(7)],
            ['title' => 'Review Investment Portfolio', 'description' => 'Monthly review of stocks and mutual funds performance.', 'priority' => 'medium', 'status' => 'done', 'category' => 'finance', 'completed_at' => now()->subDays(2)],
            ['title' => 'Birthday Party Planning', 'description' => 'Plan surprise birthday party for Sarah - venue, cake, and guest list.', 'priority' => 'low', 'status' => 'todo', 'category' => 'personal', 'due_date' => now()->addDays(20)],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
