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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

						$table->tinyInteger('voting');

						$table->foreignId('voter_id')
							->nullable()
							->constrained('users')
							->onDelete('cascade')
							->onUpdate('cascade');

						$table->foreignId('idea_id')
							->nullable()
							->constrained('ideas')
							->onDelete('cascade')
							->onUpdate('cascade');

						$table->unique(['idea_id', 'voter_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
};
