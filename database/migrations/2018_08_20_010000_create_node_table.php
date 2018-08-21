<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Node', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name', 16);
			$table->string('accessTag', 128)->nullable();
			$table->integer('pid');
			$table->integer('sort');
			$table->string('remark', 255)->nullable();
			$table->string('uri', 255)->nullable();
			$table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Node');
    }
}
