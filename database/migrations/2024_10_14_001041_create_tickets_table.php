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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->string('subject');
            $table->string('category');          
            $table->text('content')->nullable();
            $table->string('status')->default('Sent');  // opened, closed, solved
            $table->unsignedBigInteger('sender_id'); 
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->timestamps();


            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
