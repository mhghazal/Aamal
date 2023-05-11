<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('n__courses', function (Blueprint $table) {
            $table->id();
            $table->string('name_image');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->string('photo_type')->nullable();
            $table->string('voice_type')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `n__courses`ADD n_image LONGBLOB");
        DB::statement("ALTER TABLE `n__courses`ADD voice LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('n__courses');
    }
};
