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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id')->nullable();

            $table->unsignedBigInteger('condition_id')->nullable();

            $table->unsignedBigInteger('title_id')->nullable();

            $table->year('year')->nullable();
            $table->string('model')->nullable();
            $table->string('mileage')->nullable();
            $table->string('vin')->nullable();
            $table->string('make')->nullable();

            $table->string('mainGoal')->nullable();

            $table->string('sellerUpside')->nullable();

                $table->enum('status', ['pending', 'contacted_by_mail', 'contacted_by_message', 'not_interested'])->nullable()->default('pending'); ;
           //contact
            $table->string('fullName')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->longText('notes')->nullable();

               $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
               $table->foreign('condition_id')->references('id')->on('conditions')->onDelete('cascade');
               $table->foreign('title_id')->references('id')->on('title_situations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
