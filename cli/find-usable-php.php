<?php

use Composer\Semver\Semver;

/**
 * Load correct autoloader depending on install location.
 */
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../../autoload.php')) {
    require_once __DIR__ . '/../../../autoload.php';
} else {
    require_once getenv('HOME') . '/.composer/vendor/autoload.php';
}

// Cache and speed up the process
$cache = __DIR__ . '/../phps.cache';
if (file_exists($cache)) {
    $sortPhps = $phps = json_decode(file_get_contents($cache), true);
} else {
    $phps = explode(PHP_EOL, trim(shell_exec('brew list --formula | grep php')));

    // Normalize version numbers
    $sortPhps = $phps = array_reduce($phps, function ($carry, $php) {
        $carry[$php] = presumePhpVersionFromBrewFormulaName($php);

        return $carry;
    }, []);

    file_put_contents($cache, json_encode($phps));
}

// Sort the newest version to the oldest
sort($sortPhps);
$sortPhps = array_reverse($sortPhps);

// Grab the highest, set as default $foundVersion
// then first check if there's an ace.json file
// and then check if there's a composer.json file
$foundVersion = reset($sortPhps);
$constraints = null;
$dir = trim(shell_exec('pwd'));

if (file_exists($dir . '/ace.json')) {
    if (isset(json_decode(file_get_contents($dir . '/ace.json'), true)['php'])) {
        $constraints = json_decode(file_get_contents($dir . '/ace.json'), true)['php'];
    }
} elseif (file_exists($dir . '/composer.json')) {
    if (isset(json_decode(file_get_contents($dir . '/composer.json'), true)['require']['php'])) {
        $constraints = json_decode(file_get_contents($dir . '/composer.json'), true)['require']['php'];
    }
}

if ($constraints) {
    foreach ($sortPhps as $php) {
        // If the current PHP version order by newest satisfies the constraints, use it
        if (Semver::satisfies($php, $constraints)) {
            $foundVersion = $php;
            break;
        }
    }
}

echo getPhpExecutablePath(array_search($foundVersion, $phps));

/**
 * Function definitions.
 */

/**
 * Extract PHP executable path from PHP Version.
 * Copied from Brew.php and modified.
 *
 * @param  string|null  $phpFormulaName For example, "php@8.1"
 * @return string
 *
 * @throws Exception
 */
function getPhpExecutablePath(string $phpFormulaName = null)
{
    $brewPrefix = exec('printf $(brew --prefix)');

    // Check the default `/opt/homebrew/opt/php@8.1/bin/php` location first
    if (file_exists($brewPrefix . "/opt/{$phpFormulaName}/bin/php")) {
        return $brewPrefix . "/opt/{$phpFormulaName}/bin/php";
    }

    // Check the `/opt/homebrew/opt/php71/bin/php` location for older installations
    $oldPhpFormulaName = str_replace(['@', '.'], '', $phpFormulaName); // php@7.1 to php71
    if (file_exists($brewPrefix . "/opt/{$oldPhpFormulaName}/bin/php")) {
        return $brewPrefix . "/opt/{$oldPhpFormulaName}/bin/php";
    }

    throw new Exception('Cannot find an executable path for provided PHP version: ' . $phpFormulaName);
}

function presumePhpVersionFromBrewFormulaName(string $formulaName)
{
    if ($formulaName === 'php') {
        // Figure out its link
        $details = json_decode(shell_exec("brew info $formulaName --json"));

        if (!empty($details[0]->aliases[0])) {
            $formulaName = $details[0]->aliases[0];
        } else {
            return null;
        }
    }

    if (strpos($formulaName, 'php@') === false) {
        return null;
    }

    return substr($formulaName, strpos($formulaName, '@') + 1);
}
