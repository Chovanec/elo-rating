<?php
/**
 * This class calculates ratings based on the Elo system used in chess.
 *
 * @author Priyesh Patel <priyesh@pexat.com> & Michal Chovanec <michalchovaneceu@gmail.com>
 * @copyright Copyright (c) 2011 onwards, Priyesh Patel
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License
 */
class Rating
{

    /**
     * @var int The K Factor used.
     */
    const KFACTOR = 16;

    /**
     * Protected & private variables.
     */
    protected $_ratingA;
    protected $_ratingB;
    
    protected $_scoreA;
    protected $_scoreB;

    protected $_expectedA;
    protected $_expectedB;

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
    public function  __construct($ratingA,$ratingB,$scoreA,$scoreB)
    {
        $this->_ratingA = $ratingA;
        $this->_ratingB = $ratingB;
        $this->_scoreA = $scoreA;
        $this->_scoreB = $scoreB;

        $expectedScores = $this -> _getExpectedScores($this -> _ratingA,$this -> _ratingB);
        $this->_expectedA = $expectedScores['a'];
        $this->_expectedB = $expectedScores['b'];

        $newRatings = $this ->_getNewRatings($this -> _ratingA, $this -> _ratingB, $this -> _expectedA, $this -> _expectedB, $this -> _scoreA, $this -> _scoreB);
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

        $newRatings = $this ->_getNewRatings($this -> _ratingA, $this -> _ratingB, $this -> _expectedA, $this -> _expectedB, $this -> _scoreA, $this -> _scoreB);
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
        $expectedScoreA = 1 / ( 1 + ( pow( 10 , ( $ratingB - $ratingA ) / 400 ) ) );
        $expectedScoreB = 1 / ( 1 + ( pow( 10 , ( $ratingA - $ratingB ) / 400 ) ) );

        return array (
            'a' => $expectedScoreA,
            'b' => $expectedScoreB
        );
    }

    protected function _getNewRatings($ratingA,$ratingB,$expectedA,$expectedB,$scoreA,$scoreB)
    {
        $newRatingA = $ratingA + ( self::KFACTOR * ( $scoreA - $expectedA ) );
        $newRatingB = $ratingB + ( self::KFACTOR * ( $scoreB - $expectedB ) );

        return array (
            'a' => $newRatingA,
            'b' => $newRatingB
        );
    }

}