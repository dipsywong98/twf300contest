<?php
require "includes/helper.php";

if(!isAdmin()){
    alert("not autherised!");
    redirect("index.php");
    die();
}

//$key_of_interest = ["hash","#","mark_"];

$no_vote_submit=[
    "no_admin"=>[],
    "no_public"=>[],
    "no_any"=>[]
];

$output = [];

$submits = $db->all("submits");
foreach($submits as $key=>&$submit){
    if($submit["foul"]!=0)continue;
     $submit = BuildSubmit($submit);
    $_submit = [];
    foreach($submit as $k=>$v){
        if(str_contain("hash foul twf_name",$k)||str_contain($k,"#")||str_contain($k,"m_")){
            $_submit[$k] = $v;
        }
    }
    array_push($output,$_submit);
}

PrintArray($output);


//=============functions=============

function BuildSubmit($submit){
    global $no_vote_submit;
    global $db;
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
    
    $public_votes = $db->selectParams("votes",["hash"=>$hash,"admin"=>0,"is_valid"=>1]);
    $admin_votes = $db->SelectParams("votes",["hash"=>$hash,"admin"=>1,"is_valid"=>1]);
    
    $submit["#all_vote"]=count($db->SelectParams("votes",["hash"=>$hash,"is_valid"=>1]));
    $submit["#public_vote"]=count($public_votes);
    $submit["#admin_vote"]=count($admin_votes);
    $public_marks = CalMark($public_votes);
    $admin_marks = CalMark($admin_votes);
    
    foreach($public_marks as $key=>$_){
        $submit["m_all_".$key]=($public_marks[$key]+$admin_marks[$key])/2;
        $submit["m_sum_".$key]=($public_marks[$key]*$submit["#public_vote"]+$admin_marks[$key]*$submit["#admin_vote"])/$submit["#all_vote"];
        $submit["m_public_".$key]=$public_marks[$key];
        $submit["m_admin_".$key]=$admin_marks[$key];
    }
    
    return $submit;
}

function VotesNumbersByTypes($hash){
    $db = $GLOBALS["db"];
    return [
        "any"=>count($db->SelectParams("votes",["hash"=>$hash,"is_valid"=>1])),
        "public"=>count($db->selectParams("votes",["hash"=>$hash,"admin"=>0,"is_valid"=>1])),
        "admin"=>count($db->SelectParams("votes",["hash"=>$hash,"admin"=>1,"is_valid"=>1]))
        ];
}

function PrintArray($array){
    echo json_encode($array, JSON_PRETTY_PRINT);
}

function CalMark($votes){
    $count = 0;
    $mark_gen = 0;
    $mark_ent = 0;
    $mark_tch = 0;
    $mark_ctv = 0;
    foreach($votes as $key=>$vote){
        $exp = $vote["mark_experience"];
        $art = $vote["mark_art"];
        $cnt = $vote["mark_content"];
        $tch = $vote["mark_tech"];
        $ctv = $vote["mark_creative"];
        $mark_gen += $exp+$art+$cnt+$tch+$ctv;
        $mark_ent += ($exp*4+$art+$cnt*3+$ctv*2)/10;
        $mark_tch += $tch;
        $mark_ctv += $ctv;
        $count++;
    }
    if($count==0) return [
        "general"=>"N/A",
        "entertain"=>"N/A",
        "tech"=>"N/A",
        "creative"=>"N/A"
    ];
    return [
        "general"=>$mark_gen/$count,
        "entertain"=>$mark_ent/$count,
        "tech"=>$mark_tch/$count,
        "creative"=>$mark_ctv/$count
    ];
}