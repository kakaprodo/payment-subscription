<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\FeatureSubscripion;
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
        Schema::create((new FeatureSubscripion())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id')->constrained((new Feature())->getTable());
            $table->foreignId('subscription_id')->constrained((new Subscription())->getTable());
            $table->string('activable_type')->nullable()->comment('Entity type on which a feature is activated');
            $table->bigInteger('activable_id')->nullable()->comment('Entity id on which a feature is activated');
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
        Schema::dropIfExists((new FeatureSubscripion())->getTable());
    }
};
