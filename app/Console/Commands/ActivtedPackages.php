<?php

namespace App\Console\Commands;

use App\Package;
use Illuminate\Console\Command;

class ActivtedPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:activate-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check for the pending activation and will activate the subscriptions if payment has been made by the customer for that specific subscription.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptions = \DB::table("package_user")->where("is_activated" , 0)->get();
        if (count($subscriptions)) {
            foreach ($subscriptions as $key => $subscription) {
                $package = Package::find($subscription->package_id);
                $payment = json_decode(file_get_contents("https://blockchain.info/rawaddr/".$subscription->address), false);
                if($payment->total_received && $payment->total_received >= $package->package_price){
                    echo "\n";
                    echo "Payment found for the address : ".$subscription->address." - Subscription is activated";
                    $subscription->is_activated   = 1;
                    $subscription->payment_status = 1;
                    $subscription->save();
                    echo "\n";
                }
                else{
                    echo "\n";
                    echo "Payment not found for the address : ".$subscription->address;
                    echo "\n";
                }
            }
        }
        else{
            echo "\n";
            echo "No pending subscriptions found!";
            echo "\n";
        }
    }
}