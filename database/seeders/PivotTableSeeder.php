<?php

namespace Database\Seeders;

use App\Models\TmsVehicle;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsVehicleReq;
use App\Models\TmsNeededGear;
use App\Models\TmsOfferedGear;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

/**
 * This class will be used to seed pivot tables. Pivot tables that belong to the 'requierements'
 * story.
 * 
 * We actually do not fake any new db data here.
 * We simply just connect the already existing models.
 * Example: TmsCustomers and TmsNeededGears are already seeded. We just need to connect them in
 * their customer_customer_req_pivot table. We do that by getting all the customers and all the
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
        $this->seed_customer_customer_reqs_pivot_table();
        $this->seed_vehicle_vehicle_reqs_pivot_table();
        $this->seed_forwarder_forwarder_reqs_pivot_table();
    }

    /**
     * Connects TmsCustomers and TmsNeededGears, aka populates the ... pivot 
     * table with random ids.
     *
     * @return void
     */
    private function seed_customer_customer_reqs_pivot_table(): void
    {
        //Get all customers
        $customers = TmsCustomer::all();
        //Get all customer ids
        $customerIds = $customers->pluck('id')->toArray();
        //Get all requirements
        $requirements = TmsNeededGear::all();
        //Get all requirement ids
        $requirementsIds = $requirements->pluck('id')->toArray();

        foreach ($customers as $customer) {

            //We get 1 random requirement id for each customer...
            $randomArraykey = array_rand($requirementsIds);
            $randomReqId = $requirementsIds[$randomArraykey];
            //...and we attach the requirement id to the customer.
            $customer->customerReqs()->attach($randomReqId); 
        }

        foreach ($requirements as $requirement) {

            //We get one random customer
            $randomArraykey = array_rand($customerIds);
            //We get the id of the random customer...
            $randomCustomerId = $customerIds[$randomArraykey];
            //...and we attach them to the requirement.
            $requirement->customers()->attach($randomCustomerId); 
        }
    }

    private function seed_vehicle_vehicle_reqs_pivot_table(): void
    {
        $vehicles = TmsVehicle::all();
        $vehicleIds = $vehicles->pluck('id')->toArray();
        $requirements = TmsVehicleReq::all();
        $requirementsIds = $requirements->pluck('id')->toArray();

        foreach ($vehicles as $vehicle) {

            //We get 1 random requirements for each vehicle...
            $randomArraykey = array_rand($requirementsIds);
            $randomReqId = $requirementsIds[$randomArraykey];
            //...and we attach them to the vehicle.
            $vehicle->vehicleReqs()->attach($randomReqId); 
        }

        foreach ($requirements as $requirement) {

            //We get 2 random vehicles for each requirement...
            $randomArraykey = array_rand($vehicleIds);
            $randomVehicleId = $vehicleIds[$randomArraykey];
            //...and we attach them to the requirement.
            $requirement->vehicles()->attach($randomVehicleId); 
        }
    }

    private function seed_forwarder_forwarder_reqs_pivot_table():void
    {
        $forwarders = TmsForwarder::all();
        $forwarderIds = $forwarders->pluck('id')->toArray();
        $requirements = TmsOfferedGear::all();
        $requirementsIds = $requirements->pluck('id')->toArray();

        foreach ($forwarders as $forwarder) {

            //We get 1 random requirements for each forwarder...
            $randomArraykey = array_rand($requirementsIds);
            $randomReqId = $requirementsIds[$randomArraykey];
            //...and we attach them to the forwarder.
            $forwarder->forwarderReqs()->attach($randomReqId); 
        }

        foreach ($requirements as $requirement) {

            //We get 2 random forwarders for each requirement...
            $randomArraykey = array_rand($forwarderIds);
            $randomForwarderId = $forwarderIds[$randomArraykey];
            //...and we attach them to the requirement.
            $requirement->forwarders()->attach($randomForwarderId); 
        }
    }
}
