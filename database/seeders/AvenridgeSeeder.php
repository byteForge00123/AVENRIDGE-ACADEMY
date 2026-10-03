<?php

namespace Database\Seeders;

use App\Models\ConcernReport;
use App\Models\Facility;
use App\Models\Faculty;
use App\Models\GalleryItem;
use App\Models\NewsItem;
use App\Models\Post;
use App\Models\Program;
use App\Models\SchoolEvent;
use App\Models\User;
use Illuminate\Database\Seeder;

class AvenridgeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => env('AVENRIDGE_ADMIN_EMAIL', 'admin@avenridge.test')],
            ['name' => 'Avenridge Administrator', 'password' => env('AVENRIDGE_ADMIN_PASSWORD', 'ChangeMe123!'), 'role' => 'admin'],
        );

        $staff = User::updateOrCreate(
            ['email' => 'mara.ellis@avenridge.test'],
            ['name' => 'Mara Ellis', 'password' => 'ChangeMe123!', 'role' => 'staff'],
        );

        User::updateOrCreate(
            ['email' => 'jordan.lee@avenridge.test'],
            ['name' => 'Jordan Lee', 'password' => 'ChangeMe123!', 'role' => 'student'],
        );

        $programs = [
            ['Foundations', 'Early Years', 'A confident start built around curiosity, belonging, and the joy of trying something new.', 'Our youngest learners build language, number sense, and independence through play, stories, and hands-on discovery.', ['Literacy', 'Early Mathematics', 'Creative Arts', 'Nature Study']],
            ['Lower School', 'Grades 1-5', 'Strong fundamentals, thoughtful routines, and room to follow a question a little further.', 'Students connect reading, mathematics, science, and the humanities through practical projects and close teacher guidance.', ['Language Arts', 'Mathematics', 'Science', 'Humanities']],
            ['Middle School', 'Grades 6-8', 'A supportive bridge to independence, with advisory at the center of each school day.', 'Small seminars, collaborative labs, and electives help students test new interests while strengthening study habits.', ['Integrated Sciences', 'World History', 'Design Lab', 'World Languages']],
            ['Upper School', 'Grades 9-12', 'A rigorous, flexible course of study that prepares students to think clearly and contribute generously.', 'Students shape a challenging academic program with faculty mentors, advanced seminars, and meaningful community work.', ['Literature', 'Research Methods', 'Advanced Sciences', 'Civic Leadership']],
        ];

        foreach ($programs as $index => [$name, $level, $summary, $description, $subjects]) {
            Program::updateOrCreate(['slug' => str($name)->slug()], [
                'name' => $name,
                'level' => $level,
                'summary' => $summary,
                'description' => $description,
                'subjects' => $subjects,
                'sort_order' => $index,
            ]);
        }

        $faculty = [
            ['Elena Brooks', 'Head of School', 'Leadership', 'Elena believes a good school makes space for high expectations and genuine care in the same breath.'],
            ['Mara Ellis', 'Director of Student Support', 'Student Support', 'Mara works with students and families to make sure every learner has someone in their corner.'],
            ['Jonah Patel', 'Science Department Chair', 'Science', 'Jonah brings field research and patient experimentation into the classroom.'],
            ['Simone Hart', 'Arts Educator', 'Arts', 'Simone helps students find confidence through visual art, theatre, and collaborative making.'],
        ];

        foreach ($faculty as $index => [$name, $position, $department, $biography]) {
            Faculty::updateOrCreate(['name' => $name], [
                'position' => $position,
                'department' => $department,
                'biography' => $biography,
                'sort_order' => $index,
            ]);
        }

        $stories = [
            ['Students turn courtyard into a pollinator garden', 'Campus Life', 'A student-led project has brought native plants, careful observation, and a new gathering place to the east courtyard.', 'In science and art classes, students planned a small pollinator garden for the east courtyard. The first planting day brought together families, faculty, and neighbors. The project will continue through the seasons as students track the plants and the visitors they attract.', true],
            ['A week of questions at the annual inquiry fair', 'Learning', 'From oral history to robotics, the inquiry fair gave each student a chance to share work in progress.', 'The annual inquiry fair returned this spring with projects shaped by months of reading, testing, interviewing, and revision. Students presented work-in-progress to classmates and visiting families, then spent the afternoon asking one another better questions.', false],
            ['Chamber ensemble performs at Northfield Library', 'Arts', 'Six student musicians shared a short afternoon program with the Northfield community.', 'A small ensemble of Avenridge students performed at the Northfield Library this month. The program was chosen by the students and included short works for strings and piano. The visit is part of a new partnership with local community spaces.', false],
        ];

        foreach ($stories as $index => [$title, $category, $excerpt, $body, $featured]) {
            NewsItem::updateOrCreate(['slug' => str($title)->slug()], [
                'title' => $title,
                'category' => $category,
                'excerpt' => $excerpt,
                'body' => $body,
                'is_featured' => $featured,
                'published_at' => now()->subDays($index * 4 + 2),
            ]);
        }

        foreach ([
            ['Family studio morning', 'Community', 'Arts Building', 'A relaxed morning of open studios and short workshops for current families.', 12],
            ['Spring music gathering', 'Arts', 'Assembly Hall', 'Student ensembles share music from across the year.', 24],
            ['Upper School project night', 'Learning', 'Learning Commons', 'Students present independent and collaborative work to the school community.', 39],
        ] as [$title, $category, $venue, $description, $days]) {
            SchoolEvent::updateOrCreate(['title' => $title], [
                'category' => $category,
                'venue' => $venue,
                'description' => $description,
                'starts_at' => now()->addDays($days)->setTime(17, 30),
                'ends_at' => now()->addDays($days)->setTime(19, 0),
            ]);
        }

        foreach ([
            ['The Lark Library', 'Learning', 'A light-filled library with quiet reading rooms, a welcoming story corner, and help finding the next good book.'],
            ['Field Science Lab', 'Learning', 'Flexible lab space for small-group experiments, environmental study, and careful making.'],
            ['Maple Commons', 'Student Life', 'A comfortable place to eat, meet a friend, or find a quieter corner between classes.'],
            ['North Field', 'Athletics', 'Open lawns and outdoor courts give students room to move, play, and gather across seasons.'],
        ] as $index => [$name, $category, $description]) {
            Facility::updateOrCreate(['slug' => str($name)->slug()], [
                'name' => $name,
                'category' => $category,
                'description' => $description,
                'sort_order' => $index,
            ]);
        }

        $gallery = [
            ['Morning in the courtyard', 'Campus Life', 'photo-1523050854058-8df90110c9f1'],
            ['Reading together in the library', 'Learning', 'photo-1524995997946-a1c2e315a42f'],
            ['Hands-on science, shared discoveries', 'Learning', 'photo-1532094349884-543bc11b234d'],
            ['A quiet place to meet', 'Student Life', 'photo-1497366754035-f200968a6e72'],
        ];

        foreach ($gallery as $index => [$caption, $category, $image]) {
            GalleryItem::updateOrCreate(['caption' => $caption], [
                'category' => $category,
                'image_url' => 'https://images.unsplash.com/'.$image.'?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => $index,
            ]);
        }

        foreach ([
            ['Campus Life', 'A good place to read outside?', 'The courtyard benches are sunny after lunch. Has anyone found another quiet spot for reading between classes?', 'approved'],
            ['Suggestions', 'More open studio afternoons', 'Could we have one afternoon each month when the art rooms are open for personal projects? A lot of us would love time to make things together.', 'approved'],
            ['Questions', 'Where does the lost and found live?', 'I found a green water bottle near the north field and left it at the main office.', 'approved'],
            ['School Feedback', 'A small idea for advisory', 'Could advisory groups have a shared calendar for project deadlines? It might make busy weeks easier to plan.', 'pending'],
        ] as [$category, $title, $body, $status]) {
            Post::firstOrCreate(['title' => $title], [
                'category' => $category,
                'body' => $body,
                'status' => $status,
                'is_anonymous' => true,
            ]);
        }

        ConcernReport::firstOrCreate(['reference_code' => 'RPT-2026-00421'], [
            'submitted_by' => $admin->id,
            'assigned_to' => $staff->id,
            'category' => 'Safety Concern',
            'what_happened' => 'Development sample only: a fictional student noticed a loose handrail beside the east steps.',
            'where_happened' => 'East entrance steps',
            'happened_at' => now()->subDays(1),
            'status' => 'under_review',
            'is_anonymous' => true,
        ]);
    }
}