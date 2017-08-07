function format(timestamp) {
    console.log(timestamp);
    var date = new Date(timestamp * 1000);
    var month = date.getMonth() + 1;
    var dat = date.getDate();
    var hours = date.getHours();
    var minutes = "0" + date.getMinutes();
    var seconds = "0" + date.getSeconds();
    return month + "月" + dat + "日 " + hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
}

function newElement(parent, element, class_list) {
    _x = document.createElement(element);
    if (class_list != "") {
        class_list = class_list.split(" ");
        for (var i = 0; i < class_list.length; i++) {
            _x.classList.add(class_list[i]);
        }
    }

    parent.appendChild(_x);
    console.log(parent, _x);
    return _x;
}

function newSquareCard(parent, title, text, url) {
    _c = newElement(parent, "div", "demo-card-square mdl-card mdl-shadow--2dp");
    var a = newElement(_c, "div", "mdl-card__title mdl-card--expand");
    a.style.backgroundImage = "url('" + url + "')";
    var h = newElement(a, "h2", "mdl-card__title-text");
    h.innerHTML = title;
    a = newElement(_c, "div", "mdl-card__supporting-text");
    a.innerHTML = text;
    a = newElement(_c, "div", "mdl-card__actions mdl-card--border");
    h = newElement(a, "a", "mdl-button mdl-button--colored mdl-js-ripple-effect mdl-js-button");
    h.innerHTML = "VIEW VOTES";
    return _c;
}

function newTh(parent, element, class_list, text) {
    _e = newElement(parent, element, class_list);
    _e.innerHTML = text;
    _e.sort = 0;
    if (element == "th")
        _e.addEventListener("click", function (e) {
            for (var i = 0; i < $("th").length; i++) {}
            this.sort = 1 - this.sort;
            if (this.sort == 0) {} else {}
        })
    return _e;
}

function newVoteTable(parent) {
    //search bar
    var form = newElement(parent,"form","");
    form.setAttribute("action","#");
    var div = newElement(form,"div","mdl-textfield mdl-js-textfield mdl-textfield--floating-label");
    var input = newElement(div,"input","mdl-textfield__input search");
    input.type="text";
    input.id="search"
    newTh(div,"label","mdl-textfield__label","搜尋").setAttribute("for","search");
    
    //generate table
    var table = newElement(parent, "table", "mdl-data-table mdl-js-data-table");

    //generate table head
    var thead = newElement(table, "thead", "");
    var tr = newElement(thead, "tr", "");
    newTh(tr, "th", "sort", "任務編號").setAttribute("data-sort", "hash");
    newTh(tr, "th", "sort", "投票人編號").setAttribute("data-sort", "voter_hash");
    newTh(tr, "th", "sort", "投票時間").setAttribute("data-sort", "vote_time");
    newTh(tr, "th", "sort", "投票地址").setAttribute("data-sort", "voter_ip");
    newTh(tr, "th", "sort", "平均分").setAttribute("data-sort", "mark_avg");
    for (var i = 0; i < scheme.length; i++) {
        newTh(tr, "th", "sort", scheme[i]["text"]).setAttribute("data-sort", "mark_" + scheme[i]["name"]);
    }
    newTh(tr, "th", "sort", "官方評審").setAttribute("data-sort", "admin");
    newTh(tr, "th", "sort", "評語");

    //generate table body
    var tbody = newElement(table, "tbody", "list");
    for (var j = 0; j < votes.length; j++) {
        tr = newElement(tbody, "tr", "");
       newTh(tr, "td", "hash", votes[j]["hash"]);
        newTh(tr, "td", "voter_hash", votes[j]["voter_hash"]);
        newTh(tr, "td", "vote_time", votes[j]["vote_time"]).textContent=format(votes[j]["vote_time"]);
        newTh(tr, "td", "voter_ip", votes[j]["voter_ip"]);
        var avg_mark = 0;
        var avg_td = newElement(tr, "td", "mark_avg");
        for (var i = 0; i < scheme.length; i++) {
            var mark = votes[j]["mark_" + scheme[i].name];
            newTh(tr, "td", "mark_" + scheme[i].name, mark);
            avg_mark += mark;
        }
        avg_td.textContent = avg_mark / scheme.length;
        
        newTh(tr, "td", "admin", votes[j]["admin"]);
        newTh(tr, "td", "comment", votes[j]["comment"]);
    }

        
    var options = {
            valueNames: ['hash','voter_hash','vote_time', 'voter_ip','mark_avg', 'mark_experience', 'mark_balance', 'mark_art', 'mark_content', 'mark_tech', 'mark_story', 'mark_creative', 'comment']
        },
        documentTable = new List(parent, options);
    
    return table;
}


