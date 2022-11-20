<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vote;
use App\Models\User;
use App\Models\Idea;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
			$user = User::all()->random();
			$idea = Idea::all()->random();
			$vote = Vote::AVAILABLE_VOTES[array_rand(Vote::AVAILABLE_VOTES)];

        return [
            'voter_id' => $user->id,
						'idea_id' => $idea->id,
						'voting' => $vote,
        ];
    }
}
