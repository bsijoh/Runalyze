<?php

namespace Runalyze\Model\Activity;

use League\Geotools\Coordinate\Coordinate;
use League\Geotools\Geohash\Geohash;
use Runalyze\Configuration;
use Runalyze\Model;
use Runalyze\Data\Weather;
use Runalyze\Util\LocalTime;

use PDO;

/**
 * Generated by hand
 */
class InserterTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var \PDO
	 */
	protected $PDO;

	protected $OutdoorID;
	protected $IndoorID;
	protected $RunningRaceTypeId;

	protected $EquipmentType;
	protected $EquipmentA;
	protected $EquipmentB;
	protected $EquipmentC;

	protected function setUp() {
		\Cache::clean();
		$this->PDO = \DB::getInstance();
		$this->PDO->exec('INSERT INTO `'.PREFIX.'sport` (`name`,`kcal`,`outside`,`accountid`,`power`) VALUES("",600,1,0,1)');
		$this->OutdoorID = $this->PDO->lastInsertId();
		$this->PDO->exec('INSERT INTO `'.PREFIX.'sport` (`name`,`kcal`,`outside`,`accountid`,`power`) VALUES("",400,0,0,0)');
		$this->IndoorID = $this->PDO->lastInsertId();
		$this->RunningRaceTypeId = 3;
		$this->PDO->exec('INSERT INTO `'.PREFIX.'sport` (`name`,`kcal`,`outside`,`accountid`,`power`, `race_typeid`) VALUES("Running",400,0,0,0,'.$this->RunningRaceTypeId.')');
		$runningSportId = $this->PDO->lastInsertId();
		$this->PDO->exec("INSERT INTO runalyze_conf (`category`, `key`, `value`, `accountid`) VALUES ('general', 'RUNNINGSPORT', ".$runningSportId.", 0)");
		Configuration::loadAll(0);
		$this->PDO->exec('INSERT INTO `'.PREFIX.'equipment_type` (`name`,`accountid`) VALUES("Type",0)');
		$this->EquipmentType = $this->PDO->lastInsertId();
		$this->PDO->exec('INSERT INTO `'.PREFIX.'equipment_sport` (`sportid`,`equipment_typeid`) VALUES('.$this->OutdoorID.','.$this->EquipmentType.')');
		$this->PDO->exec('INSERT INTO `'.PREFIX.'equipment` (`name`,`typeid`,`notes`,`accountid`) VALUES("A",'.$this->EquipmentType.',"",0)');
		$this->EquipmentA = $this->PDO->lastInsertId();
		$this->PDO->exec('INSERT INTO `'.PREFIX.'equipment` (`name`,`typeid`,`notes`,`accountid`) VALUES("B",'.$this->EquipmentType.',"",0)');
		$this->EquipmentB = $this->PDO->lastInsertId();
		$this->PDO->exec('INSERT INTO `'.PREFIX.'equipment` (`name`,`typeid`,`notes`,`accountid`) VALUES("C",'.$this->EquipmentType.',"",0)');
		$this->EquipmentC = $this->PDO->lastInsertId();

		$Factory = new Model\Factory(0);
		$Factory->clearCache('sport');
		\SportFactory::reInitAllSports();
	}

	protected function tearDown() {
		$this->PDO->exec('DELETE FROM `'.PREFIX.'training`');
		$this->PDO->exec('DELETE FROM `'.PREFIX.'sport`');
		$this->PDO->exec('DELETE FROM `'.PREFIX.'equipment_type`');

		$Factory = new Model\Factory(0);
		$Factory->clearCache('sport');
		\Cache::clean();
	}

	/**
	 * @param array $data
	 * @return int
	 */
	protected function insert(array $data) {
		$Inserter = new Inserter($this->PDO, new Entity($data));
		$Inserter->setAccountID(0);
		$Inserter->insert();

		return $Inserter->insertedID();
	}

	/**
	 * @param int $id
	 * @return \Runalyze\Model\Activity\Entity
	 */
	protected function fetch($id) {
		return new Entity(
			$this->PDO->query('SELECT * FROM `'.PREFIX.'training` WHERE `id`="'.$id.'" AND `accountid`=0')->fetch(PDO::FETCH_ASSOC)
		);
	}

	public function testWrongObject() {
	    if (PHP_MAJOR_VERSION >= 7) $this->setExpectedException('TypeError'); else $this->setExpectedException('\PHPUnit_Framework_Error');
		new Inserter($this->PDO, new Model\Trackdata\Entity);
	}

	public function testSimpleInsert() {
		$Object = $this->fetch(
			$this->insert(array(
				Entity::TIME_IN_SECONDS => 3600,
				Entity::DISTANCE => 12.0
			))
		);

		$this->assertEquals(time(), $Object->get(Entity::TIMESTAMP_CREATED), '', 10);
		$this->assertEquals(3600, $Object->duration());
		$this->assertEquals(12.0, $Object->distance());
		$this->assertNull($Object->fitTrainingEffect());
		$this->assertNull($Object->rpe());
	}

	public function testOutdoorData() {
		$Object = $this->fetch(
			$this->insert(array(
				Entity::TIME_IN_SECONDS => 3600,
				Entity::WEATHERID => Weather\Condition::SUNNY,
				Entity::TEMPERATURE => 7,
				Entity::HUMIDITY => 67,
				Entity::PRESSURE => 1020,
				Entity::WINDDEG => 180,
				Entity::WINDSPEED => 12,
				Entity::SPORTID => $this->OutdoorID
			))
		);

		$this->assertEquals(Weather\Condition::SUNNY, $Object->weather()->condition()->id());
		$this->assertEquals(7, $Object->weather()->temperature()->value());
	}

	public function testIndoorData() {
		$Object = $this->fetch(
			$this->insert(array(
				Entity::TIME_IN_SECONDS => 3600,
				Entity::WEATHERID => Weather\Condition::SUNNY,
				Entity::TEMPERATURE => 7,
				Entity::HUMIDITY => 67,
				Entity::PRESSURE => 1020,
				Entity::WINDDEG => 180,
				Entity::WINDSPEED => 12,
				Entity::SPORTID => $this->IndoorID
			))
		);

		$this->assertTrue($Object->weather()->isEmpty());
	}

	public function testCalories() {
		$ObjectWithout = $this->fetch(
			$this->insert(array(
				Entity::TIME_IN_SECONDS => 3600,
				Entity::SPORTID => $this->OutdoorID
			))
		);

		$this->assertEquals(600, $ObjectWithout->calories());

		$ObjectWith = $this->fetch(
			$this->insert(array(
				Entity::TIME_IN_SECONDS => 3600,
				Entity::SPORTID => $this->OutdoorID,
				Entity::CALORIES => 873
			))
		);

		$this->assertEquals(873, $ObjectWith->calories());
	}

	public function testStartTimeUpdate() {
		$current = time();
		$timeago = mktime(0,0,0,1,1,2000);

		Configuration::Data()->updateStartTime($current);

		$this->insert(array(
			Entity::TIMESTAMP => $current
		));

		$this->assertEquals($current, Configuration::Data()->startTime());

		$this->insert(array(
			Entity::TIMESTAMP => $timeago
		));

		$this->assertEquals($timeago, Configuration::Data()->startTime());
	}

	public function testCalculationsForRunning() {
		$Object = $this->fetch( $this->insert(array(
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 3000,
			Entity::HR_AVG => 150,
			Entity::SPORTID => Configuration::General()->runningSport()
		)));

		$this->assertGreaterThan(0, $Object->vdotByTime());
		$this->assertGreaterThan(0, $Object->vdotByHeartRate());
		$this->assertGreaterThan(0, $Object->vdotWithElevation());
		$this->assertGreaterThan(0, $Object->jdIntensity());
		$this->assertGreaterThan(0, $Object->trimp());
	}

	public function testCalculationsForNotRunning() {
		$Object = $this->fetch( $this->insert(array(
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 3000,
			Entity::HR_AVG => 150,
			Entity::SPORTID => Configuration::General()->runningSport() + 1
		)));

		$this->assertEquals(0, $Object->vdotByTime());
		$this->assertEquals(0, $Object->vdotByHeartRate());
		$this->assertEquals(0, $Object->vdotWithElevation());
		$this->assertEquals(0, $Object->jdIntensity());
		$this->assertGreaterThan(0, $Object->trimp());
	}

	public function testVDOTstatisticsUpdate() {
		$current = time();
		$timeago = mktime(0,0,0,1,1,2000);
		$running = Configuration::General()->runningSport();
		$raceid = $this->RunningRaceTypeId;
		Configuration::Data()->updateVdotShape(0);
		Configuration::Data()->updateVdotCorrector(1);

		$this->insert(array(
			Entity::TIMESTAMP => $timeago,
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 30*60,
			Entity::HR_AVG => 150,
			Entity::SPORTID => $running,
			Entity::TYPEID => $raceid + 1,
			Entity::USE_VDOT => true
		));
		$this->insert(array(
			Entity::TIMESTAMP => $current,
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 30*60,
			Entity::HR_AVG => 150,
			Entity::SPORTID => $running + 1,
			Entity::USE_VDOT => true
		));
		$this->insert(array(
			Entity::TIMESTAMP => $current,
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 30*60,
			Entity::SPORTID => $running,
			Entity::USE_VDOT => true
		));

		$this->assertEquals(0, Configuration::Data()->vdotShape());
		$this->assertEquals(1, Configuration::Data()->vdotFactor());

		$this->insert(array(
			Entity::TIMESTAMP => $current,
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 30*60,
			Entity::HR_AVG => 150,
			Entity::SPORTID => $running,
			Entity::TYPEID => $raceid + 1,
			Entity::USE_VDOT => true
		));

		$this->assertNotEquals(0, Configuration::Data()->vdotShape());
		$this->assertEquals(1, Configuration::Data()->vdotFactor());

		$this->insert(array(
			Entity::TIMESTAMP => $current,
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 30*60,
			Entity::HR_AVG => 150,
			Entity::SPORTID => $running,
			Entity::TYPEID => $raceid,
			Entity::USE_VDOT => true
		));

		$this->assertNotEquals(0, Configuration::Data()->vdotShape());
		$this->assertNotEquals(1, Configuration::Data()->vdotFactor());
	}

	public function testWithCalculationsFromAdditionalObjects() {
		$Activity = new Entity(array(
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 3000,
			Entity::HR_AVG => 150,
			Entity::SPORTID => Configuration::General()->runningSport()
		));

		$Inserter = new Inserter($this->PDO);
		$Inserter->setAccountID(0);
		$Inserter->insert($Activity);
		$ObjectWithout = $this->fetch( $Inserter->insertedID() );

		$Inserter->setTrackdata(new Model\Trackdata\Entity(array(
			Model\Trackdata\Entity::TIME => array(1500, 3000),
			Model\Trackdata\Entity::HEARTRATE => array(125, 175)
		)));
		$Inserter->setRoute(new Model\Route\Entity(array(
			Model\Route\Entity::ELEVATION_UP => 500,
			Model\Route\Entity::ELEVATION_DOWN => 100
		)));

		$Inserter->insert($Activity);
		$ObjectWith = $this->fetch( $Inserter->insertedID());

		$this->assertGreaterThan($ObjectWithout->vdotWithElevation(), $ObjectWith->vdotWithElevation());
		$this->assertGreaterThan($ObjectWithout->jdIntensity(), $ObjectWith->jdIntensity());
		$this->assertGreaterThan($ObjectWithout->trimp(), $ObjectWith->trimp());
	}

	public function testWithSwimdata() {
		$Activity = new Entity(array(
			Entity::DISTANCE => 0.2,
			Entity::TIME_IN_SECONDS => 120,
		));

		$Inserter = new Inserter($this->PDO);
		$Inserter->setAccountID(0);
		$Inserter->setTrackdata(new Model\Trackdata\Entity(array(
			Model\Trackdata\Entity::TIME => array(30, 60, 90, 120),
			Model\Trackdata\Entity::DISTANCE => array(0.05, 0.1, 0.15, 0.2)
		)));
		$Inserter->setSwimdata(new Model\Swimdata\Entity(array(
			Model\Swimdata\Entity::STROKE => array(25, 20, 15, 20)
		)));
		$Inserter->insert($Activity);
		$Result = $this->fetch( $Inserter->insertedID());

		$this->assertEquals(80, $Result->totalStrokes());
		$this->assertEquals(50, $Result->swolf());
	}

	public function testTemperature() {
		$Zero = $this->fetch(
			$this->insert(array(
				Entity::TEMPERATURE => 0,
				Entity::SPORTID => $this->OutdoorID
			))
		);

		$this->assertEquals(0, $Zero->weather()->temperature()->value());
		$this->assertFalse($Zero->weather()->temperature()->isUnknown());
		$this->assertFalse($Zero->weather()->isEmpty());
	}

	public function testPowerCalculation() {
		// TODO: Needs configuration setting
		if (Configuration::ActivityForm()->computePower()) {
			$ActivityIndoor = new Entity(array(
				Entity::DISTANCE => 10,
				Entity::TIME_IN_SECONDS => 3000,
				Entity::SPORTID => $this->IndoorID
			));

			$Trackdata = new Model\Trackdata\Entity(array(
				Model\Trackdata\Entity::TIME => array(1500, 3000),
				Model\Trackdata\Entity::DISTANCE => array(5, 10)
			));

			$Inserter = new Inserter($this->PDO);
			$Inserter->setAccountID(0);
			$Inserter->setTrackdata($Trackdata);
			$Inserter->insert($ActivityIndoor);

			$this->assertEquals(0, $this->fetch($Inserter->insertedID())->power());

			$ActivityOutdoor = clone $ActivityIndoor;
			$ActivityOutdoor->set(Entity::SPORTID, $this->OutdoorID);
			$Inserter->insert($ActivityOutdoor);

			$this->assertNotEquals(0, $this->fetch($Inserter->insertedID())->power());
			$this->assertNotEmpty($Trackdata->power());
		}
	}

	public function testEquipment() {
		$this->PDO->exec('UPDATE `runalyze_equipment` SET `distance`=0, `time`=0 WHERE `id`='.$this->EquipmentA);
		$this->PDO->exec('UPDATE `runalyze_equipment` SET `distance`=1, `time`=600 WHERE `id`='.$this->EquipmentB);
		$this->PDO->exec('UPDATE `runalyze_equipment` SET `distance`=0, `time`=0 WHERE `id`='.$this->EquipmentC);

		$Inserter = new Inserter($this->PDO);
		$Inserter->setAccountID(0);
		$Inserter->setEquipmentIDs(array($this->EquipmentA, $this->EquipmentB));
		$Inserter->insert(new Entity(array(
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 3600,
			Entity::SPORTID => $this->OutdoorID
		)));

		$this->assertEquals(array(10, 3600), $this->PDO->query('SELECT `distance`, `time` FROM `runalyze_equipment` WHERE `id`='.$this->EquipmentA)->fetch(PDO::FETCH_NUM));
		$this->assertEquals(array(11, 4200), $this->PDO->query('SELECT `distance`, `time` FROM `runalyze_equipment` WHERE `id`='.$this->EquipmentB)->fetch(PDO::FETCH_NUM));
		$this->assertEquals(array( 0,    0), $this->PDO->query('SELECT `distance`, `time` FROM `runalyze_equipment` WHERE `id`='.$this->EquipmentC)->fetch(PDO::FETCH_NUM));
	}

	/**
	 * @group verticalRatio
	 */
	public function testStrideLengthAndVerticalRatioCalculation() {
		$Activity = new Entity(array(
			Entity::DISTANCE => 0.36,
			Entity::TIME_IN_SECONDS => 120,
			Entity::SPORTID => Configuration::General()->runningSport(),
			Entity::CADENCE => 95,
			Entity::VERTICAL_OSCILLATION => 85
		));

		$Trackdata = new Model\Trackdata\Entity(array(
			Model\Trackdata\Entity::TIME => array(60, 120),
			Model\Trackdata\Entity::DISTANCE => array(0.18, 0.36),
			Model\Trackdata\Entity::CADENCE => array(90, 100),
			Model\Trackdata\Entity::VERTICAL_OSCILLATION => array(90, 80)
		));

		$Inserter = new Inserter($this->PDO);
		$Inserter->setAccountID(0);
		$Inserter->setTrackdata($Trackdata);
		$Inserter->insert($Activity);

		$this->assertEquals(95, $this->fetch($Inserter->insertedID())->strideLength());
		$this->assertEquals(array(100, 90), $Trackdata->strideLength());

		$this->assertEquals(89, $this->fetch($Inserter->insertedID())->verticalRatio());
		$this->assertEquals(array(90, 89), $Trackdata->verticalRatio());
	}

	public function testEmptySport() {
		$Inserter = new Inserter($this->PDO);
		$Inserter->setAccountID(0);
		$Inserter->insert(new Entity(array(
			Entity::DISTANCE => 10,
			Entity::TIME_IN_SECONDS => 3600
		)));

		$mainSport = Configuration::General()->mainSport();
		$this->assertEquals($mainSport, $this->PDO->query('SELECT `sportid` FROM `runalyze_training` WHERE `id`='.$Inserter->insertedID())->fetchColumn());
	}

	public function testCalculatingNight() {
		$Activity = new Entity([
			Entity::TIMESTAMP => LocalTime::fromString('2016-01-13 08:00:00')->getTimestamp()
		]);

		$Route = new Model\Route\Entity([
			Model\Route\Entity::GEOHASHES => [(new Geohash())->encode(new Coordinate([49.44, 7.45]))->getGeohash()]
		]);
		$Route->synchronize();

		$Inserter = new Inserter($this->PDO);
		$Inserter->setAccountID(0);
		$Inserter->insert($Activity);
		$this->assertFalse($this->fetch($Inserter->insertedID())->knowsIfItIsNight());

		$Inserter->setRoute($Route);
		$Inserter->insert($Activity);
		$ResultActivity = $this->fetch($Inserter->insertedID());
		$this->assertTrue($ResultActivity->knowsIfItIsNight());
		$this->assertTrue($ResultActivity->isNight());

		$Activity->set(Entity::TIMESTAMP, LocalTime::fromString('2016-01-13 09:00:00')->getTimestamp());
		$Inserter->insert($Activity);
		$ResultActivity = $this->fetch($Inserter->insertedID());
		$this->assertTrue($ResultActivity->knowsIfItIsNight());
		$this->assertFalse($ResultActivity->isNight());
	}

	public function testTimezoneOffset() {
		$Object = $this->fetch(
			$this->insert([])
		);

		$this->assertFalse($Object->knowsTimezoneOffset());
		$this->assertEquals(null, $Object->timezoneOffset());

		$ObjectWithNull = $this->fetch(
			$this->insert([
				Entity::TIMEZONE_OFFSET => null
			])
		);

		$this->assertFalse($ObjectWithNull->knowsTimezoneOffset());
		$this->assertEquals(null, $ObjectWithNull->timezoneOffset());

		$ObjectWithOffset = $this->fetch(
			$this->insert([
				Entity::TIMEZONE_OFFSET => 120
			])
		);

		$this->assertTrue($ObjectWithOffset->knowsTimezoneOffset());
		$this->assertEquals(120, $ObjectWithOffset->timezoneOffset());

		$ObjectWithNegativeOffset = $this->fetch(
			$this->insert([
				Entity::TIMEZONE_OFFSET => -60
			])
		);

		$this->assertTrue($ObjectWithNegativeOffset->knowsTimezoneOffset());
		$this->assertEquals(-60, $ObjectWithNegativeOffset->timezoneOffset());
	}

}
