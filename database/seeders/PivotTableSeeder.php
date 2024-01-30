<?php

namespace Database\Seeders;

use App\Models\TmsGear;
use App\Models\TmsOrder;
use App\Models\TmsVehicle;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Database\Seeder;
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
     */
    public function run(): void
    {
        $this->seed_gear_customer();
        $this->seed_gear_vehicle();
        $this->seed_gear_forwarder();
        $this->seed_attribute_order();
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
     * Every attribute must get one random order.
     * 
     * @return void
     */
    private function seed_attribute_order():void
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

        foreach ($attributes as $attribute) {

            //We get 1 random orders for each attribute...
            $randomArraykey = array_rand($orderIds);
            $randomOrderId = $orderIds[$randomArraykey];
            //...and we attach them to the attribute.
            $attribute->orders()->attach($randomOrderId); 
        }
    }
}
