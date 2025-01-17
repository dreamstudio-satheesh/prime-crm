<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected $guarded = [];  
   
   
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresstypes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresstype');
    }
};
