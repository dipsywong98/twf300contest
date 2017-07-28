scheme = [
    {
        "name":"experience",
        "text":"體驗",
        "description":[
            "整個過程都感覺有趣，充滿想再玩一次的感覺",
            "遊玩中途有時會略嫌沉悶，但整體上都挺有趣",
            "遊戲沉悶，令人想中途離開"
        ]
    },
    {
        "name":"balance",
        "text":"平衡",
        "description":[
            "富有挑戰性，但又不會太難；商店定價合理；沒有逆天、圍毆",
            "頗有挑戰性；商店定價尚可；時有逆天、圍毆",
            "毫無挑戰性，太易/太難；商店定價荒謬"
        ]
    },
    {
        "name":"art",
        "text":"美術",
        "description":[
            "封面圖片製作精美，具吸引力。\n特效、音效應用得宜，選角得當，成功塑造氣氛;\n文字排版得宜,讓人讀起來感到舒服。",
            "特效運用得宜，任務有相對氣氛；\n部分特效設定太多/太少。",
            "沒有相應的特效：使用特效時機不合時宜。"
        ]
    },
    {
        "name":"content",
        "text":"內容",
        "description":[
            "內容不會太多，也不會太少。遊戲用時適中",
            "有一定內容，但內容可能過長/過短",
            "內容冗長乏味/欠缺"
        ]
    },
    {
        "name":"tech",
        "text":"技術",
        "description":[
            "能運用複雜或不是人人都懂的技術，可能是特效或變數，善用省容量技巧，沒有致命性的bug；任務流暢，玩起來不會卡等。",
            "能合理設定事件，如為事件命名或貼上適當標籤檢查運用得宜；事件之間沒有邏輯錯誤，有不錯的技術運用",
            "常常有邏輯錯誤，充滿令人煩厭的BUG，事件安排雜亂無章，令人難以理解，沒有運用不同的技術"
        ]
    },
    {
        "name":"story",
        "text":"劇情",
        "description":[
            "劇情符合邏輯，生動有趣，令人想追看下去",
            "劇情尚符合邏輯，頗有趣味，但有些許平凡",
            "劇情毫無邏輯，令人乏味，且為抄襲，或老掉牙內容"
        ]
    },
    {
        "name":"creative",
        "text":"創意",
        "description":[
            "能運用現有的動作/設定創作出同人陣上未出過的東西/新功能；令任務更富新鮮感，而且創意亦能合理融合在任務中。",
            "能運用同人陣現有的想法，並加入自己的創意和調整。",
            "只是運用同人陣現有的想法，並沒有加入個人創意"
        ]
    },
]

function listener(){
    console.log(Math.random());
}

window.onload = function(){
    
    var target = $("#mark_items")[0];
    var descriptor = $("#descriptor")[0];
    
    for(var i=0; i<scheme.length;i++){
        var select = document.createElement("select");
        select.name = scheme[i].name;
        select.innerHTML = "<option selected disabled>"+scheme[i].text+"</option>";
        for (var j=5; j>0;j--){
            var option = document.createElement("option");
            var abbr="";
            option.value = j;
            option.innerHTML = j;
            
            
            select.appendChild(option);
        }
        target.appendChild(select);
    }
}