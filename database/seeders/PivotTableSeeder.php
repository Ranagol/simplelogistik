<?php

namespace Database\Seeders;

use App\Models\TmsCustomer;
use App\Models\TmsRequirementsForCustomer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * This class will be used to seed pivot tables. We actually do not seed anything here.
 * We simply just connect the already existing models.
 * Example: TmsCustomers and TmsRequirementsForCustomers are already seeded. We just need to connect them.
 * we do that with the attach() method.
 */
class PivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->requirementsForCustomer();
    }

    private function requirementsForCustomer(): void
    {
        $customers = TmsCustomer::all();
        $customerIds = $customers->pluck('id')->toArray();
        $requirements = TmsRequirementsForCustomer::all();
        $requirementsIds = $requirements->pluck('id')->toArray();

        foreach ($customers as $customer) {

            //We get 2 random requirements for each customer, and we attach them to the customer.
            $customer->requirementsForCustomers()->attach(array_rand($requirementsIds, 2)); 
        }

        foreach ($requirements as $requirement) {

            //We get 2 random customers for each requirement, and we attach them to the requirement.
            $requirement->customers()->attach(array_rand($customerIds, 2)); 
        }
    }
}
