use Illuminate\Database\Seeder;

class PostalPtSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the countries table
        DB::table(\Config::get('postal_pt.table_name'))->delete();

        //Get all of the countries
        $postCodes = CodigosPostais::getList();
        foreach ($postCodes as $postCode){
            DB::table(\Config::get('postal_pt.table_name'))->insert($postCode));
        }
    }
}
