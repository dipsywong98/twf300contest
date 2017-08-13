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
                        你尚未遞交作品
                    </h2>
                    <a class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" href="../submit">前往遞交</a>
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
