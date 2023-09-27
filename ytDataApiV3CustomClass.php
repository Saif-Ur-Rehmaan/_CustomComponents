<?php

class YoutubeDataApiV3
{
    private $ApiKey, $VideoId, $NextpageToken, $CommentObject;
    function __construct(string $ApiKey, string $url)
    {
        $this->ApiKey = $ApiKey;

        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $queryParameters);
        $VideoId = (isset($queryParameters['v'])) ? $queryParameters['v'] : "Video ID not found in the URL.";

        $this->VideoId = $VideoId;
    }
    //comment section start
    function GetFirstArrayOfVideoComments()
    {

        $url = 'https://www.googleapis.com/youtube/v3/commentThreads?key=' . $this->ApiKey . '&videoId=' . $this->VideoId . '&part=snippet';
        $response = file_get_contents($url);
        $commentArray = json_decode($response, true);
        $comments = [];
        $NextpageToken = $commentArray["nextPageToken"];

        $this->NextpageToken = $commentArray["nextPageToken"];

        array_push($comments, $NextpageToken);

        foreach ($commentArray['items'] as $key => $comment) {
            array_push($comments, [
                'id' => $comment['id'],
                "videoId" => $comment['snippet']['videoId'],
                'topLevelComment' => $comment['snippet']['topLevelComment']['snippet'] //this array contain full detail of the person who commented this comment 
            ]);
        }
        $this->CommentObject = $comment;
        return $comments;
    }
    function ShowCommentObject()
    {
        if ($this->CommentObject != null) {

            print_r($this->CommentObject);
        } else {
            return "first use 'GetFirstArrayOfVideoComments()' method";
        }
    }
    function GetNextArrayOfComment()
    {
        if ($this->NextpageToken != null) {
            $url = 'https://www.googleapis.com/youtube/v3/commentThreads?key=' . $this->ApiKey . '&videoId=' . $this->VideoId . '&part=snippet&pageToken=' . $this->NextpageToken;
            $response = file_get_contents($url);
            $commentArray = json_decode($response, true);
            $comments = [];
            $NextpageToken = $commentArray["nextPageToken"];

            $this->NextpageToken = $commentArray["nextPageToken"];

            array_push($comments, $NextpageToken);

            foreach ($commentArray['items'] as $key => $comment) {
                array_push($comments, [
                    'id' => $comment['id'],
                    "videoId" => $comment['snippet']['videoId'],
                    'topLevelComment' => $comment['snippet']['topLevelComment']['snippet'] //this array contain full detail of the person who commented this comment 
                ]);
            }
            return $comments;
        }
        return "first use 'GetFirstArrayOfVideoComments()' method inside 'class Comment{}' function";
    }
    //comment section end

    //video section start
    function GetLikesAndDislikesOfVideo()
    {
        $requestUrl = "https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" . $this->VideoId . "&key=" . $this->ApiKey;

        $response = file_get_contents($requestUrl);
        $data = json_decode($response, true);

        if (isset($data['items'][0]['statistics'])) {
            $likesCount = $data['items'][0]['statistics']['likeCount'];
            $dislikesCount = isset($data['items'][0]['statistics']['dislikeCount']) ? $data['items'][0]['statistics']['dislikeCount'] : 0;

            return ['likes' => $likesCount, 'Dislikes' => $dislikesCount];
        } else {
            return "Video details not found.";
        }
    }


    //video section end

    //channel details start
    function GetChannelName()
    {
        $requestUrl = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=" . $this->VideoId . "&key=" . $this->ApiKey;

        $response = file_get_contents($requestUrl);
        $data = json_decode($response, true);

        if (isset($data['items'][0]['snippet']['channelTitle'])) {
            $channelName = $data['items'][0]['snippet']['channelTitle'];
            return $channelName;
        } else {
            return "Channel details not found.";
        }
    }

    function GetChannelProfilePicture()
    {
        $requestUrl = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=" . $this->VideoId . "&key=" . $this->ApiKey;

        $response = file_get_contents($requestUrl);
        $data = json_decode($response, true);

        if (isset($data['items'][0]['snippet']['channelId'])) {
            $channelId = $data['items'][0]['snippet']['channelId'];
            $requestUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&id=" . $channelId . "&key=" . $this->ApiKey;

            $response = file_get_contents($requestUrl);
            $channelData = json_decode($response, true);

            if (isset($channelData['items'][0]['snippet']['thumbnails']['default']['url'])) {
                $channelProfilePicture = $channelData['items'][0]['snippet']['thumbnails']['default']['url'];
                return $channelProfilePicture;
            } else {
                return "Channel profile picture not found.";
            }
        } else {
            return "Channel details not found.";
        }
    }
    //channel details end
}


{//example just paste this code in your php file and correct "include"
/*
<main>
    <!-- <h1>YOUTUBE DATA :</h1> -->


    <?php include 'Class.php'; ?>//include ytdataapiv3customclass

<h1>every thing fetched by using any single video of channel</h1>





    <!-- declaring api key and url and creating object -->
    <?php

    $ApiKey = 'AIzaSyAGHAst0tR5AL3IzZ49uYzI-s0QR2zdyhw';
    $url = 'https://www.youtube.com/watch?v=elVYeTyjw7Y';
    $YouTubeObject = new YoutubeDataApiV3($ApiKey, $url);

    ?>



    <!-- fetching Channel pic of channel of video $url -->
    <h1>Channel Pic: </h1><?php
    // custom class
    $ChannelPic=$YouTubeObject->GetChannelProfilePicture();
    ?>
    <img src="<?php echo $ChannelPic ?>" alt="">
    
    
    <h1>Channel Name: </h1>
    <!-- fetching Channel name of channel of video $url -->
    <?php
    $ChannelName=$YouTubeObject->GetChannelName();
    echo $ChannelName;
    ?>





    <!-- fetching likes of $url -->
    <h1>Likes: </h1>
    <?php
    $likes = $YouTubeObject->GetLikesAndDislikesOfVideo();
    echo $likes['likes'];
    ?>

    <h1>DisLikes: </h1>
    <?php
    echo $likes['Dislikes'];
    ?>






    <!-- fetching comments of $url-->
    <?php
    $comments = $YouTubeObject->GetFirstArrayOfVideoComments();
    ?>
    <h1>Comment fetched :</h1>

    <?php
    for ($i = 0; $i < count($comments); $i++) {
        $comment = $comments[$i];
        if (is_array($comment)) {
    ?>
            <p>image: <img src="<?php echo $comment['topLevelComment']['authorProfileImageUrl'] ?>" alt=""></p>
            <p>Name : <?php echo $comment['topLevelComment']['authorDisplayName'] ?></p>
            <p>Comment : <?php echo $comment['topLevelComment']['textDisplay'] ?></p>
            <p>likes on this comment : <?php echo $comment['topLevelComment']['likeCount'] ?></p> <br>
            <p> comment published on : <?php echo $comment['topLevelComment']['publishedAt'] ?></p>
            <h1>____________________________________________________________</h1>
    <?php }
    } ?>


    <?php
    //$YouTubeObject here is the variable in which 'new Comment()' is declared
    // to get next arry of comments.  run '$YouTubeObject->GetFirstArrayOfVideoComments()' then run '$YouTubeObject->GetNextArrayOfComment()'
    ?>

















</main>
*/
}




?>