<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DiscountCode;
use Carbon\Carbon;

class DiscountCodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discountCode:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of discount code!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DiscountCode::where('expired_date', Carbon::now())
            ->update(['status' => 'Expired!']);
    }
}