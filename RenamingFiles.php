<?php


    class RenamingFiles
    {

      private string $path_to_source = 'E:/Music/music_source/';

      private string $path_to_ready = 'F:/';

      private int $count_in_source = 0;

      private array $array_in_source = [];

      private array $array_in_ready = [];

      private int $index = 1;

      private string $loader = '-';

      private int $dir = 0;


      public function __construct()
      {
          try {
              if (!is_dir($this->path_to_source)) throw new \Exception("не удалось найти указанную папку: {$this->path_to_source}");
              if (!is_dir($this->path_to_ready))  throw new \Exception("не удалось найти указанную папку: {$this->path_to_ready}");

              $this->set_array_in_source();
              $this->go_rename();
          }catch (\Exception $e){
              echo $e->getMessage();
          }
      }

      private function set_array_in_source(){
          $filtered = $this->filter_mp3($this->my_scan_dir($this->path_to_source));

          $this->count_in_source =  count($filtered);
          $this->array_in_source = $filtered;
      }

      private function filter_mp3(array $source): array
      {
          $sourceFiltered = [];
          foreach ($source as $fileName){
              $extension = pathinfo("{$this->path_to_source}$fileName")['extension'];
              if ($extension == 'mp3') {
                  $sourceFiltered[] = $fileName;
              }
          }

          return $sourceFiltered;
      }

      private function go_rename(){
          set_time_limit(10000000);

          $this->clear_dir_ready();

          $this->createDir();


          for ($this->index; $this->index <= $this->count_in_source; $this->index++) {
              if ($this->index % 500 === 0) $this->createDir();

              $key =  array_rand($this->array_in_source, 1);
              $filename = $this->array_in_source[$key];
              unset($this->array_in_source[$key]);

              $new_filename = $this->parse_name($filename, $this->index);
              $this->array_in_ready[] = $new_filename;

              $path_to_source = "{$this->path_to_source}$filename";
              $path_to_ready = "{$this->path_to_ready}/dir-{$this->dir}/$new_filename";

              if (!file_exists($path_to_source)) throw new \Exception("файл не найден $path_to_source");
              if (!copy($path_to_source, $path_to_ready)) throw new \Exception("ошибка копирования $path_to_ready");
              $this->viewConsole();
              sleep(0.5);
          }

           echo 'success';
      }

      private function createDir(){
          $this->dir++;
          $newDir = $this->path_to_ready . "dir-" . $this->dir;
          if (!mkdir($newDir)) throw new \Exception("не удалось создать папку $newDir");
      }

      private function viewConsole(){
            $p = round(($this->index / $this->count_in_source) * 100, 1) ;
            $this->loader = $this->loader === '-' ? '\\' : (($this->loader === '\\') ? '|' : (($this->loader === '|') ? '/' : '-'));
            echo ".................{$this->loader} $p% " . PHP_EOL ;
      }

      private function parse_name($name, $i){
          $vowels = [
              '(zaycev.net)', 'muzlome_', '(muzofon.com)', '(music7s.com), (music4love.net)', '(NaitiMP3.ru)', '(zf.fm)', '(muztron.com)', '(music7s.com)',
              '(music4love.net)', '(music2k.com)', '(www.petamusic.ru)'
          ];
          switch (strlen($i)){
              case 1:
                  $i = "000$i";
                  break;
              case 2:
                  $i = "00$i";
                  break;
              case 3:
                  $i = "0$i";
                  break;
              default:
                  break;
          };


          $name = "$i - ".str_replace($vowels, "", $name);
          return $name;
      }

      private  function clear_dir_ready()
      {
            $listDir = $this->my_scan_dir($this->path_to_ready);
            foreach ($listDir as $dir){
                $listFiles = $this->my_scan_dir($this->path_to_ready . $dir);
                foreach ($listFiles as $file){
                    unlink($this->path_to_ready.$dir.'/'.$file);
                }
                rmdir($this->path_to_ready.$dir);
            }
      }

      private function my_scan_dir($dir): bool|array
      {
            return array_diff(scandir($dir), [".", ".."]);
      }

    }

    new RenamingFiles();