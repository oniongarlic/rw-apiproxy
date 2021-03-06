# RW-API Proxy

API request proxy to various shop backend services, currently supports Drupal 7 Commerce and Prestashop.

License: GPLv3
Status: Not yet fully stable. Documentation is still work-in-progress.

The purpose of the API proxy is it remove the need for the client application to know any backend
specific API details so that the backend can be changed to some other system or service without
changes to the client software itself. 

Supports:
* Drupal 7 Commerce
* Prestashop

This is to be used together with the rw-client application, also available on github at:
* https://github.com/City-of-Turku/rw-client

## Requirements

* PHP 5.4 or greater.

The proxy is self-contained and does not depend on any Drupal or other external code.

## Supported backends

### Drupal Commerce, trough service and commerce_service REST APIs

As the is a proxy for Drupal services the Drupal installation that it talks too need to have
the following modules installed and setup (and their dependencies):
* services
* commerce_services

### Prestashop, trough REST API
Uses the Prestashop API and because of API limitations also requires direct access to the prestashop database.

## Configuration
Make a copy of config.ini.sample to config.ini and modify service endpoints, set any required API keys
and choose a backend to use. See config.ini.sample for details.

## Client keys
A client application must have a API key to indentify it. This key is a random string and must be provided in the http request
header 'xxx' and must be sent with every request.

### Client keys configuration

Key configuration is backend service specific. 

### Prestashop

Uses Supplier or Manufacturer for apikey. (XXX: This needs more information)

### Drupal

API keys are checked from a simple database, that does not need to be part of any Drupal install, the minimum table field format below:

 CREATE TABLE apikeys (
  apikey varchar(64) primary key,
  revoked int not null default 0
 );

Database connection details are set in config.ini, see config.ini.sample for example settings.

Example PostgreSQL setup:
 createuser --pwprompt --encrypted --no-createrole --no-createdb rv4api
 createdb --encoding=UTF8 --owner=rv4api rv4api

## Responses
All response bodies are in JSON format. 
HTTP error codes are used to report success and failure.

### JSON API Response format

All JSON responses have two top-level objects: meta and data

"meta" has always the properties:
* "code": Response code, follows the HTTP response code logic (200-OK, etc)
* "op": The operation this response is for
* "message": Human readable response message
* "version": API version, currently 1

"data" is endpoint specific and can be empty.

## API endpoints

Implements simple, easy to use API method endpoints for the following functions.
For now, documentation for JSON response details is the code.

## Keys

Configure encryption keys, you can generate suitable ones with

 openssl enc -aes-256-cbc -k <yoursecretpassword> -P -md sha1

## Implemented endpoints (endpoint method description)

### Generic

* /version GET Report API version
* /news GET Get application news feed
* /download/@apk GET Download client application apk package

### Authentication

* /auth/login POST Login to backend
* /auth/logout POST Logout from backend
* /auth/user GET Get information about logged in user

### Product (Drupal commerce service)

* /product POST add product
* /products GET browse product list
* /products/barcode/@barcode:[A-Z]{3}[0-9]{6,9} GET a single product by given barcode string
* /products/image/@fid:[0-9]{1,5} GET get product image by ID, ID is in the product details
* /products/search GET search for products

### Locations

* /locations GET Get list of warehouse/locations

### Oreders
* /orders POST Create an order from list of products

### ToDo

* Add support for products list sort order using various fields
* Filtering on specific detail

These endpoints are planned, but not yet implemented

* /orders GET list of my orders
* /orders/@id/status GET order status
* /orders/@id/status POST update order status

* /products PUT update product
* /products DELETE remove product
* /products/categories

