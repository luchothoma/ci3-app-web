<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller {

    private $baseMigrationsAndSeedsPath = "database/";
    private $migrationsFolder = "migrations/";
    private $seedsFolder = "seeds/";

    private function baseDatabasePath(){ return APPPATH.$this->baseMigrationsAndSeedsPath; }
    private function migrationsPath() { return $this->baseDatabasePath().$this->migrationsFolder; }
    private function seedsPath() { return $this->baseDatabasePath().$this->seedsFolder; }
    private function baseModelsPath() { return APPPATH."models/"; }

    public function __construct() {
        parent::__construct();
        /*
        // can only be called from the command line
        if (!$this->input->is_cli_request()) {
            exit('Direct access is not allowed. This is a command line tool, use the terminal');
        }
        */
        $this->load->dbforge();

        // initiate faker
        // https://github.com/fzaninotto/Faker
        require_once APPPATH.'third_party/fakeData/index.php';
        $this->faker = Faker\Factory::create('es_AR'); // Faker\Factory::create();

    }

    public function index(){
        echo '<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>';
        echo '<style>body{background:black;color:whitesmoke;}input[type=text]{width:100%;border:1px grey dotted;background:black;padding:2px 3px;color:grey;}#result{padding:10px 5px;}.error{color:red;}.ok{color:lightgreen;}</style>';
        echo '<body>';
        echo '<input type="text"/>';
        echo '<div id="result"><div>';
        echo '<script>
        function executeCommand( data ){
            data = "Tools "+data;
            let path = data.split(" ").join("/");
            $.get(path,function(data, status){
                let classe = (status==""? "Error":"OK");
                data = (status==""? "Command NOT found.": data);
                data = data.split("\n").join("<br>");
                writeLineConsole("<b>"+classe+"</b>: "+data);
            });
        }

        function writeLineConsole( text ){
            $("#result").prepend("<p>"+text+"</p><hr></hr>");
        }

        var stack = new Array();
        var position = 0;

        $(document).ready( ()=>{
            $("input[type=text]").keypress(function (e) {
              if (e.which == 13) {
                let commandText = $(this).val();
                if(commandText != "")
                {
                    stack[ stack.length ] = commandText;
                    position++;
                    executeCommand(commandText);
                }
                else
                {
                    writeLineConsole("Empty command, write something to execute.");
                }
                $(this).val("");
              }
            });

            $("input[type=text]").keydown(function (e) {
              if(e.keyCode == 38)//Up arrow
              {
                if(position != 0)
                {
                    position --;
                    $(this).val( stack[position] );
                }
              }
              else if(e.keyCode == 40)//Down arrow
              {
                if(position != stack.length)
                {
                    position ++;
                    $(this).val( stack[position] );
                }
              }
            });
        });
        </script>';
        echo '</body>';
    }

    public function message($to = 'World') {
        echo "Hello {$to}!" . PHP_EOL;
    }

    public function initialize(){
        if (!file_exists( $this->baseDatabasePath() ))
        {
            echo $this->baseDatabasePath()." DOES NOT exist !\n";
            mkdir( $this->baseDatabasePath(), 0777, true);
            echo $this->baseDatabasePath()." created with success !\n";
        }
        else
        {
            echo $this->baseDatabasePath()." already exist !\n";
        }

        if (!file_exists( $this->migrationsPath() ))
        {
            echo $this->migrationsPath()." DOES NOT exist !\n";
            mkdir( $this->migrationsPath(), 0777, true);
            echo $this->migrationsPath()." created with success !\n";
        }
        else
        {
            echo $this->migrationsPath()." already exist !\n";
        }

        if (!file_exists( $this->seedsPath() ))
        {
            echo $this->seedsPath()." DOES NOT exist !\n";
            mkdir( $this->seedsPath(), 0777, true);
            echo $this->seedsPath()." created with success !\n";
        }
        else
        {
            echo $this->seedsPath()." already exist !\n";
        }
    }

    public function help() {
        $result = "The following are the available command line interface commands\n\n";
        $result .= "php index.php tools migration \"file_name\"         Create new migration file\n";
        $result .= "php index.php tools migrate [\"version_number\"]    Run all migrations. The version number is optional.\n";
        $result .= "php index.php tools seeder \"file_name\"            Creates a new seed file.\n";
        $result .= "php index.php tools seed \"file_name\"              Run the specified seed file.\n";

        echo $result . PHP_EOL;
    }

    public function migration($name) {
        $this->make_migration_file($name);
    }

    public function migrate($version = null) {
        $this->load->library('migration');

        if ($version != null) {
            if ($this->migration->version($version) === FALSE) {
                show_error($this->migration->error_string());
            } else {
                echo "Migrations run successfully" . PHP_EOL;
            }

            return;
        }

        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "Migrations run successfully" . PHP_EOL;
        }
    }

    protected function make_migration_file($name) {
        $date = new DateTime();
        $timestamp = $date->format('YmdHis');

        $table_name = strtolower($name);

        $path = $this->migrationsPath()."$timestamp" . "_" . "$name.php";

        $my_migration = fopen($path, "w") or die("Unable to create migration file!");

        $migration_template = "
            <?php

            class Migration_$name extends CI_Migration {

                public function up() {
                    \$this->dbforge->add_field(array(
                        'id' => array(
                            'type' => 'INT',
                            'constraint' => 11,
                            'auto_increment' => TRUE
                        )
                    ));
                    \$this->dbforge->add_key('id', TRUE);
                    \$this->dbforge->create_table('$table_name');
                }

                public function down() {
                    \$this->dbforge->drop_table('$table_name');
                }

            }
        ";

        fwrite($my_migration, $migration_template);

        fclose($my_migration);

        echo "$path migration has successfully been created." . PHP_EOL;
    }

    public function seeder($name) {
        $this->make_seed_file($name);
    }

    public function seed($name) {
        $seeder = new Seeder();

        $seeder->call($name);
    }

    protected function make_seed_file($name) {
        $path = $this->seedsPath() ."$name.php";

        $my_seed = fopen($path, "w") or die("Unable to create seed file!");

        $seed_template = "<?php

            class $name extends Seeder {

                private \$table = 'users';

                public function run() {
                    \$this->db->truncate(\$this->table);

                    //seed records manually
                    \$data = [
                        'user_name' => 'admin',
                        'password' => '9871'
                    ];
                    \$this->db->insert(\$this->table, \$data);

                    //seed many records using faker
                    \$limit = 33;
                    echo \"seeding \$limit user accounts\";

                    for (\$i = 0; \$i < \$limit; \$i++) {
                        echo \".\";

                        \$data = array(
                            'user_name' => \$this->faker->unique()->userName,
                            'password' => '1234',
                        );

                        \$this->db->insert(\$this->table, \$data);
                    }

                    echo PHP_EOL;
                }
            }
        ";

        fwrite($my_seed, $seed_template);

        fclose($my_seed);

        echo "$path seeder has successfully been created." . PHP_EOL;
    }

    public function model($name) {
        $this->make_model_file($name);
    }

    protected function make_model_file($name) {
        $path = $this->baseModelsPath()."/$name.php";

        $my_model = fopen($path, "w") or die("Unable to create model file!");

        $model_template = "
        <?php (defined('BASEPATH')) OR exit('No direct script access allowed');

        class $name extends OWN_Model {

            public function __construct() {
                parent::__construct();
            }
        }
        ";

        fwrite($my_model, $model_template);

        fclose($my_model);

        echo "$path model has successfully been created." . PHP_EOL;
    }

}