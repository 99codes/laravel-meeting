<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->uuid('uuid');
            $table->string('topic');
            $table->dateTimeTz('start_time');
            $table->integer('duration');

            $table->dateTimeTz('started_at')->nullable();
            $table->dateTimeTz('ended_at')->nullable();

            $table->string('provider');

            $table->morphs('scheduler');
            $table->morphs('presenter');
            $table->morphs('host');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('meeting_participants', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->dateTimeTz('started_at')->nullable();
            $table->dateTimeTz('ended_at')->nullable();

            $table->morphs('participant');
            $table->unsignedBigInteger('meeting_id');
            $table->primary(['participant_id', 'participant_type', 'meeting_id'], 'meeting_participant_primary_key');

            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('meeting_rooms', function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->uuid('uuid');
            $table->string('name', 100);
            $table->string('email');
            $table->tinyInteger('type');
            $table->string('group');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

     /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_participants');
        Schema::dropIfExists('meetings');
        Schema::dropIfExists('meeting_rooms');
    }
}
