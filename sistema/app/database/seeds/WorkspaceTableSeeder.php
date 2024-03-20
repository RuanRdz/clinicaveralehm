<?php

class WorkspaceTableSeeder extends Seeder {

    public function run()
    {
        DB::table('workspaces')->delete();

        $data = [
            'nome' => 'Joinville',
            'visivel' => 1
        ];
        Workspace::create($data);
    }

}