<?php
/**
*
*  ██████  ██  ██████  ██████  ██████   ██████  ██   ██
*  ██   ██ ██ ██    ██ ██   ██ ██   ██ ██    ██  ██ ██
*  ██████  ██ ██    ██ ██████  ██████  ██    ██   ███
*  ██   ██ ██ ██    ██ ██      ██   ██ ██    ██  ██ ██
*  ██████  ██  ██████  ██      ██   ██  ██████  ██   ██
*
*
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    BIOPROX <juanfer@bioprox.es>
*  @copyright 2022 BIOPROX LABORATORIOS S.C.A.
*  @license   See above
*/

/**
 * In some cases you should not drop the tables.
 * Maybe the merchant will just try to reset the module
 * but does not want to loose all of the data associated to the module.
 */
$sql = array();

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
