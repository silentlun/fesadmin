<?php
use yii\helpers\Url;
use common\helpers\Util;
/* @var $this yii\web\View */

$this->title = '';

?>

<div class="owl-carousel owl-theme home-banner">
    <?php foreach ($bannerModels as $r){ ?>
    <div class="item"><a href="<?= $r['url'] ?>" target="_blank"><img class="img-fluid" src="<?= $r['thumb'] ?>"></a></div>
    <?php }?>
    
</div>
<section class="content">
<div class="container">
  <div class="row">
     <div class="col-md-6">
     <div class="headline">
		<h4 class="head-title">竞赛新闻</h4>
	</div>
	<?php
		foreach ($newsModels as $r){
		?>
     <div class="media">
      <div class="date-formats mr-3"> <span><?=date('d', $r['created_at'])?></span> <small><?=date('m/Y', $r['created_at'])?></small> </div>
      <div class="media-body">
        <h5 class="media-heading"><a href="<?= $r['url'] ?>" title="<?=$r['title']?>" target="_blank"><?=$r['title']?></a></h5>
        <p><?=Util::strCut($r['description'], 70)?></p>
      </div>
    </div>
    <?php }?>
    
     </div>
     <div class="col-md-6">
     <iframe width="100%" height="550" class="share_self"  frameborder="0" scrolling="no" src="https://widget.weibo.com/weiboshow/index.php?language=&width=0&height=550&fansRow=2&ptype=1&speed=0&skin=1&isTitle=1&noborder=1&isWeibo=1&isFans=0&uid=2001651691&verifier=c37fcf74&dpc=1"></iframe>
     </div>
  </div>
</div>
</section>
<section class="content bg-gray">
<div class="container">
	<div class="heading">
		<h2 class="heading-title">竞赛分组</h2>
	</div>
	<div class="row justify-content-between">
		<?php
		$types = ['A', 'B', 'C', 'D', 'E'];
		$n = 0;
		foreach ($typeModels as $r){
		?>
		<div class="col">
			<div class="services-item">
				<i><img src="statics/images/group<?=$n?>.jpg"></i>
				<span class="c<?=$n?>"><?=$types[$n]?>组</span>
				<h3><?=$r['catname']?></h3>
				<a href="<?=$r['catdir']?>" target="_blank">分组介绍</a>
			</div>
		</div>
		<?php $n++;}?>
	</div>
</div>
</section>
<section class="content">
<div class="container">
<div class="heading">
		<h2 class="heading-title">指导单位</h2>
	</div>
	<div class="zddw text-center">
		<span>中国测绘学会</span>
	</div>
	<div class="heading mt-4">
		<h2 class="heading-title">友情链接</h2>
	</div>
	<div class="row flex-wrap justify-content-center clients">
		<?php
		foreach ($partnerModels as $r){
		?>
		<span><a href="<?=$r['url']?>" target="_blank"><img src="<?=$r['logo']?>"></a></span>
		<?php }?>
	</div>
	
</div>
</section>

		
