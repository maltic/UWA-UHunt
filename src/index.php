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
      <ul class="nav nav-tabs">
        <li class="active"><a href="#standings" data-toggle="tab">Standings Table</a></li>
        <li><a href="#instructions" data-toggle="tab">Instructions</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active fade in" id="standings">
          <table id="results_table" class="table table-striped table-hover tablesorter ">
            <thead>
              <tr><th>Competitor</th><th>Solved This Week</th><th>Solved All Time</th><th>Last Solution</th></tr>
            </thead>
            <tbody>
              <?php
                // get me one whole database please
                require_once "database.php";
                $db = getDBLink();

                // get dem ppls. Ordered by number of solutions, tie breaker is age of last solution. Newbies should be below oldies.
                $peoples = $db->query("SELECT u.*, COUNT(s.problemid) as count, MAX(s.datesolved) as lastacc,
                    COUNT(CASE WHEN s.datesolved >= date_sub(NOW(), INTERVAL 1 WEEK) THEN s.problemid END) as weekly_count
                    FROM solutions s, users u WHERE u.uhuntid = s.uhuntid GROUP BY u.uhuntid");

                while($person = $peoples->fetch_object()) {
                  echo "<tr><td>$person->name</td><td>$person->weekly_count</td><td>$person->count</td>
                    <td><abbr class=\"timeago\" title=\"$person->lastacc\">$person->lastacc</abbr></td></tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="instructions">
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
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.13.3/jquery.tablesorter.min.js
"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.3.1/jquery.timeago.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#results_table").tablesorter( {sortList: [[1, 1], [2, 1], [3, 1], [0, 0]]} );
        $("abbr.timeago").timeago();
        $('#standings a').click(function (e) {
          e.preventDefault()
          $(this).tab('show')
        });
        $('#instructions a').click(function (e) {
          e.preventDefault()
          $(this).tab('show')
        });
      });
    </script>
  </body>
</html>
