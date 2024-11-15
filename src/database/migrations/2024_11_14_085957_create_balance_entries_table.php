<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kakaprodo\PaymentSubscription\Models\Balance;
use Kakaprodo\PaymentSubscription\Models\BalanceEntry;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new BalanceEntry())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->bigInteger('balance_id')->constrained((new Balance())->getTable())->index();
            $table->float('amount');
            $table->boolean('is_in');
            $table->string('description')->nullable();
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
        Schema::dropIfExists((new BalanceEntry())->getTable());
    }
};
