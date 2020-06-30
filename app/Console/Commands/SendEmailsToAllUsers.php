<?php

namespace App\Console\Commands;

use App\Notifications\SendInactiveEmailNotification;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEmailsToAllUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email To All Inactive Users';

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
     * @return mixed
     */
    public function handle(UserRepository $userRepository)
    {
        $inactiveUsers = $userRepository->findByField('active',1);

        Notification::send($inactiveUsers[0], new SendInactiveEmailNotification());
        $this->info('Email send to inactive ' .$inactiveUsers->count().' userssss');
    }
}
