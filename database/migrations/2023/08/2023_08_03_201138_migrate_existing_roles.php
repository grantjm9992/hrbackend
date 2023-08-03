<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = \App\Models\CoreContext\User::all();
        foreach ($users as $user) {
            $array = [
                'user_id' => $user->getAttributeValue('id'),
                'company_id' => $user->getAttributeValue('company_id'),
                'user_role' => $user->getAttributeValue('user_role'),
            ];
            \App\Models\CoreContext\UserUserRoles::create($array);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
