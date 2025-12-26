<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\User;

class PollFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_poll()
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($admin);
        $response = $this->post(route('admin.polls.store'), [
            'question' => 'Test Poll?',
            'options' => ['Yes', 'No'],
        ]);
        $response->assertRedirect(route('admin.polls.index'));
        $this->assertDatabaseHas('polls', ['question' => 'Test Poll?']);
        $this->assertDatabaseCount('poll_options', 2);
    }

    public function test_user_can_vote_on_poll()
    {
        $poll = Poll::factory()->create();
        $option = PollOption::factory()->create(['poll_id' => $poll->id]);
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('polls.vote', $option->id));
        $response->assertStatus(302);
        $this->assertDatabaseHas('poll_votes', [
            'poll_option_id' => $option->id,
            'user_id' => $user->id,
        ]);
    }
}
