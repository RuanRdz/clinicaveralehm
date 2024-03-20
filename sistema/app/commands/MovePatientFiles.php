<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MovePatientFiles extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:move-patient-files';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Move arquivos dos pacientes de "uploads" para "uploads_older"';

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
        $execute = $this->option('execute');
        $count = 0;
        $countToMove = 0;
        $size = 0;
        $sizeToMove = 0;

        $currentYear = (int) date('Y');
        $yearLimit = (int) $this->option('year');
        if ($yearLimit == 0 || $yearLimit >= $currentYear) {
            $this->error('Ano deve ser informado e deve ser menor que o ano atual');
            exit;
        }

        $path = Config::get('app.paciente_uploads_path');
        $pathOlder = Config::get('app.paciente_uploads_older_path');

        $initialPath = new DirectoryIterator($path);
        foreach ($initialPath as $fileInfo) {
            if ($fileInfo->isDir() && ! $fileInfo->isDot()) {
                $patientFolder = $fileInfo->getFilename();
                $iterator = new DirectoryIterator($path.$patientFolder);
                foreach ($iterator as $info) {
                    if ($info->isFile() && ! $info->isDot()) {
                        $count++;
                        $size += $info->getSize();
                        $year = (int) date('Y', $info->getMTime());
                        if ($year <= $yearLimit) {
                            $countToMove++;
                            $sizeToMove += $info->getSize();
                            if ($execute) {
                                if (! is_dir($pathOlder.$patientFolder)) {
                                    mkdir($pathOlder.$patientFolder);
                                }
                                $filename = $patientFolder .'/'. $info->getFilename();
                                rename($path.$filename, $pathOlder.$filename);
                            }
                        }
                    }
                }
            }
        }

        $size = formatBytes($size);
        $sizeToMove = formatBytes($sizeToMove);

        $this->info("TOTAL FILES: $count. SIZE: $size.");
        if ($execute) {
            $this->info("FILES MOVED: $countToMove. SIZE: $sizeToMove.");
        } else {
            $this->info("FILES TO MOVE: $countToMove. SIZE: $sizeToMove.");
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
//			array('example', InputArgument::REQUIRED, 'An example argument.'),
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
			array('execute', null, InputOption::VALUE_NONE, 'Executa a transferência dos arquivos para o diretório uploads_older', null),
            array('year', null, InputOption::VALUE_REQUIRED, 'Ano limite. Os arquivos modificados anteriormente a esse ano serão movidos', null),
		);
	}
}
