<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('plate_number', 15);
            $table->string('vehicle_brand', 50);
            $table->string('vehicle_model', 50);
            $table->unsignedSmallInteger('vehicle_year')->nullable();
            $table->string('service_type', 100);
            $table->text('complaint')->nullable();
            $table->string('mechanic_name', 100)->nullable();
            $table->decimal('cost', 12, 2)->default(0);
            $table->enum('status', ['menunggu', 'dikerjakan', 'selesai', 'diambil'])->default('menunggu');
            $table->date('repair_date')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('repairs');
    }
};
