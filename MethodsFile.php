<?php

include_once('Connection.php');

class MethodsClass extends Connection
{

    /**
     * ====================================== CDN Links & Other JS Scripts functions ======================================
     */

    public function cssLinks(): string
    {

        $css = '';
        $css .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">';
        $css .= '<link  rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">';

        return $css;
    }

    public function jsLinks(): string
    {
        $js = '';
        $js .= '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
        $js .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>';
        $js .= '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>';
        $js .= '<script src="js-scripts/script.js"></script>';

        return $js;
    }

    /**
     * ====================================== CDN Links & Other JS Scripts functions ======================================
     */





    /**
     * ================================================ DB functions ================================================
     */

    public function storePhoneNumber(array $data): string // store single contact number in database
    {
        $last_id = '';
        $con = $this->connect();
        $sql = " INSERT INTO `all_phone_book` (`prefix` , `country_short_code` , `number` , `name`) VALUES ('" . $data['prefix'] . "','" . $data['country_short_code'] . "' ,'" . $data['number'] . "' ,'" . $data['name'] . "' ) ";
        $result = $con->query($sql);
        if ($result) {
            $last_id = $con->insert_id;
            $con->close();
            return $last_id;
        } else {
            $con->close();
            return $last_id;
        }
    }

    public function updatePhoneNumber(array $data): string // update single contact number in database
    {
        $contact_id = '';
        $con = $this->connect();
        $sql = " UPDATE `all_phone_book` SET `prefix`= '" . $data['prefix'] . "' , `country_short_code`= '" . $data['country_short_code'] . "' , `number`= '" . $data['number'] . "' , `name`= '" . $data['name'] . "' WHERE `id`='" . $data['id'] . "' ";
        $result = $con->query($sql);
        if ($result) {
            $contact_id = $data['id'];
            $con->close();
            return $contact_id;
        } else {
            $con->close();
            return $contact_id;
        }
    }

