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
