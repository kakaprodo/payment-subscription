<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kakaprodo\PaymentSubscription\Models\Balance;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Balance())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->morphs('balanceable');
            $table->decimal('amount', 10)->default(0);
            $table->dateTime('expired_at')->nullable();
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
        Schema::dropIfExists((new Balance())->getTable());
    }
};
