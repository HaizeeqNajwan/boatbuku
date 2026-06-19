<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("owner_profiles", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained();
            $table->string("slug")->unique();
            $table->text("bio")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("bank_name")->nullable();
            $table->string("bank_acc")->nullable();
            $table->boolean("verified")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("owner_profiles");
    }
};
