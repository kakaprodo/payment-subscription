<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\FeaturePlan;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new FeaturePlan())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id')->constrained((new Feature())->getTable());
            $table->foreignId('plan_id')->constrained((new PaymentPlan())->getTable());
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
        Schema::dropIfExists((new FeaturePlan())->getTable());
    }
};
