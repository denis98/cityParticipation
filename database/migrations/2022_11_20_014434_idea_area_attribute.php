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
        Schema::table("ideas", function(Blueprint $table) {
					$table->foreignId('area_id')
						->nullable()
						->constrained('areas')
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
        Schema::table("ideas", function(Blueprint $table) {
					$table->dropColumn("area_id");
				});
    }
};
