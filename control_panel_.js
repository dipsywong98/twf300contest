//var key_dictionary=[
//    "hash":"代碼",
//    "mark_avg":"平均分",
//    "twf_name":"",
//    "ip":"",
//    ""

//]
function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
} 

function keyfilter(key){
    if(key.includes("mark_")) {
        var t =  scheme.filter(function(s){
            return s.name==key.substr(5);
        });
//        console.log(t);
        return t[0].text;
        }
    return key;
}

function contentfilter(key,value){
    if(key=="hash"||key=="voter_hash"){
        return value.substr(0,6);
    }
    if(key.includes("time")&&!key.includes("min")){
        if(value<1000) return "N/A";
       return format(value);
       }
    return value;
}

function format(timestamp) {
//    console.log(timestamp);
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
//    console.log(parent, _x);
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
            newTh(tr, "th", "sort", "平均分").setAttribute("data-sort", "mark_avg");
        }
        if(x==3&&type=="votes"){
            newTh(tr, "th", "sort", "平均分").setAttribute("data-sort", "mark_avg");
        }
        if (target.hasOwnProperty(k)) {
             newTh(tr, "th", "sort", keyfilter(k)).setAttribute("data-sort", k);
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
//                console.log(filtered);
                var sum_mark=0;
                for (var j=0;j<filtered.length;j++){
                    var avg_mark = 0;
                    for (var l = 0; l < scheme.length; l++) {
                        var mark = filtered[j]["mark_" + scheme[l].name];
                        avg_mark += Number(mark);
                    }
                    sum_mark+=avg_mark/scheme.length;
                }
                newTh(tr, "td", "mark_avg",String(sum_mark/filtered.length).substr(0,4));
            }
            if(x==3&&type=="votes"){
                var avg_mark = 0;
                for (var l = 0; l < scheme.length; l++) {
                    var mark = votes[i]["mark_" + scheme[l].name];
                    avg_mark += mark/scheme.length;
                }
                newTh(tr, "td", "mark_avg",String(avg_mark).substr(0,4));
                
            }
            if (target.hasOwnProperty(k)) {
                if(k.includes("comment")){
                    
                    var btn = newTh(tr,"td","mdl-button mdl-js-button mdl-js-ripple-effect mdl-shadow--2dp "+k,"view");
                    newTh(btn, "p", k, contentfilter(k,target[k])).style.display="none";
                    btn.addEventListener("click",function(){
                        dialog = document.querySelector('dialog');
                        if (! dialog.showModal) {
                          dialogPolyfill.registerDialog(dialog);
                        }
                        dialog.showModal();
                       $("#dialog-content")[0].innerHTML=this.childNodes[1].innerHTML; dialog.querySelector('.close').addEventListener('click', function() {
                          dialog.close();
                        });
                    })
                }
                else if(type=="submits"&&k.includes("hash")){
                    var td = newTh(tr, "td", k+" mdl-button mdl-js-button mdl-js-ripple-effect mdl-shadow--2dp",contentfilter(k,target[k]));
                    td.hash = target["hash"];
                    td.addEventListener("click",function(e){
                        post("vote/vote.php",{"hash":this.hash});
                    });
                }
                else if(type=="votes"&&k.includes("is_valid")){
                    var td = newTh(tr, "td", k+" mdl-button mdl-js-button mdl-js-ripple-effect mdl-shadow--2dp",contentfilter(k,target[k]));
                    td.hash = target["hash"];
                    td.voter_hash = target["voter_hash"];
                    td.addEventListener("click",function(e){
                        var td = this;
                        $.ajax({
                            url:'set_vote_valid.php',
                            type:'post',
                            data:'hash='+this.hash+'&voter_hash='+this.voter_hash,
                            cache: false,
                            success: function(result){
//                                alert(result);
//                                console.log(result);
                                if(result!=-1){
//                                    hihi = this;
                                    td.innerText = result;
                                }
                                else{
                                    alert('fail to set');
                                }
                            }
                        })
//                        post("set_vote_valid.php",{"hash":this.hash,"voter_hash":this.voter_hash});
                    });
                }
                else{
                    var td = newTh(tr, "td", k, contentfilter(k,target[k]));
                    
                    
                }
                 
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