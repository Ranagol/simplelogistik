<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmsFtpCredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $pamyraOrdersTest = env('PAMYRA_ORDERS_TEST');
        // if ($pamyraOrdersTest !== null) {
        //     DB::statement($pamyraOrdersTest);
        // }

        // $pamyraOrdersLive = env('PAMYRA_ORDERS_LIVE');
        // if ($pamyraOrdersLive !== null) {
        //     DB::statement($pamyraOrdersLive);
        // }

        //TODO ANDOR I stopped here. Current problem: when I run the seeder:
        // SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''Rechnungen/Copies, '')' at line 2 (Connection: mysql, SQL: INSERT INTO tms_ftp_credentials (name, host, port, username, password, path, comment)
        //VALUES ('EmonsInvoicesTest', 'ftp.simplelogistik.de', '', 'simplv_14', 'VQw5fXLT4VSUBeFQ', 'Rechnungen/Copies, '');)
        // $emonsInvoicesTest = env('EMONS_INVOICES_TEST');
        // if ($emonsInvoicesTest !== null) {
        //     DB::statement($emonsInvoicesTest);
        // }

        // $emonsInvoicesLive = env('EMONS_INVOICES_LIVE');
        // if ($emonsInvoicesLive !== null) {
        //     DB::statement($emonsInvoicesLive);
        // }
    }
}
