<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('customer_name', 191)->unique();
            $table->string('tally_serial_no', 191)->nullable();
            $table->string('licence_editon', 191)->nullable();
            $table->unsignedInteger('primary_address_id')->nullable();
            $table->unsignedBigInteger('default_customer_type_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('amc_id')->nullable();
            $table->enum('amc', ['yes', 'no'])->default('yes');
            $table->enum('tss_status', ['active', 'inactive'])->default('active');
            $table->string('tss_adminemail', 191)->nullable();
            $table->date('tss_expirydate')->nullable();
            $table->enum('profile_status', ['Followup', 'Others'])->nullable();
            $table->string('remarks', 191)->nullable();
            $table->boolean('whatsapp_telegram_group')->nullable();
            $table->string('tdl_addons', 191)->nullable();
            $table->boolean('auto_backup')->default(false);
            $table->boolean('cloud_user')->default(false);
            $table->boolean('mobile_app')->default(false);
            $table->string('gst_no', 191)->nullable();
            $table->string('map_location', 191)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();

            //$table->foreign('amc_id')->references('id')->on('amc')->onDelete('set null');
           // $table->foreign('primary_address_id')->references('address_id')->on('address_books')->onDelete('set null'); 
            $table->foreign('products_id')->references('id')->on('products')->onDelete('set null'); 
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
