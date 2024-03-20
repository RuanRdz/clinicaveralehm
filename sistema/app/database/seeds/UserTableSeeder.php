<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $data = [
            'id' => 1,
            'email' => 'contato@componeto.com.br',
            'name' => 'Sistema',
            'credential' => 10,
            'isAdmin' => 1,
            'password' => '$2y$10$T7NA/SQDHHcT.g7sDp1OLOzmHSUVHf06IKt893Ts17XDjh8hlnKz.',
        ];
        User::create($data);
    }

}
