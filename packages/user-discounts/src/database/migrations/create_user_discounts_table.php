<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('user_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('discount_id')->constrained()->onDelete('cascade');
            $table->integer('usage_count')->default(0);
            $table->integer('usage_limit')->default(5);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('user_discounts');
    }
};
