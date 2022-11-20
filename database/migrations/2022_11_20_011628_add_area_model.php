<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('areas', function (Blueprint $table) {
					$table->id();
					$table->timestamps();

					$table->foreignId('parent_id')
						->nullable()
						->constrained('areas')
						->onDelete('set null')
						->onUpdate('cascade');

					$table->string('label');
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
			Schema::dropIfExists('areas');
    }
};
