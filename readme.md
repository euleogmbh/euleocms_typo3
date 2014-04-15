#Euleo Übersetzungsbüro
License: GPLv2 or later

Translate your Website using the Services of https://www.euleo.com/

##Description

###Die Euleo Übersetzungsbüro Erweiterung für Typo3

####Websites übersetzen mit wenigen Klicks

"Euleo Übersetzungsbüro" ist eine Erweiterung, die es ermöglicht,
Typo3-Websites direkt aus dem CMS heraus durch ein qualifiziertes
Übersetzungsbüro übersetzen zu lassen.
Mit wenigen Mausklicks ist es möglich, die Kosten für die Übersetzung
von Website-Inhalten zu ermitteln und eine Übersetzung zu beauftragen.
Wie in einem Webshop können Sie Texte aus Ihrer Website in einen Warenkorb
legen und sehen gleich, wie lange die Übersetzung dauern würde und wieviel
sie kostet. Bei Beauftragung gehen die Texte direkt zum Übersetzungsbüro,
werden dort übersetzt, korrekturgelesen und nach
Fertigstellung automatisch in die Website eingespielt.

####Professionelle Übersetzung in über 30 Sprachen

Euleo bietet professionelle und schnelle Übersetzungsleistungen.
Derzeit werden professionelle Übersetzungen von Deutsch und Englisch in über 30
verschiedene Zielsprachen angeboten.
Mehr als 700 professionelle Native Speaker sind weltweit am
Euleo Translation Management System angeschlossen.
Den Rest erledigt Euleo online und vollautomatisch für Sie.

[Zur Euleo Website](https://www.euleo.com/)

####Höchste Übersetzungsqualität

Euleo arbeitet weltweit mit über 700 Übersetzern für die 30
wichtigsten internationalen Sprachen zusammen.
Jede Übersetzung unterliegt strengen Qualitätskriterien:

- Jede Übersetzung mit einem Native Speaker
- Jeder Text wird von zwei geprüften und langjährig erfahrenen Übersetzern behandelt
- Fach-Terminologie und Eigennamen im Workflow eingebettet
- Jeder Text wird von einem zweiten Übersetzer korrekturgelesen
- Alle Übersetzer verfügen über eine International anerkannte höhere Ausbildung
  für Übersetzung, Dolmetschen oder Sprachwissenschaften

Weitere Informationen finden Sie auf https://www.euleo.com/business/quality.htm

####Vorteile der Euleo Übersetzungsbüro Erweiterung für Typo3

- die zu übersetzenden Texte werden einfach markiert und in den Warenkorb gelegt
- man sieht sofort, wieviel eine Übersetzung kosten würde und wann Sie fertig wäre
- die fertigen Übersetzungen werden automatisch ins CMS rückeingespielt.
  Einpflegearbeiten werden also überflüssig. Das spart Zeit und Geld.


####Funktionsweise

Nachdem Sie sich bei Euleo als Kunde angemeldet haben,
können Sie Textelemente Ihrer Website zur Übersetzung beauftragen.
Diese werden über eine sichere Verbindung zum Euleo Übersetzungsserver
übertragen. Dort werden die Texte von qualifizierten Übersetzern
bearbeitet und korrekturgelesen. Die fertigen Texte werden daraufhin
automatisch an die richtigen Stellen in der Datenbank eingespielt.
Eine E-Mail informiert Sie über die Fertigstellung.


##Installation

- Installieren Sie die Erweiterung ["l10nmgr"](http://typo3.org/extensions/repository/view/l10nmgr).
- Installieren Sie die Erweiterung "extbase".
- Installieren Sie die Erweiterung "fluid".
- Installieren Sie die "Euleo Übersetzungsbüro"-Erweiterung.

###Euleo-Erweiterung einrichten

####Euleo-Callback einrichten
Durch den Callback werden die Übersetztungen in das XML-File übernommen.
Um den Callback einzurichten sind folgende Schritte durchzuführen:
- Legen Sie eine Seite mit dem Titel "Euleocallback" als Unterseite von id=1 an.
- Aktivieren Sie im Reiter "Zugriff" bei "In Menüs" das Häkchen "Verbergen", damit die Seite nicht in der Navigation aufscheint.
- Fügen Sie auf der Seite das Plug-In "Euleo" hinzu.
- Aktivieren Sie nun diese Seite.

####L10N-Manager patchen
Klicken Sie auf den Link. Der Patch wird automatisch eingespielt.
Wird der L10N-Manager aktualisiert muss möglicherweise die Datei "euleo.patched" in dessen Verzeichnis gelöscht werden.

####L10N-Manager konfigurieren
Um mit dem L10N-Manager Exporte erstellen zu können, benötigt dieser eine Konfiguration.
Wie Sie diese Konfiguration erstellen, entnehmen Sie bitte der L10N-Manager Dokumentation unter "Creating a Localization Manager configuation".

####Typo3-Installation mit Euleo verknüpfen
Klicken Sie auf den Link und folgen Sie den Anweisungen

Sollten Sie noch keinen Euleo-Account haben, registrieren Sie sich bitte auf https://www.euleo.com/business/auth

Nach der Bestätigung Ihrer E-Mail-Adresse können Sie Ihre Typo3-Installation damit verknüpfen.

##Verwendung der Erweiterung
Um einen Export zu erstellen, gehen Sie bitte folgendermaßen vor:

- Klicken Sie in der linken Spalte auf den Link L10N-Manager.
- In der Liste der Konfigurationen klicken Sie auf den Titel der gewünschten Konfiguration.
- Wählen Sie die gewünschte Zielsprache im ersten Drop-Down-Feld.
- Im zweiten Drop-Down-Feld wählen Sie "XML-Export/Import".
- Aktivieren Sie die Auswahlbox "Überspringe XML-Überprüfung".
- Um zu erfahren, welche Einstellungsmöglichkeiten der L10N-Manager bietet, sehen Sie bitte in dessen Anleitung.
- Klicken Sie nun auf "Export". Sie können die XML-Datei speichern oder auch abbrechen.

## Export an Euleo übertragen

Um einen Export an Euleo zu übertragen, klicken Sie auf den Dateinamen in der oberen Auflistung.
Sie werden automatisch zum Euleo-Warenkorb weitergeleitet!

## Im Euleo-Warenkorb

Kontrollieren Sie Ihren Warenkorb und beauftragen Sie die Übersetzung.

**ACHTUNG:**

Der L10N-Manager speichert die Zielsprache im Export.
Sollten Sie in mehrere Sprachen übersetzen wollen, muss im Resultat die ID der Sprache in der XML-Datei manuell geändert werden.

## Nach Fertigstellung der Übersetzung

Sobald die Übersetzung fertiggestellt ist, erhalten Sie eine Benachrichtigung per E-Mail.
Die fertige Übersetzung scheint in der unteren Liste auf.
Durch einen Klick auf den Dateinamen können Sie die XML-Datei herunterladen.
Diese Datei kann anschließend im L10N-Manager importiert werden.

##Frequently Asked Questions
siehe https://www.euleo.com/business/FAQ.htm
