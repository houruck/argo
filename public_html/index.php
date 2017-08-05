<?php
session_start();
session_regenerate_id(true); // Generate a new session id every time
ob_start();
$session = session_id();

$logfile = "../work/log/json.log";
$ip = $_SERVER['REMOTE_ADDR'];
$time = date("D Y-m-d H:i:s");
$message = "";

$gears = array("Hunter", "Iguana", "Cheetah", "Jaeger", "Warrior", "Sidewinder", "Tiger", "BlackMamba", "Jaguar");
$sections = array("STOR", "SHED", "SSHR", "SSHL", "SLUR", "SLUL", "SADL", "SADR", "SAUL", "SAUR", "SFL", "SFR", "SHIP", "SHL", "SHR", "SLDL", "SLDR");
$parts = array("Head Internal" => "Head", "Head Armor" => "Head_PLATE", "Collar Armor" => "Torso_Upper_Hatch_PLATE", "Main Torso Armor" => "Torso_Lower_Hatch_PLATE", "Torso Internal" => "TORSO", "Torso Base Armor" => "Torso_PLATE", "Shoulder Internal" => "Lt_Shoulderpad", "Shoulder Armor" => "Lt_Shoulderpad_PLATE", "Shoulder Internal" => "Rt_Shoulderpad", "Shoulder Armor" => "Rt_Shoulderpad_PLATE", "Upper Arm Internal" => "Lt_Arm_1", "Upper Arm Armor" => "Lt_Arm_1_PLATE", "Upper Arm Internal" => "Rt_Arm_1", "Upper Arm Armor" => "Rt_Arm_1_PLATE", "Lower Arm Internal" => "Lt_Arm_2", "Lower Arm Armor" => "Lt_Arm_2_PLATE", "Lower Arm Internal" => "Rt_Arm_2", "Lower Arm Armor" => "Rt_Arm_2_PLATE", "Hand Internal" => "Lt_Hand", "Hand Armor" => "Lt_Hand_PLATE", "Hand Internal" => "Rt_Hand", "Hand Armor" => "Rt_Hand_PLATE", "Finger Armor" => "LT1_PLATE", "Hip Internal" => "Hip", "Hip Armor" => "Hip_PLATE", "Upper Leg Internal" => "Lt_Leg_1", "Upper Leg Armor" => "Lt_Leg_1_PLATE", "Upper Leg Internal" => "Rt_Leg_1", "Upper Leg Armor" => "Rt_Leg_1_PLATE", "Lower Leg Internal" => "Lt_Leg_2", "Lower Leg Armor" => "Lt_Leg_2_PLATE", "Lower Leg Internal" => "Rt_Leg_2", "Lower Leg Armor" => "Rt_Leg_2_PLATE", "Foot Internal" => "Lt_Foot", "Foot Armor" => "Lt_Foot_PLATE", "Foot Internal" => "Rt_Foot", "Foot Armor" => "Rt_Foot_PLATE", "Foot Guard" => "Lt_Foot_Guard_1_PLATE", "Foot Guard" => "Rt_Foot_Guard_1_PLATE", "Toe Armor" => "Lt_Toe_1_PLATE", "Toe Armor" => "Rt_Toe_1_PLATE", "Fore Foot Armor" => "Lt_Ball_PLATE", "Fore Foot Armor" => "Rt_Ball_PLATE", "Wheel Armor" => "Lt_Foot_RearWheel", "Wheel Armor" => "Rt_Foot_RearWheel");

// Test the user input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Get gear data from first form
$gear = $_POST["gear"];

// First form runs
if (!isset($_POST["gear"])) { // Make Hunter the default
$gear = "Hunter";
} else {
$gear = test_input($_POST["gear"]); // Sanitise variables

if (!in_array($gear, $gears)) { // Test if Gear is valid
$gear = "Gear";
}
}

$_SESSION["alma"] = $gear;

include("../work/include/form.php"); // Load the form

$output = ob_get_contents(); // Output buffer
ob_end_clean();

// Value form has been submitted
if(isset($_POST['value'])) {
    $log = "[$time] [client $ip]";

// Test session id
if (ctype_alnum($session)) {
    $message .= "$log session id is alphanumeric\n";
      }else {
        $message .= "$log [WARNING] session id NOT is alphanumeric!\n";
        file_put_contents($logfile, $message, FILE_APPEND | LOCK_EX);
        echo "$output";
        die;
}

foreach ($parts as $part) {
$value = $_POST["value"];

// Check if value is numeric
if (is_numeric($value[$part])) {
        $message .= "$log $part is numeric\n";

// Set empty fields to one - zero means immortal
    if ($value[$part] == "") {
        $value[$part] = "1";
}

// Set zero and negative numbers to one
    if ($value[$part] <= "0") {
        $value[$part] = "1";
}

// Max value is 5000
    if ($value[$part] > "5000") {
        $value[$part] = "5000";
}

    } else {
        $message .= "$log [WARNING] $part is NOT numeric\n";
        file_put_contents($logfile, $message, FILE_APPEND | LOCK_EX);
        echo "$output";
        die;
}

}

// Create folder
if (!mkdir('../work/out/'.$session.'/', 0777)) {
    $message .= "$log [ERROR] FAILED TO CREATE FOLDER\n";
    file_put_contents($logfile, $message, FILE_APPEND | LOCK_EX);
    die;
}

// Write it to file
foreach ($sections as $section) {

 include('../work/schema/'.$section.'.php'); // Load schemas

     $file = '../work/out/'.$session.'/'.$section.'.json';
     file_put_contents($file, $json, file_put_contents | LOCK_EX); // Need error handling here
     $message .= "$log $section written\n";
}

// Write the log file
file_put_contents($logfile, $message, FILE_APPEND | LOCK_EX);

include("../work/include/zip.php");

} else {
echo $output;
// HERE BE DRAGONS
// The form hasn't been submitted yet
}

?>