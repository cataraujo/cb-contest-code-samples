#!C:\php\php.exe -q
<?php
ini_set('auto_detect_line_endings', true);
class EmailSender extends Thread {
    private $file;
    private $output;
        public function __construct($file){
            $this->file = $file;
            $this->output = "";
        }
        public function run() {


           
            $subject = "Event Invitation";
            
            $message = "<b>You are invited to our event!!</b>";
            $message .= "<h1><a href=\"https://domain.com/rsvp.php\">Click here to RSVP</a></h1>";
            
            $header = "From:abc@somedomain.com \r\n";
            $header .= "Cc:afgh@somedomain.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            
           
            
            echo "Running file =>".$this->file;
            $fileCSV = fopen($this->file,"r") or die("Couldn't open file!");
   
            flock($fileCSV,LOCK_EX);
          
          
            $csvAsArray = fgetcsv($fileCSV);
            
              //todo: read file, iterate over emails and send email
            foreach($csvAsArray as $key=>$value){
                $to = $value;
                try{
                $retval = true;//mail ($to,$subject,$message,$header);
                }catch(Exception $ex){

                }
                if( $retval == true ) {
                   $this->output.= "<br> Message sent successfully...".$to."<br> ";
                }else {
                    $this->output.=  "<br> Message could not be sent...".$to."<br> ";
                }
                    
            }
            echo $this->output;
            flock($fileCSV,LOCK_UN);
            fclose($fileCSV);
           
            
        }


}



if(isset($argv[1])){
  $csvfile = $argv[1];

 $filelist = explode(',',$csvfile);

 $jobs = array();
 $pool = new Pool(8);

 foreach($filelist as $csv){
    $pool->submit(new EmailSender($csv));
    }
    $pool->shutdown();
    $pool->collect(function(EmailSender $emailTask){
        echo $emailTask->output;
        return $emailTask->isGarbage();
      });

}
?>