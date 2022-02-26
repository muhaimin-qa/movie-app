<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;

class createNewUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:newUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $quantity = $this->ask('How many user?');
        
        if($quantity == '' or $quantity == '0' or $quantity < 0){
            $this->error('Value cannot be null, 0 or negative');
        }

        for($i=0; $i<$quantity; $i++){
            $user = User::factory()->create();
            $this->info('User created '.$user->name);
        }
        
    }
}
