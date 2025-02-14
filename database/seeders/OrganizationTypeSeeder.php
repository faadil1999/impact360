<?php

namespace Database\Seeders;

use App\Models\OrganizationSubType;
use App\Models\OrganizationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizationTypes = File::get(database_path('data/organization/organization_types.json'));

        if ($organizationTypes) {
            $data_types = json_decode($organizationTypes);
            foreach ($data_types as $type) {
                $organizationType = OrganizationType::firstOrCreate([
                    'name' => $type->name
                ]);

                foreach ($type->subTypes as $subType) {
                    OrganizationSubType::firstOrCreate([
                        'name' => $subType->name,
                        'organization_type_id' => $organizationType->id
                    ]);
                }
            }
        }
    }
}
