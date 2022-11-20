<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

		const UPVOTE = 1;
		const DOWNVOTE = 2;

		protected $fillable = [
			'idea_id',
			'voter_id',
			'voting',
		];

		const AVAILABLE_VOTES = array(
			0 => Vote::UPVOTE,
			1 => Vote::DOWNVOTE,
		);

		public function voter() {
			return $this->belongsTo(User::class);
		}

		public function idea() {
			return $this->belongsTo(Idea::class);
		}

		public function scopeUpvotes($query) {
			return $query->where('voting', '=', self::UPVOTE);
		}

		public function scopeDownvotes($query) {
			return $query->where('voting', '=', self::DOWNVOTE);
		}
}
