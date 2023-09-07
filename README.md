# ITSTORE
ITStore to sklep internetowy oferujący różnorodne produkty związane z technologią. Umożliwia przeglądanie produktów, dodawanie ich do koszyka oraz zarządzanie kontem użytkownika. Ponadto, aplikacja posiada CMS do monitorowania, dodawania lub edytowania zamówień i produktów.

## Funkcjonalności:

### Administrator:
Administrator ma najwyższe uprawnienia w aplikacji. Ma dostęp do panelu CMS, który umożliwia:
- Zarządzanie użytkownikami – dodawanie, edytowanie oraz usuwanie użytkowników, a także podgląd jakie konta istnieją w aplikacji. 
- Zarządzanie kategoriami – dodawanie, a także podgląd jakie kategorie już istnieją w aplikacji.
- Zarządzanie produktami – dodawanie, edytowanie oraz usuwanie, a także podgląd jakie produkty już istnieją w aplikacji.
- Przeglądanie zamówień – przeglądanie istniejących zamówień, a także przejście do ich szczegółowych informacji.

### Użytkownik:
Użytkownik to główny typ konta w aplikacji. Ma dostęp do wszystkich funkcji aplikacji z wyłączeniem panelu administracyjnego.
- Zarządzanie profilem – użytkownik ma możliwość edycji hasła, emaila oraz danych osobowych.
- Przeglądanie produktów- przeglądanie istniejących produktów, wraz z podzieleniem na kategorie. Podczas przeglądania produktów użytkownik ma możliwość dodania danego produktu do koszyka.
- Przeglądania szczegółowych informacji o danym produkcie – użytkownik ma możliwość zapoznania się ze szczegółowym opisem danego produktu.
- Zarządzanie koszykiem- użytkownik ma możliwość zarządzania swoim koszykiem- dodawanie produktów, usuwanie produktów z koszyka, a także aktualizowanie ich ilości.

### Gość:
Gość to użytkownik z ograniczonym i najniższym poziomem dostępu do aplikacji. Ma możliwość przeglądania produktów. Ponadto, ma możliwość rejestracji lub zalogowania się do aplikacji, jeżeli posiada aktywne konto.

## Wymagania systemowe
- wersja apache'a : 2.4.41
- wersja PHP'a : 7.4.3
- wersja MySQL : 5.1.1

## Instalacja
- Krok 0: Pierwszym krokiem będzie stworzenie pliku /config/config.php a następnie nadanie mu odpowiednich uprawnień o+w
- Krok 1: W kolejnym kroku wypełniamy formularz odpowiednimi danymi aby utworzyć bazę danych na serwerze.
- Krok 2: Po pomyślnym utworzeniu bazy danych powinny wyświetlić się na ekranie utworzone tabele.
- Krok 3: Następnym krokiem jest wypełnienie bazy danych rekordami, po pomyślnym wykonaniu zadania powinny wyświetlić się na ekranie dodane rekordy w formie tabeli.
- Krok 4: W tym kroku należy wypełnić formularz z danymi dotyczącymi instalowanej aplikacji oraz utworzyć konto administratora w systemie.
- Krok 5: Po pomyślnym wykonaniu wszystkich powyższych kroków, instalator wyświetli komunikat umożliwiający użytkownikowi przejście do strony głównej.

## Autor:
- Jakub Mamiński
- 392772
- maminski

## Wykorzystane zewnętrzne biblioteki:
- bootstrap@5.2.3
- ionicons@7.1.0
