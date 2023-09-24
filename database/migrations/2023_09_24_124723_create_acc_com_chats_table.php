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
        Schema::create('acc_com_chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid')->nullable(false)->default('');
            $table->string('udid')->nullable(false)->default('');
            $table->integer('company_id')->nullable(false)->default(0);
            $table->boolean('is_group')->default(0);
            $table->smallInteger('is_active')->nullable(false)->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_com_chats');
    }
};
