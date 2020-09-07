<?php


    class RenamingFiles
    {

      private $path_to_source = 'music_source/';

      private $path_to_ready = 'E:/';

      private $count_in_source;

      private $array_in_source = [];

      private $count_in_ready;

      private $array_in_ready = [];

      private $index = 1;


      public function __construct()
      {
          $this->set_count_in_source();
          $this->set_array_in_source();
          if (isset($_POST['go_rename']))
              $this->go_rename();


      }

          public function get_path_to_source(){
              return $this->path_to_source;
          }

          public function get_path_to_ready(){
              return $this->path_to_ready;
          }

        /**
         * @return mixed
         */
        public function get_count_in_source()
        {
            return $this->count_in_source;
        }

        /**
         * @return array
         */
        public function get_array_in_source()
        {
            return $this->array_in_source;
        }

      private function set_count_in_source()
      {
         $this->count_in_source =  count($this->my_scan_dir($this->path_to_source));
      }

      private function set_array_in_source(){
          $this->array_in_source = $this->my_scan_dir($this->path_to_source);
      }

      private function go_rename(){
          set_time_limit(1000);

          $this->clear_dir_ready();

          for ($this->index; $this->index <= $this->count_in_source; $this->index++) {

              $key =  array_rand($this->array_in_source, 1);
              $filename = $this->array_in_source[$key];
              unset($this->array_in_source[$key]);

              $new_filename = $this->parse_name($filename, $this->index);
              $this->array_in_ready[] = $new_filename;

              copy("{$this->path_to_source}$filename", "{$this->path_to_ready}$new_filename");

              $this->json_log();
          }


          var_dump($this->array_in_ready);
      }

      private function parse_name($name, $i){
          $vowels = [
              '_(zaycev.net)', 'muzlome_', '(muzofon.com)', '(music7s.com), (music4love.net)'
          ];
          $name = "$i-".str_replace($vowels, "", $name);
          return $name;
      }

      private  function clear_dir_ready()
      {
            $list = $this->my_scan_dir($this->path_to_ready);
            foreach ($list as $file)
                unlink($this->path_to_ready.$file);
      }

      private function my_scan_dir($dir){
            return array_diff(scandir($dir), [".", ".."]);
      }

      private function json_log(){

          $percent = ($this->index / $this->count_in_source) * 100;

          $data = [
              "files_ready" => $this->array_in_ready,
              "percent" => (int)$percent
          ];

          file_put_contents('data.json',json_encode($data));
      }

        private function json_exit(){
            file_put_contents('data.json',json_encode(["json_exit" => 1]));
        }







    }