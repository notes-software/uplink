<?php

/**
 * MIGRATION DOCUMENTATION
 * https://sprnva.000webhostapp.com/docs/migration
 *
 * Always remember:
 * "up" is for run migration
 * "down" is for the rollback, reverse the migration
 * 
 */
$create_user_folder = [
	"mode" => "NEW",
	"table"	=> "user_folder",
	"primary_key" => "id",
	"up" => [
		"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
		"folder_code" => "text NOT NULL",
		"user_id" => "int(11) NOT NULL",
		"folder_name" => "varchar(255) NOT NULL",
		"updated_at" => "datetime DEFAULT NULL",
		"created_at" => "datetime DEFAULT NULL"
	],
	"down" => [
		"" => ""
	]
];
