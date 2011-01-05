<?php
/**
 * This file contains the class::Helper
 */

define('HF_MAX', Helper::getHFmax());
define('HF_REST', Helper::getHFrest());
define('START_TIME', Helper::getStartTime());
define('START_YEAR', date("Y", START_TIME));

require_once(FRONTEND_PATH.'class.JD.php');

/**
 * Class for all helper-functions previously done by functions.php
 * @defines   HF_MAX       int   Maximal heart-frequence [bpm]
 * @defines   HF_REST      int   Heart-frequence in rest [bpm]
 * @defines   START_TIME   int   Timestamp of first training
 * @defines   START_YEAR   int   Year of first training
 * 
 * @author Hannes Christiansen <mail@laufhannes.de>
 * @version 1.0
 * @uses class::Error ($error)
 * @uses class::Mysql ($mysql)
 * @uses class::JD
 *
 * Last modified 2010/08/28 18:08 by Hannes Christiansen
 */
class Helper {
	/**
	 * This class contains only static methods
	 */
	function __construct() {}
	function __destruct() {}

	/**
	 * Get the name or all information of a sport
	 * @param $sport_id       ID of the sport
	 * @param $as_array       Return as array [bool]
	 * @return string|array   Name of sport or all information as array
	 */
	static function Sport($sport_id, $as_array = false) {
		global $mysql;

		$sport = $mysql->fetch('ltb_sports', $sport_id);
		return ($as_array) ? $sport : $sport['name'];
	}

	/**
	 * Get the name or all information of a type
	 * @param $type_id          ID of the type
	 * @param $as_short        Return the shortname [bool]
	 * @param $as_has_splits   Return if the type allows splits [bool]
	 * @param $as_array        Return as array [bool]
	 * @return various         Depends on arguments
	 */
	static function Typ($type_id, $as_short = false, $as_has_splits = false, $as_array = false) {
		global $mysql;

		$typ = $mysql->fetch('ltb_typ', $type_id);
		if ($as_short)
			return $typ['abk'];
		if ($as_has_splits)
			return $typ['splits'];
		if ($as_array)
			return $typ;
		return $typ['name'];
	}

	/**
	 * Get the name or all information of a shoe
	 * @param $schuh_id       ID of the schuh
	 * @param $as_array       Return as array [bool]
	 * @return string|array   Name of shoe or all information as array
	 */
	static function Schuh($schuh_id, $as_array = false) {
		global $mysql;

		$schuh = $mysql->fetch('ltb_schuhe', $schuh_id);
		return ($as_array) ? $schuh : $schuh['name'];
	}

	/**
	 * Returns the img-Tag for a weather-symbol
	 * @param int       $wetter_id
	 * @return string   img-tag
	 */
	static function WetterImg($wetter_id) {
		global $mysql;

		$wetter = $mysql->fetch('ltb_wetter', $wetter_id);
		return ($wetter !== false)
			? '<img src="img/wetter/'.$wetter['bild'].'" title="'.$wetter['name'].'" style="vertical-align:bottom;" />'
			: '';
	}

	/**
	 * Get the speed depending on the sport as pace or km/h
	 * @uses self::Pace
	 * @uses self::Kmh
	 * @uses self::Sport
	 * @param $km         Distance [km]
	 * @param $time       Time [s]
	 * @param $sport_id   ID of sport for choosing pace/kmh
	 * @return string
	 */
	static function Tempo($km, $time, $sport_id = 0) {
		global $mysql;

		if ($km == 0 || $time == 0)
			return '';

		$kmh_mode = 0;
		$title = '';
		$as_pace = self::Pace($km, $time).'/km';
		$as_kmh = self::Kmh($km, $time).' km/h';

		if ($sport_id != 0) {
			$sport = self::Sport($sport_id, true);
			$kmh_mode = $sport['kmh'];
		}
		if ($kmh_mode == 1)
			return '<span title="'.$as_pace.'">'.$as_kmh.'</span>';
		return '<span title="'.$as_kmh.'">'.$as_pace.'</span>';
	}

