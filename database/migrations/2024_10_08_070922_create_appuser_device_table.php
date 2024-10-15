<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appuser_device', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appuser_id')->unsigned()->nullable();
            $table->foreign('appuser_id')->references('id')->on('appuser')->onDelete('cascade');
            $table->longText('jwt_token');
            $table->String('device_name');
            $table->String('device_unique_id');
            $table->enum('device_type', ['A','I','O'])->default('O');
            $table->String('os_version');
            $table->String('app_version');
            $table->String('device_token');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appuser_device');
    }
};
