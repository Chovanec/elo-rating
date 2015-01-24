<?php

/**
 * This class calculates ratings based on the Elo system used in chess.
 *
 * @author Michal Chovanec <michalchovaneceu@gmail.com>
 * @copyright Copyright © 2012 - 2014 Michal Chovanec
 * @license Creative Commons Attribution 4.0 International License
 */

namespace Rating;

class Rating
{

    /**
     * Protected & private variables.
     */
    protected $_ratingA;
    protected $_ratingB;
    protected $_gamesNumberA;
    protected $_gamesNumberB;

    protected $_scoreA;
    protected $_scoreB;

    protected $_expectedA;
    protected $_expectedB;

    protected $_KFactorA;
    protected $_KFactorB;

    protected $_newRatingA;
    protected $_newRatingB;

    /**
     * Costructor function which does all the maths and stores the results ready
     * for retrieval.
     *
     * @param int Current rating of A
     * @param int Current rating of B
     * @param int Score of A
     * @param int Score of B
     */
    public function  __construct($ratingA,$ratingB,$scoreA,$scoreB,$gamesNumberA,$gamesNumberB)
    {
        $this->_ratingA = $ratingA;
        $this->_ratingB = $ratingB;
        $this->_gamesNumberA = $gamesNumberA;
        $this->_gamesNumberB = $gamesNumberB;
        $this->_scoreA = $scoreA;
        $this->_scoreB = $scoreB;

        $expectedScores = $this -> _getExpectedScores($this -> _ratingA,$this -> _ratingB);
        $this->_expectedA = $expectedScores['a'];
        $this->_expectedB = $expectedScores['b'];

        $KFactor = $this -> _getKFactors($this -> _ratingA,$this -> _ratingB,$this -> _gamesNumberA,$this -> _gamesNumberB);
        $this->_KFactorA = $KFactor['a'];
        $this->_KFactorB = $KFactor['b'];

        $newRatings = $this ->_getNewRatings($this -> _ratingA, $this -> _ratingB, $this -> _expectedA, $this -> _expectedB, $this -> _scoreA, $this -> _scoreB, $this -> _KFactorA, $this -> _KFactorB);
        $this->_newRatingA = $newRatings['a'];
        $this->_newRatingB = $newRatings['b'];
    }

    /**
     * Set new input data.
     *
     * @param int Current rating of A
     * @param int Current rating of B
     * @param int Score of A
     * @param int Score of B
     */
    public function setNewSettings($ratingA,$ratingB,$scoreA,$scoreB)
    {
        $this -> _ratingA = $ratingA;
        $this -> _ratingB = $ratingB;
        $this -> _scoreA = $scoreA;
        $this -> _scoreB = $scoreB;

        $expectedScores = $this -> _getExpectedScores($this -> _ratingA,$this -> _ratingB);
        $this -> _expectedA = $expectedScores['a'];
        $this -> _expectedB = $expectedScores['b'];

        $newRatings = $this ->_getNewRatings($this -> _ratingA, $this -> _ratingB, $this -> _expectedA, $this -> _expectedB, $this -> _scoreA, $this -> _scoreB, $this -> _gamesNumberA, $this -> _gamesNumberB);
        $this -> _newRatingA = $newRatings['a'];
        $this -> _newRatingB = $newRatings['b'];
    }

    /**
     * Retrieve the calculated data.
     *
     * @return Array An array containing the new ratings for A and B.
     */
    public function getNewRatings()
    {
        return array (
            'a' => $this -> _newRatingA,
            'b' => $this -> _newRatingB
        );
    }

    /**
     * Protected & private functions begin here
     */

    protected function _getExpectedScores($ratingA,$ratingB)
    {
        $difA = $ratingA - $ratingB;

        if ( $difA > 400 ) { $difA = 400; }
        else if ( $difA < -400 ) { $difA = -400; }

        $expectedScoreA = 1 / ( 1 + ( pow( 10 , -( $difA ) / 400 ) ) );


        $difB = $ratingB - $ratingA;

        if ( $difB > 400 ) { $difB = 400; }
        else if ( $difB < -400 ) { $difB = -400; }

        $expectedScoreB = 1 / ( 1 + ( pow( 10 , -( $difB ) / 400 ) ) );


        return array (
            'a' => $expectedScoreA,
            'b' => $expectedScoreB
        );
    }

    protected function _getKFactors($ratingA,$ratingB,$gamesNumberA,$gamesNumberB)
    {
        if ( $gamesNumberA < 30 && $ratingA < 2300 ) { $KFactorA = 40; }
        else if ( $ratingA >= 30 && $ratingA < 2400 ) { $KFactorA = 20; }
        else { $KFactorA = 10; }

        if ( $gamesNumberB < 30 && $ratingB < 2300 ) { $KFactorB = 40; }
        else if ( $ratingB >= 30 && $ratingB < 2400 ) { $KFactorB = 20; }
        else { $KFactorB = 10; }

        return array (
        'a' => $KFactorA,
        'b' => $KFactorB
      );
    }

    protected function _getNewRatings($ratingA,$ratingB,$expectedA,$expectedB,$scoreA,$scoreB,$KFactorA,$KFactorB)
    {
        $newRatingA = $ratingA + ( $KFactorA * ( $scoreA - $expectedA ) );
        $newRatingB = $ratingB + ( $KFactorB * ( $scoreB - $expectedB ) );

        return array (
            'a' => $newRatingA,
            'b' => $newRatingB
        );
    }

}
