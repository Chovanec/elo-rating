<?php

require_once('../src/Rating/Rating.php');

class RatingTest extends PHPUnit_Framework_TestCase
{

  public function testGetExpectedScores()
  {
    $object = new Rating\Rating(1000, 1500, 0, 1, 10, 10);
    $method = $this->getPrivateMethod('Rating\Rating', '_getExpectedScores');

    $expectedScore = $method->invokeArgs( $object, array(1000, 1500) );

    $this->assertEquals($expectedScore['a'], (1 / ( 1 + ( pow( 10 , 400 / 400 ) ) )) );
    $this->assertEquals($expectedScore['b'], (1 / ( 1 + ( pow( 10 , -400 / 400 ) ) )) );

    $expectedScore = $method->invokeArgs( $object, array(1500, 1400) );

    $this->assertEquals($expectedScore['a'], (1 / ( 1 + ( pow( 10 , -100 / 400 ) ) )) );
    $this->assertEquals($expectedScore['b'], (1 / ( 1 + ( pow( 10 , 100 / 400 ) ) )) );
  }

  public function testGetKFactors()
  {
    $object = new Rating\Rating(1000, 1500, 0, 1, 40, 40);
    $method = $this->getPrivateMethod('Rating\Rating', '_getKFactors');

    $KFactor = $method->invokeArgs( $object, array(1000, 1500, 10, 40) );

    $this->assertEquals($KFactor['a'], 40 );
    $this->assertEquals($KFactor['b'], 20 );

    $KFactor = $method->invokeArgs( $object, array(2500, 2320, 55, 5) );

    $this->assertEquals($KFactor['a'], 10 );
    $this->assertEquals($KFactor['b'], 20 );
  }

  public function testGetNewRating()
  {
    $rating = new Rating\Rating(1000, 1000, 1, 0, 0, 0);
    $results = $rating->getNewRatings();

    $this->assertEquals($results['a'], 1020 );
    $this->assertEquals($results['b'], 980 );

    $rating = new Rating\Rating(1000, 1000, 0, 1, 40, 0);
    $results = $rating->getNewRatings();

    $this->assertEquals($results['a'], 990 );
    $this->assertEquals($results['b'], 1020 );

    $rating = new Rating\Rating(2500, 2500, 1, 0, 50, 50);
    $results = $rating->getNewRatings();

    $this->assertEquals($results['a'], 2505 );
    $this->assertEquals($results['b'], 2495 );

    $rating = new Rating\Rating(2500, 2500, .5, .5, 50, 50);
    $results = $rating->getNewRatings();

    $this->assertEquals($results['a'], 2500 );
    $this->assertEquals($results['b'], 2500 );
  }


  /**
  * getPrivateMethod
  *
  * @author	Joe Sexton <joe@webtipblog.com>
  * @param 	string $className
  * @param 	string $methodName
  * @return	ReflectionMethod
  */
  public function getPrivateMethod( $className, $methodName ) {
    $reflector = new ReflectionClass( $className );
    $method = $reflector->getMethod( $methodName );
    $method->setAccessible( true );

    return $method;
  }
}
