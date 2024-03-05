<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsFtpCredentialSeeder extends Seeder
{
    private TmsFtpCredential $tmsFtpCredential;

    /**
     * The TmsFtpCredential contains the array of ftp connection details. This is set in the 
     * constructor. That is the only way so we can use config() and env() functions to pull in the 
     * username and password. Since we have a constructor, an object will be created, that will 
     * contain the array of ftp connection details. Now, to acces this object, we use in this
     * constructor a dependency injection. 
     * when we have this object, then we can access the credentials with a getter, and using them
     * for seeding.
     *
     * @param TmsFtpCredential $tmsFtpCredential
     */
    public function __construct(TmsFtpCredential $tmsFtpCredential)
    {
        $this->tmsFtpCredential = $tmsFtpCredential;
    }

    /**
     * Run the database seeds. Gets the credentials, and for every credential record, creates a new
     * record in the tms_ftp_credentials table.
     */
    public function run(): void
    {
        foreach($this->tmsFtpCredential->getFtpConnectionDetails() as $ftpCredential) {
            TmsFtpCredential::create($ftpCredential);
        }
    }
}
