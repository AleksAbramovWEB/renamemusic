<?php


class DeleteThumbFiles
{
    protected string $path = 'E:\Photo\алтай 2021';

    public function __construct()
    {
        $listFiles = $this->my_scan_dir();
        foreach ($listFiles as $file){
            if (!strripos($file, 'thumb')) continue;
            echo $this->path.'/'.$file . PHP_EOL;
            unlink($this->path.'/'.$file);
        }
    }

    private function my_scan_dir(): bool|array
    {
        return array_diff(scandir($this->path), [".", ".."]);
    }
}

new DeleteThumbFiles();