<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Mato Ilic <info@matoilic.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class Tx_T3chimp_Domain_Repository_CountryRepository {
    private $countryListPath = 'EXT:t3chimp/Resources/Private/Language/Countries';

    /**
     * @var array
     */
    private static $localized = array();

    /**
     * @return array
     */
    public function findAllOrdered() {
        return $this->findAllOrderedByLocale($GLOBALS['TSFE']->config['config']['language']);
    }

    /**
     * @param string $locale
     * @return array
     */
    public function findAllOrderedByLocale($locale = 'default') {
        if(!array_key_exists($locale, self::$localized)) {
            $file = t3lib_div::getFileAbsFileName($this->countryListPath . '/' . $locale . '.php');
            if(!file_exists($file)) {
                $locale = 'default';
                $file = t3lib_div::getFileAbsFileName($this->countryListPath . '/default.php');
            }

            if(!array_key_exists($locale, self::$localized)) {
                self::$localized[$locale] = require($file);
            }
        }

        return self::$localized[$locale];
    }

    public function injectSettingsProvider(Tx_T3chimp_Provider_Settings $settings) {
        $this->countryListPath = $settings->get('countryLists');
    }
}
