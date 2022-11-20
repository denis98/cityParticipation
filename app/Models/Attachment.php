<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory;
		use SoftDeletes;

		public function idea() {
			return $this->belongsTo(Idea::class);
		}

		public function creator() {
			return $this->belongsTo(User::class);
		}

		public function getIconAttribute() {
			switch($this->mime) {
				default:
					return 'fa fa-file';
					break;
				case 'image/png':
				case 'image/jpg':
				case 'image/jpeg':
					return 'fa fa-image';
					break;
			}

			return 'fa fa-file';
		}
}
