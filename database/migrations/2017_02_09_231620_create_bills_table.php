<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->text('bill_num');
            $table->text('bill_uri');
            $table->text('bill_title');
            $table->text('bill_intro_date');
            $table->char('bill_cosponsors');
            $table->char('bill_sponsor_id');
            $table->text('bill_committees');
            $table->text('bill_latest_major_action_date');
            $table->text('bill_latest_major_action');
            $table->text('bill_congress_term');
            $table->text('bill_chamber');

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
        Schema::dropIfExists('bills');
    }
}