function newUserTable(parent) {
    //search bar
    var form = newElement(parent,"form","");
    form.setAttribute("action","#");
    var div = newElement(form,"div","mdl-textfield mdl-js-textfield mdl-textfield--floating-label");
    var input = newElement(div,"input","mdl-textfield__input search");
    input.type="text";
    input.id="search"
    newTh(div,"label","mdl-textfield__label","搜尋").setAttribute("for","search");
    
    //generate table
    var table = newElement(parent, "table", "mdl-data-table mdl-js-data-table");

    //generate table head
    var thead = newElement(table, "thead", "");
    var tr = newElement(thead, "tr", "");
    newTh(tr, "th", "sort", "用戶編號").setAttribute("data-sort", "hash");
    newTh(tr, "th", "sort", "用戶帳號").setAttribute("data-sort", "username");
    newTh(tr, "th", "sort", "用戶地址").setAttribute("data-sort", "ip");
    newTh(tr, "th", "sort", "用戶種類").setAttribute("data-sort", "mark_avg");
    for (var i = 0; i < scheme.length; i++) {
        newTh(tr, "th", "sort", scheme[i]["text"]).setAttribute("data-sort", "mark_" + scheme[i]["name"]);
    }
    newTh(tr, "th", "sort", "評語");

    //generate table body
    var tbody = newElement(table, "tbody", "list");
    for (var j = 0; j < votes.length; j++) {
        tr = newElement(tbody, "tr", "");
       newTh(tr, "td", "hash", votes[j]["hash"]);
        newTh(tr, "td", "voter_hash", votes[j]["voter_hash"]);
        newTh(tr, "td", "vote_time", votes[j]["vote_time"]).textContent=format(votes[j]["vote_time"]);
        newTh(tr, "td", "voter_ip", votes[j]["voter_ip"]);
        var avg_mark = 0;
        var avg_td = newElement(tr, "td", "mark_avg");
        for (var i = 0; i < scheme.length; i++) {
            var mark = votes[j]["mark_" + scheme[i].name];
            newTh(tr, "td", "mark_" + scheme[i].name, mark);
            avg_mark += mark;
        }
        avg_td.textContent = avg_mark / scheme.length;
        newTh(tr, "td", "comment", votes[j]["comment"]);
    }

        
    var options = {
            valueNames: ['hash','voter_hash','vote_time', 'voter_ip','mark_avg', 'mark_experience', 'mark_balance', 'mark_art', 'mark_content', 'mark_tech', 'mark_story', 'mark_creative', 'comment']
        },
        documentTable = new List(parent, options);
    
    return table;
}

function newTable(parent,listArray,type){
     //search bar
    var form = newElement(parent,"form","");
    form.setAttribute("action","#");
    var div = newElement(form,"div","mdl-textfield mdl-js-textfield mdl-textfield--floating-label");
    var input = newElement(div,"input","mdl-textfield__input search");
    input.type="text";
    input.id="search"
    newTh(div,"label","mdl-textfield__label","搜尋").setAttribute("for","search");
    
    var tag=[];
    
     //generate table
    var table = newElement(parent, "table", "mdl-data-table mdl-js-data-table");

    //generate table head
    var thead = newElement(table, "thead", "");
    var tr = newElement(thead, "tr", "");
    target=listArray[0];
    var x = 0;
    for (var k in target){
        if(Number.isInteger(Number(k)))continue;
        if(x==1&&type=="submits"){
            newTh(tr, "th", "sort", "mark_avg").setAttribute("data-sort", "mark_avg");
        }
        if(x==3&&type=="votes"){
            newTh(tr, "th", "sort", "mark_avg").setAttribute("data-sort", "mark_avg");
        }
        if (target.hasOwnProperty(k)) {
             newTh(tr, "th", "sort", k).setAttribute("data-sort", k);
            tag.push(k);
        }
        x++;
    }
    
    var tbody = newElement(table, "tbody", "list");
    for (var i=0; i<listArray.length; i++){
        tr = newElement(tbody, "tr", "");
        target=listArray[i];
        x=0;
        for (var k in target){
            if(Number.isInteger(Number(k)))continue;
            if(x==1&&type=="submits"){
                var filtered = votes.filter(function(vote) { 
                    return vote.hash == target.hash; 
                });
                var sum_mark=0;
                for (var j=0;j<filtered.length;j++){
                    var avg_mark = 0;
                    for (var l = 0; l < scheme.length; l++) {
                        var mark = votes[j]["mark_" + scheme[l].name];
                        avg_mark += mark;
                    }
                    sum_mark+=avg_mark/scheme.length;
                }
                newTh(tr, "th", "mark_avg",sum_mark/filtered.length);
            }
            if(x==3&&type=="votes"){
                var avg_mark = 0;
                for (var l = 0; l < scheme.length; l++) {
                    var mark = votes[i]["mark_" + scheme[l].name];
                    avg_mark += mark/scheme.length;
                }
                newTh(tr, "th", "mark_avg",avg_mark);
                
            }
            if (target.hasOwnProperty(k)) {
                 newTh(tr, "td", k, target[k]);
            }
                x++;
        }
    }
    
    if(type=="submits"||type=="votes"){
        tag.push("mark_avg");
    }
    
    var options = {valueNames: tag},
        documentTable = new List(parent, options);
    
    return table;
}