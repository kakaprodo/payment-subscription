<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
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
        Schema::create((new Subscription())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->morphs('subscriptionable'); // Creates subscriptionable_id and subscriptionable_type
            $table->foreignId('plan_id')->constrained((new PaymentPlan())->getTable());
            $table->integer('discount_id')->nullable()->constrained((new Discount())->getTable());
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
        Schema::dropIfExists((new Subscription())->getTable());
    }
};
