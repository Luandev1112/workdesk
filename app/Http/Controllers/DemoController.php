<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Schema;
use ZipArchive;
use File;

class DemoController extends Controller
{
    public function __construct()
    {

        if(env('DEMO_MODE') != 'On'){
            return false;
        }

        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 600);

    }

    public function cron_1()
    {
        $this->drop_all_tables();
        $this->import_demo_sql();
    }

    public function cron_2()
    {
        $this->remove_folder();
        $this->extract_uploads();
    }



    public function drop_all_tables()
    {
        Schema::disableForeignKeyConstraints();
        foreach(DB::select('SHOW TABLES') as $table) {
            $table_array = get_object_vars($table);
            Schema::drop($table_array[key($table_array)]);
        }
    }

    public function import_demo_sql() {
        $sql_path = base_path('workdesk_demo.sql');
        DB::unprepared(file_get_contents($sql_path));
    }

    public function extract_uploads()
    {
        $zip = new ZipArchive;
        $zip->open(base_path('public/uploads.zip'));
        $zip->extractTo('public/uploads');

    }

    public function remove_folder()
    {
        File::deleteDirectory(base_path('public/uploads'));
    }


}
