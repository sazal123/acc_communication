<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acc_com_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid')->nullable(false)->default('');
            $table->string('udid')->nullable(false)->default('');
            $table->integer('company_id')->nullable(false)->default(0);
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->unsignedBigInteger('chat_id')->unique();
            $table->unsignedBigInteger('created_by');
            $table->smallInteger('is_active')->nullable(false)->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('chat_id')->references('id')->on('acc_com_chats')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_com_groups');
    }
};
