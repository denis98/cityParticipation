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
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
						$table->softDeletes();

						$table->string('title');
						$table->mediumText('description');
						$table->string('topic');
						$table->mediumText('location');
						$table->string('coordinates');

						$table->foreignId('issuer_id')
							->nullable()
							->constrained('users')
							->onDelete('set null')
							->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideas');
    }
};
