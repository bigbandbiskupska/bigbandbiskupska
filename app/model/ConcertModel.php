<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Tulinkry\Model\BaseModel;

class ConcertModel extends BaseModel
{

    const lorem = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
";
    const ALBUM_ID = "6297830325684432193";

    private $concerts;
    private $concert;

    public function __construct () {
        $this -> concerts = array (
            (object) [
                "id" => 1,
                "lattitude" => 50.0875476,
                "longitude" => 14.3999416,
                "date" => DateTime::from( "2016-10-04 18:30:00" ),
                "name" => "Big Band Biskupská na HAMU",
                "location_text" => "Sál Bohuslava Martinů, Malostranské náměstí, Praha",
                "photo_id" => "6297830529003997106",
                "album_id" => self::ALBUM_ID,
                "description" => "Základní umělecká škola v Biskupské ulici je od nového školního roku součástí projektu Akademie umění a kultury pro seniory v hlavním městě, který má nabídnout možnost aktivního trávení volného času a umělecké seberealizace.

Jako slavnostní uvedení nových studentů v ZUŠ Biskupské se pořádá koncert, jehož součástí bude i kratší (než jste zvyklí) vystoupení Big Bandu Biskupská s dirigentem Milanem Tolknerem.

Těšit se můžete na stálou sólistku big bandu Kateřinu Tošnarovou, při jejímž zpěvu tuhne krev v žilách, a také na některé starší kousky z našeho repertoáru, které v minulé sezóně nedostaly tolik prostoru.

Koncert se uskuteční v nádherném sále Hudební a taneční fakulty AMU v Praze, který již byl svědkem mnoha vyjímečných vystoupení různorodých umělců. Koncert začíná v 18:30.

Těšíme se na vás!",
            ],
            (object) [
                "id" => 2,
                "lattitude" => 50.0817551,
                "longitude" => 14.4073673,
                "date" => DateTime::from( "2016-06-28 16:00:00" ),
                "name" => "Big Band Biskupská na Střeleckém ostrově",
                "location_text" => "Střelecký ostrov, Praha 5",
                "photo_id" => "6297830530208318354",
                "album_id" => self::ALBUM_ID,
                "description" => "Za nádherného počasi rozhýbáme i Vltavu u Střeleckého ostrova. Do prázdnin už moc nechybí, tak se nezapomeňte zastavit a poslechnout si naposledy v této sezóně náš pestrý repertoár.

Těšíme se na vás!",
            ],
            (object) [
                "id" => 3,
                "lattitude" => 50.1447072,
                "longitude" => 15.1176113,
                "date" => DateTime::from( "2016-06-24 18:00:00" ),
                "name" => "Big Band Biskupská v Poděbradech",
                "location_text" => "Kolonáda, Poděbrady",
                "photo_id" => "6297830526336708690",
                "album_id" => self::ALBUM_ID,
                "description" => "Big Band Biskupská vystoupí na kolonádě v Poděbradech. Z Prahy, co by kamenem dohodil a zbytek došel pěšky.

Těšíme se na vás!",
            ],
            (object) [
                "id" => 4,
                "lattitude" => 50.0875726,
                "longitude" => 14.4189987,
                "date" => DateTime::from( "2016-06-01 14:00:00" ),
                "name" => "Maraton ZUŠ",
                "location_text" => "Staroměstské náměstí, Praha 1",
                "photo_id" => "6297830527767232498",
                "album_id" => self::ALBUM_ID,
                "description" => "Na Maratonu ZUŠ zahraje i Big Band Biskupská. Zazní výběr z jazzových a swingových melodií ale také několik populárních písní z mladších desetiletí.

Výstup Big Bandu Biskupská je naplánován zhruba na 14h.

Big Band Biskupská pod taktovkou Milana Tolknera koncertuje již od roku 2009 a za léta své činnosti má za sebou vystoupení s známými českými zpěváky - Václav Noid Bárta, Ondřej Ruml, Tomáš Savka, Michaela Nosková, František Zahradníček a vystoupení na prestižních akcích - Ples Prahy 1 nebo Mezinárodní studentský ples, obojí v komplexu na Žofíně v Praze.

Těšíme se na vás. Na Staromáku to žije!",
            ],
            (object) [
                "id" => 5,
                "lattitude" => 50.0875476,
                "longitude" => 14.3999416,
                "date" => DateTime::from( "2016-05-26 18:30:00" ),
                "name" => "Závěrečný koncert ZUŠ Biskupská",
                "location_text" => "Sál Bohuslava Martinů, Malostranské náměstí, Praha",
                "photo_id" => "6297830529003997106",
                "album_id" => self::ALBUM_ID,
                "description" => "Závěrečný koncert základní umělecké školy Biskupská, sídlící ve stejnojmenné ulici na Praze 1, kde se vyučuje nepřeberné množství hudebník nástrojů, zpěv a v neposlední řadě škola má také literárně dramatický či výtvarný obor.

V zástupu žáků, kteří na koncertě podají špičkový výkon vystoupí i žákovská tělesa - Komorní orchestr ZUŠ Biskupská s dirigentem Alešem Chalupským a právě Big Band Biskupská vedený Milanem Tolknerem.

Big Band Biskupská koncertuje již od roku 2009 a za léta své činnosti má za sebou vystoupení s známými českými zpěváky - Václav Noid Bárta, Ondřej Ruml, Tomáš Savka, Michaela Nosková, František Zahradníček a vystoupení na prestižních akcích - Ples Prahy 1 nebo Mezinárodní studentský ples, obojí v komplexu na Žofíně v Praze.

Těšíme se na vás. Na Malé straně to žije!",
            ],
            (object) [
                "id" => 6,
                "lattitude" => 49.9733874,
                "longitude" => 14.3899573,
                "date" => DateTime::from( "2016-05-21 15:00:00" ),
                "name" => "Koncert na Zbraslavi - Big Band Biskupská",
                "location_text" => "Bowling Zbraslav U Stromečku, Elišky Přemyslovny 433, 15600 Zbraslav",
                "photo_id" => "6297830529784674802",
                "album_id" => self::ALBUM_ID,
                "description" => "K tanci a poslechu vám u zbraslavských Pivních slavností zahraje Big Band Biskupská spolu se zpěvákem Slavou Korsakem. Zazní nejen jazzové a swingové melodie ale i písně populární hudby.

Po big bandu, od 21h vám zahraje big beatová kapela Lokomotiva Planet, která svými podmanivými rytmy roztančí nejednoho diváka.

Big Band Biskupská koncertuje již od roku 2009 (první koncert na Zbraslavi) a za léta své činnosti má za sebou vystoupení s známými českými zpěváky - Ondřej Ruml, Tomáš Savka, Michaela Nosková, František Zahradníček a vystoupení na prestižních akcích - Ples Prahy 1 nebo Mezinárodní studentský ples, obojí v komplexu na Žofíně v Praze.

Taktéž se zúčastnil několika výjezdů do zahraničí, kde svými výkony potěšil tamní diváky. Naposledy ve Francii, což se stalo jak pro diváky, tak i pro celý big band nezapomenutelným zážitkem.

Pivní slavnosti zažívají svůj třetí úspěšný ročník, připravit se můžete na piva z lokálních pivovarů - z pivovaru Chříč, Krakonoš, Malešov, Hendrych, Gwern, z pivovarského dvoru Zvíkov, ze Zemského pivovaru a z Olivova pivovaru.

Těšíme se na vás. Na Zbraslavi to žije!",
            ],
            (object) [
                "id" => 7,
                "lattitude" => 49.2548602,
                "longitude" => 15.1875094,
                "date" => DateTime::from( "2016-05-20 19:00:00" ),
                "name" => "Jazz na hradě v Žirovnici",
                "location_text" => "Tyršova 456, 394 68 Žirovnice, Česká Republika",
                "photo_id" => "6297830528956103474",
                "album_id" => self::ALBUM_ID,
                "description" => "Již pátý ročník věhlasné akce Jazz na Hradě. Spojení dvou hudebních těles - Big Band Biskupská z Prahy a Pěvecký sbor Arietta ze Žirovnice. Hostem večera Václav Noid Bárta, muzikant a muzikálový zpěvák. To všechno si nesmíte nechat ujít!

Nebuďte zmatení, z kapacitních důvodů, navzdory názvu akce, se koncert bude konat v sokolovně.

Václav Noid Bárta je muzikantem již od útlého věku - ovládá hru na klavír, flétnu, klarinet, kytaru, basu a bicí. Nezapomenutelnou doménou je však jeho charakteristický zpěv. Na poli populární a rockové hudby v průběhu let spolupracoval jako skladatel, aranžér a zpěvák s předními hudebníky ČR.

V posledních letech vytvořil řadu muzikálových rolí: Vortinger (Excalibur), Ďábel (Elixír života), Baron (Dáma s kaméliemi), James Wayne (Obraz Doriana Graye), Josef Němec (Němcová!), Robin z Loxley (Robin Hood), Hamlet (Hamlet). Na scéně Hudebního divadla Karlín zazářil již v roli Garcii v Carmen, v rolích Jidáše Iškariotského a Piláta Pontského
v Jesus Christ Superstar, jako Radames v muzikálu Aida a Daniel v muzikálu Lucie.

Big Band Biskupská koncertuje již od roku 2009 a za léta své činnosti má za sebou vystoupení s známými českými zpěváky - Ondřej Ruml, Tomáš Savka, Michaela Nosková, František Zahradníček a vystoupení na prestižních akcích - Ples Prahy 1 nebo Mezinárodní studentský ples, obojí v komplexu na Žofíně v Praze.

Pěvecký sbor Arietta, vedený zkušenou sbormistryní Ludmilou Zadražilovou, patří k ZUŠ v Žirovnici a pracuje s dětmi ze širokého okolí. Tento sbor, kromě akcí ve svém domovském kraji, vystoupil i například v sále České národní banky, v Úněticích u Prahy nebo na hradě Karlštejn.

Kombinaci obou těles zařídilo dlouholeté přátelství kapelníka big bandu Milana Tolknera, který z blízkosti Žirovnice pochází, a ředitele žirovnické ZUŠ Zdeňka Zadražila, který pochází také pochopitelně z blízkosti Žirovnice.

Těšíme se na vás. V Žirovnici to žije!",
            ],
        );
    }

