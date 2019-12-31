<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Ixudra\Curl\Facades\Curl;
use App\Currency;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            //
            //     Commands\Serve::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->call(function () {
            $response = Curl::to('https://currency.jafari.pw/json')
                    ->get();
            $currencies = json_decode($response);
            $currencies = $currencies->Currency;
            foreach ($currencies as $currency) {
                $currency_db = Currency::where("code", $currency->Code)->first();
                if ($currency_db === null) {
                    $currency_db = new Currency();
                    $currency_db->code = $currency->Code;
                    $currency_db->price = $currency->Sell;
                    $currency_db->save();
                } else {
                    $currency_db->code = $currency->Code;
                    $currency_db->price = $currency->Sell;
                    $currency_db->save(); 
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
