<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
		use SoftDeletes;

		protected $fillable = [
			'content',
			'issuer_id',
			'idea_id',
		];

		public function issuer() {
			return $this->belongsTo(User::class);
		}

		public function idea() {
			return $this->belongsTo(Idea::class);
		}
}
