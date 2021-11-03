<?php
    /*
    | Author : amir changizi
    | Email  : amir.changizi.5@gmail.com
    | Date   : ۲۰۲۱-11-03
    | TIME   : ۰۶:۲۹ بعدازظهر
    */

    use SamanBank\Validation\SamanValidation;

    if (! function_exists('samanValidation'))
    {
        function samanValidation()
        {
            return new SamanValidation();
        }
    }

    if (! function_exists('bankCs'))
    {
        function bankCs($nationalCode)
        {
            $saman = new SamanValidation();
            $saman->bankCs($nationalCode);
        }
    }



    if (! function_exists('samanPersonalInfo'))
    {
        function samanPersonalInfo($nationalCode ,$birthDate)
        {
            $saman = new SamanValidation();
            return $saman->personalInfo($nationalCode ,$birthDate);
        }
    }

    if (! function_exists('postInfo'))
    {
        function postInfo($postCode)
        {
            $saman = new SamanValidation();
            return $saman->postInfo($postCode);
        }
    }

    if (! function_exists('mobileMatching'))
    {
        function mobileMatching($mobile, $nationalCode)
        {
            $saman = new SamanValidation();
            return $saman->mobileMatching($mobile, $nationalCode);
        }
    }
