<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('assigned_to');
            $table->dropColumn('assigned_to');
            $table->uuid('assigned_to')->nullable();
        });
    }

    public function down()
    {
        //
    }
};
