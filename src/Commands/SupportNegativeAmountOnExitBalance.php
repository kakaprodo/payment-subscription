<?php

namespace Kakaprodo\PaymentSubscription\Commands;

use Illuminate\Console\Command;
use Kakaprodo\PaymentSubscription\Models\BalanceEntry;

class SupportNegativeAmountOnExitBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment-subscription:correct-exit-balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to convert all exit balance entries amount into negative amount';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $exitBalanceEntries = BalanceEntry::out()->where('amount', '>', 0)->get();

        foreach ($exitBalanceEntries as $exitBalanceEntry) {
            $exitBalanceEntry->amount = - ($exitBalanceEntry->amount);
            $exitBalanceEntry->save();
        }

        return Command::SUCCESS;
    }
}
