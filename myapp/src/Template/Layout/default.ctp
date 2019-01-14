<?php
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> -->
  <title>
    <?= $cakeDescription ?>:
    <?= $this->fetch('title') ?>
  </title>
  <?= $this->Html->meta('icon') ?>
  <?= $this->Html->script('jquery-3.1.0.min.js') ?>
  <?= $this->Html->script('materialize.min.js') ?>
  <?= $this->Html->script('map.js') ?>
  <?= $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDgd-t3Wa40gScJKC3ZH3ithzuUUapElu4") ?>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <?= $this->Html->css('materialize.css') ?>
  <?= $this->Html->css('okiyoru.css') ?>

  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
  <?= $this->Html->scriptstart() ?>
  $(document).ready(function(){
  googlemap_init('google_map', '沖縄県浦添市屋富祖３丁目１５');
});
<?= $this->Html->scriptend() ?>
<body>
  <ul id="slide-out" class="side-nav">
    <li>
      <div class="user-view">
        <div class="background">
          <img src="http://192.168.33.10/img/common/top/top1.jpg">
        </div>
        <a href="#!user"><img class="circle" src="http://192.168.33.10/img/common/top/top1.jpg"></a>
        <a href="#!name"><span class="white-text name">John Doe</span></a>
        <a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
      </div>
    </li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">info_outline</i>新着情報</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">event_available</i>特集</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">trending_up</i>ランキング</a></li>
    <li><a class="waves-effect" href="http://okiyoru.local"><i class="material-icons">vertical_align_top</i>トップページ</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">cloud</i>facebook</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">help_outline</i>よくある質問</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">contact_mail</i>お問い合わせ</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">note</i>プライバシーポリシー</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">note</i>ご利用規約</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">star_half</i>店舗の掲載をご希望の方</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">vpn_key</i>店舗ログイン</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Subheader</a></li>
    <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
  </ul>
  <nav>
    <div class="nav-wrapper">
      <a href="#" data-activates="slide-out" class="button-collapse oki-button-collapse"><i class="material-icons">menu</i></a>
      <a href="#!" class="brand-logo oki-brand-logo">OKIYORU Go</a>
      <ul class="right">
        <li><a data-target="modal-search" class="modal-trigger"><i class="material-icons">search</i></a></li>
        <li><a data-target="modal-login" class="modal-trigger"><i class="material-icons">vpn_key</i></a></li>
      </ul>
    </div>
  </nav>
  <!-- 検索モーダル -->
  <div id="modal-search" class="modal">
    <div class="modal-content">
      <h4>Modal Header</h4>
      <p>A bunch of text</p>
      <div class="search-box">
        <div class="row">
          <li class="search col s12 l12">
            <div class="input-field oki-input-field">
              <input placeholder="キーワード" id="modal-key-word" type="text" class="validate input-search">
            </div>
          </li>
          <li class="search col s6 l6">
            <div class="input-field oki-input-field">
              <select>
                <option value="" disabled selected>エリア</option>
                <option value="naha">那覇</option>
                <option value="miyakojima">宮古島</option>
                <option value="ishigakijima">石垣島</option>
                <option value="tomigusuku">豊見城</option>
                <option value="nanjo">南城</option>
                <option value="itoman">糸満</option>
                <option value="urasoe">浦添</option>
                <option value="ginowan">宜野湾</option>
                <option value="okinawashi">沖縄市</option>
                <option value="uruma">うるま</option>
                <option value="nago">名護</option>
              </select>
            </div>
          </li>
          <li class="search col s6 l6">
            <div class="input-field oki-input-field">
              <select>
                <option value="" disabled selected>ジャンル</option>
                <option value="cabacula">キャバクラ</option>
                <option value="girlsbar">ガールズバー</option>
                <option value="snack">スナック</option>
                <option value="club">クラブ</option>
                <option value="lounge">ラウンジ</option>
                <option value="pub">パブ</option>
                <option value="bar">バー</option>
              </select>
            </div>
          </li>
          <li class="search col s12 l12">
            <a class="waves-effect waves-light btn-large"><i class="material-icons right">search</i>検索</a>
          </li>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">閉じる</a>
    </div>
  </div>
  <!-- ログインモーダル -->
  <div id="modal-login" class="modal">
    <div class="modal-content">
      <h4>Modal Header</h4>
      <p>A bunch of text</p>
      <div class="search-box">
        <div class="row">
          <li class="search col s12 l12">
            <div class="input-field oki-input-field">
              <input id="email" type="email" class="validate">
              <label for="email">Email</label>
            </div>
          </li>
          <li class="search col s12 l12">
            <div class="input-field oki-input-field">
              <input id="password" type="password" class="validate">
              <label for="password">Password</label>
            </div>
          </li>
          <li class="search col s12 l12">
            <button class="modal-login btn waves-effect waves-light" type="submit" name="action">ログイン
              <i class="material-icons right">send</i>
            </button>
          </li>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">閉じる</a>
    </div>
  </div>

  <?= $this->fetch('content') ?>
  <div class="container row">
    <h1>位置情報取得サンプル</h1>
    <button onclick="getPosition();">位置情報を取得する</button>
    <div style="width:100%;height:300px;" id="google_map"></div>
  </div>
  <footer class="page-footer">
    <div class="container row">
      <div class="col s12 l6">
        <h5 class="white-text">Links</h5>
        <ul class="collection">
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="#!"><i class="material-icons">info_outline</i>新着情報</a></li>
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="#!"><i class="material-icons">event_available</i>特集</a></li>
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="#!"><i class="material-icons">trending_up</i>ランキング</a></li>
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="/"><i class="material-icons">vertical_align_top</i>トップページ</a></li>
        </ul>
      </div>
      <div class="col s12 l6">
        <h5 class="white-text">Links</h5>
        <ul class="collection">
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="#!"><i class="material-icons">cloud</i>facebook</a></li>
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="#!"><i class="material-icons">help_outline</i>よくある質問</a></li>
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="/pages/contract"><i class="material-icons">contact_mail</i>お問い合わせ</a></li>
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="/pages/privacy_policy"><i class="material-icons">note</i>プライバシーポリシー</a></li>
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="/pages/contract"><i class="material-icons">note</i>ご利用規約</a></li>
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="/pages/membership_join"><i class="material-icons">star_half</i>店舗の掲載をご希望の方</a></li>
          <li><a class="grey-text link-box text-lighten-3 collection-item" href="/owner"><i class="material-icons">vpn_key</i>店舗ログイン</a></li>
        </ul>
      </div>
      <div class="col s12">
        <span class="grey-text text-lighten-3">【おきよる】では、県内特化型ポータルサイトとして、沖縄全域のナイト情報を提供しております。(※ソープ、デリヘル等の風俗情報を除く)。
          高機能な検索システムを採用しておりますので、お客様にピッタリな情報がすぐに見つかります。
        更に店舗ごとに多彩なクーポン券などご用意しておりますのでお店に行く前に検索してクーポン券があるのかチェックしてみるのもいいでしょう。</span>
        <span><?= $this->Html->link(__('　　　　'), ['controller' => 'developer/Developers', 'action' => 'index']) ?></li>
</span>
      </div>
    </div>
      <div class="footer-copyright oki-footer-copyright">
        Copyright 2018
        <?=(2018-date('Y'))?' - '.date('Y'):'';?> OKIYORU Go All Rights Reserved.
      </div>
    <div id="return_top">
      <a href="#body" class="red"><i class="medium material-icons return_top">keyboard_arrow_up</i></a>
    </div><!-- END #return_top -->
  </footer>

 <script src="http://192.168.33.10/js/okiyoru.js"></script>
</body>
</html>
