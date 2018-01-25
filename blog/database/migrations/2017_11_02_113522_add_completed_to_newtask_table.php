<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompletedToNewtaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('newtasks', function (Blueprint $table) {
        $table->increments('id');
		$table->char('taskType', 15);
		$table->integer('circle');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
		Schema::table('newtasks', function (Blueprint $table) {
          $table->dropIndex('newtasks_taskTask_index');	
		 });
	}
}
