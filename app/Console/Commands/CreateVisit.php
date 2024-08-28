<?php

namespace App\Console\Commands;

use App\Models\Visit\Visit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateVisit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-visit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear una nueva visita a un cliente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Pedir al usuario los datos
        $name = $this->ask('Enter the customer name');
        $email = $this->ask('Enter the customer email');
        $latitude = $this->ask('Enter the latitude');
        $longitude = $this->ask('Enter the longitude');

        $validator = Validator::make(
            compact('name', 'email', 'latitude', 'longitude'),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]
        );

        if ($validator->fails()) {
            $this->error('Failed to create visit:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        Visit::create([
            'customer_name' => $name,
            'customer_email' => $email,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        $this->info('Visit created successfully');

        return 0;
    }
}
