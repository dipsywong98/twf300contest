<div style="align:center;">
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
        <div class="mdl-tabs__tab-bar">
            <a href="#tab1-panel" class="mdl-tabs__tab is-active">我的作品</a>
            <a href="#tab2-panel" class="mdl-tabs__tab">我的投票</a>
        </div>
        <div class="mdl-tabs__panel is-active" id="tab1-panel">
            <div class="section">
                <div class="section-text mdl-shadow--8dp" id="lol">
                    <h2>
                        <?php echo $submit["twf_name"];?>
                    </h2>
                    <img width="300px" src="../uploads/<?php echo $_hash;?>/<?php echo $_hash;?>.<?php echo $submit['photo_type'];?>"/>
                    <p>最短遊玩時間：
                        <?php echo $submit["time_min"];?>
                    </p>
                    <button onclick="Download()" class="mdl-button mdl-button-colored mdl-js-button mdl-button--raised mdl-js-ripple-effect">下載已遞交的TWF檔</button>
                    <script>
                        newVoteTable($("#lol")[0], recieves, "")

                    </script>
                </div>

            </div>
        </div>
        <div class="mdl-tabs__panel" id="tab2-panel">
            <div class="section">
                <div class="section-text mdl-shadow--8dp" id="xd">
                    <script>
                        newVoteTable($("#xd")[0], votes, missions)

                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
