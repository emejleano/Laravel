<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) { // Use plural 'orders'
            $table->id();
            $table->unsignedBigInteger('user_id'); // Proper foreign key type
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('email');
            $table->string('phoneno');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pincode');
            $table->tinyInteger('status')->default(0); // Remove quotes around 0
            $table->text('message')->nullable(); // Use text for longer messages
            $table->string('tracking_no');
            $table->decimal('total_price', 10, 2); // Use decimal for currency
            $table->timestamps();
            
            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders'); // Use plural 'orders'
    }
};