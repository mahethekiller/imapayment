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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Prices are base prices (before GST)
            $table->decimal('member_price', 10, 2)->default(0);
            $table->decimal('non_member_price', 10, 2)->default(0);
            $table->decimal('gst_percent', 5, 2)->default(18.00);

                                                              // Workshop / PDF control
            $table->boolean('workshop_mode')->default(false); // if true -> no PDF download
            $table->boolean('enable_pdf_download')->default(true);

            // PDF file path (storage/app/public/landing_pages/...)
            $table->string('pdf_path')->nullable();

            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
