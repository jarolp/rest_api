# Zadanie rekrutacyjne

### Użyte Technologie
* PHP
* SQLite 3
* Slim 3 Framework [+ pakiet illuminate/database]

### Wymagania
<p>Do uruchomienia aplikacji wymagany jest środowisko LAMP lub WAMP z PDO oraz SQLite3.</p>
<p>W przypadku Windowsa można pobrać sobie np: WAMPserver.</p>

### Instalacja
Pliki należy pobrać i umieścić w dowolnym katalogu www. 

#### Przykładowa ścieżka dla WAMPserver:
C:\wamp\www\application

#### Utworzenie virtual host'a
Dokładny opis jak to zrobić: 
http://foundationphp.com/tutorials/apache_vhosts.php

#### Wartość w pliku C:\WINDOWS\system32\drivers\etc\hosts
127.0.0.1 api.local

#### Wartość w pliku httpd-vhosts.conf w WAMPserver
<pre>
<code>
	ServerName api.local
	ServerAlias api.local
	DocumentRoot c:/wamp/www/application/public
</code>
</pre>

#### Dane wejściowe
Jako dane wjściowe wymagane są dwa pola:
* nazwisko
* imie
Przykład danych wejściowych:	
<pre>
<code>
{
    "imie" : "Artur",
    "nazwisko" : "Tański"
}
</code>
</pre>
#### Warunki wejścia:
Zadaniem API będzie zapis, odczyt i usuwanie imienia i nazwiska z bazy SQLlite. Dane wchodzące muszą być unikalne.

### Działanie

#### Aplikacja posiada walidację danych wejściowych! Sprawdzane jest :
* czy pola są wysyłane, 
* czy nie są puste,
* oraz znaki w słowie zamienia na małe a pierwszą literę na dużą.

#### Aplikacja posiada cztery linki:

1. Sprawdza czy osoba istnieje w bazie
* http://api.local/read-human - METODA POST

2. Sprawdza czy osoba istnieje w bazie jeśli nie to dodaje ją
* http://api.local/create-human - METODA POST

3. Sprawdza czy osoba istnieje w bazie jeśli tak to usuwa ją
* http://api.local/delete-human - METODA POST

4. Stworzone dla celów podglądowych, wyświetla obecną zawartość bazy
* http://api.local/read-people - METODA GET
	


#### Możliwe odpowiedzi aplikacji
1. /read-human

* Znaleziono w bazie człowieka {imie} {nazwisko}
* Nie znaleziono w bazie człowieka {imie} {nazwisko}
* Nie przesłano wszystkich wymaganych pól. 'Nazwisko', 'Imie'!
* Wszystkie pola muszą być uzupełnione!
	
2. /create-human

* Dodano człowieka do bazy {imie} {nazwisko}!
* Człowiek {imie} {nazwisko} już istnieje w bazie!
* Nie przesłano wszystkich wymaganych pól. 'Nazwisko', 'Imie'!
* Wszystkie pola muszą być uzupełnione!

3. /delete-human

* Usunięto człowieka {imie} {nazwisko}
* Nie znaleziono w bazie człowieka {imie} {nazwisko}
* Nie przesłano wszystkich wymaganych pól. 'Nazwisko', 'Imie'!
* Wszystkie pola muszą być uzupełnione!
	
4. /read-people

* "Zwrotką jest JSON z listą ludzi [imie i nazwisko]"
* Nie przesłano wszystkich wymaganych pól. 'Nazwisko', 'Imie'!
* Wszystkie pola muszą być uzupełnione!

5. Inny link niż te powyżej, pojawi się komunikat "Nieprawidłowy link"
 
#### Lokalizacja pliku SQLite
Baza SQLite utworzy się w lokalizacji /application/public/sqliteDB

### Jak testować?
<p> W przeglądarce zainstalować wtyczkę np: RESTman lub POSTman.</p>
<p> Po uruchomieniu należy wprowadzić link i wybrać metodę wysyłki danych:</p>
<p> W części body wprowadzić pola imie i nazwisko i uzupełnić je. Można ich nie uzupełniać ale pojawi się odpowiedni komunikat o błędzie w danych wejściowych.</p>
<p> W części response pojawi się odpowiedź.</p>
