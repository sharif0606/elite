<?php 

function title_case($value)
{
    return mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
}

function brands() {
    $brands = array(
        array('id' => '1','name' => 'Toyota'),
        array('id' => '2','name' => 'Honda'),
        array('id' => '3','name' => 'Nissan'),
        array('id' => '4','name' => 'Barisal'),
        array('id' => '5','name' => 'Mazda'),
        array('id' => '6','name' => 'Suzuki'),
        array('id' => '7','name' => 'Mitsubishi'),
        array('id' => '8','name' => 'Hino')
    );

    return $brands;
}
function body_types() {
    $body_types = array(
        array('id' => '1','name' => 'Sedan'),
        array('id' => '2','name' => 'Coupe'),
        array('id' => '3','name' => 'Hatchback'),
        array('id' => '4','name' => 'Station Wagon'),
        array('id' => '5','name' => 'SUV'),
        array('id' => '6','name' => 'Pick Up'),
        array('id' => '7','name' => 'Van'),
        array('id' => '8','name' => 'Wagon')
    );

    return $body_types;
}
function sub_body_types() {
    $sub_body_types = array(
        array('id' => '1','name' => 'Flat Body'),
        array('id' => '2','name' => 'Crane'),
        array('id' => '3','name' => 'Dump'),
        array('id' => '4','name' => 'Loader'),
        array('id' => '5','name' => 'Garbage Truck'),
        array('id' => '6','name' => 'Chasis'),
        array('id' => '7','name' => 'Self'),
        array('id' => '8','name' => 'Fork Lift')
    );

    return $sub_body_types;
}
function drive() {
    $drive = array(
        array('id' => '1','name' =>'2WD'),
        array('id' => '2','name' => '4WD'),
        array('id' => '3','name' => '4-2'),
        array('id' => '4','name' => '4-4'),
        array('id' => '5','name' => '6-2'),
        array('id' => '6','name' => '6-4'),
        array('id' => '7','name' => '8-4'),
    );

    return $drive;
}
function transmission() {
    $transmission = array(
        array('id' => '1','name' =>'Automatic'),
        array('id' => '2','name' => 'Manual'),
        array('id' => '3','name' => 'Smoother'),
        array('id' => '4','name' => 'Semi AT'),
        array('id' => '5','name' => 'Inomat'),
        array('id' => '6','name' => 'Duonic'),
        array('id' => '7','name' => 'Escot'),
    );

    return $transmission;
}
function fuel() {
    $fuel = array(
        array('id' => '1','name' =>'Petrol'),
        array('id' => '2','name' => 'Disel'),
        array('id' => '3','name' => 'LPG'),
        array('id' => '4','name' => 'CNG'),
        array('id' => '5','name' => 'Electric Vehicles'),
        array('id' => '6','name' => 'Hybrid(Petrol)'),
        array('id' => '7','name' => 'Hybrid(Disel)'),
    );

    return $fuel;
}
function color() {
    $color = array(
        array('id' => '1','name' =>'Red'),
        array('id' => '2','name' => 'Green'),
        array('id' => '3','name' => 'Blue'),
        array('id' => '4','name' => 'Yellow'),
        array('id' => '5','name' => 'Purple'),
        array('id' => '6','name' => 'Pink'),
        array('id' => '7','name' => 'Rose'),
    );

    return $color;
}
function inventory_location() {
    $inventory_location = array(
        array('id' => '1','country_id' =>'20'),
        array('id' => '2','country_id' => '100'),
        array('id' => '3','country_id' => '109'),
        array('id' => '4','country_id' => '131'),
        array('id' => '5','country_id' => '192'),
        array('id' => '6','country_id' => '45'),
        array('id' => '7','country_id' => '226'),
    );

    return $inventory_location;
}



