<?php
/**
 * This file contains class::Entity
 * @package Runalyze\Model\RaceResult
 */

namespace Runalyze\Model\RaceResult;

use Runalyze\Model;

/**
 * RaceResult entity
 * 
 * @author Hannes Christiansen 
 * @author Michael Pohl
 * @package Runalyze\Model\RaceResult
 */
class Entity extends Model\Entity {
	/**
	 * Key: official_distance
	 * @var string
	 */
	const OFFICIAL_DISTANCE = 'official_distance';
	
	/**
	 * Key: official_time
	 * @var string
	 */
	const OFFICIAL_TIME = 'official_time';
      
	/**
	 * Key: offically_measured
	 * @var string
	 */
	const OFFICIALLY_MEASURED = 'officially_measured';
	
	/**
	 * Key: name
	 * @var string
	 */
	const NAME = 'name';
	/**
	 * Key: place_total
	 * @var string
	 */
	const PLACE_TOTAL = 'place_total';
      
	/**
	 * Key: place_gender
	 * @var string
	 */
	const PLACE_GENDER = 'place_gender';
	
	/**
	 * Key: place_ageclass
	 * @var string
	 */
	const PLACE_AGECLASS=  'place_ageclass';
      
	/**
	 * Key: participants_total
	 * @var string
	 */
	const PARTICIPANTS_TOTAL = 'participants_total';
	
	/**
	 * Key: participants_gender
	 * @var string
	 */
	const PARTICIPANTS_GENDER = 'participants_gender';
      
	/**
	 * Key: participants_ageclass
	 * @var string
	 */
	const PARTICIPANTS_AGECLASS = 'participants_ageclass';
	
	/**
	 * Key: activity id
	 * @var string
	 */
	const ACTIVITY_ID = 'activity_id';
      
	/**
	 * Key: account id
	 * @var string
	 */
	const ACCOUNTID = 'accountid';

	/**
	 * All properties
	 * @return array
	 */
	static public function allDatabaseProperties() {
		return array(
			self::OFFICIAL_DISTANCE,
			self::OFFICIAL_TIME,
			self::OFFICIALLY_MEASURED,
			self::NAME,
			self::PLACE_TOTAL,
			self::PLACE_GENDER,
			self::PLACE_AGECLASS,
			self::PARTICIPANTS_TOTAL,
			self::PARTICIPANTS_GENDER,
			self::PARTICIPANTS_AGECLASS,
			self::ACTIVITY_ID
		);
	}
	
	/**
	 * Properties
	 * @return array
	 */
	public function properties() {
		return static::allDatabaseProperties();
	}
	
	/**
	 * Ensure that numeric fields get numeric values
	 */
	protected function ensureAllNumericValues() {
		$this->ensureNumericValue(array(
			self::OFFICIAL_DISTANCE,
			self::OFFICIAL_TIME,
			self::OFFICIALLY_MEASURED,
		    self::PLACE_TOTAL,
			self::PLACE_GENDER,
			self::PLACE_AGECLASS,
			self::PARTICIPANTS_TOTAL,
			self::PARTICIPANTS_GENDER,
			self::PARTICIPANTS_AGECLASS,
			self::ACTIVITY_ID
		));
	}
	
	/**
	 * Synchronize
	 */
	public function synchronize() {
		parent::synchronize();

		$this->ensureNullIfEmpty(self::OFFICIALLY_MEASURED, true);
		$this->ensureAllNumericValues();
	}
	
	/**
	 * Can be null?
	 * @param string $key
	 * @return boolean
	 */
	protected function canBeNull($key) {
		switch ($key) {
			case self::OFFICIALLY_MEASURED:
				return true;
		}

		return false;
	}

	/**
	 * official distance
	 * @return string
	 */
	public function officialDistance() {
		return $this->Data[self::OFFICIAL_DISTANCE];
	}
	
	/**
	 * official time
	 * @return string
	 */
	public function officialTime() {
		return $this->Data[self::OFFICIAL_TIME];
	}
	
	/**
	 * officially measured
	 * @return string
	 */
	public function officiallyMeasured() {
		return $this->Data[self::OFFICIALLY_MEASURED];
	}
	
	/**
	 * name
	 * @return string
	 */
	public function name() {
		return $this->Data[self::NAME];
	}
	
	/**
	 * place total
	 * @return string
	 */
	public function placeTotal() {
		return $this->Data[self::PLACE_TOTAL];
	}
	
	/**
	 * place gender
	 * @return string
	 */
	public function placeGender() {
		return $this->Data[self::PLACE_GENDER];
	}
	
	/**
	 * place ageclass
	 * @return string
	 */
	public function placeAgeclass() {
		return $this->Data[self::PLACE_AGECLASS];
	}
	
	/**
	 * participants total
	 * @return string
	 */
	public function participantsTotal() {
		return $this->Data[self::PARTICIPANTS_TOTAL];
	}
	
	/**
	 * participants gender
	 * @return string
	 */
	public function participantsGender() {
		return $this->Data[self::PARTICIPANTS_GENDER];
	}
	
	/**
	 * participants ageclass
	 * @return string
	 */
	public function participantsAgeclass() {
		return $this->Data[self::PARTICIPANTS_AGECLASS];
	}
	
	/**
	 * activity id
	 * @return string
	 */
	public function activityId() {
		return $this->Data[self::ACTIVITY_ID];
	}
	
	/**
	 * account id
	 * @return string
	 */
	public function accountId() {
		return $this->Data[self::ACCOUNTID];
	}

}