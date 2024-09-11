-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2024 at 02:36 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gearup_database`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adresy`
--

CREATE TABLE `adresy` (
  `addressId` int(11) NOT NULL,
  `miasto` varchar(255) DEFAULT NULL,
  `kraj` varchar(255) DEFAULT NULL,
  `kod_pocztowy` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adresy`
--

INSERT INTO `adresy` (`addressId`, `miasto`, `kraj`, `kod_pocztowy`) VALUES
(1, 'Warszawa', 'Polska', '00-006'),
(2, 'Sandomierz', 'Polska', '27-600'),
(5, '', '', ''),
(6, '', '', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `kategoriaId` int(11) NOT NULL,
  `nazwa` varchar(255) DEFAULT NULL,
  `zdjecie_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`kategoriaId`, `nazwa`, `zdjecie_url`) VALUES
(1, 'Piłka nożna', 'pilka.jpg'),
(2, 'Rowery', 'rowery.jpg'),
(3, 'Narciarstwo', 'narty.jpg'),
(4, 'Turystyka', 'turystyka.jpg'),
(5, 'Tenis', 'tenis.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oferty`
--

CREATE TABLE `oferty` (
  `ofertyId` int(11) NOT NULL,
  `nazwa_produktu` varchar(255) DEFAULT NULL,
  `kategoriaId` int(11) DEFAULT NULL,
  `cena` decimal(10,2) DEFAULT NULL,
  `data_dodania` date DEFAULT NULL,
  `opis` text DEFAULT NULL,
  `uzytkownicyId` int(11) DEFAULT NULL,
  `lokalizacja` varchar(255) NOT NULL,
  `dostepna` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oferty`
--

INSERT INTO `oferty` (`ofertyId`, `nazwa_produktu`, `kategoriaId`, `cena`, `data_dodania`, `opis`, `uzytkownicyId`, `lokalizacja`, `dostepna`) VALUES
(14, 'Deska Snowboardowa', 3, 100.00, '2024-03-28', 'Zupełnie nowa deska snowboardową Nitro x Volcom Ripper w kształcie twin tipowym, stworzoną dla małych riderów, którzy pragną opanować pierwsze skręty, hamowanie, kontrolę prędkości, ollie, graby i inne wymarzone triki. Łatwy profil deski Flat-Out Rocker i elastyczność rdzenia Softride Ripper wybaczą błędy młodego shreddera, który nie będzie musiał martwić się o złapanie przeciwkrawędzi. Ten true twin tip wyposażony jest w łatwy w utrzymaniu ślizg Premium Extruded FH.\r\n\r\nSpecyfikacja:\r\n\r\nKształt: twin\r\n\r\nProfil: Flat-out Rocker - kombinacja strefy flat camber z rockerem na końcach deski\r\n\r\nSztywność: 1 w skali na 10 (1-miękki, 10-najsztywniejszy)\r\n\r\nSidecut: Radial - krzywizna boczna deski. Konstrukcja oparta jest na jednym promieniu na całej długości deski\r\n\r\nRdzeń: Powercore - drewniany rdzeń z topoli \r\n\r\nŚlizg: Tłoczony Premium Extruded FH - przyjemny, trwały ślizg, łatwy w utrzymaniu\r\n', 4, 'Warszawa', 0),
(15, 'Piłka Nike Academy', 1, 50.00, '2024-03-30', 'Płeć:\r\nUnisex\r\nSezon:\r\nKolor:\r\nBiały\r\nSport:\r\nPiłka nożna\r\nMateriał:\r\n60% elastodien, 15% polyurethan, 13% polyester, 12% ethylenvinylacetat\r\nTyp piłki:\r\nTreningowa', 4, 'Gdańsk', 0),
(17, 'Rakieta tenisowa Babolat Pure Strike Lite 3gen', 5, 99.00, '2024-04-02', 'Rakieta tenisowa Babolat Pure Strike Lite 3gen. \r\nPotestowy model rakiety zachowany w bardzo dobrym stanie. Delikatne zarysowania widoczne na bocznych częściach ramy. Rakieta posiada założony naciąg Babolat RPM Power oraz owijkę zewnętrzną. \r\n\r\nRakieta z kolekcji Pure Strike dla młodych zawodników turniejowych i amatorów szukających lżejszej ramy. Waga - 265g - ułatwia manewrowanie i sprawia, że to model idealny dla szerokiego spektrum zawodników. Główka oferuje duże pole centrycznego trafienia. Balans to idealne połączenie mocy i kontroli. Niska waga nie obciąża ręki. Zastosowano następujące technologie: FSI POWER, C2 PURE FEEL, CONTROL FRAME TECHNOLOGY.', 4, 'Płock', 0),
(18, 'Rower górski z pełna amortyacją Crussis LEGEND 68 29\" - model 2024 - 19\" (170-185 cm)', 2, 899.00, '2024-04-02', 'Najlepszy e-rower sezonu już tu jest! Zainspirowany legendą narodowego hokeja, Crussis LEGEND 68 jest efektem pracy całego zespołu Crussis i idealnym e-rowerem dla wymagających rowerzystów. Dzięki unikalnemu złoto-czarnemu designowi masz także pewność, że każdy odwróci za Tobą głowę na przejażdżkach.\r\n\r\nJako pierwszy rower Crussis wyposażony jest w karbonową ramę, jest w pełni amortyzowany i napędzany topowym silnikiem BOSCH Performance CX. Razem z pojemnym akumulatorem Bosch PowerTube 750 przejedziesz nawet 170 km, dzięki czemu jazda na luksusowym rowerze będzie naprawdę przyjemna! Wszystkim sterujesz za pomocą wyświetlacza LCD BOSCH Kiox 300, na którym dostępny jest również asystent chodzenia.\r\n\r\nZa zmianę przełożeń odpowiada najwyższej klasy 12-biegowy zestaw SRAM Eagle XX1. Dodatkowo najwyższej klasy widelec amortyzowany FOX 36 Float e-MTB+ o skoku 150 mm uprzyjemni Ci jazdę. Tylne zawieszenie zapewnia lekki amortyzator FOX Float X z kompleksowym systemem tuningu.\r\n\r\nSzerokie 29-calowe koła obute są w opony MAXXIS Rekon o grubości 2,6 cala. Oferują bezkompromisową jakość, która nie pozostawi Cię samym sobie nawet w najtrudniejszym terenie. O Twoje bezpieczeństwo zadbają hamulce hydrauliczne SRAM Code R.', 4, 'Szczecin', 1),
(31, 'Narty damskie allmountain SALOMON E STANCE 80 W', 3, 179.00, '2024-04-03', 'Styl Jazdy: ALLMOUNTAIN / FREERIDE\r\nSezon: 2022/2023\r\nPłeć: Kobieta\r\nWiązanie narciarskie w zestawie: SALOMON M11 z GRIP WALK\r\nZakres rozstawu wiązań (mm): 253 - 320 mm\r\nPłyta pod wiązaniem: tak\r\nTechnologie: TYTNOWO-CARBONOWA RAMA NARTY, GRIP WALK\r\nDIN wiązań (skala siły wypięcia): 3,5 - 11\r\nRocker: ALLRIDE ROCKER\r\nSzerokość talii (mm): 80 mm\r\nRdzeń narty: POPLAR WOODCORE- RDZEŃ DREWNIANY Z DREWNA TOPOLI\r\nStan: FABRYCZNIE NOWE\r\nPoziom zaawansowania narciarza: średniozaawansowany/zaawansowany', 4, 'Warszawa', 1),
(34, 'Explor Backpack 30L Unisex', 4, 59.00, '2024-04-08', 'Explor 30 to jedyny plecak, którego naprawdę potrzebujesz! Zaprojektowany został z myślą o wielofunkcyjności i łatwym dostępie do spakowanych rzeczy. Plecak spełnia standardy wymiarów bagażu podręcznego w samolocie.\r\nKieszeń główna otwiera się w podobny sposób, co walizka, dając dobry dostęp do spakowanego bagażu. Plecak zawiera przegrodę na laptop do 17\"\" (rozmiar 37,5 x 24.5 cm), solidny, odpinany pas biodrowy z trzema kieszeniami a także posiada dopasowanie Smart-Hydration-compatibile™ z zapięciem na zamek błyskawiczny, które umożliwia wygodne korzystanie z Twojego bukłaka na wodę. Znajduje się ono na pasku ramiennym i daje bardzo szybki i łatwy dostęp do płynu. Dzięki wielofunkcyjnym zaczepom do plecaka można przymocować siekierę, narty, karimatę lub inne wyposażenie.\r\nExplor 30 ma wiele wewnętrznych oraz zewnętrznych kieszeni oraz płaskie dno które sprawia, że można go postawić. Stabilizująca wkładka na plecach odznacza się doskonałą wentylacją.\r\nPlecak jest odporny na wilgoć i został zaprojektowany z myślą o wspinaczce, wycieczkach na ryby, jeździe na nartach, codziennemu dojeżdżaniu do pracy a także wszelkiego rodzaju wycieczkach i wyprawach.\r\n*Do tego plecaka dołączona jest osłona przeciwdeszczowa Backpack Raincover.\r\n\r\n55 x 30 x 18 cm', 11, 'Rzeszów', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rozgrywki`
--

CREATE TABLE `rozgrywki` (
  `rozgrywkiId` int(11) NOT NULL,
  `nazwa` varchar(255) DEFAULT NULL,
  `kategoriaId` int(11) DEFAULT NULL,
  `dataRozgrywki` datetime DEFAULT NULL,
  `lokalizacja` varchar(255) DEFAULT NULL,
  `liczbaOsob` int(11) DEFAULT NULL,
  `opis` text DEFAULT NULL,
  `uzytkownicyId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rozgrywki`
--

INSERT INTO `rozgrywki` (`rozgrywkiId`, `nazwa`, `kategoriaId`, `dataRozgrywki`, `lokalizacja`, `liczbaOsob`, `opis`, `uzytkownicyId`) VALUES
(1, 'Towarzyski mecz piłki nożnej na lokalnym boisku', 1, '2024-04-20 13:00:00', 'Warszawa', 16, 'Zapraszamy wszystkich miłośników piłki nożnej na towarzyski mecz, który odbędzie się 20 kwietnia 2024 roku na stadionie miejskim w Miastowie. Mecz rozpocznie się o godzinie 13:00 i będzie trwał do wyczerpania sił wszystkich uczestników.\r\n\r\nZasady:\r\n\r\nMecz będzie trwał około 2 godzin.\r\nKażdy uczestnik może wziąć udział bez względu na wiek czy umiejętności piłkarskie.\r\nWymagane jest założenie odpowiedniego stroju sportowego i obuwia do gry na sztucznej nawierzchni.\r\nOrganizatorzy zapewniają piłki oraz bramki.\r\n\r\nPo meczu będzie można zostać na grilla organizowanego wraz z prowadzącym.', 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczestnictwo`
--

CREATE TABLE `uczestnictwo` (
  `uczestnictwoId` int(11) NOT NULL,
  `rozgrywkiId` int(11) DEFAULT NULL,
  `uzytkownicyId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `nazwa_uzytkownika` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `haslo` varchar(128) NOT NULL,
  `profile_pic` varchar(135) DEFAULT NULL,
  `plec` varchar(26) DEFAULT NULL,
  `numer_telefonu` varchar(250) DEFAULT NULL,
  `addressId` int(11) DEFAULT NULL,
  `imie` varchar(255) DEFAULT NULL,
  `nazwisko` varchar(255) DEFAULT NULL,
  `opis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `nazwa_uzytkownika`, `email`, `haslo`, `profile_pic`, `plec`, `numer_telefonu`, `addressId`, `imie`, `nazwisko`, `opis`) VALUES
(4, 'Jacobn0x', 'Jakubowskyy97@gmail.com', '$2y$10$./tOMOB9zG3rh7kZPZM9guDGNnrJl1DglsLvyEVr4vh1je4NFhxqK', '../Images/Profile/knitwear-data.jpg', 'male', '788893232', 1, 'Krzysztof', 'Kowalski', ''),
(11, 'adrianK', 'AdrianKowal@gmail.com', '$2y$10$x3bIW1B2/spqSONybSQ6EepRtucgH9iIcivXPXJVPtS2e3A9HiKM2', '../Images/Profile/defaultUser.jpg', 'male', '643432890', 5, NULL, NULL, NULL),
(12, 'test', 'test@test.pl', '$2y$10$YCYLWHn/VteXiO6R2Dznsu/TLb8XPCJ1pdx8td49LEISR4tFS362m', '../Images/Profile/defaultUser.jpg', 'male', '798231543', 6, 'Marcin', 'Kołodziej', 'Parę słów o mnie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wypozyczenia`
--

CREATE TABLE `wypozyczenia` (
  `wypozyczeniaId` int(11) NOT NULL,
  `uzytkownikId` int(11) DEFAULT NULL,
  `ofertyId` int(11) DEFAULT NULL,
  `dataRozpoczecia` date DEFAULT NULL,
  `dataZakonczenia` date DEFAULT NULL,
  `cena` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wypozyczenia`
--

INSERT INTO `wypozyczenia` (`wypozyczeniaId`, `uzytkownikId`, `ofertyId`, `dataRozpoczecia`, `dataZakonczenia`, `cena`) VALUES
(6, 11, 15, '2024-04-11', '2024-04-26', 107.14),
(7, 4, 14, '2024-04-09', '2024-04-12', 42.86),
(8, 12, 17, '2024-04-11', '2024-04-26', 212.14);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia`
--

CREATE TABLE `zdjecia` (
  `zdjecieId` int(11) NOT NULL,
  `nazwa_pliku` varchar(255) DEFAULT 'default.jpg',
  `ofertyId` int(11) DEFAULT NULL,
  `rozgrywkiId` int(11) DEFAULT NULL,
  `typ` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zdjecia`
--

INSERT INTO `zdjecia` (`zdjecieId`, `nazwa_pliku`, `ofertyId`, `rozgrywkiId`, `typ`) VALUES
(10, 'Deska_1.jpg', 14, NULL, 'oferta'),
(11, 'Deska_2.jpg', 14, NULL, 'oferta'),
(12, 'Deska_3.jpg', 14, NULL, 'oferta'),
(13, 'Deska_4.jpg', 14, NULL, 'oferta'),
(15, 'Piłka_1.jpg', 15, NULL, 'oferta'),
(17, 'Rakieta_1.jpg', 17, NULL, 'oferta'),
(18, 'Rakieta_2.jpg', 17, NULL, 'oferta'),
(19, 'Rakieta_3.jpg', 17, NULL, 'oferta'),
(20, 'Rakieta_4.jpg', 17, NULL, 'oferta'),
(21, 'Rower_1.jpg', 18, NULL, 'oferta'),
(22, 'Rower_2.jpg', 18, NULL, 'oferta'),
(23, 'Rower_3.jpg', 18, NULL, 'oferta'),
(24, 'Rower_4.jpg', 18, NULL, 'oferta'),
(50, 'Narty_damskie_allmountain_SALOMON_E_STANCE_80_W_1.jpg', 31, NULL, 'oferta'),
(51, 'Narty_damskie_allmountain_SALOMON_E_STANCE_80_W_2.jpg', 31, NULL, 'oferta'),
(52, 'Narty_damskie_allmountain_SALOMON_E_STANCE_80_W_3.jpg', 31, NULL, 'oferta'),
(53, 'Narty_damskie_allmountain_SALOMON_E_STANCE_80_W_4.jpg', 31, NULL, 'oferta'),
(54, 'Towarzyski_mecz_piłki_nożnej_na_lokalnym_boisku_1.jpg', NULL, 1, 'rozgrywka'),
(55, 'Towarzyski_mecz_piłki_nożnej_na_lokalnym_boisku_2.jpg', NULL, 1, 'rozgrywka'),
(56, 'Towarzyski_mecz_piłki_nożnej_na_lokalnym_boisku_3.jpg', NULL, 1, 'rozgrywka'),
(70, 'Explor_Backpack_30L_Unisex_1.jpg', 34, NULL, 'oferta'),
(71, 'Explor_Backpack_30L_Unisex_2.jpg', 34, NULL, 'oferta'),
(72, 'Explor_Backpack_30L_Unisex_3.jpg', 34, NULL, 'oferta'),
(73, 'Explor_Backpack_30L_Unisex_4.jpg', 34, NULL, 'oferta');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `adresy`
--
ALTER TABLE `adresy`
  ADD PRIMARY KEY (`addressId`);

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`kategoriaId`);

--
-- Indeksy dla tabeli `oferty`
--
ALTER TABLE `oferty`
  ADD PRIMARY KEY (`ofertyId`),
  ADD KEY `kategoriaId` (`kategoriaId`),
  ADD KEY `uzytkownicyId` (`uzytkownicyId`);

--
-- Indeksy dla tabeli `rozgrywki`
--
ALTER TABLE `rozgrywki`
  ADD PRIMARY KEY (`rozgrywkiId`),
  ADD KEY `kategoriaId` (`kategoriaId`),
  ADD KEY `uzytkownicyId` (`uzytkownicyId`);

--
-- Indeksy dla tabeli `uczestnictwo`
--
ALTER TABLE `uczestnictwo`
  ADD PRIMARY KEY (`uczestnictwoId`),
  ADD UNIQUE KEY `rozgrywkiId` (`rozgrywkiId`,`uzytkownicyId`),
  ADD KEY `uzytkownicyId` (`uzytkownicyId`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addressId` (`addressId`);

--
-- Indeksy dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD PRIMARY KEY (`wypozyczeniaId`),
  ADD KEY `uzytkownikId` (`uzytkownikId`),
  ADD KEY `ofertyId` (`ofertyId`);

--
-- Indeksy dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD PRIMARY KEY (`zdjecieId`),
  ADD KEY `ofertyId` (`ofertyId`),
  ADD KEY `rozgrywkiId` (`rozgrywkiId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresy`
--
ALTER TABLE `adresy`
  MODIFY `addressId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `kategoriaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `oferty`
--
ALTER TABLE `oferty`
  MODIFY `ofertyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `rozgrywki`
--
ALTER TABLE `rozgrywki`
  MODIFY `rozgrywkiId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `uczestnictwo`
--
ALTER TABLE `uczestnictwo`
  MODIFY `uczestnictwoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  MODIFY `wypozyczeniaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `zdjecia`
--
ALTER TABLE `zdjecia`
  MODIFY `zdjecieId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `oferty`
--
ALTER TABLE `oferty`
  ADD CONSTRAINT `oferty_ibfk_1` FOREIGN KEY (`kategoriaId`) REFERENCES `kategorie` (`kategoriaId`),
  ADD CONSTRAINT `oferty_ibfk_2` FOREIGN KEY (`uzytkownicyId`) REFERENCES `uzytkownicy` (`id`);

--
-- Constraints for table `rozgrywki`
--
ALTER TABLE `rozgrywki`
  ADD CONSTRAINT `rozgrywki_ibfk_1` FOREIGN KEY (`kategoriaId`) REFERENCES `kategorie` (`kategoriaId`),
  ADD CONSTRAINT `rozgrywki_ibfk_2` FOREIGN KEY (`uzytkownicyId`) REFERENCES `uzytkownicy` (`id`);

--
-- Constraints for table `uczestnictwo`
--
ALTER TABLE `uczestnictwo`
  ADD CONSTRAINT `uczestnictwo_ibfk_1` FOREIGN KEY (`rozgrywkiId`) REFERENCES `rozgrywki` (`rozgrywkiId`),
  ADD CONSTRAINT `uczestnictwo_ibfk_2` FOREIGN KEY (`uzytkownicyId`) REFERENCES `uzytkownicy` (`id`);

--
-- Constraints for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (`addressId`) REFERENCES `adresy` (`addressId`);

--
-- Constraints for table `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD CONSTRAINT `wypozyczenia_ibfk_1` FOREIGN KEY (`uzytkownikId`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `wypozyczenia_ibfk_2` FOREIGN KEY (`ofertyId`) REFERENCES `oferty` (`ofertyId`);

--
-- Constraints for table `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD CONSTRAINT `zdjecia_ibfk_1` FOREIGN KEY (`ofertyId`) REFERENCES `oferty` (`ofertyId`),
  ADD CONSTRAINT `zdjecia_ibfk_2` FOREIGN KEY (`rozgrywkiId`) REFERENCES `rozgrywki` (`rozgrywkiId`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_expired_rentals_and_update_offers` ON SCHEDULE EVERY 1 HOUR STARTS '2024-04-04 20:35:38' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM wypozyczenia WHERE dataZakonczenia < CURDATE();
    UPDATE oferty 
    SET dostepna = 1 
    WHERE ofertyId NOT IN (SELECT ofertyId FROM wypozyczenia);
  END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
