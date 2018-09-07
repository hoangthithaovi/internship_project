<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->longText('title_event');
            $table->longText('location');
            $table->longText('description');
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->boolean('status')->default(1);
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });
         // Full Text Index
        DB::statement('alter table events ADD FULLTEXT fulltext_index (title_event,location,description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
