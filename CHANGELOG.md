# Trainerlizenzen Changelog

## Version 2.0.1 (2019-12-20)

- Fix: Kompatibilität mit Contao 4 alle Versionen hergestellt
- Fix: Abhängigkeit Symfony entfernt

## Version 2.0.0 (2019-08-19)

Initialversion als Bundle für Contao 4

## Version 1.4.1 (2018-10-25)

- Fix: Markieren-Checkbox Standardeinstellung von true auf false geändert
- Fix: Zurücklink für PDF-Card-Abruf war falsch. Richtig ist main.php statt contao/main.php
- Fix: Zurücklink für Lizenz-Abruf war falsch. Richtig ist main.php statt contao/main.php
- Fix: Datum letzter Abruf PDF-Card wurde mit 1.1.1970 angezeigt
- Add: Anzeige des Datums der heruntergeladenen PDF-Dateien

## Version 1.4.0 (2018-06-01)

- Add: Bundesverband im Referenten-Formular (für besondere Rechte z.B. bei E-Mails)
- Fix: Beim Mailversand wurde bisher nur 1 Referent des LV berücksichtigt
- Add: DSB-Verantwortliche/r bekommt optional BCC der E-Mail
- Add: DSB-Verantwortliche/r bekommt die Trainerliste immer als BCC

## Version 1.3.0 (2018-01-03)

- Fix: Anpassung der Felder für Contao 4 (CSS)
- Fix: Anpassung der BE-Links für Contao 4
- Fix: Kompatibilität mit C4 in Trainerliste.php hergestellt
- Fix: require xls_export in autoload.ini ergänzt

## Version 1.2.3 (2017-10-27)

- Fix: Beim Export wurden auch deaktivierte Trainer exportiert

## Version 1.2.2 (2017-10-27)

- Fix: Felder Benutzergruppen-Berechtigungen fehlten teilweise (exclude = true)

## Version 1.2.1 (2017-10-27)

- Fix: Lizenzverlängerungen im Export
- Neu: Ausgabe der DOSB-Lizenznummer im Export

## Version 1.2.0 (2017-10-03)

Neuer Entwicklungszweig: Version 2 mit separater Lizenzentabelle ist noch nicht fertig, aber die neuen API-Funktionen wurden gewünscht

- Neu: Lizenzabruf im Format PDF Card
- Fix: Verifizierung um Lizenzerwerbsdatum erweitert

## Version 1.1.0 (2017-07-17)

- Neu: Verlängerungen umgebaut auf MultiColumnWizard

## Version 1.0.0 (2017-06-25)

Erste öffentliche Version
