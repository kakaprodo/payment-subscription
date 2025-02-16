<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kakaprodo\PaymentSubscription\Models\Subscription;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table((new Subscription())->getTable(), function (Blueprint $table) {
            $table->date('started_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table((new Subscription())->getTable(), function (Blueprint $table) {
            $table->dropColumn('started_at');
        });
    }
};
