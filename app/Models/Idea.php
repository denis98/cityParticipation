<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Idea extends Model
{
    use HasFactory;
		use SoftDeletes;

		protected $fillable = [
			'title',
			'description',
			'topic',
			'coordinates',
			'location',
		];

		public function issuer() {
			return $this->belongsTo(User::class, 'issuer_id');
		}

		public function comments() {
			return $this->hasMany(Comment::class);
		}

		public function votes() {
			return $this->hasMany(Vote::class);
		}

		public function attachments() {
			return $this->hasMany(Attachment::class);
		}

		public function area() {
			return $this->belongsTo(Area::class);
		}

		public function getAddressAttribute() {
			return json_decode($this->location);
		}

		public function getQuarterAttribute() {
			if( isset($this->address->quarter) ) {
				return $this->address->quarter;
			} elseif( isset($this->address->suburb) ) {
				return $this->address->suburb;
			} elseif( isset($this->address->city) ) {
				return $this->address->city;
			} elseif( isset($this->address->town) ) {
				return $this->address->town;
			} elseif( isset($this->address->village) ) {
				return $this->address->village;
			}
		}

		public function getStreetAttribute() {
			return $this->address->road;
		}

		public function scopeLastMonth($query) {
			return $query->where('created_at', '>', Carbon::today()->subMonths(1));
		}

		public function scopeLastWeek($query) {
			return $query->where('created_at', '>', Carbon::today()->subWeeks(1));
		}

		public function scopeUpvotes($query) {
			return $query->withCount(['votes' => function($q) {
				$q->where('voting', 1);
			}])->orderBy('votes_count', 'DESC');
		}

		public function scopeNewest($query) {
			return $query->orderBy('created_at', 'DESC');
		}
}
