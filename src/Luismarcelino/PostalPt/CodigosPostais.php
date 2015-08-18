<?php

namespace Luismarcelino\PostalPt;

use Illuminate\Database\Eloquent\Model;

/**
 * CountryList
 *
 */
class CodigosPostais {

	/**
	 * @var string
	 * Array containing postCodes data.
	 */
	protected $postCodes;

	/**
	 * @var string
	 * The table for the postCodes in the database, is "post_codes_pt" by default.
	 */
	protected $table;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
       $this->table = \Config::get('postal_pt.table_name');
    }

    /**
     * Get the countries from the TXT file, if it hasn't already been loaded.
     *
     * @return array
     */
    protected function getPostCodes()
    {
        //Get the postCodes from the CSV file
        if (sizeof($this->postCodes) == 0){
			if (($handle = fopen(__DIR__ . '/todos_cp.txt', 'r')) !== FALSE) {
				$this->postCodes = [];
			    while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
			        if (count($data)>1){
						if (!is_numeric($data[0])){
							continue;
						}

						array_push($this->postCodes, [
							'concelho_id'	=>	$data[0].$data[1],
							'localidade_id'	=>	$data[2],
							'localidade'	=>	$data[3],
							'arteria'		=>	$data[5].$data[6].$data[7].$data[8].$data[9],
							'local'			=>	$data[10],
							'troco'			=>	$data[11],
							'postCode'		=>	$data[14].'-'.$data[15],
							'designation'	=>	$data[16]
						]);

					}
			    }
			    fclose($handle);
			}
        }

        //Return the countries
        return $this->postCodes;
    }

	/**
	 * Returns one country
	 *
	 * @param string $id The freguesia id
     *
	 * @return array
	 */
	public function getOne($id)
	{
        $postCodes = $this->getPostCodes();
		return $postCodes[$id];
	}

	/**
	 * Returns a list of countries
	 *
	 * @param string sort
	 *
	 * @return array
	 */
	public function getList($sort = null)
	{
	    //Get the countries list
	    $postCodes = $this->getPostCodes();

	    //Sorting
	    $validSorts = array(
	        'id',
	        'name',
        );

	    if (!is_null($sort) && in_array($sort, $validSorts)){
	        uasort($postCodes, function($a, $b) use ($sort) {
	            if (!isset($a[$sort]) && !isset($b[$sort])){
	                return 0;
	            } elseif (!isset($a[$sort])){
	                return -1;
	            } elseif (!isset($b[$sort])){
	                return 1;
	            } else {
	                return strcasecmp($a[$sort], $b[$sort]);
	            }
	        });
	    }

	    //Return the countries
		return $postCodes;
	}
}
