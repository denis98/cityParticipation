<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


		public function ideas() {
			return $this->hasMany(Idea::class, 'issuer_id');
		}

		public function votes() {
			return $this->hasManyThrough(Vote::class, Idea::class, 'issuer_id');
		}

		public function voted() {
			return $this->hasMany(Vote::class, 'voter_id');
		}

		public function hasUpvoted(Idea $idea) {
			$tmp = $this->voted()->where('idea_id', $idea->id);
			if( $tmp->count() > 0 ) {
				if( $tmp->first()->voting == Vote::UPVOTE ) {
					return true;
				}
			}

			return false;
		}

		public function hasDownvoted(Idea $idea) {
			$tmp = $this->voted()->where('idea_id', $idea->id);
			if( $tmp->count() > 0 ) {
				if( $tmp->first()->voting == Vote::DOWNVOTE ) {
					return true;
				}
			}

			return false;
		}

		public function scopeByIdeas($query) {
			return $query->withCount(['ideas'])->orderBy('ideas_count', 'DESC');
		}

		public function scopeByUpvotes($query) {
			return $query->withCount(['votes'])->orderBy('votes_count', 'DESC');
		}

}
