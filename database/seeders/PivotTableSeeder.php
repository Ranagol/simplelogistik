<?php

namespace Database\Seeders;

use App\Models\TmsGear;
use App\Models\TmsOrder;
use App\Models\TmsVehicle;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Database\Seeder;
use App\Models\TmsPaymentMethod;
use App\Models\TmsOrderAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

/**
 * This class will be used to seed pivot tables. 
 * 
 * We actually do not fake any new db data here.
 * We simply just connect the already existing models.
 * Example: TmsCustomers and TmsGears are already seeded. We just need to connect them in
 * their gear_customer pivot table. We do that by getting all the customers and all the
 * requirements, and then we get random ids from both of them. Then we attach them to each other.
 * we do that with the attach() method.
 */
class PivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds for the pivot tables, belonging to the 'requirements' story.
     * These functions are named with _ because that is the pivot table naming convention.
     * Example: gear_customer is the pivot table for the TmsGear and TmsCustomer models.
     */
    public function run(): void
    {
        // $this->seed_gear_customer();
        // $this->seed_gear_vehicle();
        // $this->seed_gear_forwarder();
        $this->seed_order_order_attribute();
        $this->seed_customer_payment_method();
        $this->seed_order_payment_method();
    }

    /**
     * Connects TmsCustomers and TmsGears, aka populates the gear_customer pivot 
     * table with random customer and random gear ids.
     * Every customer will get one gear.
     * Every gear will get one customer.
     * We do this, because we use randomized id's, and this is the only way to make sure that
     * all customers and all gears have at least one connection.
     * So, there will be 40 gear customer connections.
     *
     * @return void
     */
    private function seed_gear_customer(): void
    {
        //Get all customers
        $customers = TmsCustomer::all();
        //Get all customer ids
        $customerIds = $customers->pluck('id')->toArray();
        //Get all requirements
        $gears = TmsGear::all();
        //Get all requirement ids
        $gearIds = $gears->pluck('id')->toArray();

        foreach ($customers as $customer) {

            //We get 1 random requirement id for each customer...
            $randomArraykey = array_rand($gearIds);
            $randomGearId = $gearIds[$randomArraykey];
            //...and we attach the requirement id to the customer.
            $customer->gears()->attach($randomGearId); 
        }

        foreach ($gears as $gear) {

            //We get one random customer
            $randomArraykey = array_rand($customerIds);
            //We get the id of the random customer...
            $randomCustomerId = $customerIds[$randomArraykey];
            //...and we attach them to the gear.
            $gear->customers()->attach($randomCustomerId); 
        }
    }

    /**
     *
     * @return void
     */
    private function seed_gear_vehicle(): void
    {
        $vehicles = TmsVehicle::all();
        $vehicleIds = $vehicles->pluck('id')->toArray();
        $gears = TmsGear::all();
        $gearIds = $gears->pluck('id')->toArray();

        foreach ($vehicles as $vehicle) {

            //We get 1 random gears for each vehicle...
            $randomArraykey = array_rand($gearIds);
            $gearId = $gearIds[$randomArraykey];
            //...and we attach them to the vehicle.
            $vehicle->gears()->attach($gearId); 
        }

        foreach ($gears as $gear) {

            //We get 2 random vehicles for each gear...
            $randomArraykey = array_rand($vehicleIds);
            $randomVehicleId = $vehicleIds[$randomArraykey];
            //...and we attach them to the gear.
            $gear->vehicles()->attach($randomVehicleId); 
        }
    }

    private function seed_gear_forwarder():void
    {
        $forwarders = TmsForwarder::all();
        $forwarderIds = $forwarders->pluck('id')->toArray();
        $gears = TmsGear::all();
        $gearIds = $gears->pluck('id')->toArray();

        foreach ($forwarders as $forwarder) {

            //We get 1 random gears for each forwarder...
            $randomArraykey = array_rand($gearIds);
            $randomGearId = $gearIds[$randomArraykey];
            //...and we attach them to the forwarder.
            $forwarder->gears()->attach($randomGearId); 
        }

        foreach ($gears as $gear) {

            //We get 2 random forwarders for each gear...
            $randomArraykey = array_rand($forwarderIds);
            $randomForwarderId = $forwarderIds[$randomArraykey];
            //...and we attach them to the gear.
            $gear->forwarders()->attach($randomForwarderId); 
        }
    }

    /**
     * We have 20 orders seeded.
     * We have 73 attributes seeded (because Pamyra has 73 attributes).
     * Every order must get one random attribute.
     * 
     * @return void
     */
    private function seed_order_order_attribute():void
    {
        $orders = TmsOrder::all();
        $orderIds = $orders->pluck('id')->toArray();
        $attributes = TmsOrderAttribute::all();
        $attributeIds = $attributes->pluck('id')->toArray();

        foreach ($orders as $order) {

            //We get 1 random attribute for each order...
            $randomArraykey = array_rand($attributeIds);
            $randomAttributeId = $attributeIds[$randomArraykey];
            //...and we attach them to the order.
            $order->orderAttributes()->attach($randomAttributeId); 
        }
    }

    /**
     * We have 20 orders seeded.
     * We have 5 payment methods seeded.
     * Every order must get one random payment method.
     * 
     * @return void
     */
    private function seed_order_payment_method():void
    {
        $orders = TmsOrder::all();
        $orderIds = $orders->pluck('id')->toArray();
        $paymentMethods = TmsPaymentMethod::all();
        $paymentMethodIds = $paymentMethods->pluck('id')->toArray();

        foreach ($orders as $order) {

            //We get 1 random payment method for each order...
            $randomArraykey = array_rand($paymentMethodIds);
            $randomPaymentMethodId = $paymentMethodIds[$randomArraykey];
            //...and we attach them to the order.
            $order->paymentMethods()->attach(
                $randomPaymentMethodId,
                [
                    'is_active' => true,
                ]
            ); 
        }
    }

    /**
     * We have 40 customers seeded.
     * We have 5 payment methods seeded.
     * Every customer must get one random payment method.
     * 
     * @return void
     */
    private function seed_customer_payment_method():void
    {
        $customers = TmsCustomer::all();
        $customerIds = $customers->pluck('id')->toArray();
        $paymentMethods = TmsPaymentMethod::all();
        $paymentMethodIds = $paymentMethods->pluck('id')->toArray();

        foreach ($customers as $customer) {

            //We get 1 random payment method for each customer...
            $randomArraykey = array_rand($paymentMethodIds);
            $randomPaymentMethodId = $paymentMethodIds[$randomArraykey];
            
            /**
             * ...and we attach them to the customer.
             * Now, this pivot table has one additional column, called 'is_active'. Because a customer
             * can have multiple payment methods, but only one can be active at a time. So, we need to
             * set the 'is_active' column to true for the random payment method we just attached.
             */
            $customer->paymentMethods()->attach(
                $randomPaymentMethodId,
                [
                    'is_active' => true,
                ]
            ); 
        }
    }
}