    public function item ( $id ) {
        foreach ( $this -> concerts as $concert ) {
            if ( $id == $concert -> id ) {
                return $concert;
            }
        }
        return NULL;
    }

    public function limit ( $limit = 10, $offset = 0, $by = array (), $order = array () ) {
        uasort($this -> concerts, function($a, $b) {
            return $b->date->getTimestamp() - $a->date->getTimestamp();
        });

        $limited = [];
        $it = 0;
        foreach ($this->concerts as $key => $concert) {
            if($it >= $offset && $it < $offset + $limit)
                $limited [] = $concert;
            $it ++;
        }
        return $limited;
    }

    public function count ( $by = array (), $order = array () ) {
        return count( $this -> concerts );
    }

    public function all () {
        uasort($this -> concerts, function($a, $b) {
            return $b->date->getTimestamp() - $a->date->getTimestamp();
        });
        return $this -> concerts;
    }

    public function newest ( $limit, $offset = 0 ) {
        uasort($this -> concerts, function($a, $b) {
            return $b->date->getTimestamp() - $a->date->getTimestamp();
        });

        $filtered = [];
        foreach ( $this -> concerts as $concert )
            if ( $concert -> date > new DateTime )
                $filtered [] = $concert;

        $limited = [];
        for ( $i = $offset; $i < $limit + $offset; $i ++ )
            if ( isset( $filtered[ $i ] ) )
                $limited [] = $filtered[ $i ];
        return $limited;
    }

    public function groupByMonth ($limit, $offset = 0, $by = array (), $order = array ()) {
        $myconcerts = $this->limit($limit, $offset, $by, $order);
        $concerts = array ();
        $actuals = array ();
        $previous = null;
        foreach ($myconcerts as $key => $concert) {
            if(!$previous) {
                $actuals [] = $previous = $concert;
                continue;
            }

            if($previous->date->format('Y:n') !== $concert->date->format('Y:n')) {
                if($actuals && count($actuals)) {
                    $concerts [] = $actuals;
                }
                $actuals = array ();
            }
            $actuals [] = $concert;
            $previous = $concert;
        }
        if($actuals && count($actuals)) {
            $concerts [] = $actuals;
        }
        return $concerts;
    }

}
