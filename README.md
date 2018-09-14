# Elo Rating PHP
A PHP class which implements the [Elo rating system](http://en.wikipedia.org/wiki/Elo_rating_system).

# Install with composer

`composer require chovanec/elo-rating dev-master`

Link to Packagist.org: https://packagist.org/packages/chovanec/elo-rating

# Usage

    require 'src/Rating/Rating.php';

    // player A elo = 1000
    // player B elo = 2000
    // player A lost
    // player B win
    
    $rating = new Rating(1000, 2000, Rating::LOST, Rating::WIN);

    // player A elo = 1000
    // player B elo = 2000
    // player A draw
    // player B draw
    
    $rating = new Rating(1000, 2000, Rating::DRAW, Rating::DRAW);
    
    $results = $rating->getNewRatings();
    
    echo "New rating for player A: " . $results['a'];
    echo "New rating for player B: " . $results['b'];
    
---------------------------------------

# Credits
    
<a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/80x15.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Elo Rating PHP</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://michalchovanec.com" property="cc:attributionName" rel="cc:attributionURL">Michal Chovanec</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.
