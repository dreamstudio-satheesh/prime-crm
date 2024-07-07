<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('onsite_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('contact_person_id');
            $table->string('type_of_call');
            $table->timestamp('call_start_time');
            $table->timestamp('call_end_time')->nullable();
            $table->enum('status_of_call', ['completed', 'pending']);
            $table->decimal('service_charges', 8, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('contact_person_id')->references('customer_id')->on('address_books')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onsite_visits');
    }
};
