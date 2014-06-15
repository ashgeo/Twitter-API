<?php
include "library/twitteroauth.php";
?>

<?php
// userToken Details 
$consumer          = "EiNX4EdODzSWcKGfZH4gV3KJl";
$consumersecret    = "DN6JTvt5PXYJnX8wsTMHzCo3Zj0VkQIs5CiITglqtkvcE8OyTJ";
$accesstoken       = "358733128-6v36imPKnPoPnyoePI6fxCO8ushCJJh4hJ5KHb4c";
$sccesstokensecret = "swRS0L6VI7PuZ05fZ5qvp9rFb8iEjs4b2SpnOyG57D98I";
$twitter           = new TwitterOAuth($consumer, $consumersecret, $accesstoken, $sccesstokensecret);
//perfomin isset function to check username
if (isset($_POST['keywords'])) {
    $keywords = $_POST['keywords'];//name
    $nbTweet  = $_POST['nbTweet'];//number of tweets needed
    if (empty($nbTweet)) {
        $nbTweet = 5;//default 5 tweets to show
    }
//API 1.1 version for tweets and count	
    $tweets = $twitter->get("https://api.twitter.com/1.1/search/tweets.json?q=" . $keywords . "&result_type=recent&count=" . $nbTweet);
}
?>
<!-- HTML Starts Here-->
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>
      Twitter 
    </title>
  </head>
  <body>
    <div id="resultant">
	<!-- Form for name and tweet count-->
      <form action="" method="post">
        <label>
          Name:
        </label>
        <input type="text" name="keywords"/>
        <br/>
        
        <label>
          Number of Twitts:
        </label>
        <input type="text" name="nbTweet"/>
        <br/>
        <input type="submit" name="ok"/>
      </form>
<div id="count">

<?php
//Finding Followers count , Following, name ,tweets count
	if (isset($_POST['keywords']))
	{
	$username  = $keywords;
	$users     = $twitter->get('https://api.twitter.com/1.1/users/show.json?screen_name=' . $username);
	$followers = $users->followers_count;
	$following = $users->friends_count;
	$uname     = $users->name;
	$twt_no    = $users->statuses_count;
	echo "Account Name:";
	echo $uname . "</br>";
	echo "Followers:";
	echo $followers . "</br>";
	echo "Following:";
	echo $following . "</br>";
	echo "No of Tweets:";
	echo $twt_no;
	}
?>
</div>
      <hr>
<?php
	if (isset($_POST['keywords']))://Checking isset
		foreach ($tweets->statuses as $tweet):
?>
     
     <p class="tweet">
        <?php
        echo "Followers ";//followers count of of the twitted person
        echo $tweet->user->followers_count . "<br/>";//followers count of of the twitted person
        echo "Name ";
        echo $tweet->user->name . "<br/>";//Name of of the twitted person
       ?>
   <img src="<?php echo $tweet->user->profile_image_url;?>"alt="user picture"/><!--profile photo of of the twitted person-->
    <span>
      <?php
        echo $tweet->text;
     ?>   
    </p>
    <?php
    endforeach;// end loop
		else:
    ?>
   
     <?php
		endif;
	?>
   </div>
  </body>
</html>