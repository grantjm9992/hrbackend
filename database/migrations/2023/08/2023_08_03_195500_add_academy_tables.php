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
        Schema::create('group_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->string('name');
            $table->string('tag_colour');
            $table->timestamps();
        });
        Schema::create('academic_cycles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('course_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->string('name');
            $table->string('tag_colour');
            $table->timestamps();
        });
        Schema::create('levels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->string('name');
            $table->string('tag_colour');
            $table->timestamps();
        });
        Schema::create('teachers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->uuid('user_id');
            $table->string('text_colour');
            $table->string('colour');
            $table->string('hours');
            $table->string('hour_cycle');
            $table->timestamps();
        });
        Schema::create('course', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('price')->nullable();
            $table->string('currency')->nullable()->default('EUR');
            $table->string('billing_cycle')->nullable()->default('monthly');
            $table->string('status')->nullable()->default('active');
            $table->uuid('course_category_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
