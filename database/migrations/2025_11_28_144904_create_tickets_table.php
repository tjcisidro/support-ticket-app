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
            $table->string('subject');
            $table->text('description');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent']);
            $table->enum('type', ['technical_issues','account_billing','product_service','general_inquiry','feedback']);
            $table->enum('contact_method', ['email', 'phone', 'either', 'none']);
            $table->enum('status', ['open', 'noted', 'closed'])->default('open');
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
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
