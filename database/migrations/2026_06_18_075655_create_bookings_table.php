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
        Schema::create("bookings", function (Blueprint $table) {
            $table->id();
            $table->foreignId("boat_id")->constrained();
            $table->string("customer_name");
            $table->string("customer_phone");
            $table->date("date");
            $table->time("start_time");
            $table->time("end_time");
            $table->integer("pax");
            $table
                ->enum("status", [
                    "pending",
                    "confirmed",
                    "rejected",
                    "cancelled",
                ])
                ->default("pending");
            $table->text("notes")->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("bookings");
    }
};
