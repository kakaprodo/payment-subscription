<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
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
        Schema::table((new PaymentPlan())->getTable(), function (Blueprint $table) {
            $table->string('type')
                ->default(PaymentPlan::TYPE_PAY_AS_YOU_GO)
                ->comment('you can describe any type that you want for a plan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table((new PaymentPlan())->getTable(), function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