	/**
	 * Get the speed in min/km without unit
	 * @uses self::Time
	 * @param $km     Distance [km]
	 * @param $time   Time [s]
	 * @return string
	 */
	static function Pace($km, $time) {
		return self::Time(round($time/$km));
	}

	/**
	 * Get the speed in km/h without unit
	 * @param $km     Distance [km]
	 * @param $time   Time [s]
	 * @return string
	 */
	static function Kmh($km, $time) {
		return number_format($km*3600/$time, 1, ',', '.');
	}

	/**
	 * Display a distance as km or m
	 * @param $km         Distance [km]
	 * @param $decimals   Decimals after the point
	 * @param $track      Run on a tartan track? [bool]
	 */
	static function Km($km, $decimals = 1, $track = false) {
		if ($km == 0)
			return '';
		if ($track)
			return number_format($km*1000, 0, ',', '.').' m';
		return number_format($km, $decimals, ',', '.').' km';
	}

	/**
	 * Display the time as a formatted string
	 * @uses self::TwoNumbers
	 * @param $time_in_s
	 * @param $show_days    Show days (default) or count hours > 24 [bool]
	 * @param $show_zeros   Show e.g. '0:00:00' for 0 [bool]
	 */
	static function Time($time_in_s, $show_days = true, $show_zeros = false) {
		$string = '';
		if ($show_zeros)
			return floor($time_in_s/3600).':'.self::TwoNumbers(floor($time_in_s/60)%60).':'.self::TwoNumbers($time_in_s%60);
		if ($time_in_s >= 86400 && $show_days)
			$string = floor($time_in_s/86400).'d ';
		if ($time_in_s < 3600)
			$string .= (floor($time_in_s/60)%60).':'.self::TwoNumbers($time_in_s%60);
		elseif ($show_days)
			$string .= (floor($time_in_s/3600)%24).':'.self::TwoNumbers(floor($time_in_s/60)%60).':'.self::TwoNumbers($time_in_s%60);
		else
			$string .= floor($time_in_s/3600).':'.self::TwoNumbers(floor($time_in_s/60)%60).':'.self::TwoNumbers($time_in_s%60);
		return $string;
	}

	/**
	 * Find the personal best for a given distance
	 * @uses self::Time
	 * @param $dist          Distance [km]
	 * @param $return_time   Return as integer [bool]
	 * @return various[string|int]
	 */
	static function Bestzeit($dist, $return_time = false) {
		global $mysql;
	
		$pb = $mysql->fetch('SELECT `dauer`, `distanz` FROM `ltb_training` WHERE `typid`='.WK_TYPID.' AND `distanz`="'.$dist.'" ORDER BY `dauer` ASC LIMIT 1');
		if ($return_time)
			return ($pb != '') ? $pb['dauer'] : 0;
		if ($bestzeit != '')
			return self::Time($pb['dauer']);
		return '<em>keine</em>';
	}

	/**
	 * Get the TRIMP for a training or get the minutes needed for a given TRIMP
	 * @param $training_id   Training-ID
	 * @param $trimp         [optional] If set, calculate backwards     
	 * @return int
	 */
	static function TRIMP($training_id, $trimp = false) {
		global $mysql, $config, $global;
	
		$dat = $mysql->fetch('ltb_training', $training_id);
		if ($dat === false)
			$dat = array();
		$factor_a = ($config['geschlecht'] == 'm') ? 0.64 : 0.86;
		$factor_b = ($config['geschlecht'] == 'm') ? 1.92 : 1.67;
		$sportid = ($dat['sportid'] != 0) ? $dat['sportid'] : 1;
		$sport = sport($sportid,true);
		$typ = ($dat['typid'] != 0) ? self::Typ($dat['typid'], false, false, true) : 0;
		$HFavg = ($dat['puls'] != 0) ? $dat['puls'] : $sport['HFavg'];
		$RPE = ($typ != 0) ? $typ['RPE'] : $sport['RPE'];
		$HFperRest = ($HFavg - $global['HFrest']) / ($global['HFmax'] - $global['HFrest']);
		$TRIMP = $dat['dauer']/60 * $HFperRest * $factor_a * exp($factor_b * $HFperRest) * $RPE / 10;
	
		if ($trimp === false)
			return round($TRIMP);
		// Anzahl der noetigen Minuten fuer $back als TRIMP-Wert
		return $trimp / ( $HFperRest * $factor_a * exp($factor_b * $HFperRest) * 5.35 / 10 );
	}

