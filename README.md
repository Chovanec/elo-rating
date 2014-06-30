#Elo Rating Class
A PHP class which implements the [Elo rating system](http://en.wikipedia.org/wiki/Elo_rating_system).

#Usage

    // player A elo = 1000
    // player B elo = 2000
    // player A lost
    // player B win
    $rating = new Rating(1000, 2000, 0, 1);

    // player A elo = 1000
    // player B elo = 2000
    // player A draw
    // player B draw
    $rating = new Rating(1000, 2000, .5, .5);
    
    $results = $rating->getNewRatings();
    
    echo "New rating for player A: " . $results['a'];
    echo "New rating for player B: " . $results['b'];
    
---------------------------------------
    
<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons Licence" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Elo Rating Class</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://pexat.com/" property="cc:attributionName" rel="cc:attributionURL">Priyesh Patel</a> and <a href="http://michalchovanec.com">Michal Chovanec</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>.
