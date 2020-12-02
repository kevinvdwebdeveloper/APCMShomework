<?Php

    //Validate input for password
    //min 6
    //max 20
    //at least one special char
    //OOP (two classes)
    class Validation {
      protected $password;
      protected ValidationCheck $validationCheck;

      public function __construct($checks){
        $this->validationCheck = new ValidationCheck($checks);
      }

      public function validate($password){
        $this->validationCheck->password = $password;
        return $this->validationCheck->validateChecks();
      }
    }



    class ValidationCheck extends Validation {
      public $validationChecks = [
        "minChar" => '',
        "maxChar" => '',
        "specialChar" => '',
      ];

      public function __construct($checks){
        foreach ($checks as $check => $value) {
          $this->validationChecks[$check] = $value;
        }
      }

      public function validateChecks() {
        foreach ($this->validationChecks as $check => $value) {
          if(isset($value)) {
            $checkMethod = $check . 'Check';
            if(method_exists($this, $checkMethod)){

              $result = $this->$checkMethod();
              var_dump($result);
              if($result == false){
                  return false;
              }
            }
          }
        }

        return true;
      }

      private function minCharCheck() {
        if(strlen($this->password) >= $this->validationChecks['minChar']){
          return true;
        } else {
          return false;
        }
      }

      private function maxCharCheck() {
        if(strlen($this->password) <= $this->validationChecks['maxChar']){
          return true;
        } else {
          return false;
        }
      }

      private function specialCharCheck() {
        if(preg_match("/[^a-zA-Z0-9]+/", $this->password) == true){
          return true;
        } else {
          return false;
        }
      }
    }

    $password = '123456-';

    $validation = new Validation([
      "minChar" => 6,
      "maxChar" => 20,
      "specialChar" => true,
    ]);

    if($validation->validate($password)){
      echo 'Good';
    } else {
      echo 'bad';
    }

?>
