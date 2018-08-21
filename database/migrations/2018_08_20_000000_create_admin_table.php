<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Admin', function (Blueprint $table) {
            $table->increments('id');
			$table->string('username', 16)->unique();
			$table->string('password', 255);
			$table->string('email', 255)->unique()->nullable();
			$table->integer('Role_id')->default(0);
			$table->tinyInteger('status');
			$table->rememberToken();
			$table->timeStamp('createTime')->nullable();
			$table->timeStamp('updateTime')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Admin');
    }
}
