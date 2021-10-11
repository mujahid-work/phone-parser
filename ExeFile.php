<?php

include_once('MethodsFile.php');
$obj = new MethodsClass();


if (isset($_POST['action']) && $_POST['action'] == 'add-or-update') { // checking for store request

    $id = $_POST['id'];
    $number = $_POST['number'];
    $name = $_POST['name'];
    if ($obj->isValidPhoneNumber($number)) { // validating phone number
        $number = $obj->normalizePhoneNumber($number); // normalizing phone number
        $country_code = $obj->extractCountryCode($number); // extract country code from phone number
        $country_data = $obj->getCountryData($country_code); // fetching country short code and country code from json
        $number = $obj->removeCountryCode($country_code, $number); // removing country code from number
        if ($country_data) { // if valid country code and data found against country code
            $data = [
                'id' => $id,
                'prefix' => $country_data[0]['country_code'],
                'country_short_code' => $country_data[0]['country_short_code'],
                'number' => $number,
                'name' => $name
            ];
            $is_duplicate = $obj->checkForDuplicate($data); // checking for phone number exist in DB
            if (!empty($is_duplicate)) { // if found return original row id
                echo '<span class="text-danger"> Phone number already existed. ID: <b>' . $is_duplicate . '</b> </span>';
            } else { // if not found go for storing in DB
                if ($id == "") {
                    $last_inserted_id = $obj->storePhoneNumber($data); // storing phone number in DB
                    echo '<span class="text-success"> Phone number added successfully. ID: <b>' . $last_inserted_id . '</b> </span>';
                } else {
                    $obj->updatePhoneNumber($data); // storing phone number in DB
                    echo '<span class="text-success"> Phone number updated successfully. ID: <b>' . $id . '</b> </span>';
                }
            }
        } else { // if not a valid country code or no data found against country code
            echo '<span class="text-danger"> Please enter a valid country code.  </span>';
        }
    } else { // if invlid phone number
        echo '<span class="text-danger"> Please enter a valid phone number. </span>';
    }

    exit;
} elseif (isset($_GET['action']) && $_GET['action'] == 'fetch-all') { //checking for fetch all request

    $keywords = $_GET['keywords'];
    echo $obj->displayContactNumbers($keywords); // getting and displaying all phone numbers

    exit;
} elseif (isset($_GET['action']) && $_GET['action'] == 'delete-single-contact') { //checking for delete contact request

    $id = $_GET['id'];
    $deleted_id = $obj->deleteContactNumber($id); // deleting phone numbers
    if (!empty($deleted_id)) {
        echo '<span class="text-success"> Phone number deleted successfully. ID: <b>' . $deleted_id . '</b>  </span>';
    } else {
        echo '<span class="text-danger"> something went wrong. Please try again! </span>';
    }

    exit;
} elseif (isset($_GET['action']) && $_GET['action'] == 'fetch-single-contact') { //checking for fetch single contact request

    $id = $_GET['id'];
    echo $obj->fetchSingleContact($id); // getting phone numbers

    exit;
} else {

    echo '<span class="text-danger"> undefined action </span>';

    exit;
}
