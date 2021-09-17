<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_user', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id');
            $table->integer('user_id');
            $table->tinyInteger('is_activated')->default(0);
            $table->string('invoice_id');
            $table->string('address');
            $table->tinyInteger('payment_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_user');
    }
}
