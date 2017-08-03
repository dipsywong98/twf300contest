//$.getScript("sortable.min.js");
//$.getScript("scheme.min.js");
//$.getScript("list.min.js);
//Sortable.init();
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

function newVoteTable(parent, votes, missions) {
    //generate table
    var table = newElement(parent, "table", "mdl-data-table mdl-js-data-table");
    //    Sortable.initTable(table);
    //    table.setAttribute("data-sortable","true");

    //generate table head
    var thead = newElement(table, "thead", "");
    var tr = newElement(thead, "tr", "");
    if (missions != "") newTh(tr, "th", "sort", "任務名稱").setAttribute("data-sort", "twf_name");
    newTh(tr, "th", "sort", "投票時間").setAttribute("data-sort", "vote_time");
    newTh(tr, "th", "sort", "平均分").setAttribute("data-sort", "mark_avg");
    for (var i = 0; i < scheme.length; i++) {
        newTh(tr, "th", "sort", scheme[i]["text"]).setAttribute("data-sort", "mark_" + scheme[i]["name"]);
    }
    newTh(tr, "th", "sort", "評語");

    //generate table body
    var tbody = newElement(table, "tbody", "list");
    for (var j = 0; j < votes.length; j++) {
        tr = newElement(tbody, "tr", "");
        if (missions != "") newTh(tr, "td", "twf_name", missions[j]["twf_name"]);
        newTh(tr, "td", "vote_time", votes[j]["vote_time"]);
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
            valueNames: ['vote_time', 'mark_avg', 'mark_experience', 'mark_balance', 'mark_art', 'mark_content', 'mark_tech', 'mark_story', 'mark_creative']
        },
        documentTable = new List(table, options);
$($('th.sort')[0]).trigger('click', function() {
            console.log('clicked');
        });
    return table;
}
