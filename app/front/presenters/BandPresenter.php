<?php

namespace App\FrontModule\Presenters;

use Nette;
use App;
use Latte;


class BandPresenter extends BasePresenter
{
	/**
	 * @var App\Model\MemberModel
	 * @inject
	 */
	public $members;

	public function actionDefault ()
	{

		$this -> template -> sections = $this -> members -> all ();
		$this -> template -> oldmembers = $this -> members -> where ( ["old" => true] );

	}

	public function generateDescription( $member ) {
		// Na flétnu hraje od svých 11 let, je absolventkou třídy Pavla Zajíce. 
		// V roce 2010 stála u zrodu big bandu pod vedením Milana Tolknera. 
		// Kromě hudby se věnuje informatice, tenisu a fotografování.
		$latte = new Latte\Engine;

		$start = [
			"Na {\$instrument|case: 4} hraje od svých {\$age|years: 2}.",
			"Na {\$instrument|case: 4} začal{\$suffix} hrát ve svých {\$age|years: 6}.",
			"Po vyzkoušení několika různých nástrojů se rozhodl{\$suffix} pro {\$instrument|case: 4} ve svých {\$age|years: 6}.",
			"Začal{\$suffix} hrát na {\$instrument|case: 4} zhruba ve svých {\$age|years: 6}.",
			"Hra na {\$instrument|case: 4} {\$gender|case: 4} zajímala od malička, nicméně s muzikantskou dráhou začal{\$suffix} až ve svých {\$age|years: 6}.",
			"Když se v {\$age|years: 6} rozhodoval{\$suffix} co dělat, {\$instrument|case: 1} byla jasná volba.",
			"Vyzkoušel{\$suffix} {\$oinstruments[0]|case: 4}, pak změnil{\$suffix} k {\$oinstruments[1]|case: 3}, ale nebylo to ono. "
				. "Až se konečně usadil{\$suffix} na {\$instrument|case: 6}.",
			"Na {\$instrument|case: 4} není opravdu jednoduché hrát. I tak se tomu velmi slibně už od {\$age|years: 2} věnuje a poctivě cvičí.",
			"I přesto, že vždycky hodně propadal{\$suffix} vášní {\$other[0]|case: 3}, tak nakonec moudře zvolil{\$suffix} {\$instrument|case: 4}. A udělal{\$suffix} dobře!",
			"V {\$age-6|years: 6} začal{\$suffix} s {\$oinstruments[0]|case: 7}. V {\$age-4|years: 6} změnil{\$suffix} k {\$oinstruments[1]|case: 3}. "
				. "Myslel{\$suffix} si, že to už je konečná, ale pak, jakoby ze snu, slyšel{\$suffix} v {\$age|years: 6} {\$instrument|case: 4}. A toho už se nezbavil{\$suffix}.",
			"V {\$age-6|years: 6} začal{\$suffix} svižně s {\$oinstruments[0]|case: 7}. V {\$age-4|years: 6} změnil{\$suffix} k {\$oinstruments[1]|case: 3}. "
				. "Myslel{\$suffix} si, že to už je finále, ale pak uviděl{\$suffix} v {\$age|years: 6} {\$instrument|case: 4}. A u toho už zůstal{\$suffix}.",

		];



		$bigband = [
			"Do big bandu pod vedením Milana Tolknera se přidal{\$suffix} v roce {\$year}.",
			"Do big bandu se připojil{\$suffix} v roce {\$year}.",
			"V big bandu hraje od roku {\$year}. Za toto období posbíral{\$suffix} mnoho cenných zkušeností.",
			"Členem big bandu pod vedením Milana Tolknera se stal{\$suffix} v roce {\$year}.",
			"V současnosti hraje v big bandu již {l}since: {\$year}{r}.",
			"Big band existuje od roku 2010 a jeho členem se stal{\$suffix} již v roce {\$year}.",
			"Za {l}since: {\$year}{r} v big bandu významně podpořil{\$suffix} jeho výstup svou hrou na {\$instrument|case: 4}.",
			"S kratičkou přestávkou zhruba uprostřed hraje v big bandu neuvěřitelně již {l}since: {\$year}{r}. Přidal{\$suffix} se totiž v roce {\$year}.",
			"{\$instrument|case: 1|firstUpper} k {\$instrument|case: 3} do big bandu sedá již v roce {\$year}. To dává dohromady do dneška již {l}since: {\$year}{r} v big bandu.",

		];

		$interest = [
			"Kromě hudby se věnuje {array_slice(\$interests, 0, count(\$interests) - 1)|case: 3|implode: ', '} a {\$interests[count(\$interests)-1]|case: 3}.",
			"Mimo hudbu se věnuje {\$interests[0]|case: 3} a {\$interests[1]|case: 3}, ovšem nebrání se ani {\$interests[2]|case: 3}.",
			"Kromě hudby se věnuje {\$interests[0]|case: 3}, {\$interests[1]|case: 3}, ale i {\$interests[2]|case: 3}.",
			"Kromě hudby dává svůj volný čas {array_slice(\$interests, 0, count(\$interests) - 1)|case: 3|implode: ', '} a {\$interests[count(\$interests)-1]|case: 3}.",
			"Nikdy {\$gender|case: 4} příliš nezajímalo například {\$other[0]|case: 1} nebo {\$other[1]|case: 1}. "
				. "Zatímco {array_slice(\$interests, 0, 2)|case: 3|implode: ' a '} věnuje naplno svůj volný čas.",
			"Trochu lituje, že nikdy nezkusil{\$suffix} {\$other[0]|case: 4}, protože vždycky dal{\$suffix} přednost "
				. "{array_slice(\$interests, 0, count(\$interests) - 1)|case: 3|implode: ', '} nebo {\$interests[count(\$interests)-1]|case: 3}.",
			"I přes urputnou snahu stát se mistrem v {\$other[0]|case: 6}, je nakonec rád{\$suffix}, že dal{\$suffix} přednost {\$interests[0]|case: 3}. "
				. "A to tak moc, že nestíhá ani moc cvičit na {\$instrument|case: 4}.",
			"Mívá noční můry. Je{\$gender|case: 4} nadřízený v nich hraje na {\$instrument|case: 4} sólo s hroznýma overtónama a {\$gender|case: 1} pak nemůže několik hodin usnout. "
				. "Nikdo neví, kdy se to objevilo, ale zřejmě se to stalo při {\$interests[0]|case: 6}.",
			"Má strašlivé sny. Je{\$gender|case: 4} kamarád v nich hraje na {\$instrument|case: 4} sólo s hroznýma vytaženýma tónama a {\$gender|case: 1} pak nemůže ani polapit dech. "
				. "Kdysi dávno při {\$interests[0]|case: 6} se uhodil{\$suffix} a od té doby to má.",
			"Snívá hrozivé sny. Je{\$gender|case: 4} kamarád v nich hraje na {\$instrument|case: 4} sólo s dlouhýma tónama a {\$gender|case: 1} pak nemůže ani polapit dech. "
				. "Asi to má z dlouhodobého hlediska zabýváním se {\$interests[0]|case: 7}.",
			"Všechno před ostatními tají, takže není moc informací, které o {\$gender|case: 6} napsat. Je{\$gender|case: 4} nejbližší však tvrdí, že se v nejhlubších sklepeních své duše oddává {\$interests[0]|case: 3}.",
			"Tajnůstkář{\$suffix}. Je však jasně vidět, že {\$gender|case: 4} baví {\$interests[0]|case: 1} nebo {\$interests[1]|case: 1}.",
			"Miluje filmy. Například Marečku, podejte mi {\$instrument|case: 4} nebo Slunce, seno, {\$instrument|case: 1}. Rád{\$suffix} chodí do kina a do divadla, celkově dost kulturně žije.",
			"Miluje filmy. Například Dneska to roztočíme, {\$instrument|case: 5} nebo {\$instrument|case: 1|firstUpper} se vrací. Na filmy kouká doma.",
			"Miluje divadlo. Nejoblíbenější hrou je Továrna na {\$instrument|case: 4} z roku 1922 nebo, o něco starší, Mnoho povyku pro {\$instrument|case: 4}. A vůbec Shakespearem žije.",
			"Je toho tolik, co dělá. Například miluje {array_slice(\$other, 0, 2)|case: 4|implode: ', '} a {array_slice(\$other, 2, 1)|case: 4|implode: ', '}. "
				. "Ale taky zbožňuje {array_slice(\$other, 3, 2)|case: 4|implode: ', '} a {array_slice(\$other, 5, 1)|case: 4|implode: ', '}. "
				. "Je ohromující, že to všechno stíhá.", 
			"V budoucnu by chtěl{\$suffix} na {\$interests[0]|case: 6} založit byznys. Plány jsou velké, ale dost ještě času.",
			"Jednou se chce {\$interests[0]|case: 7} živit, ale do té doby musí dělat {\$interests[0]|case: 4}.",
		];

		$instruments = [
			"trumpeta" => [ "trumpeta", "trumpety", "trumpetě", "trumpetu", "trumpeto", "trumpetě", "trumpetou" ],
			"klarinet" => [ "klarinet", "klarinetu", "klarinetem", "klarinet", "klarinete", "klarinetu", "klarinetem" ],
			"saxofon" => [ "saxofon", "saxofonu", "saxofonu", "saxofon", "saxofone", "saxofonu", "saxofonem" ],
			"basa" => [ "basa", "basy", "base", "basu", "baso", "base", "basou" ],
			"bicí" => [ "bicí", "bicích", "bicím", "bicí", "bicí", "bicích", "bicími" ],
			"klávesy" => [ "klávesy", "kláves", "klávesám", "klávesy", "klávesy", "klávesách", "klávesami" ],
			"flétna" => [ "flétna", "flétny", "flétně", "flétnu", "flétno", "flétně", "flétnou" ],
			"trombón" => [ "trombón", "trombónu", "trombónu", "trombón", "trombóne", "trombónu", "trombónem" ],
			"zpěv" => [ "zpěv", "zpěvu", "zpěvu", "zpěv", "zpěve", "zpěvu", "zpěvem" ],
		];

		$words = [
			"rok" => [ "rok", "roku", "rokem", "rok", "roku", "roku", "rokem" ],
			"roky" => [ "roky", "roků", "rokům", "roky", "roky", "rocích", "rokami" ],
			"léta" => [ "léta", "let", "letům", "léta", "léta", "letech", "lety" ],
		];

		$pronouns = [
			"on" => [ "on", "něj", "mu", "ho", "", "něm", "ním" ],
			"ona" => [ "ona", "ní", "ní", "ji", "", "ní", "ní" ],
		];

		$interests = [
			"informatika" => [ "informatika", "", "informatice", "informatika", "", "informatice", "informatikou" ],
			"deskové hry" => [ "deskové hry", "", "deskovým hrám", "deskové hry", "", "deskových hrách", "deskovými hrami" ],
			"sport" => [ "sport", "", "sportu", "sport", "", "sportu", "sportem" ],
			"plavání" => [ "plavání", "", "plavání", "plavání", "", "plavání", "plaváním" ],
			"extrémní lyžování" => [ "extrémní lyžování", "", "extrémnímu lyžování", "extrémní lyžování", "", "extrémním lyžování", "extrémním lyžováním" ],
			"nahánění bodů u kapelníka" => [ "nahánění bodů u kapelníka", "", "nahánění bodů u kapelníka", "nahánění bodů u kapelníka", "", "nahánění bodů u kapelníka", "naháněním bodů u kapelníka" ],
			"stavění hradů z písku" => [ "stavění hradů z písku", "", "stavění hradů z písku", "stavění hradů z písku", "", "stavění hradů z písku", "stavěním hradů z písku" ],
			"pískání přes kousek trávy" => [ "pískání přes kousek trávy", "", "pískání přes kousek trávy", "pískání přes kousek trávy", "", "pískání přes kousek trávy", "pískáním přes kousek trávy" ],
			"fandění fotbalu" => [ "fandění fotbalu", "", "fandění fotbalu", "fandění fotbalu", "", "fandění fotbalu", "fanděním fotbalu" ],
			"vaření" => [ "vaření", "", "vaření", "vaření", "", "vaření", "vařením" ],
			"zalévání zahrady" => [ "zalévání zahrady", "", "zalévání zahrady", "zalévání zahrady", "", "zalévání zahrady", "zaléváním zahrady" ],
			"učení" => [ "učení", "", "učení", "učení", "", "učení", "učením" ],
			"domácí kutilství" => [ "domácí kutilství", "", "domácímu kutilství", "domácí kutilství", "", "domácím kutilství", "domácím kutilstvím" ],
			"akvaristika" => [ "akvaristika", "", "akvaristice", "akvaristiku", "", "akvaristice", "akvaristikou" ],
			"numismatiku" => [ "numismatiku", "", "numismatice", "numismatiku", "", "numismatice", "numismatikou" ],
			"dějepis" => [ "dějepis", "", "dějepisu", "dějepis", "", "dějepisu", "dějepisem" ],
			"rybaření" => [ "rybaření", "", "rybaření", "rybaření", "", "rybaření", "rybařením" ],
			"lovení bouřek" => [ "lovení bouřek", "", "lovení bouřek", "lovení bouřek", "", "lovení bouřek", "lověním bouřek" ],
			"pěstování fazolí" => [ "pěstování fazolí", "", "pěstování fazolí", "pěstování fazolí", "", "pěstování fazolí", "pěstováním fazolí" ],
			"keramika" => [ "keramika", "", "keramice", "keramiku", "", "keramice", "keramikou" ],
			"jízda na koni" => [ "jízda na koni", "", "jízdě na koni", "jízdu na koni", "", "jízdě na koni", "jízdou na koni" ],
			"poloprofesionální pití vody" => [ "poloprofesionální pití vody", "", "poloprofesionálnímu pití vody", "poloprofesionální pití vody", "", "poloprofesionálním pití vody", "poloprofesionálním pití vody" ],
			"čtení Méďy Pusíka" => [ "čtení Méďy Pusíka", "", "čtení Méďy Pusíka", "čtení Méďy Pusíka", "", "čtení Méďy Pusíka", "čtením Méďy Pusíka" ],
			"pletení vlněných šál" => [ "pletení vlněných šál", "", "pletení vlněných šál", "pletení vlněných šál", "", "pletení vlněných šál", "pletením vlněných šál" ],
			"objíždení letních hudebních festivalů" => [ "objíždení letních hudebních festivalů", "", "objíždení letních hudebních festivalů", "objíždení letních hudebních festivalů", "", "objíždení letních hudebních festivalů", "objíždením letních hudebních festivalů" ],
			"nošení velké červené bedny se stojany" => [ "nošení velké červené bedny se stojany", "", "nošení velké červené bedny se stojany", "nošení velké červené bedny se stojany", "", "nošení velké červené bedny se stojany", "nošením velké červené bedny se stojany" ],
			"truhlaření" => [ "truhlaření", "", "truhlaření", "truhlaření", "", "truhlaření", "truhlařením" ],
			"gymnastika" => [ "gymnastika", "", "gymnastice", "gymnastiku", "", "gymnastice", "gymnastikou" ],
			"degustaci vína" => [ "degustace vína", "", "degustaci vína", "degustaci vína", "", "degustaci vína", "degustací vína" ],
			"sbírání nerostů a hornin" => [ "sbírání nerostů a hornin", "", "sbírání nerostů a hornin", "sbírání nerostů a hornin", "", "sbírání nerostů a hornin", "sbíráním nerostů a hornin" ],
			"chytání motýlů" => [ "chytání motýlů", "", "chytání motýlů", "chytání motýlů", "", "chytání motýlů", "chytáním motýlů" ],
			"astrologii" => [ "astrologie", "", "astrologii", "astrologii", "", "astrologii", "astrologií" ],
			"stanování v zakázaných oblastech" => [ "stanování v zakázaných oblastech", "", "stanování v zakázaných oblastech", "stanování v zakázaných oblastech", "", "stanování v zakázaných oblastech", "stanováním v zakázaných oblastech" ],
			"okousávání tužky" => [ "okousávání tužky", "", "okousávání tužky", "okousávání tužky", "", "okousávání tužky", "okousáváním tužky" ],
			"okousávání nehtů" => [ "okousávání nehtů", "", "okousávání nehtů", "okousávání nehtů", "", "okousávání nehtů", "okousáváním nehtů" ],
			"okousávání nohou" => [ "okousávání nohou", "", "okousávání nohou", "okousávání nohou", "", "okousávání nohou", "okousáváním nohou" ],
			"opravování telefonů" => [ "opravování telefonů", "", "opravování telefonů", "opravování telefonů", "", "opravování telefonů", "opravováním telefonů" ],
			"závody na kancelářských křeslech" => [ "závody na kancelářských křeslech", "", "závodům na kancelářských křeslech", "závody na kancelářských křeslech", "", "závodech na kancelářských křeslech", "závody na kancelářských křeslech" ],
			"kloboučnictví" => [ "kloboučnictví", "", "kloboučnictví", "kloboučnictví", "", "kloboučnictví", "kloboučnictvím" ],


		];

		$dictionary = [
			$instruments,
			$pronouns,
			$interests,
			$words,
		];

		$exluded_instruments = array_diff(array_keys($instruments), [$member->instrument]);
		shuffle($exluded_instruments);

		$parameters = [
			"year" => rand ( 2010, date('Y') - 1 ),
			'suffix' => $member->male ? '' : 'a',
			'instrument' => $member->instrument,
			'gender' => $member->male ? 'on' : 'ona',
			'age' => rand ( 8, 15 ),
			'member' => $member,
			'interests' => $xxx = self::generateInterests ( $interests, $max = rand( 3, 4 ) ),
			'other' => self::generateInterests ( $interests, count($interests) - $max, $xxx ),
			'oinstruments' => $exluded_instruments,
		];

		$latte->addFilter('years', function ($s, $case = 1) use($words) {
			switch ( $s ) {
				case 0: return "teď";
				case 1: return $s . " " . $words["rok"][$case - 1];
				case 2: 
				case 3:
				case 4: return $s . " " . $words["roky"][$case - 1];
				default: return $s . " " . $words["léta"][$case - 1];
			}
		});

		$latte->addFilter("case", function($s, $case = 1) use ($dictionary) {
			$convert = function($x) use($dictionary, $case) {
				foreach ($dictionary as $dict) {
					if(isset($dict[$x]) && isset($dict[$x][$case - 1])) 
						return $dict[$x][$case - 1];
				}
				throw new Nette\InvalidArgumentException("word was not found " . $s);
			};

			if(is_array($s)) {
				return array_map($convert, $s);
			}

			return $convert($s);
		});


		$template = [
			$start [ rand () % count($start) ],
			$bigband [ rand () % count($bigband) ],
			$interest [ rand () % count($interest) ],
		];

		$latte->setLoader(new Latte\Loaders\StringLoader());
		return $latte->renderToString(implode(" ", $template), $parameters);
	}

	public static function generateInterests ($interests, $n, $exlude = []) {
		$keys = array_keys($interests);

		if($n + count($exlude) > count($keys))
			throw new Nette\InvalidArgumentException("n is greater than " + count($keys));

		$taken = [];

		while ( count($taken) !== $n ) {
			$rand = rand () % count($keys);
			if ( ! in_array ( $keys[$rand], $taken) && ! in_array ( $keys[$rand], $exlude ) )
				$taken [] = $keys[$rand];
		}
		return $taken;
	}


}
