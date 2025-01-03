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
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('target_user_id')->after('user_id'); // Add target_user_id column
            $table->foreign('target_user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key reference
        });
    }
    
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['target_user_id']);
            $table->dropColumn('target_user_id');
        });
    }
    
};
