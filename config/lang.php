<?php 
/* 
Central file with traslate variables and other string language
*/
$APP_NAME = "SoI - Shadows of Island";
if(isset($_SESSION['lang'])) {
    $LANG = $_SESSION['lang'];
} else {
    $LANG = 'PL';
}


if($LANG == "PL") {
    // Statystyki i informacje o graczu
    $labels = array(
        "NAME"      => "Imię",
        "CHARACTER" => "Postać",
        "CHAR_STAT" => "Statystyki postaci",
        "EMAIL"     => "E-mail",
        "RE_EMAIL"  => "Powtórz E-mail",
        "PASS"      => "Hasło",
        "RE_PASS"   => "Powtórz hasło",
        "ENERGY"    => "Energia",
        "STR"       => "Siłą",
        "HP"        => "Życie",
        "GOLD"      => "Złoto",
        // Lokalizacja i opisy
        "CITY"      => "Miasto",
        "ADVENTURE" => "Przygoda",
        "ADVENTURE_DESC" => "Wyrusz w mroczną przygodę, w której czekają bestie i potwory, a powrót może być niemożliwy. To wyzwanie, które sprawdzi Twoją odwagę i umiejętności przetrwania. Nie dla tchórzy, ale dla tych, którzy są gotowi stawić czoła swoim największym lękom i wrócić niezmienieni.",
        "HEALER"    => "Uzdrowiciel",
        "HEALER_DESC" => "Miejsce do którego trafisz, prędzej czy później. Uzdrowiciel wyleczy Twoje rany, a jeżeli trzeba - ściągnie zza światów.",
        "INN"       => "Karczma",
        "INN_DESC"  => "Karczma w mrocznym świecie to zapomniany zakątek, oświetlany jedynie skąpym światłem przyciemnionych świec. Drewniane belki na suficie są niemal zatopione w dymie, a ściany obrosły ciemnymi plamami historii. W tle szmery tajemniczych rozmów, a na zapomnianym pianinie melodyjka zatracenia.",
        "ARENA"     => "ARENA",
        "ARENA_DESC" => "Wokół murów unosi się tajemnicza i nieprzenikniona ciemność, w której czai się niebezpieczeństwo. Każdy krok na tej arenie to krok w nieznane, a w powietrzu unosi się zapach magii i krwi. To miejsce, gdzie bohaterowie zmierzą się w epickich pojedynkach, a ich losy zostaną przypieczętowane w mrocznych okolicznościach.",
        "SHOP"      => "SKLEP",
        "SHOP_DESC" => "Największy sklep w mieście. Widać go z daleka. Ma mocne, drewniane dzwi wejściowe. Jeżeli masz złoto, tutaj dostaniesz coś, co może przydać Ci się w trakcie podróży. Nie ryzykuj tu kradzieży! Magiczne oczy widzą każdego wędrowca. Zapłać uczciwie, a sklepikarz da Ci to czego zażadasz.",
        "WORK_DISTRICT" => "DZIELNICA PRACY",
        "WORK_DISTRICT_DESC" => "Wszystko ma swoją cene. Potrzebujesz złota, aby kupić najpotrzebniejsze rzeczy. Tutaj możesz podjąć się pracy, aby zarobić trochę monet.",
        "TOWN_HALL" => "Ratusz",
        "TOWN_HALL_DESC" => "Jedno z najbardziej okazałych miejsc na wyspie. Znajdziesz tutaj spis mieszkańców oraz podróżników. W jednej z sal znajdują sie również tablie ogłoszeniowe.",
        "CHAR_STAT_DESC" => "Kompletny opis statystyk mechanicznych Twojej postaci.",
        "EQUIPMENT" => "Ekwipunek",
        "EQUIPMENT_DESC" => "Zanim gdziekolwiek się ruszysz, warto sprawdzić, czy masz przy sobie jakąkolwiek broń. Inaczej Twój los będzie bardziej niż marny!",
        "PRIV_MESS_DESC" => "Twoja indywidualna skrzynka odbiorza. Tutaj wyślesz wiadomość do innego gracza oraz otrzymasz wszystkie listy skierowane do Ciebie!",
        "MAIN_CHAT" => "Czat główny",
        "MAIN_CHAT_DESC" => "Miejsce luźnych rozmów. Nie jest to karczma. Czat to miejsce do rozmów na wszelkie tematy. Prosimy o zachowanie kultury!",
        "CHANGELOG" => "Ostatnie zmiany",
        "CHANGELOG_DESC" => "Ostatnie zmiany w grze. Warto sprawdzić co nowego w SoI!",
        "SETTING_DESC" => "Tutaj zmienisz swój nickname, hasło oraz zarządzisz swoim kontem w grze!",

        "START_INFO_1" => '<h2>Twoja podróż rozpoczyna się tutaj...</h2>
        <p>Dokładnie nikt nie pamięta, kto pierwszy dotarł do tej wyspy. Lepiej by jednak było, gdyby nikt nigdy do niej nie dotarł, bowiem cień na niej jest wieczny</p>
        <p>Czy zdołasz przełamać strach? Czy udasz się jako jeden z kolejnych Wędrowców w głąb tej krainy?</p>
        <p>Budzisz się obolały na brzegu tego ponurego miejsca. Nie pamiętasz co się dokładnie stało, ani nawet kim na prawdę jesteś. Rozglądasz się uważnie dookoła, ale widok, który masz przed sobą nie napawa Cię radością.
        To miejsce jest inne, dziwne, być może złe. Chwilę pózniej na kamieniu obok przysiada ptak i uważnie Cię obserwuje. Nie wygląda na łagodne stworzenie, a jego pazury zapewne nie są
        tylko na pokaz. Chcesz iść w jego kierunku, coś powiedzieć, ale ptaszyko rozdziera dziub, a pisk przeszywa Cię lękiem do szpiku kości. Ten dzwięk otumania Twoje zmysły, padasz na kolana i czujesz, że życie z Ciebie ucieka...
        <p>Budzisz się znów, jest wczesny ranek.. a obok Ciebie skrawek papieru. Ostrożnie bierzesz go do ręki mając nadzieje, że to wszystko tylko straszny sen. 
           Ku swemu zdziwieniu potrafisz odczytać zawartość tej zniszczonej kartki. Wiadomość jest krótka - "Chodź.. chodź.. czekamy!" </p>
        <p>Nie widząc innej możliwości, wstajesz z wolna i sprawdzasz swój stan. Możesz chodzić, a to już dobrze. Kawałek dalej znajdujesz długi kij i wydetpną ścieżkę. 
         Chwytając badyla dla lepszej równowagi jak i bezpieczeństwa, powoli idziesz w kierunku mało zachęcającej drogi.. </p>',
        "START_INFO_2" => '                    <h2>Czym jest Shadows of Island?</h2>
        <p>Shadows of Island (SoI) to internetowa gra przeglądarkowka skierowana do wszystkich graczy ceniących sobie rozgrwykę w "papierowe rpgi". 
        Gra stara się oddać klimat pierwotnych gier role-play, więc nie uświadczysz u nas rozbudowanych efektów graficznych. Szczegółówe opisy miejsc oraz zdarzeń
        wraz z ilustracjami pozwolą zrozumieć Ci co zaszło w trakcie Twoich przygód. W trakcie gry skup się na odgrywaniu swojej roli. Pamiętaj, że na wyspie mógł wylądować każdy. 
        Może to pisarz, a może żadny krwi barbarzyńca?</p>
        <p>Klimat gry oparty jest na mrocznej fantastycznej. Spotkać tu można absolutnie wszystko. Od pięknych dam, szlachetnych rycerz, a nawet czterdziestookie demony. 
            Harpie, trole, nagi, dziki. Jeże i ryby. Zamki, speluny, lochy i twareny. Ograniczy Cie tylko Twoja wyobrażnia i pomysł na przygodę!</p>
        </p>
        <ul> Główne cechy gry
            <li>Darmowe konto</li>
            <li>Historia Twojej postaci potoczy się tak, jak TY chcesz!</li>
            <li>Brak ścisłej fabuły, gracze sami tworzą przygody!</li>
            <li>Czat do rozgrywek klimatycznych (sesji, przygód) oraz czat ogólny do rozmów lużnych!</li>
            <li>Możesz grać mechanicznie (Zdobywać poziomy, rozwijać statystyki) lub całkowicie klimatycznie (Za pomocą karczmy).
            <li>I wiele więcej...</li>
        </ul>',
        
        // String (Button, Other)
        "TIME"      => "Data i godzina",
        "START"     => "Wyrusz",
        "DASHBOARD" => "Panel główny",
        "OTHER_FUNC" => "Pozostałe funkcje",
        "PRIV_MESS" => "Prywatne wiadomości",
        "SETTING"   => "Ustawienia",
        "LOGOUT"    => "Wyloguj się",
        "LOGIN"     => "Logowanie",
        "LOGIN_BTN" => "Zaloguj się",
        "REGISTER"  => "Rejestracja",
        "REGISTER_BTN"  => "Zarejestruj się",
        "ADM_PANEL" => "Panel admina",
        "IMG_SRC"   => "Źródło zdjęcia",
        "CLOSE_BTN" => "Zamknij",

        // In location
        "ADVENTURE_DESC_2" => "Zanim opuścisz mury miasta, poświęcasz wiele czasu na przygotowanie swojego ekwipunku. 
        Wiesz, że to, co zabierzesz ze sobą, może zadecydować o Twoim przetrwaniu w trudnych chwilach. Odpowiednio pakujesz swój plecak,
        upewniając się, że masz przy sobie jedzenie, które zaspokoi Twoje głodne żołądek w czasie podróży, wodę, która ugasi pragnienie, a także śpiwór,
        który zagwarantuje Ci spokojny sen podczas noclegów na dziko. Kiedy patrzysz na swoje dobrze przygotowane wyposażenie,
        wiesz, że jesteś gotowy na to wyzwanie. Wyruszasz w nieznane tereny, pełen nadziei i determinacji, by odkryć świat poza murami miasta i poznać tajemnice,
        które skrywają się na tej długiej drodze.
        Czy chcesz wyruszyć? Koszt to 1 punkt energi/wyprawa.",
    );
} else if ($LANG == "ENG") {
    // Statystyki i informacje o graczu
    $labels = array(
        "NAME"      => "Name",
        "CHARACTER" => "Character",
        "CHAR_STAT" => "Character statistics",
        "EMAIL"     => "E-mail",
        "RE_EMAIL"  => "Repeat E-mail",
        "PASS"      => "Password",
        "RE_PASS"   => "Repeat password",
        "ENERGY"    => "Energy",
        "STR"       => "Strength",
        "HP"        => "Health",
        "GOLD"      => "Gold",
        // Lokalizacja i opisy
        "CITY"      => "City",
        "ADVENTURE" => "Adventure",
        "ADVENTURE_DESC" => "Embark on a dark adventure where beasts and monsters await and returning may be impossible. This is a challenge that will test your courage and survival skills. Not for cowards, but for those who are ready to face their greatest fears and not come back unchanged.",
        "HEALER"    => "Healer",
        "HEALER_DESC" => "A place you will reach, sooner or later. The healer will heal your wounds and, if necessary, bring you back from beyond the worlds.",
        "INN"       => "Inn",
        "INN_DESC"  => "The inn in a dark world is a forgotten corner, lit only by the scant light of dim candles. The wooden beams on the ceiling are almost engulfed in smoke, and the walls are covered with dark stains of history. In the background there are the murmurs of mysterious conversations and the melody of doom playing on a forgotten piano.",
        "ARENA"     => "ARENA",
        "ARENA_DESC"     => "There is a mysterious and impenetrable darkness around the walls, where danger lurks. Every step in this arena is a step into the unknown, and the smell of magic and blood hangs in the air. This is a place where heroes will face each other in epic duels, and their fate will be sealed in dark circumstances.",
        "SHOP"      => "SHOP",
        "SHOP_DESC" => "The biggest store in town. It can be seen from a distance. It has a strong wooden entrance door. If you have gold, here you will get something that may be useful during your trip. Don't risk theft here! Magic eyes see every wanderer. Pay honestly and the shopkeeper will give you what you want.",
        "WORK_DISTRICT" => "WORK DISTRICT",
        "WORK_DISTRICT_DESC" => "Everything has its price. You need gold to buy the most necessary things. Here you can take a job to earn some coins.",
        "TOWN_HALL" => "Town Hall",
        "TOWN_HALL_DESC" => "One of the most impressive places on the island. Here you will find a list of residents and travelers. There are also bulletin boards in one of the rooms.",
        "CHAR_STAT_DESC" => "A complete description of your character's mechanical statistics.",
        "EQUIPMENT" => "Equipment",
        "EQUIPMENT_DESC" => "Before you go anywhere, it's worth checking if you have any weapons with you. Otherwise, your fate will be more than miserable!",
        "PRIV_MESS_DESC" => "Your individual mailbox receives. Here you can send a message to another player and receive all letters addressed to you!",
        "MAIN_CHAT" => "Main chat",
        "MAIN_CHAT_DESC" => "A place for casual conversations. This is not an inn. Chat is a place to talk about any topic. Please keep it civil!",
        "CHANGELOG" => "Changelog",
        "CHANGELOG_DESC" => "Recent changes to the game. It's worth checking out what's new in SoI!",
        "SETTING_DESC" => "Here you can change your nickname, password and manage your game account!",

        "START_INFO_1" => '<h2>Your journey begins here...</h2>
        <p>No one exactly remembers who first reached this island. It would have been better if no one ever did, for the shadow here is eternal.</p>
        <p>Can you overcome the fear? Will you venture forth as one of the next Wanderers into the heart of this land?</p>
        <p>You wake up sore on the shore of this grim place. You dont remember exactly what happened, or even who you truly are. You look around carefully, but the sight before you does not fill you with joy.
        This place is different, strange, perhaps evil. A moment later, a bird lands on a nearby rock and observes you closely. It doesnt look like a gentle creature, and its claws are probably not just for show. You want to approach it, say something, but the bird opens its beak, and its screech pierces you with fear to the core. That sound numbs your senses, you fall to your knees, feeling life slipping away from you...
        <p>You wake up again, its early morning... and next to you is a piece of paper. You cautiously pick it up hoping its all just a terrible dream.
        To your surprise, you can read the contents of this damaged sheet. The message is short - "Come.. come.. were waiting!"</p>
        <p>Seeing no other option, you slowly rise and assess your condition. You can walk, which is good. A little further, you find a long stick and a beaten path.
        Grasping the stick for better balance and safety, you slowly walk towards the uninviting road..</p>
        ',
        "START_INFO_2" => '<h2>What is Shadows of Island?</h2>
        <p>Shadows of Island (SoI) is an online browser-based game aimed at all players who appreciate gameplay in "pen-and-paper RPGs".
        The game aims to capture the atmosphere of classic role-playing games, so you wont find elaborate graphical effects here. Detailed descriptions of locations and events,
        along with illustrations, will help you understand what happened during your adventures. During the game, focus on playing your role. Remember, anyone could have landed on the island.
        It could be a writer, or perhaps a barbarian of no blood?</p>
        <p>The games atmosphere is based on dark fantasy. Here you can encounter absolutely anything. From beautiful ladies, noble knights, to forty-eyed demons.
        Harpies, trolls, nagi, wild animals. Hedgehogs and fish. Castles, caves, dungeons, and swamps. Only your imagination and adventure ideas will limit you!</p>
        <ul>Main features of the game
            <li>Free account</li>
            <li>Your characters story will unfold as YOU wish!</li>
            <li>No strict storyline, players create adventures themselves!</li>
            <li>Chat for immersive gameplay (sessions, adventures) and general chat for casual conversations!</li>
            <li>You can play mechanically (level up, develop statistics) or completely atmospherically (using the tavern).</li>
            <li>And much more...</li>
        </ul>',
        
        // String (Button, Other)
        "TIME"      => "Date & Time",
        "START"     => "Go",
        "DASHBOARD" => "Dashboard",
        "OTHER_FUNC" => "Other functions",
        "PRIV_MESS" => "Private messages",
        "SETTING"   => "Setting",
        "LOGOUT"    => "Log out",
        "LOGIN"     => "Login",
        "LOGIN_BTN"     => "Log in",
        "REGISTER"  => "Register",
        "REGISTER_BTN"  => "Create account",
        "ADM_PANEL" => "Admin panel",
        "IMG_SRC"   => "Image source",
        "CLOSE_BTN" => "Close",

        // In location
        "ADVENTURE_DESC_2" => "Before you leave the city walls, you spend a lot of time preparing your equipment.
        You know that what you take with you may determine your survival in difficult times. You pack your backpack appropriately,
        making sure you have food to satisfy your hungry stomach during the journey, water to quench your thirst, and a sleeping bag,
        which will guarantee you a good night's sleep during your overnight stay in the wild. When you look at your well-prepared equipment,
        you know you are ready for this challenge. You set off into unknown territories, full of hope and determination, to discover the world beyond the city walls and learn the secrets,
        that hide on this long road.
        Do you want to go? The cost is 1 energy point/expedition.",
        
    );
} 

?>
