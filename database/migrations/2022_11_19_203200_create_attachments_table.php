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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
						$table->softDeletes();

						$table
							->foreignId('creator_id')
							->nullable()
							->constrained('users')
							->onDelete('set null')
							->onUpdate('cascade');
						$table
							->foreignId('idea_id')
							->constrained('ideas')
							->onDelete('cascade')
							->onUpdate('cascade');

						$table->integer('filesize');
						$table->string('mime');
						$table->string('originalName');
						$table->string('displayName');
						$table->string('pathinfo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
};