    public function checkForDuplicate(array $data): string // check for duplicate contact number in database
    {
        $orignal_id = '';
        $and_where_id_not_equal_to = '';
        $con = $this->connect();
        if ($data['id'] != "") {
            $and_where_id_not_equal_to = " AND `id` != '" . $data['id'] . "' ";
        }
        $sql = " SELECT * FROM `all_phone_book` WHERE `prefix`= '" . $data['prefix'] . "' AND `number`= '" . $data['number'] . "'  $and_where_id_not_equal_to ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $orignal_id = $row['id'];
            $con->close();
            return $orignal_id;
        } else {
            $con->close();
            return $orignal_id;
        }
    }

    public function getAllPhoneNumbers(string $keywords): array // fetch all contacts numbers from database
    {
        $phone_numbers = [];
        $con = $this->connect();
        if ($keywords !== "") {
            $sql = " SELECT * FROM `all_phone_book` where (`prefix` like '%$keywords%' OR `name` like '%$keywords%' OR `number` like '%$keywords%' OR `country_short_code` like '%$keywords%') AND `deleted` = '0' order by `id` DESC ";
        } else {
            $sql = " SELECT * FROM `all_phone_book` where `deleted` = '0' order by `id` DESC ";
        }

        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $phone_numbers[] = $row;
            }
            $con->close();
            return $phone_numbers;
        } else {
            $con->close();
            return $phone_numbers;
        }
    }

    public function deleteContactNumber(int $id): string // delete single contact number from database
    {
        $contact_id = '';
        $con = $this->connect();
        $sql = " UPDATE `all_phone_book` SET `deleted`='1' WHERE `id`='" . $id . "' ";
        $result = $con->query($sql);
        if ($result) {
            $contact_id = $id;
            $con->close();
            return $contact_id;
        } else {
            $con->close();
            return $contact_id;
        }
    }

    public function fetchSingleContact(int $id): string // fetch single contact number from database
    {
        $row = '';
        $con = $this->connect();
        $sql = " SELECT * FROM `all_phone_book` WHERE `id`= '" . $id . "' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $con->close();
            return json_encode($row);
        } else {
            $con->close();
            return json_encode($row);
        }
    }

    /**
     * ================================================ DB functions ================================================
     */





    /**
     * ================================================ Helper functions ================================================
     */

    public function displayContactNumbers(string $keywords): string
    {
        $tbody = '';
        $all_phone_numbers = $this->getAllPhoneNumbers($keywords);
        if (!empty($all_phone_numbers)) {
            foreach ($all_phone_numbers as $key => $value) {
                $tbody .= '<tr>
                    <td>' . $value['id'] . '</td>
                    <td>' . $value['name'] . '</td>
                    <td>' . $value['country_short_code'] . '</td>
                    <td>' . $value['prefix'] . '</td>
                    <td>' . $value['number'] . '</td>
                    <td>' . $value['updated_at'] . '</td>
                    <td> 
                        <i class="fa fa-edit text-info ml-3" onclick="fetchSingleContact(' . $value["id"] . ')"></i>
                        <i class="fa fa-trash-o text-danger ml-3"  onclick="deleteSingleContact(' . $value["id"] . ')"></i>
                    </td>
                </tr>';
            }
        } else {
            $tbody .= '<tr>
                    <td colspan="6" class="text-danger text-center">
                        <h1> No record found </h1>
                    </td>
                </tr>';
        }
        return $tbody;
    }

    public function isValidPhoneNumber(string $number, int $min_digits = 8, int $max_digits = 14): bool //validating contact number
    {
        if (preg_match('/^[+][0-9]/', $number)) { // if + found at the start
            $count = 1;
            $number = str_replace(['+'], '', $number, $count); // removing +
        }
        $number = $this->removeOtherCharacters($number); // removing other charaters
        return $this->isDigits($number, $min_digits, $max_digits); // confirming we only have digits left
    }

    public function isDigits(string $s, int $min_digits = 9, int $max_digits = 14): bool // make sure only digits in string and in between min & max length
    {
        return preg_match('/^[0-9]{' . $min_digits . ',' . $max_digits . '}\z/', $s);
    }

    public function normalizePhoneNumber(string $number): string // normalize phone number and replace leading zero with +
    {
        $number = $this->removeOtherCharacters($number); // removing other charaters
        return $this->replaceLeadingZero($number); // replacing leading zero with +
    }

    public function removeOtherCharacters(string $number): string //remove all other characters like white space, dots, hyphens and brackets
    {
        return str_replace([' ', '.', '-', '(', ')'], '', $number);
    }

    public function replaceLeadingZero(string $number): string
    {
        if (!preg_match('/^[+][0-9]/', $number)) { //if + not found at the start
            return '+' . ltrim($number, "0");
        }
        return $number;
    }

    public function removeCountryCode(string $country_code, string $number): string
    {
        $count = 1;
        $number = str_replace([$country_code], '', $number, $count);
        return $number;
    }

    public function getCountryData(string $country_code): array // get country data from json for specific country code
    {
        $json_data_array = $this->readJson();
        $found = array_filter($json_data_array, function ($v, $k) use ($country_code) {
            return $v['country_code'] == $country_code;
        }, ARRAY_FILTER_USE_BOTH);
        if ($found) {
            return array_values($found);
        }
        return [];
    }

    public function extractCountryCode(string $number): string // extract country code from number string
    {
        $one_digit_country_code = substr($number, 0, 2);
        $two_digit_country_code = substr($number, 0, 3);
        $three_digit_country_code = substr($number, 0, 4);

        if ($this->getCountryData($three_digit_country_code)) {
            return $three_digit_country_code;
        } elseif ($this->getCountryData($two_digit_country_code)) {
            return $two_digit_country_code;
        } elseif ($this->getCountryData($one_digit_country_code)) {
            return $one_digit_country_code;
        } else {
            return false;
        }
    }

    public function readJson(): array // reads json stored country data
    {
        $json_db = 'js-scripts/countries-prefix-data.json';
        $json_data_array = [];
        $json_data = file_get_contents($json_db);
        $json_data_array = json_decode($json_data, true);
        return $json_data_array;
    }

    /**
     * ================================================ Helper functions ================================================
     */
}
