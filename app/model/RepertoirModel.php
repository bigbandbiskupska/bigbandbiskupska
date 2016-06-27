<?php

namespace App\Model;

use Nette;

class RepertoirModel
{
	private $songs;

	public function __construct ()
	{
		$this -> songs = array (
			(object) [
				"name" => "S' Wonderful",
				"interpreter" => "George Gershwin",
				"duration" => Nette\Utils\DateTime::from ( "00:03:10" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Big Swing Face",
				"interpreter" => "William O. Potts",
				"duration" => Nette\Utils\DateTime::from ( "00:04:15" ),
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=I2qYyjtlPBg",
			],
			(object) [
				"name" => "Wonderwall",
				"interpreter" => "N. Gallagher",
				"duration" => Nette\Utils\DateTime::from ( "00:02:44" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Hello dolly",
				"interpreter" => "Jerry Herman",
				"duration" => Nette\Utils\DateTime::from ( "00:02:25" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Haven't Met You Yet",
				"interpreter" => "Michael Bublé",
				"duration" => Nette\Utils\DateTime::from ( "00:03:58" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "A String Of Pearls",
				"interpreter" => "Jerry Gray",
				"duration" => Nette\Utils\DateTime::from ( "00:02:18" ),
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=rznsWgym9gc",
			],
			(object) [
				"name" => "Lásko má já stůňu",
				"interpreter" => "Karel Svoboda",
				"duration" => Nette\Utils\DateTime::from ( "00:02:00" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Přejdi Jordán",
				"interpreter" => "Zdeněk Marat",
				"duration" => Nette\Utils\DateTime::from ( "00:03:06" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Kočka není pes",
				"interpreter" => "Elvis Presley",
				"duration" => Nette\Utils\DateTime::from ( "00:02:00" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Mona Lisa",
				"interpreter" => "Jay Livingston",
				"duration" => Nette\Utils\DateTime::from ( "00:02:12" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Je Taime",
				"interpreter" => "Lara Fabian",
				"duration" => Nette\Utils\DateTime::from ( "00:04:20" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Sway",
				"interpreter" => "P. B. Ruiz",
				"duration" => Nette\Utils\DateTime::from ( "00:02:50" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Lullaby Of Birdland",
				"interpreter" => "George Shearing",
				"duration" => Nette\Utils\DateTime::from ( "00:02:40" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Little Secret",
				"interpreter" => "Nikky Yanofsky",
				"duration" => Nette\Utils\DateTime::from ( "00:03:15" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Waterloo",
				"interpreter" => "Benny Anderson",
				"duration" => Nette\Utils\DateTime::from ( "00:02:50" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Mack The Knife",
				"interpreter" => "Kurt Weil",
				"duration" => Nette\Utils\DateTime::from ( "00:02:50" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "I Dreamed A Dream",
				"interpreter" => "C. M. Schönberg",
				"duration" => Nette\Utils\DateTime::from ( "00:04:07" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Chain Of Fools",
				"interpreter" => "Anretha Franklin",
				"duration" => Nette\Utils\DateTime::from ( "00:03:05" ),
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=gGAiW5dOnKo",
			],
			(object) [
				"name" => "Goldeneye",
				"interpreter" => "John Barry",
				"duration" => Nette\Utils\DateTime::from ( "00:04:30" ),
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=v5e3H038u2Q",
			],
			(object) [
				"name" => "Trombonové zazvonění",
				"interpreter" => "Pavel Rabas",
				"duration" => Nette\Utils\DateTime::from ( "00:03:00" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "One Moment In Time",
				"interpreter" => "Albert Hammond",
				"duration" => Nette\Utils\DateTime::from ( "00:04:35" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Can't Take My Eyes Off You",
				"interpreter" => "Bob Crewe",
				"duration" => Nette\Utils\DateTime::from ( "00:04:00" ),
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=LmiOSaGiEes",
			],
			(object) [
				"name" => "The Best",
				"interpreter" => "Mike Chapman",
				"duration" => Nette\Utils\DateTime::from ( "00:03:00" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Thank You For The Music",
				"interpreter" => "Benny Anderson",
				"duration" => Nette\Utils\DateTime::from ( "00:03:50" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "I Feel Good",
				"interpreter" => "James Brown",
				"duration" => Nette\Utils\DateTime::from ( "00:03:05" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "In The Mood",
				"interpreter" => "Joe Garland",
				"duration" => Nette\Utils\DateTime::from ( "00:03:45" ),
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Až se k tobě vrátím",
				"interpreter" => "Kryštof Marek",
				"duration" => Nette\Utils\DateTime::from ( "00:03:00" ),
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=5eZxx4c9OeU",
			],
			(object) [
				"name" => "Hallelujah",
				"interpreter" => "Leonard Cohen",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Pátá",
				"interpreter" => "T. Hatch",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Hernando's Hideway",
				"interpreter" => "Richard Adler",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "I Just Called",
				"interpreter" => "Stevie Wonder",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Mr. Bojangles",
				"interpreter" => "Jery Jeff Wolker",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "You'll Never Find Another Love Like Me",
				"interpreter" => "Knenneth Gamble",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Sex Bomb",
				"interpreter" => "Tom Jones",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Things",
				"interpreter" => "Bobby Darin",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Crazy Little Thing Called Love",
				"interpreter" => "Freddie Mercury",
				"duration" => NULL,
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=zO6D_BAuYCI",
			],
			(object) [
				"name" => "My Heart Will Go On",
				"interpreter" => "James Horner",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Bad, Bad Leroy Brown",
				"interpreter" => "Jim Croce",
				"duration" => NULL,
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=QvwDohEEQ1E",
			],
			(object) [
				"name" => "Směs písní Karla Hašlera",
				"interpreter" => "Karel Hašler",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Já, Máří Magdaléna",
				"interpreter" => "A. L. Webber",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Skyfall",
				"interpreter" => "Paul Epworth",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Škoda lásky",
				"interpreter" => "Jaromír Vejvoda",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Rock Around The Clock",
				"interpreter" => "M. C. Freedman",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "The Winner Takes It All",
				"interpreter" => "Benny Anderson",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "James Bond Theme",
				"interpreter" => "Monty Norman",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "It Don't Mean A Thing",
				"interpreter" => "Duke Ellington",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Close Your Eyes",
				"interpreter" => "Michael Bublé",
				"duration" => NULL,
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=LoEWmc60wJY",
			],
			(object) [
				"name" => "Jingle Bells",
				"interpreter" => "James L. Pierpont",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Tell Him",
				"interpreter" => "David Foster",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Byla jedna holčička",
				"interpreter" => "Moe Jaffe",
				"duration" => NULL,
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=22IcgPwXFQE",
			],
			(object) [
				"name" => "Away In A Manger",
				"interpreter" => "American melody",
				"duration" => NULL,
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=HuF-D7eaars",
			],
			(object) [
				"name" => "Rockin' Around The Christmas Tree",
				"interpreter" => "Johny Marks",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Everyday",
				"interpreter" => "Slade",
				"duration" => NULL,
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=1pPL9PPy1MI",
			],
			(object) [
				"name" => "Směs Pomáda",
				"interpreter" => "Jim Jacobs",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Tichá noc",
				"interpreter" => "Franz Gruber",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Četník se žení",
				"interpreter" => "Raymond Lefevre",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Birdland",
				"interpreter" => "Joe Zawinul",
				"duration" => NULL,
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=wsWViUTJ_0c",
			],
			(object) [
				"name" => "Sir Duke",
				"interpreter" => "Stevie Wonder",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Psát od prvních řádků",
				"interpreter" => "A. L. Webber",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Slunečníce",
				"interpreter" => "Eman Nováček",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Žabák",
				"interpreter" => "Václav Trojan",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Smíření",
				"interpreter" => "Petr Ulrych",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Padam, Padam",
				"interpreter" => "Henry Contet",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Milord",
				"interpreter" => "Georges Moustaki",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Non Je Ne Regrette Rien",
				"interpreter" => "Charles Dumont",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Čardáš swing",
				"interpreter" => "Ferdinand Havlík",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "New York",
				"interpreter" => "John Kander",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Dneska pojedem vlakem ven",
				"interpreter" => "Havrani",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Sing, Sing, Sing",
				"interpreter" => "Louis Prima",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Everything",
				"interpreter" => "Michael Bublé",
				"duration" => NULL,
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=SPUJIbXN0WY",
			],
			(object) [
				"name" => "Feeling Good",
				"interpreter" => "L. Bricusse",
				"duration" => NULL,
				"visible" => true,
				"link" => "https://www.youtube.com/watch?v=Edwsf-8F3sI",
			],
			(object) [
				"name" => "Tiger Rag",
				"interpreter" => "La Rocca",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Summertime",
				"interpreter" => "George Gershwin",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "It Had Better Be Tonight",
				"interpreter" => "Henry Manchini",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "All I Want For Christmas Is You",
				"interpreter" => "Mariah Carey",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Jen jedenkrát v roce",
				"interpreter" => "Jiří Zmožek",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Každý má svůj sen",
				"interpreter" => "A. L. Webber",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Jakety Sax",
				"interpreter" => "Benny Hill",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Hluboko, hluboko",
				"interpreter" => "Bert Kaempfert",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Už nikdy víc milovat nebudu",
				"interpreter" => "Karel Hála",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Vím, že jsi se mnou",
				"interpreter" => "Karel Svoboda",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Hádej Matyldo",
				"interpreter" => "Australská lidová",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "White Christmas",
				"interpreter" => "Michael Bublé",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "You Needed Me",
				"interpreter" => "Randy Goodrum",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Save The Last Dance For Me",
				"interpreter" => "Mort Shuman",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Bei mir bist du schön",
				"interpreter" => "Sholom Sekunda",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Memory",
				"interpreter" => "A. L. Webber",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Tequila",
				"interpreter" => "Chuck Rio",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "My Way",
				"interpreter" => "Paul Anka",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Over The Rainbow",
				"interpreter" => "Harold Arlen",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Etuda v E",
				"interpreter" => "F. Chopin",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Alexander's Ragtime Band",
				"interpreter" => "Irving Berlin",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Rock This Town",
				"interpreter" => "Brian Setzer",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Yesterday",
				"interpreter" => "Paul McCartney",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Strangers In The Night",
				"interpreter" => "Frank Sinatra",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Blues Machine",
				"interpreter" => "Michael Sweeney",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Thunderball",
				"interpreter" => "John Barry",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Tenkrát na západě",
				"interpreter" => "Enrico Morricone",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Beatles Hits",
				"interpreter" => "John Lennon",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Let It Snow",
				"interpreter" => "Jule Styne",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Monday Monday",
				"interpreter" => "John Phillips",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Funiculi Funicula",
				"interpreter" => "Luigi Denza",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],


			(object) [
				"name" => "Jazz Merry Chrismas",
				"interpreter" => "Paul Cook",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
			(object) [
				"name" => "Somewhere",
				"interpreter" => "Leonard Bernstein",
				"duration" => NULL,
				"visible" => true,
				"link" => NULL,
			],
		);
	}


	public function all ( $order = [] )
	{
		uasort($this->songs, function($a, $b) {
			return Nette\Utils\Strings::toAscii($a->name) > Nette\Utils\Strings::toAscii($b->name);
		});
		return $this->songs;
	}

	public function order ( $order = "name" )
	{
		uasort($this->songs, function($a, $b) use ($order) {
			return Nette\Utils\Strings::toAscii($a->$order) > Nette\Utils\Strings::toAscii($b->$order);
		});
		return $this->songs;
	}

};