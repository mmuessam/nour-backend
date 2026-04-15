<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('case_updates')) return;
        Schema::create('case_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('cases')->onDelete('cascade');
            $table->string('title');
            $table->text('details')->nullable();
            $table->foreignId('added_by')->constrained('users')->onDelete('restrict');
            $table->unsignedBigInteger('donation_amount')->default(0);
            $table->string('emoji', 10)->default('📝');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_updates');
    }
};