	/**
	 * Calculating ActualTrainingLoad (at a given timestamp)
	 * @uses ATL_DAYS
	 * @uses DAY_IN_S
	 * @param $time   [optional] Timestamp
	 */
	static function ATL($time = 0) {
		global $mysql;

		if ($time == 0)
			$time = time();
		$dat = $mysql->fetch('SELECT SUM(`trimp`) as `sum` FROM `ltb_training` WHERE `time` BETWEEN '.($time-ATL_DAYS*DAY_IN_S).' AND "'.$time.'"');
		return round($dat['sum']/ATL_DAYS);
	}

	/**
	 * Calculating ChronicTrainingLoad (at a given timestamp)
	 * @uses CTL_DAYS
	 * @uses DAY_IN_S
	 * @param $time   [optional] Timestamp
	 */
	static function CTL($time = 0) {
		global $mysql;

		if ($time == 0)
			$time = time();
		$dat = $mysql->fetch('SELECT SUM(`trimp`) as `sum` FROM `ltb_training` WHERE `time` BETWEEN '.($time-CTL_DAYS*DAY_IN_S).' AND "'.$time.'"');
		return round($dat['sum']/CTL_DAYS);
	}

	/**
	 * Calculating TrainingStressBalance (at a given timestamp)
	 * @uses self::CTL
	 * @uses self::ATL
	 * @param $time
	 */
	static function TSB($time = 0) {
		global $mysql;

		return self::CTL($time) - self::ATL($time);
	}

	/**
	 * Creating a RGB-color for a given stress-value [0-100]
	 * @param $stress   Stress-value [0-100]
	 */
	static function Stresscolor($stress) {
		if ($stress > 100)
			$stress = 100;
		$gb = dechex(200 - 2*$stress);
		if ((200 - 2*$stress) < 16)
			$gb = '0'.$gb;
		return 'C8'.$gb.$gb;
	}

	/**
	 * Calculating 'Grundlagenausdauer'
	 * @uses DAY_IN_S
	 * @param $as_int
	 * @param $timestamp
	 */
	static function Grundlagenausdauer($as_int = false, $timestamp = 0) {
		global $global, $mysql;

		if ($timestamp == 0)
			$timestamp = time();
		$points = 0;
		// Wochenkilometer
		$wk_sum = 0;
		$data = $mysql->fetch('SELECT `time`, `distanz` FROM `ltb_training` WHERE `time` BETWEEN '.($timestamp-140*DAY_IN_S).' AND '.$timestamp.' ORDER BY `time` DESC');
		foreach($data as $dat) {
			$tage = round ( ($timestamp - $dat['time']) / DAY_IN_S , 1 );
			$wk_sum += (2 - (1/70) * $tage) * $dat['distanz'];
		}
		$points += $wk_sum / 20;
		// Lange L�ufe ...
		$data = $mysql->fetch('SELECT `distanz` FROM `ltb_training` WHERE `typid`='.LL_TYPID.' AND `time` BETWEEN '.($timestamp-70*DAY_IN_S).' AND '.$timestamp.' ORDER BY `time` DESC');
		foreach($data as $dat)
			$points += ($dat['distanz']-15) / 2;
	
		$points = round($points - 50);
		if ($points < 0) $points = 0;
		if ($points > 100) $points = 100;
	
		if ($as_int)
			return $points;
		return ($as_int) ? $points : $points.' &#37;';
	}

