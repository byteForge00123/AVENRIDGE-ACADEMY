<?php

namespace Tests\Feature;

use App\Models\ConcernReport;
use App\Models\Post;
use App\Models\PostReply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentSafetyTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_feed_only_shows_approved_posts_without_author_details(): void
    {
        $student = User::factory()->create([
            'name' => 'Private Student Name',
            'email' => 'private.student@example.test',
        ]);

        Post::create([
            'user_id' => $student->id,
            'category' => 'Campus Life',
            'title' => 'Approved community note',
            'body' => 'A public message shared by a student.',
            'status' => 'approved',
        ]);

        Post::create([
            'category' => 'Questions',
            'title' => 'Pending private note',
            'body' => 'This message is still waiting for a staff review.',
            'status' => 'pending',
        ]);

        $response = $this->get(route('community.index'));

        $response->assertOk()
            ->assertSee('Approved community note')
            ->assertSee('Anonymous Student')
            ->assertDontSee('Pending private note')
            ->assertDontSee('Private Student Name')
            ->assertDontSee('private.student@example.test');
    }

    public function test_new_community_posts_wait_for_moderation_and_are_anonymous(): void
    {
        $this->post(route('community.store'), [
            'category' => 'Suggestions',
            'title' => 'A community suggestion',
            'body' => 'Could we have a regular student reading group?',
        ])->assertRedirect(route('community.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'A community suggestion',
            'status' => 'pending',
            'is_anonymous' => true,
            'user_id' => null,
        ]);
    }

    public function test_replies_wait_for_moderation_and_are_published_anonymously(): void
    {
        $post = Post::create([
            'category' => 'Questions',
            'title' => 'A question for the community',
            'body' => 'Does anyone have a favorite book recommendation?',
            'status' => 'approved',
        ]);

        $this->post(route('community.reply', $post), [
            'body' => 'Pending reply privacy marker',
        ])->assertRedirect();

        $reply = PostReply::firstOrFail();
        $this->assertSame('pending', $reply->status);
        $this->assertNull($reply->user_id);

        $this->get(route('community.index'))
            ->assertDontSee('Pending reply privacy marker');

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->patch(route('admin.replies.moderate', $reply), ['status' => 'approved'])
            ->assertRedirect();

        $this->get(route('community.index'))
            ->assertSee('Pending reply privacy marker')
            ->assertSee('Anonymous Student');
    }

    public function test_report_tracking_only_exposes_status_and_submission_date(): void
    {
        $this->post(route('concerns.store'), [
            'category' => 'Bullying',
            'what_happened' => 'Private incident marker describing a difficult situation.',
            'where_happened' => 'Private location marker',
            'people_involved' => 'Private identity marker',
            'additional_details' => 'Private follow-up marker',
        ])->assertOk()->assertSee('Your report has been submitted.');

        $report = ConcernReport::firstOrFail();

        $this->post(route('concerns.track'), ['reference_code' => $report->reference_code])
            ->assertOk()
            ->assertSee($report->reference_code)
            ->assertSee('Submitted')
            ->assertDontSee('Private incident marker')
            ->assertDontSee('Private location marker')
            ->assertDontSee('Private identity marker')
            ->assertDontSee('Private follow-up marker');
    }

    public function test_unassigned_staff_member_cannot_update_a_concern_report(): void
    {
        $assignedStaff = User::factory()->create(['role' => 'staff']);
        $otherStaff = User::factory()->create(['role' => 'staff']);
        $report = ConcernReport::create([
            'reference_code' => 'RPT-2026-98765',
            'assigned_to' => $assignedStaff->id,
            'category' => 'Safety Concern',
            'what_happened' => 'A fictional report used to verify staff assignment access.',
            'status' => 'submitted',
        ]);

        $this->actingAs($otherStaff)
            ->patch(route('admin.reports.update', $report), ['status' => 'under_review'])
            ->assertForbidden();

        $this->assertDatabaseHas('concern_reports', [
            'id' => $report->id,
            'status' => 'submitted',
        ]);
    }

    public function test_only_admins_can_manage_school_content(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $this->actingAs($student)
            ->get(route('admin.content.index', 'programs'))
            ->assertForbidden();
    }

    public function test_admin_content_form_saves_program_subjects_as_structured_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('admin.content.store', 'programs'), [
            'name' => 'Upper School',
            'level' => 'Grades 9-12',
            'summary' => 'A rigorous and flexible course of study.',
            'description' => 'Students build depth through advanced seminars and meaningful community work.',
            'subjects' => 'Literature, Research Methods, Civic Leadership',
            'sort_order' => 4,
        ])->assertRedirect(route('admin.content.index', 'programs'));

        $this->assertDatabaseHas('programs', [
            'name' => 'Upper School',
            'slug' => 'upper-school',
            'subjects' => '["Literature","Research Methods","Civic Leadership"]',
        ]);
    }

    public function test_self_registration_always_assigns_student_role(): void
    {
        $this->post(route('register.store'), [
            'name' => 'New Student',
            'email' => 'new.student@example.test',
            'password' => 'Avenridge-Secure-123',
            'password_confirmation' => 'Avenridge-Secure-123',
            'role' => 'admin',
        ])->assertRedirect(route('community.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'new.student@example.test',
            'role' => 'student',
        ]);
    }
}