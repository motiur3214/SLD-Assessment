<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserBackgroundInformation
{
    /**
     * Create the event listener.
     */
    public function __construct(private UserService $userService)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(UserSaved $event)
    {
        $this->userService->saveDetails($event->user);
    }

}
