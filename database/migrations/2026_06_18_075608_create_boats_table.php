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
        Schema::create("boats", function (Blueprint $table) {
            $table->id();
            $table->foreignId("owner_id")->constrained("users");
            $table->string("name");
            $table->string("type"); // e.g. 'fishing', 'speedboat'
            $table->integer("capacity");
            $table->text("description")->nullable();
            $table->decimal("price_per_hour", 10, 2)->nullable();
            $table->decimal("price_per_trip", 10, 2)->nullable();
            $table->string("location");
            $table->enum("status", ["active", "inactive"])->default("active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("boats");
    }
};
