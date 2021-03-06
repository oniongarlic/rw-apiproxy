<?php

/**
 * Backend interface
 *
 * @package Backend
 */
abstract class BackendActionsInterface
{
protected $token;

public function set_auth_token($token)
{
$this->token=$token;
}

// Authentication
abstract public function check_auth();
abstract public function set_auth($username, $password);
abstract public function get_user();
abstract public function login();
abstract public function logout();

abstract public function auth_apikey($key);

// Locations
abstract public function get_locations();

// Categories
abstract public function get_categories();

// Files (images)
abstract public function upload_file($file, $filename=null);
abstract public function view_file($fid, $data=false);

// Products
abstract public function add_product(array $data, array $files);
// abstract public function create_product($type, $sku, $title, $price);
abstract public function index_products();

abstract public function get_product($id);
abstract public function get_product_by_sku($sku);

/**
 * validate Description field, for now only strips any tags from it.
 *
 */
protected Function validateDescription($desc)
{
return strip_tags($desc);
}

/**
 * Validate against a regexp
 *
 */
public Function validateReg($str, $reg)
{
return preg_match($reg, $str)===1 ? $bc : false;
}

/**
 * Validate EAN/ISBN
 *
 * Checks if given code is 13 numbers
 * XXX: Does not *really* validate it properly yet
 *
 */
public Function validateEAN($bc)
{
return preg_match('/^[0-9]{13}$/', $bc)===1 ? $bc : false;
}

/**
 * Validate our barcode format.
 * We accept both (old) AAA123456 and (new) AAA123456789
 */
public Function validateBarcode($bc)
{
return preg_match('/^[A-Z]{3}[0-9]{6,9}$/', $bc)===1 ? $bc : false;
}

}
