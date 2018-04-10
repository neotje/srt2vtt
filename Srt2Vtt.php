<?php
/* 
# srt2vtt

This is a PHP script to convert a srt format to webvtt format.

## Using the script

1. Download the Scipt [here](https://raw.githubusercontent.com/neotje/srt2vtt/master/Srt2Vtt.php)
2. Place the scipt in your project folder
3. An example:
```php
require_once("./path/to/script.php");
$convert = new \theOne\Srt2Vtt("./path/to/input.srt", "./path/to/ouput.vtt");
$convert->run();
```

## Authors

* Neo Hop [Neotje](https://github.com/neotje) - changed the script to srt2vtt

## Acknowledgments

* [Leda Ferreira](https://github.com/leda-ferreira) - Wrote the script for vtt2srt [This Script](https://github.com/leda-ferreira/vtt2srt/blob/master/src/Vtt2Srt.php)
*/

namespace theOne;

class Srt2Vtt
{
    private $input_file;
    private $output_file;
    public function __construct($input_file, $output_file)
    {
        $this->input_file = $input_file;
        $this->output_file = $output_file;
    }
    public function run()
    {
        $contents = file_get_contents($this->input_file);
        if ($contents === false) {
            $message = "Error: Failed to read '{$this->input_file}'.";
            throw new Exception($message);
        }
        $output = $this->convert($contents);
        $result = file_put_contents($this->output_file, $output);
        if ($result === false) {
            $message = "Error: Failed to write to '{$this->output_file}'.";
            throw new Exception($message);
        }
        return 1;
    }
    private function convert($contents)
    {
        $lines = $this->split($contents);
        $output = 'WEBVTT'.PHP_EOL; // adding the WEBVTT header
        $i = 0;
        foreach ($lines as $line) {
            $pattern1 = '#(\d{2}):(\d{2}):(\d{2})\,(\d{3})#'; // '01:52:52.554'
            $pattern2 = '#(\d{2}):(\d{2})\,(\d{3})#'; // '00:08.301'
            $m1 = preg_match($pattern1, $line);
            if (is_numeric($m1) && $m1 > 0) {
                $i++;
                $line = preg_replace($pattern1, '$1:$2:$3.$4' , $line);
            }
            else {
                $m2 = preg_match($pattern2, $line);
                if (is_numeric($m2) && $m2 > 0) {
                    $i++;
                    $line = preg_replace($pattern2, '00:$1:$2.$3', $line);
                }
            }

            $output .= $line . PHP_EOL;
        }
        return $output;
    }
    private function split($contents)
    {
        $lines = explode("\n", $contents);
        if (count($lines) === 1) {
            $lines = explode("\r\n", $contents);
            if (count($lines) === 1) {
                $lines = explode("\r", $contents);
            }
        }
        return $lines;
    }
}
