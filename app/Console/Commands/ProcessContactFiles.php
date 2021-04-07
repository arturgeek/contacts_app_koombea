<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\File;
use App\Models\Contact;
use Storage;
//use DB;

class ProcessContactFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contactFiles:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will process the files uploaded with contacts per user.';

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
     * @return int
     */
    public function handle()
    {
        //DB::table('files')->where("state", "wait")->update( ["state" => "complete"] );
        $pending_files = File::where("state", "wait")->get();

        foreach($pending_files as $file)
        {
            $file_name = $file->file_name;
            $mapping = $file->mapping;
            $file_contents = Storage::get($file_name);

            $file_contents = explode("\n", $file_contents);
            $file_headers = $file_contents[0];
            $file_headers = explode(";", $file_headers);
            $mapping = json_decode($mapping, JSON_UNESCAPED_UNICODE);

            Contact::truncate();
            foreach($file_contents as $index => $row)
            {
                if($index == 0 || empty($row)) continue;

                $contact = [];
                $data_row = explode(";", $row);
                foreach( $mapping as $key => $index_in_file )
                {
                    $contact[$key] = $data_row[$index_in_file];
                }

                $contact_is_valid = $this->validateContact( $contact, $index );
                if(empty($contact_is_valid))
                {
                    $contact["cc_type"] = $this->getCreditCardType($contact["cc_num"]);
                    $contact["cc_last"] = substr($contact["cc_num"], -4);
                    $contact["cc_num"] = $this->encryptCreditCard($contact["cc_num"]);

                    $this->createContact($contact);
                }
                else
                {
                    echo $contact_is_valid;
                }
                echo PHP_EOL;
            }

            echo PHP_EOL;
        }
        return 0;
    }

    private function createContact( $contact_data )
    {
        print_r($contact_data);
        $contact = new Contact;
        $contact->name = $contact_data["name"];
        $contact->date_of_birth = $contact_data["date_of_birth"];
        $contact->phone = $contact_data["phone"];
        $contact->address = $contact_data["address"];
        $contact->cc_num = $contact_data["cc_num"];
        $contact->email = $contact_data["email"];
        $contact->cc_type = $contact_data["cc_type"];
        $contact->cc_last = $contact_data["cc_last"];
        $contact->save();
    }

    private function validateContact( $contact , $row_number )
    {
        $illegal_name_characters = "#$%^&*()+=[]';,./{}|:<>?~";
        if(false !== strpbrk($contact["name"], $illegal_name_characters))
        {
            return "Name ".$contact["name"]." has illegal characters - row(".$row_number.")";
        }

        $date_of_birth = $contact["date_of_birth"];
        if( !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date_of_birth) )
        {
            return "Date ".$date_of_birth." has an invalid format - row(".$row_number.")";
        }

        $phone = trim($contact["phone"]);
        if( !preg_match("/^\(\+([0-9]{2})\)\s([0-9]{3})-?([0-9]{3})-?([0-9]{2})-?([0-9]{2})$/", $phone) )
        {
            return "Phone ".$phone." has an invalid format - row(".$row_number.")";
        }

        $email = trim($contact["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            return "Email ".$email." has an invalid format - row(".$row_number.")";
        }

        $address = trim($contact["address"]);
        if ( empty($address) ) 
        {
            return "Address is empty - row(".$row_number.")";
        }

        return "";
    }

    private function validateDate($date)
    {
        $d = DateTime::createFromFormat("Y m d", $date);
        return $d && $d->format($format) == $date;
    }

    private function getCreditCardType( $cc_number )
    {
        if( (str_starts_with($cc_number, "34") || str_starts_with($cc_number, "37")) && strlen($cc_number) == 15 )
        {
            return "American Express";
        }
        if( str_starts_with($cc_number, "300") && (strlen($cc_number) >= 14 && strlen($cc_number) <= 19 ) )
        {
            return "Diners Club International";
        }
        if( str_starts_with($cc_number, "54") && strlen($cc_number) == 16 )
        {
            return "Diners Club USA & CA";
        }

        $first_six = substr($cc_number, 0, 6);
        $first_six = intval($first_six);
        $is_discover_candidate = false;
        if( ($first_six >= 622126  && $first_six <= 622925) )
        {
            $is_discover_candidate = true;
        }
        if( 
            str_starts_with($cc_number, "6011") || str_starts_with($cc_number, "644") || str_starts_with($cc_number, "645") ||
            str_starts_with($cc_number, "646") || str_starts_with($cc_number, "647") || str_starts_with($cc_number, "648") ||
            str_starts_with($cc_number, "649") || str_starts_with($cc_number, "65")
        )
        {
            $is_discover_candidate = true;
        }

        if( $is_discover_candidate && ( strlen($cc_number) >= 16 && strlen($cc_number) <= 19 ) )
        {
            return "Discover Card";
        }
        $is_discover_candidate = false;
        
        $first_four = substr($cc_number, 0, 4);
        $first_four = intval($first_four);
        if( ($first_four >= 3528 && $first_four <= 3589) && ( strlen($cc_number) >= 16 && strlen($cc_number) <= 19 ) )
        {
            return "JCB";
        }

        $first_two = substr($cc_number, 0, 2);
        $first_two = intval($first_two);
        if( ($first_four >= 2221 && $first_four <= 2720) || ($first_two >= 51 && $first_two <= 55) )
        {
            if(count($cc_number) == 16 )
            {
                return "Mastercard";
            }
        }

        if( str_starts_with($cc_number, "4") && (strlen($cc_number) >= 13 && strlen($cc_number) <= 16 ) )
        {
            return "Visa";
        }

        return "Undefined";
    }

    private function encryptCreditCard($cc_number)
    {
        $options1 = [ 'cost1' => 10, 'salt1' => '$P27r06o9!nasda57b2M22' ];
        $cc_crypt = password_hash($cc_number, PASSWORD_BCRYPT, $options1);
        return $cc_crypt;
    }
}
