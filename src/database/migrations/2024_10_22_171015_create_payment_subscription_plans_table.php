<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        Schema::create((new PaymentPlan())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sub_title')->nullable();
            $table->string('price_format')->nullable();
            $table->decimal('initial_cost', 8, 2)->default(0);
            $table->string('description')->nullable();
            $table->string('slug');
            $table->boolean('has_pay_as_you_go')->default(false);
            $table->boolean('is_free')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists((new PaymentPlan())->getTable());
    }
};
