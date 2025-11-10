<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ai_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('prompt_text');
            $table->text('response_text')->nullable();
            $table->string('model_used')->default('yandexgpt-5.1-pro');
            $table->integer('tokens_used')->nullable();
            $table->string('status')->default('completed');
            $table->timestamps();
            
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_requests');
    }
};