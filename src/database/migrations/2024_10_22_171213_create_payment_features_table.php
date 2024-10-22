<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kakaprodo\PaymentSubscription\Models\Feature;
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
        Schema::create((new Feature())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('plan_id')->constrained((new PaymentPlan())->getTable());
            $table->string('slug')->unique();
            $table->decimal('cost', 8, 2)->default(0);
            $table->string('unit')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_pay_as_you_go')->default(false);
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
        Schema::dropIfExists((new Feature())->getTable());
    }
};
