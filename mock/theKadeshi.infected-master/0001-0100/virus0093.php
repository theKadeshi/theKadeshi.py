<?php
$target_urls = array (
			'http://livedietweightloss.com/?a=370951&c=uwl&s=28IHH',
			'http://livedietweightloss.com/?a=370951&c=uwl&s=28IHH',
			'http://livedietweightloss.com/?a=370951&c=uwl&s=28IHH',
);
$n = mt_rand(0,count($target_urls)-1);
$rand_url=$target_urls[$n];
?>
<meta http-equiv="refresh" content="2; url=<?php echo $rand_url;?> "> 