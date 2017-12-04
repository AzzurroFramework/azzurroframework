<?php
/*
	Azzurro Framework loader

	- load core files
	- load af module files

	---- Changelog ---
	Rev 1.0 - November 20th, 2017
			- Basic functionality


	Copyright 2017 Alessandro Pasqualini
	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at
    	http://www.apache.org/licenses/LICENSE-2.0
	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.

	@author    Alessandro Pasqualini <alessandro.pasqualini.1105@gmail.com>
	@url       https://github.com/alessandro1105
*/

	//--- AUTOLOADER CORE AZZURRO FRAMEWORK ---
	spl_autoload_register(function ($class) {
		// Remove white spaces at the start of the class
		$className = ltrim($class, '\\');
		$fileName  = __AF_VENDOR_DIR__ . DIRECTORY_SEPARATOR;
		$namespace = "";

		// If there is a namespace
		if ($lastNsPos = strrpos($class, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName  .= strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR);
		}

		// If it's an interface
		if (strpos($className, "Interface") !== false) {
			$fileName .= $className . ".interface.php";

		// If it's an exception
		} else if (strpos($className, "Exception") !== false) {
			$fileName .= $className . ".exception.php";

		// If it's a class
		} else {
			$fileName .= $className . ".class.php";
		
		}

		// If the file exists
		if (file_exists($fileName) and is_file($fileName)) {
			require_once($fileName);
		}
	});


	//--- AUTOLOADER CORE MODULES ---
	// Classes and exceptions are automatically loaded
	spl_autoload_register(function ($class) {

		// Remove white spaces at the start of the class
		$className = ltrim($class, '\\');
		$fileName  = __AF_VENDOR_DIR__ . DIRECTORY_SEPARATOR;
		$namespace = "";

		// If there is a namespace
		if ($lastNsPos = strrpos($class, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName  .= strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR);
		}

		// If it's a provider
		if (strpos($className, "Provider") !== false) {
			$fileName .= $className . ".provider.php";

		// If it's a service	
		} else if (strpos($className, "Service") !== false) {
			$fileName .= $className . ".service.php";

		// If it's a filter	
		} else if (strpos($className, "Filter") !== false) {
			$fileName .= $className . ".filter.php";

		// If it's a controller
		} else if (strpos($className, "Controller") !== false) {
			$fileName .= $className . ".controller.php";
		}

		// If the file exists
		if (file_exists($fileName) and is_file($fileName)) {
			require_once($fileName);
		}
	});


	// --- LOADING THE CORE MODULES ---
	// Scan the core modules directory
	foreach (scandir(__DIR__ . "/core/modules/") as $content) {
		// Create the module declaration file
		$module = __DIR__ . "/core/modules/" . $content . "/" . $content . ".module.php";
		// If the file exists
		if (file_exists($module)) {
			// Require it
			require_once($module);
		}
	}