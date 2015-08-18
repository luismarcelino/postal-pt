<?php
namespace Luismarcelino\PostalPt;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SeedPostCodesCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'postalpt:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates the database with records following the Postal-Pt specifications.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $app = app();
        $app['view']->addNamespace('postal_pt',substr(__DIR__,0,-8).'database');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->line('');
        $this->info('The (very long) seed process will populate the "'.\Config::get('postal_pt.table_name').'" portuguese postal codes list');

        $this->line('');

        if ( $this->confirm("Proceed with seeding? [Yes|no]") )
        {
            $this->line('');
            $this->info( "Seeding database..." );
            if( $this->seedPostCodes() )
            {
                $this->line('');

                $this->info( "Postal-PT seeded!" );
            }
            else{
                $this->error(
                    "Coudn't create migration.\n Check the write permissions".
                    " within the app/database/migrations directory."
                );
            }

            $this->line('');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

    /**
     * Seed the portuguese post codes
     *
     * @return bool
     */
    protected function seedPostCodes()
    {
        $app = app();

        //Empty the 'postal_pt.table_name' table
        \DB::table(\Config::get('postal_pt.table_name'))->delete();

        //Get the postCodes from the CSV file
		if (($handle = fopen(__DIR__ . '/todos_cp.txt', 'r')) !== FALSE) {
			$this->postCodes = [];
		    while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
		        if (count($data)>1){
					if (!is_numeric($data[0])){
						continue;
					}

					$postCode = [
						'concelho_id'	=>	$data[0].$data[1],
						'localidade_id'	=>	$data[2],
						'localidade'	=>	$data[3],
						'arteria'		=>	self::buildString(array_slice($data, 5, 5, true)),
						'local'			=>	$data[10],
						'troco'			=>	$data[11],
						'post_code'		=>	$data[14].'-'.$data[15],
						'designation'	=>	$data[16]
					];

                    \DB::table(\Config::get('postal_pt.table_name'))->insert($postCode);

				}
		    }
		    fclose($handle);
		}

        return true;
    }

    static private function buildString (array $array) {
        $string = '';
        foreach ($array as $component){
            if (strlen($component)>0){
                if (strlen($string)>0){
                    $string = $string.' '.$component;
                }
                else {
                    $string = $component;
                }
            }
        }
        return $string;
    }
}
