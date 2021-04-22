<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobilePhoneLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_phone_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('request_url');
            $table->string('request_HTTP_method');
            $table->text('request_header');
            $table->text('request_body')->nullable();
            $table->timestamp('requested_at');
            $table->string('requestor')->nullable();
            $table->string('requestor_ip');
            $table->string('status_code');
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
        Schema::dropIfExists('mobile_phone_logs');
    }
}
