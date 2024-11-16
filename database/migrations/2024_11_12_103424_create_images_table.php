<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path'); // To store the image file path
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('images');
    }
  
};
