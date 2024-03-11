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
            // doc: https://laravel.com/docs/10.x/migrations#column-method-string
            $table->string('title');
            $table->text('description');
            // $table->string('status')->default(TicketStatus::OPEN);
            $table->enum('status', ['open', 'resolved', 'rejected'])->default('open');
            $table->string('attachment')->nullable();
            // $table->bigInteger('user_id')->references('id')->on('users');;
            $table->foreignId('user_id')->constrained(); // 'id' field of 'user' table
            $table->foreignId('status_changed_by_id')->nullable()->constrained('users'); // 'status_changed_by_id' field of 'user' table
            $table->timestamps();
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