	/**
	 * Calculate a prognosis for a given distance
	 * @uses VDOT_FORM
	 * @uses self::Grundlagenausdauer
	 * @uses self::Bestzeit
	 * @uses self::Time
	 * @uses self::Km
	 * @uses JD::WKPrognosis
	 * @param $dist   Distance [km]
	 * @param $bahn   A track run? [bool]
	 * @param $VDOT   Make prognosis for a given VDOT value? (used in plugin/panel.prognose)
	 */
	static function Prognose($dist, $bahn = false, $VDOT = 0) {
		global $global;
	
		$VDOT_new = ($VDOT == 0) ? VDOT_FORM : $VDOT;
		$pb = self::Bestzeit($dist, true);
		// Grundlagenausdauer
		if ($dist > 5)
			$VDOT_new *= 1 - (1 - self::Grundlagenausdauer(true)/100) * (exp(0.005*($dist-5)) - 1);
		$prognose_dauer = JD::WKPrognosis($VDOT_new, $dist);
		if ($VDOT != 0)
			return zeit($prognose_dauer);
		$bisher_tag = ($prognose_dauer < $pb) ? 'del' : 'strong';
		$neu_tag = ($prognose_dauer > $pb) ? 'del' : 'strong';
		return '
	<p>
		<span>
			<small>von</small>
				<'.$bisher_tag.' title="VDOT '.JD::WK2VDOT($dist, $pb).'">
					'.self::Time($pb).'
				</'.$bisher_tag.'>
			<small>auf</small>
				<'.$neu_tag.' title="VDOT '.$VDOT_new.'">
					'.self::Time($prognose_dauer).'
				</'.$neu_tag.'>
			<small>('.self::Time($prognose_dauer/$dist).'/km)</small>
		</span>
		<strong>'.self::Km($dist, 0, $bahn).'</strong>
	</p>'.NL;
	}

	/**
	 * Get a leading 0 if $int is lower than 10
	 * @param $int
	 */
	static function TwoNumbers($int) {
		return ($int < 10) ? '0'.$int : $int;
	}

	/**
	 * Get a special char if $var is not set
	 * @param $var
	 * @param $char   special char [optional]
	 */
	static function Unbekannt($var, $char = '?') {
		if ((is_numeric($var) && $var != 0) || (!is_numeric($var) && $var != '') )
			return $var;
		return $char;
	}

	/**
	 * Cut a string if it is longer than $cut (default CUT_LENGTH)
	 * @uses CUT_LENGTH
	 * @param $text
	 * @param $cut
	 */
	static function Cut($text, $cut = 0) {
		if ($cut == 0)
			$cut = CUT_LENGTH;
		if (strlen($text) >= $cut)
			return substr ($text, 0, $cut-3).'...';
		return $text;
	}

	/**
	 * Get the timestamp of the start of the week
	 * @param $time
	 */
	static function Wochenstart($time) {
		$w = date("w", $time);
		if ($w == 0)
			$w = 7;
		$w -= 1;
		return mktime(0, 0, 0, date("m",$time), date("d",$time)-$w, date("Y",$time));
	}

	/**
	 * Get the timestamp of the end of the week
	 * @param $time
	 */
	static function Wochenende($time) {
		$start = Wochenstart($time);
		return mktime(23, 59, 50, date("m",$start), date("d",$start)+6, date("Y",$start));
	}

	/**
	 * Get the name of a day
	 * @param $w       date('w');
	 * @param $short   bool[optional]
	 */
	static function Wochentag($w, $short = false) {
		switch($w%7) {
			case 0: return ($short) ? "So" : "Sonntag";
			case 1: return ($short) ? "Mo" : "Montag";
			case 2: return ($short) ? "Di" : "Dienstag";
			case 3: return ($short) ? "Mi" : "Mittwoch";
			case 4: return ($short) ? "Do" : "Donnerstag";
			case 5: return ($short) ? "Fr" : "Freitag";
			case 6: return ($short) ? "Sa" : "Samstag";
		}
	}

