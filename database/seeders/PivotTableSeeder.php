<?php

namespace Database\Seeders;

use App\Models\TmsVehicle;
use App\Models\TmsCustomer;
use App\Models\TmsVehicleReq;
use App\Models\TmsCustomerReq;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

/**
 * This class will be used to seed pivot tables. We actually do not seed anything here.
 * We simply just connect the already existing models.
 * Example: TmsCustomers and TmsCustomerReqs are already seeded. We just need to connect them.
 * we do that with the attach() method.
 */
class PivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedRequirementsForCustomersTable();
        $this->seedRequirementsForVehiclesTable();
    }

    /**
     * Connects TmsCustomers and TmsCustomerReqs, aka populates the requirements_for_customers pivot 
     * table with random ids.
     *
     * @return void
     */
    private function seedRequirementsForCustomersTable(): void
    {
        $customers = TmsCustomer::all();
        $customerIds = $customers->pluck('id')->toArray();
        $requirements = TmsCustomerReq::all();
        $requirementsIds = $requirements->pluck('id')->toArray();

        foreach ($customers as $customer) {

            //We get 1 random requirements for each customer...
            $randomArraykey = array_rand($requirementsIds);
            $randomReqId = $requirementsIds[$randomArraykey];
            //...and we attach them to the customer.
            $customer->customerReqs()->attach($randomReqId); 
        }

        foreach ($requirements as $requirement) {

            //We get 2 random customers for each requirement...
            $randomArraykey = array_rand($customerIds);
            $randomCustomerId = $customerIds[$randomArraykey];
            //...and we attach them to the requirement.
            $requirement->customers()->attach($randomCustomerId); 
        }
    }

    private function seedRequirementsForVehiclesTable(): void
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
}
