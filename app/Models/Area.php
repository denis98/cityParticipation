<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

		protected $fillable = [
			'label',
		];

		public function parent() {
			return $this->belongsTo(Area::class);
		}

		public function children() {
			return $this->hasMany(Area::class, 'parent_id');
		}

		public function ideas() {
			return $this->hasMany(Idea::class);
		}
}
