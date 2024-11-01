=== VIES Validator ===
Contributors: marekma
Version: 1.0.4
Donate link: https://wpzen.it
Tags: woocommerce, vies, partita iva, validation, vat, wpzen
Requires at least: 3.0.1
Tested up to: 4.9.6
Requires PHP: 5.6
Stable Tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a VAT Number (Partita IVA) field to Woocommerce checkout and validate it using the VIES API service from Agenzia delle Entrate.


== Description ==

The plugin allow you to validate your clients VAT Number using the online VIES service from Agenzia delle Entrate.

If you don't currently have a VAT Number field you can easily add one from the settings menu. If you already have one just specify the field ID and the validation will take place on your existing field.

For more information about VIES see [https://telematici.agenziaentrate.gov.it/VerificaPIVA/Scegli.jsp](https://telematici.agenziaentrate.gov.it/VerificaPIVA/Scegli.jsp)

Based on [eu-vat-validator](https://github.com/pH-7/eu-vat-validator): a simple and clean PHP library that validates EU VAT registration numbers against the central ec.europa.eu database.

== Installation ==

1. Upload the plugin to your Woocommerce e-commerce website.
2. Go to Settings -> Vies Validator
3. Configure the plugin. Select "Add VAT Number field to checkout" if you don't currently have a VAT Number. Fill the "VAT field ID" if you alrready have a VAT Number field instead.
4. Customize the error message for invalid VAT Numbers and select if your new VAT field should be required.


== Frequently Asked Questions ==

= I don't have a VAT Number field in my checkout, what can I do? =

VIES Validator can add the VAT Number field for you, either required or not.

= I already have a VAT Number field, can the plugin validate that one? =

Yes, your field needs to have a unique CSS ID. Copy the ID and insert it in the General options of VIES Validator to make the magic happen.

== Screenshots ==

1. The Vies Validator settings page.

== Changelog ==

= 1.0 =
* First Release

= 1.0.1 =
* Updated readme.txt

= 1.0.2 =
* Updated readme.txt

= 1.0.4 =
* Updated readme.txt

== Upgrade Notice ==

= 1.0 =
* First release of the plugin.

= 1.0.1 =
Updated the Readme and FAQ sections.

= 1.0.2 =
Updated the Readme and FAQ sections.

= 1.0.4 =
Updated the Readme and FAQ sections.