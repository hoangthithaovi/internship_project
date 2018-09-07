<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(companiesSeederTable::class);
        $this->call(type_eventsSeederTable::class);
        $this->call(eventsSeederTable::class);
        $this->call(usersSeederTable::class);
        $this->call(ticketsSeederTable::class);
        $this->call(actionsSeederTable::class);
        $this->call(groupActionSeederTable::class);
        $this->call(groupsSeederTable::class);
        $this->call(userActionSeederTable::class);
        $this->call(attached_filesSeederTable::class);
        $this->call(commentsSeederTable::class);
        $this->call(likesSeederTable::class);
        $this->call(order_detailsSeederTable::class);
        $this->call(ordersSeederTable::class);
        $this->call(usersGroupsSeederTable::class);
        $this->call(typeEventEventsSeederTable::class);
        $this->call(companyEventSeederTable::class);
    }
}
