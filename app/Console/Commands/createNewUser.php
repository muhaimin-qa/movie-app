<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class createNewUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:newUser {quantity : Number of user to be created}';

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
        for($i=0; $i<$this->argument('quantity'); $i++){
            $user = User::factory()->create();
             
            $this->info('User created '.$user->name);
        }
        
    }
}
