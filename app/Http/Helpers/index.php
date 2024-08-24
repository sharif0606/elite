<?php


function Replace($data) {
    $data = str_replace("!", "", $data);
    $data = str_replace("@", "", $data);
    $data = str_replace("#", "", $data);
    $data = str_replace("$", "", $data);
    $data = str_replace("%", "", $data);
    $data = str_replace("^", "", $data);
    $data = str_replace("&", "", $data);
    $data = str_replace("*", "", $data);
    $data = str_replace("(", "", $data);
    $data = str_replace(")", "", $data);
    $data = str_replace("?", "", $data);
    $data = str_replace("+", "", $data);
    $data = str_replace("=", "", $data);
    $data = str_replace(",", "", $data);
    $data = str_replace(":", "", $data);
    $data = str_replace(";", "", $data);
    $data = str_replace("|", "", $data);
    $data = str_replace("'", "", $data);
    $data = str_replace('"', "", $data);
    $data = str_replace("  ", "-", $data);
    $data = str_replace(" ", "-", $data);
    $data = str_replace(".", "-", $data);
    $data = str_replace("__", "-", $data);
    $data = str_replace("_", "-", $data);
    return strtolower($data);
 }



function encryptor($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
    $secret_key = 'beatnik#technolgoy_sampreeti';
    $secret_iv = 'beatnik$technolgoy@sampreeti';

        // hash
    $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

        //do the encyption given text/string/number
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
            //decrypt the given text/string/number
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}


// The function to count words in Unicode  strings
function countUnicodeWords( $unicode_string ){
    // First remove all the punctuation marks & digits
    $unicode_string = preg_replace('/[[:punct:][:digit:]]/', '', $unicode_string);
    // Now replace all the whitespaces (tabs, new lines, multiple spaces) by single space
    $unicode_string = preg_replace('/[[:space:]]/', ' ', $unicode_string);
    // The words are now separated by single spaces and can be splitted to an array
    // I have included \n\r\t here as well, but only space will also suffice
    $words_array = preg_split( "/[\n\r\t ]+/", $unicode_string, 0, PREG_SPLIT_NO_EMPTY );
    // Now we can get the word count by counting array elments
    return count($words_array);
}



function limitWordShow($string, $word_limit)
{
    $words = explode(" ",$string);
    return implode(" ", array_splice($words, 0, $word_limit));
}

function currentUserId(){
	return encryptor('decrypt', request()->session()->get('userId'));
}

function currentUser(){
	return encryptor('decrypt', request()->session()->get('roleIdentity'));
}

function company(){
    return ['company_id' => encryptor('decrypt', Session::get('companyId'))];
}
function companyAccess(){
    return encryptor('decrypt', Session::get('companyAccess'));
}



function invoice(){
	return [
		['image'=>'','link'=>''],
		['image'=>'','link'=>'']
	];
}
function getBangladeshCurrency($number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
        6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
        11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen',
        15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty',
        50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );
    $digits = array('', 'Hundred', 'Thousand', 'Lac', 'Crore');
    
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' ' : null;
            $str[] = ($number < 21) 
                ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred 
                : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else {
            $str[] = null;
        }
    }
    
    $Taka = implode('', array_reverse($str));
    $decimal_part = (int)$decimal;
    $poysa = '';
    if ($decimal_part) {
        $poysa_words = '';
        if ($decimal_part < 20) {
            $poysa_words = $words[$decimal_part];
        } else {
            $tens = floor($decimal_part / 10) * 10;
            $units = $decimal_part % 10;
            $poysa_words = $words[$tens];
            if ($units) {
                $poysa_words .= ' ' . $words[$units];
            }
        }
        $poysa = " and " . $poysa_words . ' Paisa';
    }
    return ($Taka ? $Taka . 'Taka' : '') . $poysa .' '. 'Only.';
}

// function getBangladeshCurrency( $number)
// {
//     $decimal = round($number - ($no = floor($number)), 2) * 100;
//     $hundred = null;
//     $digits_length = strlen($no);
//     $i = 0;
//     $str = array();
//     $words = array(0 => '', 1 => 'One', 2 => 'Two',
//         3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
//         7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
//         10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
//         13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
//         16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
//         19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
//         40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
//         70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
//     $digits = array('', 'Hundred','Thousand','Lac', 'Crore');
//     while( $i < $digits_length ) {
//         $divider = ($i == 2) ? 10 : 100;
//         $number = floor($no % $divider);
//         $no = floor($no / $divider);
//         $i += $divider == 10 ? 1 : 2;
//         if ($number) {
//             $plural = (($counter = count($str)) && $number > 9) ? '' : null;
//             $hundred = ($counter == 1 && $str[0]) ? '  ' : null;
//             $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
//         } else $str[] = null;
//     }
//     $Taka = implode('', array_reverse($str));
//     $poysa = ($decimal) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Poysa' : '';
//     return ($Taka ? $Taka . 'Taka ' : '') . $poysa ;
// }

// if ( ! function_exists( 'money_format' ) ) {

//     function money_format($number)
//     {

//         $decimal = (string)($number - floor($number));
//             $money = floor($number);
//             $length = strlen($money);
//             $delimiter = '';
//             $money = strrev($money);

//             for($i=0;$i<$length;$i++){
//                 if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
//                     $delimiter .=',';
//                 }
//                 $delimiter .=$money[$i];
//             }

//             $result = strrev($delimiter);
//             $decimal = preg_replace("/0\./i", ".", $decimal);
//             $decimal = substr($decimal, 0, 3);

//             if( $decimal != '0'){
//                 $result = $result.$decimal;
//             }

//             return $result;

//       }
// }
if (!function_exists('money_format')) {
    function money_format($number)
    {
        // Check if the number is negative
        $isNegative = $number < 0;

        // Work with the absolute value of the number
        $number = abs($number);

        // Separate the number into its integer and decimal parts
        $decimal = number_format($number - floor($number), 2, '.', '');
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        // Add commas as thousand separators
        for ($i = 0; $i < $length; $i++) {
            if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
                $delimiter .= ',';
            }
            $delimiter .= $money[$i];
        }

        $result = strrev($delimiter);
        $decimal = substr($decimal, 1); // Remove the leading zero from the decimal part

        // Append the decimal part to the result
        $result = $result . $decimal;

        // Add the minus sign back if the number was negative
        if ($isNegative) {
            $result = '-' . $result;
        }

        return $result;
    }
}