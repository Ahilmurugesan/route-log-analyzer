<?php

/**
 * Controller for business logic's for the package
 *
 * @author Ahilan
 */

namespace Ahilan\LogViewer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class LogViewerController extends Controller
{

    /**
     * Index function for the package route
     *
     * @param Request $request
     * @return \Illuminate\View\View
     * @author Ahilan
     */
    public function index(Request $request)
    {
        $request_log = $request->log; //Get the log name from the request

        $directories = storage_path('logs/'); //Directory for the log files

        $all_files = File::allFiles($directories); //Getting all files from the log folder

        /**
         * Getting file name of all the log files present in the log directory
         */
        $file_name = [];
        foreach($all_files as $key => $value)
        {
            $file_name[] = $value->getFilename();
        }

        /**
         * Checking if it's a initial request or request from the browser
         */
        if($request_log == null) {
            $file_to_display = $file_name[0];
        }else{
            $file_to_display = Crypt::decryptString($request_log);
        }

        /**
         * Getting data from the log files
         */
        $log = array();
        $file = File::get(storage_path('logs/'.$file_to_display));

        preg_match_all($this->pattern_log('dates'), $file, $headings);

        if (!is_array($headings)) {
            return $log;
        }

        $log_data = preg_split($this->pattern_log('dates'), $file);
        if ($log_data[0] < 1) {
            array_shift($log_data);
        }

        foreach ($headings as $h)
        {
            for ($i = 0, $j = count($h); $i < $j; $i++)
            {
                foreach ($this->error_level() as $level => $color)
                {
                    if (strpos(strtolower($h[$i]), '.' . $level) || strpos(strtolower($h[$i]), $level . ':'))
                    {
                        preg_match($this->pattern_log('log_msg') . $level . $this->pattern_log('log_msg_full'), $h[$i], $current);

                        if (!isset($current[4])) {
                            continue;
                        }

                        $log[] = array(
                            'context' => $current[3],
                            'level' => [$level, $color],
                            'folder' =>'',
                            'date' => $current[1],
                            'text' => $current[4],
                            'desc' => preg_replace("/^\n*/", '', $log_data[$i])
                        );
                    }
                }
            }
        }

        if (empty($log))
        {

            $lines = explode(PHP_EOL, $file);
            $log = [];
            foreach ($lines as $key => $line) {
                $log[] = [
                    'context' => '',
                    'level' => '',
                    'date' => $key + 1,
                    'text' => $line,
                    'desc' => '',
                ];
            }

        }
        $final_log = array_reverse($log);

        return view('logViewer::logviewer', compact('final_log', 'file_to_display', 'file_name'));
    }

    /**
     * Regex Pattern for the message detection
     *
     * @param $value
     * @return mixed
     * @author Ahilan
     */
    public function pattern_log($value)
    {
        $tempPatterns = [
            'dates' => '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/',
            'log_msg' => '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)',
            'log_msg_full' => ': (.*?)( in .*?:[0-9]+)?$/i',
            'files' => '/\{.*?\,.*?\}/i',
        ];
        return $tempPatterns[$value];
    }

    /**
     * To get the error level for the package
     *
     * @return array
     * @author Ahilan
     */
    public function error_level()
    {
        $error_level = [
                        'debug' => '#4caf50',
                        'info' => '#9c27b0',
                        'notice' => '#607d8b',
                        'warning' => '#ffc107',
                        'error' => '#ff5722',
                        'critical' => '#ed5249',
                        'alert' => '#ff9800',
                        'emergency' => '#f44036',
                        'processed' => '#4cbd4f',
                        'failed' => '#000000'
                    ];
        return $error_level;
    }

    /**
     * Download function for the log file
     *
     * @param $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @author Ahilan
     */
    public function download($file)
    {
        $file_download = $file;
        $path = storage_path('logs/'.$file_download);
        return response()->download($path);
    }
}
