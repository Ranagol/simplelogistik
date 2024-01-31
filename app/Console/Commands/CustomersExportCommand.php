<?php

namespace App\Console\Commands;

use App\Models\TmsAddress;
use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CustomersExportCommand extends Command
{
    private $headline = 'Konto;Name (Adressattyp Unternehmen);Unternehmensgegenstand;Name (Adressattyp natürl. Person);Vorname (Adressattyp natürl. Person);Name (Adressattyp keine Angabe);Adressattyp;Kurzbezeichnung;EU-Land;EU-UStID;Anrede;Titel/Akad. Grad;Adelstitel;Namensvorsatz;Adressart;Straße;Postfach;Postleitzahl;Ort;Land;Versandzusatz;Adresszusatz;Abweichende Anrede;Abw. Zustellbezeichnung 1;Abw. Zustellbezeichnung 2;Kennz. Korrespondenzadresse;Adresse Gültig von;Adresse Gültig bis;Telefon;Bemerkung (Telefon);Telefon GL;Bemerkung (Telefon GL);E-Mail;Bemerkung (E-Mail);Internet;Bemerkung (Internet);Fax;Bemerkung (Fax);Sonstige;Bemerkung (Sonstige);Bankleitzahl 1;Bankbezeichnung 1;Bank-Kontonummer 1;Länderkennzeichen 1;IBAN-Nr. 1;IBAN1 korrekt;SWIFT-Code 1;Abw. Kontoinhaber 1;Kennz. Hauptbankverb. 1;Bankverb 1 Gültig von;Bankverb 1 Gültig bis;Bankleitzahl 2;Bankbezeichnung 2;Bank-Kontonummer 2;Länderkennzeichen 2;IBAN-Nr. 2;IBAN2 korrekt;SWIFT-Code 2;Abw. Kontoinhaber 2;Kennz. Hauptbankverb. 2;Bankverb 2 Gültig von;Bankverb 2 Gültig bis;Bankleitzahl 3;Bankbezeichnung 3;Bank-Kontonummer 3;Länderkennzeichen 3;IBAN-Nr. 3;IBAN3 korrekt;SWIFT-Code 3;Abw. Kontoinhaber 3;Kennz. Hauptbankverb. 3;Bankverb 3 Gültig von;Bankverb 3 Gültig bis;Bankleitzahl 4;Bankbezeichnung 4;Bank-Kontonummer 4;Länderkennzeichen 4;IBAN-Nr. 4;IBAN4 korrekt;SWIFT-Code 4;Abw. Kontoinhaber 4;Kennz. Hauptbankverb. 4;Bankverb 4 Gültig von;Bankverb 4 Gültig bis;Bankleitzahl 5;Bankbezeichnung 5;Bank-Kontonummer 5;Länderkennzeichen 5;IBAN-Nr. 5;IBAN5 korrekt;SWIFT-Code 5;Abw. Kontoinhaber 5;Kennz. Hauptbankverb. 5;Bankverb 5 Gültig von;Bankverb 5 Gültig bis;Geschäftspartnerbank;Briefanrede;Grußformel;Kundennummer;Steuernummer;Sprache;Ansprechpartner;Vertreter;Sachbearbeiter;Diverse-Konto;Ausgabeziel;Währungssteuerung;Kreditlimit (Debitor);Zahlungsbedingung;Fälligkeit in Tagen (Debitor);Skonto in Prozent (Debitor);Kreditoren-Ziel 1 Tg.;Kreditoren-Skonto 1 %;Kreditoren-Ziel 2 Tg.;Kreditoren-Skonto 2 %;Kreditoren-Ziel 3 Brutto Tg.;Kreditoren-Ziel 4 Tg.;Kreditoren-Skonto 4 %;Kreditoren-Ziel 5 Tg.;Kreditoren-Skonto 5 %;Mahnung;Kontoauszug;Mahntext 1;Mahntext 2;Mahntext 3;Kontoauszugstext;Mahnlimit Betrag;Mahnlimit %;Zinsberechnung;Mahnzinssatz 1;Mahnzinssatz 2;Mahnzinssatz 3;Lastschrift;Verfahren;Mandantenbank;Zahlungsträger;Indiv. Feld 1;Indiv. Feld 2;Indiv. Feld 3;Indiv. Feld 4;Indiv. Feld 5;Indiv. Feld 6;Indiv. Feld 7;Indiv. Feld 8;Indiv. Feld 9;Indiv. Feld 10;Indiv. Feld 11;Indiv. Feld 12;Indiv. Feld 13;Indiv. Feld 14;Indiv. Feld 15;Abweichende Anrede (Rechnungsadresse);Adressart (Rechnungsadresse);Straße (Rechnungsadresse);Postfach (Rechnungsadresse);Postleitzahl (Rechnungsadresse);Ort (Rechnungsadresse);Land (Rechnungsadresse);Versandzusatz (Rechnungsadresse);Adresszusatz (Rechnungsadresse);Abw. Zustellbezeichnung 1 (Rechnungsadresse);Abw. Zustellbezeichnung 2 (Rechnungsadresse);Adresse Gültig von (Rechnungsadresse);Adresse Gültig bis (Rechnungsadresse)';
    private $csv = '';
    private $exportedIds = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers-export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all Customers to a CSV file that are changed or new since the last export.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Exporting Customers to CSV file...');
        $this->csv = $this->headline . chr(10);
        $this->exportCustomers();
        if (count($this->exportedIds) > 0) {
            $this->saveCsv();
            $this->info('Exported IDs: ' . json_encode($this->exportedIds));
        } else {
            $this->info('No new or changed customers found.');
        }        
        $this->info('Done!');
    }

    /**
     * Export all Customers to a CSV file that are changed or new since the last export.
     */
    private function exportCustomers()
    {
        $exportedId = 0;

        $customerObj = new TmsCustomer();
        $customers = $customerObj->join('tms_addresses','customer_id', '=', 'tms_customers.id')
                                 ->orWhere('tms_customers.exported_at', null)->orWhere('tms_customers.exported_at', '<', TmsCustomer::max('updated_at'))
                                 ->orWhere('tms_addresses.exported_at', null)->orWhere('tms_addresses.exported_at', '<', TmsAddress::max('updated_at'))
                                 ->get(['tms_customers.*','tms_customers.exported_at AS tms_customers_exported_at','tms_customers.updated_at AS tms_customers_updated_at','tms_addresses.*']);

        foreach ($customers as $customer) {        
            $customersAndAddresses = $customer->addresses()->where('is_billing',1)->first();
            if($customer != null              && $customer->tms_customers_exported_at == $customer->tms_customers_updated_at && 
               $customersAndAddresses != null && $customersAndAddresses->updated_at == $customersAndAddresses->exported_at) 
            {
                $this->info('skipped: ' . $customer->id . json_encode($customer->updated_at) . ' ' . json_encode($customer->exported_at) . ' ' . json_encode($customersAndAddresses->updated_at) . ' ' . json_encode($customersAndAddresses->exported_at));
                continue;
            }            
            
            $exportedId = $this->exportCustomer($customer, $customersAndAddresses);
            if ( $exportedId !== false) {
                $this->exportedIds[] = $exportedId;
            }                  
        }
    }

    /**
     * Prepare the CSV data.
     * @param TmsCustomer $customer
     * @param TmsAddress $customersAndAddresses
     * @return integer|boolean
     */
    private function exportCustomer($customer, $customersAndAddresses)    
    {
        $salutation = [0 => 'Firma', 1 => 'Herr', 2 => 'Frau'];        

        // without a billing address we can not export the customer
        if (!isset($customersAndAddresses->last_name) || 
             isset($customersAndAddresses->last_name) && $customersAndAddresses->last_name == '') {
            return false;
        }

        // Konto;Name (Adressattyp Unternehmen);Unternehmensgegenstand;Name (Adressattyp natürl. Person);Vorname (Adressattyp natürl. Person);Name (Adressattyp keine Angabe);Adressattyp;Kurzbezeichnung;EU-Land;EU-UStID;Anrede;Titel/Akad. Grad;Adelstitel;Namensvorsatz;Adressart;Straße;Postfach;Postleitzahl;Ort;Land;Versandzusatz;Adresszusatz;Abweichende Anrede;Abw. Zustellbezeichnung 1;Abw. Zustellbezeichnung 2;Kennz. Korrespondenzadresse;Adresse Gültig von;Adresse Gültig bis;Telefon;Bemerkung (Telefon);Telefon GL;Bemerkung (Telefon GL);E-Mail;Bemerkung (E-Mail);Internet;Bemerkung (Internet);Fax;Bemerkung (Fax);Sonstige;Bemerkung (Sonstige);Bankleitzahl 1;Bankbezeichnung 1;Bank-Kontonummer 1;Länderkennzeichen 1;IBAN-Nr. 1;IBAN1 korrekt;SWIFT-Code 1;Abw. Kontoinhaber 1;Kennz. Hauptbankverb. 1;Bankverb 1 Gültig von;Bankverb 1 Gültig bis;Bankleitzahl 2;Bankbezeichnung 2;Bank-Kontonummer 2;Länderkennzeichen 2;IBAN-Nr. 2;IBAN2 korrekt;SWIFT-Code 2;Abw. Kontoinhaber 2;Kennz. Hauptbankverb. 2;Bankverb 2 Gültig von;Bankverb 2 Gültig bis;Bankleitzahl 3;Bankbezeichnung 3;Bank-Kontonummer 3;Länderkennzeichen 3;IBAN-Nr. 3;IBAN3 korrekt;SWIFT-Code 3;Abw. Kontoinhaber 3;Kennz. Hauptbankverb. 3;Bankverb 3 Gültig von;Bankverb 3 Gültig bis;Bankleitzahl 4;Bankbezeichnung 4;Bank-Kontonummer 4;Länderkennzeichen 4;IBAN-Nr. 4;IBAN4 korrekt;SWIFT-Code 4;Abw. Kontoinhaber 4;Kennz. Hauptbankverb. 4;Bankverb 4 Gültig von;Bankverb 4 Gültig bis;Bankleitzahl 5;Bankbezeichnung 5;Bank-Kontonummer 5;Länderkennzeichen 5;IBAN-Nr. 5;IBAN5 korrekt;SWIFT-Code 5;Abw. Kontoinhaber 5;Kennz. Hauptbankverb. 5;Bankverb 5 Gültig von;Bankverb 5 Gültig bis;Geschäftspartnerbank;Briefanrede;Grußformel;Kundennummer;Steuernummer;Sprache;Ansprechpartner;Vertreter;Sachbearbeiter;Diverse-Konto;Ausgabeziel;Währungssteuerung;Kreditlimit (Debitor);Zahlungsbedingung;Fälligkeit in Tagen (Debitor);Skonto in Prozent (Debitor);Kreditoren-Ziel 1 Tg.;Kreditoren-Skonto 1 %;Kreditoren-Ziel 2 Tg.;Kreditoren-Skonto 2 %;Kreditoren-Ziel 3 Brutto Tg.;Kreditoren-Ziel 4 Tg.;Kreditoren-Skonto 4 %;Kreditoren-Ziel 5 Tg.;Kreditoren-Skonto 5 %;Mahnung;Kontoauszug;Mahntext 1;Mahntext 2;Mahntext 3;Kontoauszugstext;Mahnlimit Betrag;Mahnlimit %;Zinsberechnung;Mahnzinssatz 1;Mahnzinssatz 2;Mahnzinssatz 3;Lastschrift;Verfahren;Mandantenbank;Zahlungsträger;Indiv. Feld 1;Indiv. Feld 2;Indiv. Feld 3;Indiv. Feld 4;Indiv. Feld 5;Indiv. Feld 6;Indiv. Feld 7;Indiv. Feld 8;Indiv. Feld 9;Indiv. Feld 10;Indiv. Feld 11;Indiv. Feld 12;Indiv. Feld 13;Indiv. Feld 14;Indiv. Feld 15;Abweichende Anrede (Rechnungsadresse);Adressart (Rechnungsadresse);Straße (Rechnungsadresse);Postfach (Rechnungsadresse);Postleitzahl (Rechnungsadresse);Ort (Rechnungsadresse);Land (Rechnungsadresse);Versandzusatz (Rechnungsadresse);Adresszusatz (Rechnungsadresse);Abw. Zustellbezeichnung 1 (Rechnungsadresse);Abw. Zustellbezeichnung 2 (Rechnungsadresse);Adresse Gültig von (Rechnungsadresse);Adresse Gültig bis (Rechnungsadresse)
        // 20019585;;;Pfeiffer;Kerstin;;1;Pfeiffer, Kerstin;;;Herr;;;;STR;Auf Herdenen 33;;78052;Villingen-Schwenningen;DE;;;;;;1;;;07721870533;;;;simplelogistik@emons.de;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;0;0;;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;;;0;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
        // 20012165;Daumann Motorsport;business;Daumann;Klaus;;2;Daumann Motorsport;;;Firma;;;;STR;Burgkunstadter Str. 10;;96257;Redwitz an der Rodach;DE;;;;;;1;;;09574 3999;;;;daumann-motorsport@t-online.de;;;;;;;;;;;;DE36770698680000050890;;GENODEF1MGA;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;0;0;;0;10;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;;;0;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
        $this->csv .= $customer->internal_id . ';';                                         // Konto = 20012165
        $this->csv .= $customer->company_name . ';';                                        // Name (Adressattyp Unternehmen) = Daumann Motorsport
        $this->csv .= ($customer->company_name != '') ? 'business;' : ';';                  // Unternehmensgegenstand = business
        $this->csv .= $customersAndAddresses->last_name . ';';                              // Name (Adressattyp natürl. Person) = Daumann
        $this->csv .= $customersAndAddresses->first_name . ';';                             // Vorname (Adressattyp natürl. Person) = Markus                        
        $this->csv .= ($customer->bussiness_customer==null) ?                               // Name (Adressattyp keine Angabe) = Daumann Markus
                      ($customersAndAddresses->last_name.' '.$customersAndAddresses->first_name . ';') : ';' ;                                        
        $this->csv .= ($customer->bussiness_customer==1) ? '2;' : '1;';                     // Adressattyp = 1
        $this->csv .= $customersAndAddresses->last_name . ';';                              // Kurzbezeichnung = Daumann
        $this->csv .= '' . ';';                                                             // EU-Land = DE
        $this->csv .= $customer->tax_number . ';';                                          // EU-UStID = DE36770698680000050890
        $this->csv .= $salutation[$customersAndAddresses->salutation] ?? '' . ';';          // Anrede = Firma/Herr/Frau
        $this->csv .= $customersAndAddresses->title . ';';                                  // Titel/Akad. Grad = Prof. Dr.
        $this->csv .= ($customersAndAddresses->nobility_title) ?? ''  . ';';                // Adelstitel = 
        $this->csv .= ($customersAndAddresses->name_prefix) ?? '' . ';';                    // Namensvorsatz =
        $this->csv .= ($customersAndAddresses->address_type) ?? 'STR' . ';';                // Adressart = 
        $this->csv .= $customersAndAddresses->street . ';';                                 // Straße = Burgkunstadter Str. 10
        $this->csv .= ($customersAndAddresses->post_office_box) ?? '' . ';';                // Postfach =
        $this->csv .= $customersAndAddresses->zip_code . ';';                               // Postleitzahl = 96257
        $this->csv .= $customersAndAddresses->city . ';';                                   // Ort = Redwitz an der Rodach
        $this->csv .= $this->getAlpha2Code($customersAndAddresses->country) . ';';          // Land = DE                  Adresse Gültig bis;Telefon;
        $this->csv .= ';';                                                                  // Versandzusatz =             Versandzusatz
        $this->csv .= $customersAndAddresses->address_additional_information . ';';         // Adresszusatz =              Adresszusatz
        $this->csv .= ';';                                                                  // Abweichende Anrede =        Abweichende Anrede;
        $this->csv .= ';';                                                                  // Abw. Zustellbezeichnung 1 = Abw. Zustellbezeichnung 1;
        $this->csv .= ';';                                                                  // Abw. Zustellbezeichnung 2 = Abw. Zustellbezeichnung 2;
        $this->csv .= '1;';                                                                 // Kennz. Korrespondenzadresse =  Kennz. Korrespondenzadresse;
        $this->csv .= ';';                                                                  // Adresse Gültig von =        Adresse Gültig von;
        $this->csv .= ';';                                                                  // Adresse Gültig bis =
        $this->csv .= $customersAndAddresses->phone . ';';                                  // Telefon = 09574 3999
        $this->csv .= ';';                                                                  // Bemerkung (Telefon) =
        $this->csv .= $customer->phone . ';';                                               // Telefon GL = 09574 3999
        $this->csv .= ';';                                                                  // Bemerkung (Telefon GL) =     
        $this->csv .= $customersAndAddresses->email . ';';                                  // E-Mail =
        $this->csv .= ';';                                                                  // Bemerkung (E-Mail) =
        $this->csv .= $customer->internet . ';';                                             // Internet =
        $this->csv .= ';';                                                                  // Bemerkung (Internet) =   
        $this->csv .= ';';                                                                  // Fax =
        $this->csv .= ';';                                                                  // Bemerkung (Fax) =
        $this->csv .= ';';                                                                  // Sonstige =
        $this->csv .= $customer->comments . ';';                                            // Bemerkung (Sonstige) =
        $this->csv .= ';';                                                                  // Bankleitzahl 1 =     
        $this->csv .= ';';                                                                  // Bankbezeichnung 1 =
        $this->csv .= ';';                                                                  // Bank-Kontonummer 1 =
        $this->csv .= ';';                                                                  // Länderkennzeichen 1 =
        $this->csv .= ';';                                                                  // IBAN-Nr. 1 =
        $this->csv .= ';';                                                                  // IBAN1 korrekt =
        $this->csv .= ';';                                                                  // SWIFT-Code 1 =
        $this->csv .= ';';                                                                  // Abw. Kontoinhaber 1 =
        $this->csv .= ';';                                                                  // Kennz. Hauptbankverb. 1 =
        $this->csv .= ';';                                                                  // Bankverb 1 Gültig von =
        $this->csv .= ';';                                                                  // Bankverb 1 Gültig bis =
        $this->csv .= ';';                                                                  // Bankleitzahl 2 =
        $this->csv .= ';';                                                                  // Bankbezeichnung 2 =
        $this->csv .= ';';                                                                  // Bank-Kontonummer 2 =
        $this->csv .= ';';                                                                  // Länderkennzeichen 2 =
        $this->csv .= ';';                                                                  // IBAN-Nr. 2 =
        $this->csv .= ';';                                                                  // IBAN2 korrekt =
        $this->csv .= ';';                                                                  // SWIFT-Code 2 =
        $this->csv .= ';';                                                                  // Abw. Kontoinhaber 2 =
        $this->csv .= ';';                                                                  // Kennz. Hauptbankverb. 2 =
        $this->csv .= ';';                                                                  // Bankverb 2 Gültig von =
        $this->csv .= ';';                                                                  // Bankverb 2 Gültig bis =
        $this->csv .= ';';                                                                  // Bankleitzahl 3 =
        $this->csv .= ';';                                                                  // Bankbezeichnung 3 =
        $this->csv .= ';';                                                                  // Bank-Kontonummer 3 =
        $this->csv .= ';';                                                                  // Länderkennzeichen 3 =
        $this->csv .= ';';                                                                  // IBAN-Nr. 3 =
        $this->csv .= ';';                                                                  // IBAN3 korrekt =
        $this->csv .= ';';                                                                  // SWIFT-Code 3 =
        $this->csv .= ';';                                                                  // Abw. Kontoinhaber 3 =
        $this->csv .= ';';                                                                  // Kennz. Hauptbankverb. 3 =
        $this->csv .= ';';                                                                  // Bankverb 3 Gültig von =
        $this->csv .= ';';                                                                  // Bankverb 3 Gültig bis =
        $this->csv .= ';';                                                                  // Bankleitzahl 4 =
        $this->csv .= ';';                                                                  // Bankbezeichnung 4 =
        $this->csv .= ';';                                                                  // Bank-Kontonummer 4 =
        $this->csv .= ';';                                                                  // Länderkennzeichen 4 =
        $this->csv .= ';';                                                                  // IBAN-Nr. 4 =
        $this->csv .= ';';                                                                  // IBAN4 korrekt =
        $this->csv .= ';';                                                                  // SWIFT-Code 4 =
        $this->csv .= ';';                                                                  // Abw. Kontoinhaber 4 =
        $this->csv .= ';';                                                                  // Kennz. Hauptbankverb. 4 =
        $this->csv .= ';';                                                                  // Bankverb 4 Gültig von =
        $this->csv .= ';';                                                                  // Bankverb 4 Gültig bis =
        $this->csv .= ';';                                                                  // Bankleitzahl 5 =
        $this->csv .= ';';                                                                  // Bankbezeichnung 5 =
        $this->csv .= ';';                                                                  // Bank-Kontonummer 5 =
        $this->csv .= ';';                                                                  // Länderkennzeichen 5 =
        $this->csv .= ';';                                                                  // IBAN-Nr. 5 =
        $this->csv .= ';';                                                                  // IBAN5 korrekt =
        $this->csv .= ';';                                                                  // SWIFT-Code 5 =
        $this->csv .= ';';                                                                  // Abw. Kontoinhaber 5 =
        $this->csv .= ';';                                                                  // Kennz. Hauptbankverb. 5 =
        $this->csv .= ';';                                                                  // Bankverb 5 Gültig von =
        $this->csv .= ';';                                                                  // Bankverb 5 Gültig bis =
        $this->csv .= ';';                                                                  // Geschäftspartnerbank =
        $this->csv .= ';';                                                                  // Briefanrede =
        $this->csv .= ';';                                                                  // Grußformel =
        $this->csv .= ';';                                                                  // Kundennummer =
        $this->csv .= ';';                                                                  // Steuernummer =
        $this->csv .= ';';                                                                  // Sprache =
        $this->csv .= ';';                                                                  // Ansprechpartner =
        $this->csv .= ';';                                                                  // Vertreter =
        $this->csv .= ';';                                                                  // Sachbearbeiter =
        $this->csv .= '0;';                                                                 // Diverse-Konto =
        $this->csv .= '0;';                                                                 // Ausgabeziel =
        $this->csv .= ';';                                                                  // Währungssteuerung =
        $this->csv .= '0;';                                                                 // Kreditlimit (Debitor) =
        $this->csv .= $customer->payment_time . ';';                                        // Zahlungsbedingung =How many days the payment can be delayed. Example: 20 days means that the customer will pay after 20 days. 
        $this->csv .= '0;';                                                                 // Fälligkeit in Tagen (Debitor) =
        $this->csv .= '0;';                                                                 // Skonto in Prozent (Debitor) =
        $this->csv .= '0;';                                                                 // Kreditoren-Ziel 1 Tg. =
        $this->csv .= '0;';                                                                 // Kreditoren-Skonto 1 % =
        $this->csv .= '0;';                                                                 // Kreditoren-Ziel 2 Tg. =
        $this->csv .= '0;';                                                                 // Kreditoren-Skonto 2 % =
        $this->csv .= '0;';                                                                 // Kreditoren-Ziel 3 Brutto Tg. =
        $this->csv .= '0;';                                                                 // Kreditoren-Ziel 4 Tg. =
        $this->csv .= '0;';                                                                 // Kreditoren-Skonto 4 % =
        $this->csv .= '0;';                                                                 // Kreditoren-Ziel 5 Tg. =
        $this->csv .= '0;';                                                                 // Kreditoren-Skonto 5 % =
        $this->csv .= '0;';                                                                 // Mahnung =
        $this->csv .= '0;';                                                                 // Kontoauszug =
        $this->csv .= ';';                                                                  // Mahntext 1 =
        $this->csv .= ';';                                                                  // Mahntext 2 =
        $this->csv .= ';';                                                                  // Mahntext 3 =
        $this->csv .= ';';                                                                  // Kontoauszugstext =
        $this->csv .= '0;';                                                                 // Mahnlimit Betrag =
        $this->csv .= '0;';                                                                 // Mahnlimit % =
        $this->csv .= '0;';                                                                 // Zinsberechnung = 0 = No interest calculation, 1 = Interest calculation
        $this->csv .= '0;';                                                                 // Mahnzinssatz 1 =
        $this->csv .= '0;';                                                                 // Mahnzinssatz 2 =
        $this->csv .= '0;';                                                                 // Mahnzinssatz 3 =
        $this->csv .= ';';                                                                  // Lastschrift =
        $this->csv .= ';';                                                                  // Verfahren =  
        $this->csv .= '0;';                                                                 // Mandantenbank =  
        $this->csv .= ';';                                                                  // Zahlungsträger =
        $this->csv .= ';';                                                                  // Indiv. Feld 1 =
        $this->csv .= ';';                                                                  // Indiv. Feld 2 =
        $this->csv .= ';';                                                                  // Indiv. Feld 3 =
        $this->csv .= ';';                                                                  // Indiv. Feld 4 =
        $this->csv .= ';';                                                                  // Indiv. Feld 5 =
        $this->csv .= ';';                                                                  // Indiv. Feld 6 =
        $this->csv .= ';';                                                                  // Indiv. Feld 7 =
        $this->csv .= ';';                                                                  // Indiv. Feld 8 =
        $this->csv .= ';';                                                                  // Indiv. Feld 9 =
        $this->csv .= ';';                                                                  // Indiv. Feld 10 =
        $this->csv .= ';';                                                                  // Indiv. Feld 11 =
        $this->csv .= ';';                                                                  // Indiv. Feld 12 =
        $this->csv .= ';';                                                                  // Indiv. Feld 13 =
        $this->csv .= ';';                                                                  // Indiv. Feld 14 =
        $this->csv .= ';';                                                                  // Indiv. Feld 15 =
        $this->csv .= ';';                                                                  // Abweichende Anrede (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Adressart (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Straße (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Postfach (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Postleitzahl (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Ort (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Land (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Versandzusatz (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Adresszusatz (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Abw. Zustellbezeichnung 1 (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Abw. Zustellbezeichnung 2 (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Adresse Gültig von (Rechnungsadresse) =
        $this->csv .= ';';                                                                  // Adresse Gültig bis (Rechnungsadresse) =
        $this->csv .= chr(10);                                                              // Newline

        return $customer->id;
    }

    /**
     * Get the alpha2 code from the country name.
     * @param string $countryName
     * @return string
     */ 
    private function getAlpha2Code($countryName) {
        return TmsCountry::where('id', json_decode($countryName)->id)->first()->alpha2_code;
    }

    /**
     * Save the CSV file.
     */
    private function saveCsv()
    {
        $filename = 'customers' . Carbon::now()->format('Ymd_His'). '.csv';
        $path = base_path('documents/csvexports/customersWithBillingAddress/' . $filename);
        $data = iconv('UTF-8', 'windows-1252', $this->csv);        
        
        file_put_contents($path, $data);

        TmsCustomer::whereIn('id', $this->exportedIds)->update(['exported_at' => Carbon::now()]);
        TmsAddress::whereIn('customer_id', $this->exportedIds)->update(['exported_at' => Carbon::now()]);        
    }
}
