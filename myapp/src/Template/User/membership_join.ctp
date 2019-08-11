<?= $this->fetch('sidebar') ?>
<div class="container">
  <h2 id="post_title" class="rich_font">店舗掲載のご案内</h2>

  <div class="post_content clearfix">
    <p>掲載をご希望、又は検討されている経営者様へ</p>
    <p>【<?=LT['001']?>】では、県内特化型ポータルサイトとして、沖縄全域のナイト情報を提供するため(<span style="color: #ff0000;">※</span>ソープ、デリヘル等の風俗情報を除く)、２０１８年にサイトをオープンしました。</p>
    <p>今はまだ掲載店舗が少ないサイトではありますが、掲載してくださった経営者様と共に成長していきたいと考えております。</p>
    <p>今の時代、ユーザーは何処にどんなお店があるのかスマートフォンで検索する時代になりました。経営者様の店舗がどういった雰囲気のお店なのかわからず、入店を渋ってしまうお客様がいたとしたら、それは集客方法の改善が必要かも知れません。</p>
    <p>こちらのサイト【<?=LT['001']?>】は、WordPress（ワードプレス）といいます、 CMS（ コンテンツマネジメントシステム）というシステムで構築されております。WordPressは、google等の検索エンジンに非常に強く作られており経営者様の店舗も一発検索にヒットするような仕組みが備えられており、集客UPに非常に効果が期待できます。</p>
    <p>まずは半年間の無料掲載をしつつ、集客してみませんか？サイト運営者としてもまずは中身をどんどん増やしていくことが検索ユーザーにも有益な情報を提供できると考えております。</p>
    <p>どのように掲載されるのかは、下のURL先をサンプルとして用意しておりますのでご覧ください。</p>
    <div class="org-link">
      <a href="https://okiyoru.com/introduce/miyakojima-mitsuki/">ラウンジ 三月 -みつき-</a>
    </div>
  </p>
  <p>店舗掲載をご希望の方は、下のURLからユーザー登録をお願いします。</p>
  <div class="org-link"><?= $this->Html->link(__('新規登録する'), ['controller' => 'owner/Owners', 'action' => 'signup']) ?>
  </div>
</p>
<p>既に会員の方は下のURLからログインしてください。</p>
  <div class="org-link"><?= $this->Html->link(__('ログインページへ'), ['controller' => 'owner/Owners', 'action' => 'login']) ?>

</div>
</div>
</div>
