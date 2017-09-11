<?php
require "includes/helper.php";

if(!isAdmin()){
    alert("not autherised!");
    redirect("index.php");
    die();
}

$no_vote_submit=[
    "no_admin"=>[],
    "no_public"=>[],
    "no_any"=>[]
];

$submits = $db->all("submits");
foreach($submits as $key=>$submit){
     BuildSubmit($submit);
}

echo json_encode($no_vote_submit, JSON_PRETTY_PRINT).'<br>';

function BuildSubmit($submit){
    global $no_vote_submit;
    $hash = $submit["hash"];
    $voteNumbers = VotesNumbersByTypes($hash);
    if($voteNumbers["public"]==0){
        array_push($no_vote_submit["no_public"],$hash);
    }
    if($voteNumbers["admin"]==0){
        array_push($no_vote_submit["no_admin"],$hash);
    }
    if($voteNumbers["any"]==0){
        array_push($no_vote_submit["no_any"],$hash);
    }
    
//    $votes = $db->SelectParams("votes",[
//        "hash"=>$hash,
//        "valid"=>1
//    ]);
//    
//    $marks = CalculateMarks($votes);
}

function VotesNumbersByTypes($hash){
    $db = $GLOBALS["db"];
    return [
        "public"=>count($db->selectParams("votes",["hash"=>$hash,"admin"=>0,"is_valid"=>1])),
        "admin"=>count($db->SelectParams("votes",["hash"=>$hash,"admin"=>1,"is_valid"=>1])),
        "any"=>count($db->SelectParams("votes",["hash"=>$hash,"is_valid"=>1]))
        ];
}