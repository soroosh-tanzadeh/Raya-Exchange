<?php

/*
 *  Copyright (C) 2019 maxivity
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\ProcessUtils;

class Serve extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application on the PHP development server';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function fire() {
        chdir('/');

        $host = $this->input->getOption('host');

        $port = $this->input->getOption('port');

        $base = ProcessUtils::escapeArgument($this->laravel->basePath());

        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));

        $this->info("Laravel development server started on http://{$host}:{$port}/");

        if (defined('HHVM_VERSION')) {
            if (version_compare(HHVM_VERSION, '3.8.0') >= 0) {
                passthru("{$binary} -m server -v Server.Type=proxygen -v Server.SourceRoot={$base}/ -v Server.IP={$host} -v Server.Port={$port} -v Server.DefaultDocument=server.php -v Server.ErrorDocument404=server.php");
            } else {
                throw new Exception("HHVM's built-in server requires HHVM >= 3.8.0.");
            }
        } else {
            passthru("{$binary} -S {$host}:{$port} {$base}/server.php");
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return [
            ['host', null, InputOption::VALUE_OPTIONAL, 'The host address to serve the application on.', 'localhost'],
            ['port', null, InputOption::VALUE_OPTIONAL, 'The port to serve the application on.', 8000],
        ];
    }

}
