<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @author Ahilan
     */
    public function up()
    {
        Schema::create('route_usages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('route_name')->nullable();
            $table->string('uri')->nullable();
            $table->string('controller')->nullable();
            $table->string('prefix')->nullable();
            $table->string('count')->nullable();
            $table->dateTime('last_accessed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @author Ahilan
     */
    public function down()
    {
        Schema::dropIfExists('route_usages');
    }
}
