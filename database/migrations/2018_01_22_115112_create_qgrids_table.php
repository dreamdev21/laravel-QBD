<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQgridsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qgrids', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id');
            $table->integer('parent_id');
            $table->string('content_type');
            $table->string('content')->nullable(true);
            $table->integer('content_order');
            $table->string('creation_date')->nullable(true);
            $table->string('change_date')->nullable(true);
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
        Schema::dropIfExists('qgrids');
    }
}
