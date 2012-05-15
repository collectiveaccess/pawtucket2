<?php
/* ----------------------------------------------------------------------
 *
 * Stopwords module.  Copyright 2007-2008 Whirl-i-Gig (http://www.whirl-i-gig.com)
 *
 * Disclaimer:  There are no doubt inefficiencies and bugs in this code; the
 * documentation leaves much to be desired. If you'd like to improve these  
 * libraries please consider helping us develop this software. 
 *
 * phpweblib is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY.
 *
 * This source code are free and modifiable under the terms of 
 * GNU Lesser General Public License. (http://www.gnu.org/copyleft/lesser.html)
 *
 * ----------------------------------------------------------------------
 * class Stopwords
 *
 * Returns stopwords for various languages
 *
 * Author	seth@whirl-i-gig.com
 * ---------------------------------------------------------------------- 
 */


# ----------------------------------------------------------------------
class Stopwords {
	private $opa_stop_words;

	# ------------------------------------------------------------------
	function Stopwords() {
		$this->opa_stop_words = array();
	}
	# ------------------------------------------------------------------
	function getStopwords($ps_lang) {
		/* Most of the stop word lists are taken from the Java Lucene code. Have a look at http://lucene.apache.org/ */
		switch($ps_lang){
			case 'en':
				$this->opa_stop_words = array("a", "an", "and", "are", "as", "at", "be",
												"but", "by", "for", "if", "in", "into",
												"is", "it", "no", "not", "of", "on", "or",
												"s", "such", "t", "that", "the", "their",
												"then", "there", "these", "they", "this",
												"to", "was", "will", "with");
				break;
			case 'de':
				$this->opa_stop_words = array("einer", "eine", "eines", "einem", "einen",
												"der", "die", "das", "dass", "daß",
												"du", "er", "sie", "es",
												"was", "wer", "wie", "wir",
												"und", "oder", "ohne", "mit",
												"am", "im", "in", "aus", "auf",
												"ist", "sein", "war", "wird",
												"ihr", "ihre", "ihres",
												"als", "für", "von", "mit",
												"dich", "dir", "mich", "mir",
												"mein", "sein", "kein",
												"durch", "wegen", "wird");
				break;
			case 'nl':
				$this->opa_stop_words = array("de", "en", "van", "ik", "te", "dat", "die",
												"in", "een", "hij", "het", "niet", "zijn", 
												"is", "was", "op", "aan", "met", "als", "voor", "had",
												"er", "maar", "om", "hem", "dan", "zou", "of", "wat", "mijn", "men", "dit", "zo",
												"door", "over", "ze", "zich", "bij", "ook", "tot", "je", "mij", "uit", "der", "daar",
												"haar", "naar", "heb", "hoe", "heeft", "hebben", "deze", "u", "want", "nog", "zal",
												"me", "zij", "nu", "ge", "geen", "omdat", "iets", "worden", "toch", "al", "waren",
												"veel", "meer", "doen", "toen", "moet", "ben", "zonder", "kan", "hun", "dus",
												"alles", "onder", "ja", "eens", "hier", "wie", "werd", "altijd", "doch", "wordt",
												"wezen", "kunnen", "ons", "zelf", "tegen", "na", "reeds", "wil", "kon", "niets",
												"uw", "iemand", "geweest", "andere");
				break;
			case 'fr':
				$this->opa_stop_words = array("a", "afin", "ai", "ainsi", "après", "attendu", "au", "aujourd", "auquel", "aussi",
												"autre", "autres", "aux", "auxquelles", "auxquels", "avait", "avant", "avec", "avoir",
												"c", "car", "ce", "ceci", "cela", "celle", "celles", "celui", "cependant", "certain",
												"certaine", "certaines", "certains", "ces", "cet", "cette", "ceux", "chez", "ci",
												"combien", "comme", "comment", "concernant", "contre", "d", "dans", "de", "debout",
												"dedans", "dehors", "delà", "depuis", "derrière", "des", "désormais", "desquelles",
												"desquels", "dessous", "dessus", "devant", "devers", "devra", "divers", "diverse",
												"diverses", "doit", "donc", "dont", "du", "duquel", "durant", "dès", "elle", "elles",
												"en", "entre", "environ", "est", "et", "etc", "etre", "eu", "eux", "excepté", "hormis",
												"hors", "hélas", "hui", "il", "ils", "j", "je", "jusqu", "jusque", "l", "la", "laquelle",
												"le", "lequel", "les", "lesquelles", "lesquels", "leur", "leurs", "lorsque", "lui", "là",
												"ma", "mais", "malgré", "me", "merci", "mes", "mien", "mienne", "miennes", "miens", "moi",
												"moins", "mon", "moyennant", "même", "mêmes", "n", "ne", "ni", "non", "nos", "notre",
												"nous", "néanmoins", "nôtre", "nôtres", "on", "ont", "ou", "outre", "où", "par", "parmi",
												"partant", "pas", "passé", "pendant", "plein", "plus", "plusieurs", "pour", "pourquoi",
												"proche", "près", "puisque", "qu", "quand", "que", "quel", "quelle", "quelles", "quels",
												"qui", "quoi", "quoique", "revoici", "revoilà", "s", "sa", "sans", "sauf", "se", "selon",
												"seront", "ses", "si", "sien", "sienne", "siennes", "siens", "sinon", "soi", "soit",
												"son", "sont", "sous", "suivant", "sur", "ta", "te", "tes", "tien", "tienne", "tiennes",
												"tiens", "toi", "ton", "tous", "tout", "toute", "toutes", "tu", "un", "une", "va", "vers",
												"voici", "voilà", "vos", "votre", "vous", "vu", "vôtre", "vôtres", "y", "à", "ça", "ès",
												"été", "être", "ô"
				);
				break;
			default: break;
		}
		
		return $this->opa_stop_words;
	}
	# ------------------------------------------------------------------
}
# ----------------------------------------------------------------------
?>