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
$create_user_files = [
	"mode" => "NEW",
	"table"	=> "user_files",
	"primary_key" => "id",
	"up" => [
		"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
		"file_code" => "varchar(23) NOT NULL",
		"user_id" => "int(11) NOT NULL",
		"folder_id" => "int(11) NOT NULL",
		"slug" => "text DEFAULT NULL",
		"filetype" => "text NOT NULL",
		"filesize" => "text NOT NULL",
		"iconsize" => "text NOT NULL",
		"created_at" => "timestamp NULL DEFAULT NULL",
		"updated_at" => "timestamp NULL DEFAULT NULL"
	],
	"down" => [
		"" => ""
	]
];