	/**
	 * Get the name of the month
	 * @param $m       date('m');
	 * @param $short   bool[optional]
	 */
	static function Monat($m, $short = false) {
		switch($m) {
			case 1: return ($short) ? "Jan" :  "Januar";
			case 2: return ($short) ? "Feb" :  "Februar";
			case 3: return ($short) ? "Mrz" :  "M&auml;rz";
			case 4: return ($short) ? "Apr" :  "April";
			case 5: return ($short) ? "Mai" :  "Mai";
			case 6: return ($short) ? "Jun" :  "Juni";
			case 7: return ($short) ? "Jul" :  "Juli";
			case 8: return ($short) ? "Aug" :  "August";
			case 9: return ($short) ? "Sep" :  "September";
			case 10: return ($short) ? "Okt" :  "Oktober";
			case 11: return ($short) ? "Nov" :  "November";
			case 12: return ($short) ? "Dez" :  "Dezember";
		}
	}

	/**
	 * Replace every comma with a point
	 * @param $string
	 */
	static function CommaToPoint($string) {
		return ereg_replace(",", ".", $string);
	}

	/**
	 * Replace ampersands for a textarea
	 * @param $text
	 */
	static function Textarea($text) {
		return stripslashes(ereg_replace("&","&amp;",$text));
	}

	/**
	 * Replace umlauts from AJAX
	 * @param $text
	 */
	static function Umlaute($text) {
		$text = ereg_replace("ß", "�", $text);
		$text = ereg_replace("Ä", "�", $text); $text = ereg_replace("Ö", "�", $text);
		$text = ereg_replace("Ü", "�", $text); $text = ereg_replace("ä", "�", $text);
		$text = ereg_replace("ö", "�", $text); $text = ereg_replace("ü", "�", $text);
		return $text;
	}

	/**
	 * Check the modus of a row from dataset
	 * @param $row   Name of dataset-row
	 * @return int   Modus
	 */
	static function getModus($row) {
		global $mysql;

		$db = mysql_query('SELECT `name`, `modus` FROM `ltb_dataset` WHERE `name`="'.$row.'" LIMIT 1');
		$dat = mysql_fetch_assoc($db);
		return $dat['modus'];
	}

	/**
	 * Return an empty td-Tag
	 * @return string
	 */
	static function emptyTD() {
		return '<td>&nbsp;</td>'.NL;
	}

	/**
	 * Get the HFmax from ltb_user
	 * @return int   HFmax
	 */
	static function getHFmax() {
		global $mysql, $error;

		if (defined('HF_MAX'))
			return HF_MAX;
		$userdata = $mysql->fetch('SELECT `puls_max` FROM `ltb_user` ORDER BY `time` DESC LIMIT 1');
		if ($userdata === false) {
			$error->add('WARNING', 'HFmax is not set in database, 200 as default.');
			return 200;
		}
		return $userdata['puls_max'];
	}

	/**
	 * Get the HFrest from ltb_user
	 * @return int   HFrest
	 */
	static function getHFrest() {
		global $mysql, $error;

		if (defined('HF_REST'))
			return HF_MAX;
		$userdata = $mysql->fetch('SELECT `puls_ruhe` FROM `ltb_user` ORDER BY `time` DESC LIMIT 1');
		if ($userdata === false) {
			$error->add('WARNING', 'HFrest is not set in database, 60 as default.');
			return 60;
		}
		return $userdata['puls_ruhe'];
	}

	/**
	 * Get timestamp of first training
	 * @return int   Timestamp
	 */
	static function getStartTime() {
		global $mysql;

		$data = $mysql->fetch('SELECT MIN(`time`) as `time` FROM `ltb_training`');
		if ($data === false)
			return time();
		return $data['time'];
	}
}
?>