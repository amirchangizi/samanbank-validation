<?php
    /*
    | Author : amir changizi
    | Email  : amir.changizi.5@gmail.com
    | Date   : ۲۰۲۱-11-03
    | TIME   : ۰۵:۱۵ بعدازظهر
    */

    namespace SamanBank\Validation;

    use SoapClient;

    class SamanValidation
    {
        public $url;

        public $username;

        public $password;

        public $client;

        public function __construct()
        {
            $this->url = config('services.cr24.url');
            $this->username = config('services.cr24.username');
            $this->password = config('services.cr24.password');
            $this->client = new SoapClient($this->url, ["trace" => 1, "exception" => 0]);
        }

        public function bankCs($nationalCode)
        {
            $result = $this->client->__soapCall('BankCs', [
                'BankCs' => [
                    "accountModel" => $this->accountModel(),
                    'nationalCode' => $nationalCode,
                ]
            ]);

            if (!$result->BankCsResult->ServiceStatus == "Success")
                throw \Exception('BankCs faild.');

            return $result->BankCsResult;
        }

        public function personalInfo($nationalCode, $birthDate): array
        {
            [$y, $m, $d] = explode('-', $birthDate);
            $result = $this->client->__soapCall('RegInfo', [
                'RegInfo' => [
                    "accountModel" => $this->accountModel(),
                    'nationalCode' => $nationalCode,
                    'birthDate'    => [
                        "Day"   => $d,
                        "Month" => $m,
                        "Year"  => $y
                    ]
                ]
            ]);

            if (!$result->RegInfoResult->ServiceStatus == "Success")
                throw \Exception('region info mismatch');

            return (array)$result->RegInfoResult;
        }

        public function postInfo(int $postCode)
        {
            $result = $this->client->__soapCall('PostInfo', [
                'PostInfo' => [
                    "accountModel" => $this->accountModel(),
                    'postCode'     => $postCode
                ]
            ]);

            if (!$result->PostInfoResult->ServiceStatus == "Success")
                throw \Exception('post code mismatch');

            return $result->PostInfoResult->Result;
        }

        public function mobileMatching($mobile, $nationalCode)
        {
            ini_set('default_socket_timeout', 600);
            $result = $this->client->__soapCall("MobileAndNationalCodeMatching", [
                "MobileAndNationalCodeMatching" => [
                    "accountModel" => $this->accountModel(),
                    "nationalCode" => $nationalCode,
                    "mobileNumber" => $mobile
                ]
            ]);

            if (!$result->MobileAndNationalCodeMatchingResult->ServiceStatus == "Success")
                return false;

            return (int)$result->MobileAndNationalCodeMatchingResult->Result;
        }

        protected function accountModel()
        {
            return [
                "UserName" => $this->username,
                "PassWord" => $this->password
            ];
        }

    }
