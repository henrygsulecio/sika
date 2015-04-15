<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportCodes extends Command {
	// constants
	const CUBETA_POINTS = 50;
	const GALON_POINTS = 20;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mobil:import-codes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import Mobile codes.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// without timeout
		set_time_limit(0);

		// are you sure
		if ($this->confirm('Do you wish to continue? [yes|no]')) {
			// code types
			$this->info('Inserting code types');
			$this->insertCodeTypes();

			// files to import
			$files_path = storage_path() . '/files';
			$this->info('Folder: ' . $files_path);
			$files = array(
				'cubeta' => 'CodigosCubetaMobil.xlsx',
				'galon' => 'CodigosGalonMobil.xlsx',
			);

			foreach ($files as $code_type_name => $file) {
				$this->info('========================');
				$this->info('File: ' . $file);

				Excel::load($files_path . '/' . $file, function($reader) use($code_type_name) {
					// getting file in array
					$file_array = $reader->toArray();

					// only the 1st sheet
					$sheet = $file_array[0];
					//Log::info(print_r($sheet, true));

					// getting the code_type_id
					$code_type = DB::table('code_type')
			      ->select('id')
			      ->where('name', '=', $code_type_name)
			      ->first();
					if (!$code_type) {
						return;
					}

					// reading the array
					$row_count = 0;
					foreach ($sheet as $row) {
						// updating count
						$row_count++;
						if ($row_count % 1000 == 0) {
							$this->info('row #: ' . $row_count);
						}

						// fist row
						if ($row_count == 1) {
							$keys = array_keys($row);
							foreach ($keys as $code) {
								$this->insertCode($code, $code_type->id);
							}
						}

						// other rows
						foreach ($row as $code) {
							$this->insertCode($code, $code_type->id);
						}
					}
				});
			}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

	/**
	 * Insert code types
	 */
	protected function insertCodeTypes()
	{
		// now value
    $now = date('Y-m-d H:i:s');

    // types list
    $types = array(
    	'cubeta' => self::CUBETA_POINTS,
    	'galon' => self::GALON_POINTS,
    );

		// cubeta
		foreach ($types as $key => $points) {
			$type_id = DB::table('code_type')
	      ->select('id')
	      ->where('name', '=', $key)
	      ->first();
	    if (!$type_id) {
	    	DB::table('code_type')->insert(
		      array(
		        'name' => $key,
		        'points' => $points,
		        'created_at' => $now,
		        'updated_at' => $now,
		      )
		    );
	    }
		}
	}

	/**
	 * Insert codes
	 */
	protected function insertCode($code, $code_type_id)
	{
		if (strlen($code) == 7) {
			try {
				DB::table('code')->insert(
		      array(
		        'code_type_id' => $code_type_id,
		        'code' => strtoupper($code),
		        'created_at' => date('Y-m-d H:i:s'),
		      )
		    );
			} catch (Exception $e) {
				//Log::error($e);
			}
		}
	}

}
