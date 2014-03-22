<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UWA UHunt</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <!-- Theme overloading -->
    <link rel="stylesheet" href="css/bootstrap.theme.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="panel panel-default" style="width:60%; min-width: 600px; margin-left:auto; margin-right:auto">
      <h1 style="padding:1em">UWA Competitive Programming Standings</h1>
    <!-- Default panel contents -->
      <div class="panel-heading">Standings Table</div>
      <div class="panel-body">
        <h3>Instructions</h3>
        <p>This is the internal leaderboard for UWA. It should make UHunt problem solving more competitive, and more fun! 
          If you want to see your name up here you need to post a request on the ICPC forum, and we will add you right away.
          This is more for fun than for competition, so try not to take it too seriously. The scores are updated automatically every hour, so be patient when beating all your friends.</p>

        <p>
          Remember that you need to log into UHunt to update your UHunt account after solving UVa problems. Think of this table as a UWA specific extension of UHunt.
        </p>

        <p><a href="http://uhunt.felix-halim.net/">Go to UHunt</a></p>
      </div>

      <!-- Table -->
      <table class="table table-striped table-hover ">
        <thead>
          <th>Rank</th><th>Competitor</th><th> Solutions</th><th>Last Solution</th>
        </thead>
        <tbody>
          <?php
            // get me one whole database please
            require_once "database.php";
            $db = getDBLink();


            // get dem ppls. Ordered by number of solutions, tie breaker is age of last solution. Newbies should be below oldies.
            $peoples = $db->query("SELECT u.*, COUNT(s.problemid) as count, MAX(s.datesolved) as lastacc FROM solutions s, users u 
              WHERE u.uhuntid = s.uhuntid GROUP BY u.uhuntid ORDER BY count DESC, lastacc ASC, u.uhuntid");

            // my awesome padding and ranking hacks
            $rank = 1;
            $pad = 2.5;
            while($person = $peoples->fetch_object()) {

              // hax
              $pad -= 0.5;
              if ($pad < 0.0)
                $pad = 0.0;

              // more padding hax
              $pt = $pad.'em';
              $pt = "style='padding-top:$pt; padding-bottom:$pt'";


              echo "<tr><td $pt >$rank</td><td $pt>$person->name</td><td $pt>$person->count</td>
                <td $pt>$person->lastacc</td></tr>";

              $rank += 1;
            }
          ?>
        </tbody>
      </table>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  </body>
</html>