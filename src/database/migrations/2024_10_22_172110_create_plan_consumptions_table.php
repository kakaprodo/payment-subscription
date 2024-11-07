<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\PlanConsumption;
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
        Schema::create((new PlanConsumption())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained((new Subscription())->getTable());
            $table->string('description')->nullable();
            $table->string('action')->nullable();
            $table->decimal('price', 8, 2);
            $table->boolean('is_paid')->default(false);
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
        Schema::dropIfExists((new PlanConsumption())->getTable());
    }
};
