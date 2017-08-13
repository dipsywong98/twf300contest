$.getScript("../js/scheme.js");

function listener() {
    console.log(Math.random());
}

function showBtn(){
    
    btn = document.createElement("input");
    btn.type="submit";
    btn.name="submit";
    btn.value="submit";
    btn.textContent="遞交";
    btn.classList.add("mdl-button","mdl-js-button","mdl-button--raised","mdl-button--colored","mdl-js-ripple-effect");
    $('form')[0].appendChild(btn);
}

function now(){return Math.floor(Date.now() / 1000);}

function count(){
    window.setTimeout(function(){
        $("#text")[0].textContent = (start_time+time_min-now())+"秒後可以投票";
        if(now()<start_time+time_min){
            count();
        }else{
            $('#text')[0].parentElement.removeChild($('#text')[0]);
            showBtn();
        }
       },1000);
}

window.onload = function () {
    start_time = now();
    var target = $("#mark_items")[0];
    var descriptor = $("#descriptor")[0];

    var tr = document.createElement("tr");
    for (var i = 0; i < scheme.length; i++) {
        var td = document.createElement("td");
        td.innerHTML = scheme[i].text;
        
        tr.appendChild(td);
    }
    target.appendChild(tr);
    
    tr = document.createElement("tr");
    for (var i = 0; i < scheme.length; i++) {
        var td = document.createElement("td");
        var select = document.createElement("select");
        select.name = "mark_"+scheme[i].name;
        select.id = "mark_"+scheme[i].name;
        select.innerHTML = "<option selected disabled value=''>請評分</option>";
        for (var j = 5; j > 0; j--) {
            var option = document.createElement("option");
            var abbr = "";
            option.value = j;
            option.innerHTML = j;


            select.appendChild(option);
        }
        td.appendChild(select)
        tr.appendChild(td);
    }
    target.appendChild(tr);
    
    load();
    
    $("select").on("change",function(){
        var marks = $("select");
        var v=0;
        for(var i=0;i<marks.length;i++){
            var d=marks[i].value;
            if(d!=""){
                v=(v*i+Number(d))/(i+1);
            }
        }
        console.log(v);
        $("#avg")[0].innerHTML = v;
    });

    count();

    $('form').submit(function () {
        
        if($("select").length==0)return false;
        
        var msg="";
        
        for(var i=0;i<scheme.length;i++){
            if($("select")[i].value==''){
                msg+="請評"+scheme[i].text+"分\n";
            }
        }
        if(msg!=''){
            alert(msg);
            return false;
        }
        
    });
}
