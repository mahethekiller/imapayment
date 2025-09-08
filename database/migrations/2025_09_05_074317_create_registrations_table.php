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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // member if logged in
            $table->string('name');
            $table->string('email');
            $table->string('login_email')->nullable(); // separate from login email if member
            $table->string('mobile')->nullable();
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('company_gst')->nullable();
            $table->string('preferred_city')->nullable();

            $table->integer('extra_members_count')->default(0);

            // pricing
            $table->decimal('base_amount', 10, 2)->default(0);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2)->default(0);

            $table->string('status')->default('pending'); // pending, success, failed
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();

            $table->json('meta')->nullable(); // store any extras
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
