<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="MainPageStyle.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>World Street Journal</title>
</head>

<body>
    
<header>
    <div id="Div-Header">
        <a class="Login" href="#">Subscribe for 0.50/week</a>

        <?php if (isset($_SESSION['email'])): ?>
            <div id="user-info">
                <span><?php echo htmlspecialchars($_SESSION['email']); ?></span>
            </div>

                <div>
                <form method="POST" action="../logout.php">
                    <button type="submit" id="Logout">Logout</button>
                </form>
            </div>
        <?php else: ?>
            <a class="Login" id="login" href="http://127.0.0.1/Projects/Login.php">Login</a>
        <?php endif; ?>

        <a id="title" href="site.php">World Street Journal</a>
        <div id="Date"></div>

        <script src="script.js" defer></script>
    </div>
</header>
<hr id="hr-first">


<nav>
    <div>
        <a class="navbar" href="#">World</a>
        <a class="navbar" href="#">Opinion</a>
        <a class="navbar" href="#">Business</a>
        <?php if (isset($_SESSION['email'])): ?>
            <a class="navbar" id="Books" href="BooksPage/_Books.php">Books</a>
        <?php else: ?>
            <a class="navbar" href="../Login.php" onclick="alert('Devi prima fare il login per accedere alla sezione Books.');">Books</a>
        <?php endif; ?>
    </div>

    <div class="hr-double"><hr>
        <hr></div>
    
    </nav>

    <script>
    <?php if (isset($_SESSION['email'])): ?>
        var userEmail = "<?php echo htmlspecialchars($_SESSION['email']); ?>";
    <?php else: ?>
        var userEmail = null;
    <?php endif; ?>
</script>


<main>
    
    <div id="Container-1">
     <div class="Div-1"><a href="#" id="header-1" class=""><h1></h1></a>
                       <p id="paragrafo">In 2020, Donald Trump convinced supporters that anything but in-person Election Day voting was untrustworthy.
                       After his loss, Republicans shifted their stance.
                       <div id="readMore">read more</div></p> 

                       <div id="paragraphs">
                       <p id="sottoParagrafo">President-elect Trump promised a 25 percent tariff on Canada and Mexico, and an additional 10 percent on China, 
                        blaming the flow of drugs and migrants.</p>
                    </div>

                    


     </div>

     <div id="IMG-1"><img src="Div-1/Trump.webp" data-category="politics" width="340" height="340" alt="Trump"><hr id="hr-4"></div>

      <div class="Div-2"> <h1>Bill Gates Privately Says He Has Backed Harris With $50 Million Donation</h1>
                          <p>Mr. Gates said in a statement to The Times that 
                          “this election is different,” reflecting a significant change in his political strategy.
                          Mr. Gates said in a statement to The Times that 
                          “this election is different,” reflecting a significant change in his political strategy.</p>
                          <img src="Aside/billgates.jpg" data-category="politics" width="520" height="360" alt="Bill Gates">
                          <hr>
       </div>
    </div><hr id="hr-1">
    
    <div id="mostRecentArticles"><h1>Most recent Articles</h1></div>
    <div id="articles-container">
        
    </div>

    
    <div id="Container-2">
                         <h2>Tech&AI</h2>
        <div class="Div-3"><h1>The A.I. Power Grab</h1>
             <p>Big tech companies say A.I. can help solve climate change, 
            even as it’s driving up their emissions and raising doubts about their climate goals.</p>
            <img src="Section2/Tech.webp" data-category="technology" width="560" height="360" alt="TECH POWER GRAB"><hr id="hr-3"> 
        </div>

        <div class="Div-4"><h1>Microsoft and OpenAI’s Close Partnership Shows Signs of Fraying</h1>
            <p>The “best bromance in tech” has had a reality check as OpenAI has tried to change its deal with Microsoft 
                and the software maker has tried to hedge its bet on the start-up.</p>
                <img src="Section3/AI.jpeg" data-category="technology" width="720" height="360" alt="AI partnership between Microsoft and OpenAI">
       </div>         
    </div> <hr>
    

    
    <h2 id="SportsCoverage">Sports coverage</h2>
    <div id="Container-3">
                         <div class="Div-5"><h3>Ranking 134 College Football Teams After a Weekend of Mayhem</h3>
                            <p>Notre Dame has jumped into the top five, and the changes don’t stop there.</p><hr>
                            <h3>How Saquon Barkley Flipped the N.F.L.’s Race for the M.V.P. Upside Down</h3>
                            <p>The star running back signed with the Eagles to rewrite his story. 
                            He has a lot of writing left to do, a columnist for The Athletic writes.</p><hr>
                            <h3>Conor McGregor Verdict Should Make Soccer Think Twice About Associating With Him</h3>
                            <p>The former MMA fighter was play-fighting on a Premier League pitch only last month, our columnist writes.</p>
                            
                        </div>

                         <img src="sport/sport.webp" data-category="sport" id="images" width="660" height="480" alt="Sport"><button id="button">></button>

                         <div class="Div-6"><h3>The End of the Cowboys-Commanders Game Left One Broadcaster ‘Speechless’</h3><hr>
                                            <h3>Why Some N.H.L. Fans Are Happily Paying $30 for Chicken Fingers</h3><hr>
                                            <h3>A Tennis Star’s Dream Season Carries a Large Asterisk</h3><hr id="hr-6">

                         </div>
    </div><hr id="hr-7">

    
    <div id="GamesContainer">
    <?php if (isset($_SESSION['email'])): ?>
        <a data-category="games" href="Games/RollDiceGame/RollDice.html">Roll Dices Game</a>
    <?php else: ?>
        <a data-category="games" href="../Login.php" onclick="alert('Devi prima fare il login');">Roll Dices Game</a>
        <?php endif; ?>
    </div>
</main>



<footer>
<div class="footer-container">
    <h1 class="Mainfooter"> <a href="site.php">World Street Journal</a></h1><hr>
    <nav><ul class="footer1"> 
         <li> <a href="#"> News </a></li>
         <li> <a href="#"> Arts </a></li>
         <li> <a href="#"> Lifestyle</a> </li>
         <li> <a href="#"> Reviews</a> </li>
         <li> <a href="#"> More </a></li></ul></nav>
</div>
</footer><hr>

<div class="afterfooter"> 
    <a href="#">copyright 2024 WSJ & CO</a>
</div>

</body>
</html>