use Illuminate\Database\Migrations\Migration;

class SetupPostCodesPtTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Creates the users table
		Schema::create(\Config::get('postal_pt.table_name'), function($table)
		{
		    $table->integer('id')->index();
		    $table->string('concelho_id',4)->nullable();
			$table->integer('localidade_id')->unsigned()->nullable();
		    $table->string('localidade', 255)->nullable();
			$table->string('arteria', 255)->nullable();
			$table->string('local', 255)->nullable();
			$table->string('troco', 255)->nullable();
			$table->string('postCode', 8)->index();
			$table->string('designation', 255);

		    $table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(\Config::get('postal_pt.table_name'));
	}

}
