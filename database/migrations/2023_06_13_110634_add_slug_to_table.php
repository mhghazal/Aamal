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
        Schema::table('sections', function (Blueprint $table) {
            // Check if the column exists before attempting to add it
            if (!Schema::hasColumn('sections', 'slug')) {
                $table->string('slug')->after('name_section');
            }
        });

        Schema::table('courses', function (Blueprint $table) {
            // Check if the column exists before attempting to add it
            if (!Schema::hasColumn('courses', 'slug')) {
                $table->string('slug')->after('name_course');
            }
        });

        Schema::table('games', function (Blueprint $table) {
            // Check if the column exists before attempting to add it
            if (!Schema::hasColumn('games', 'slug')) {
                $table->string('slug')->after('name_game');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            //
        });
    }
};
