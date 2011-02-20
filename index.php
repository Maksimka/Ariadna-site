<?
session_start();
include ("blocks/db_connect.php");  /*соединяемся с базой данных*/
include ("scripts/rotator.php");
include ("scripts/maxsite_str_word.php");

if (isset ($_GET[v])) {$v = $_GET[v];}
//if (!isset ($m)) { $m = date("m"); }
//else {if (!preg_match("[0123456789]", $m)) $m=date("m");}
//echo $m;

$tab_set = "settings"; 
$query_set = "SELECT title, meta_d, meta_k, text  FROM $tab_set WHERE page = 'index'";

try {
    $res_set = mysqli_query ($db, $query_set);
    if (!$res_set) {throw new Exception("Ошибка при выполнении запроса!<br>");}
	/* Проверка на кол-во записей > 0 */
    if (mysqli_num_rows($res_set) == 0) {throw new Exception("Данные отсутствуют!");}
    $row_set = mysqli_fetch_array ($res_set);
}
catch (Exception $e) {
    echo "<div class = 'error'>".$e->getMessage()."</div>";
}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="description" content="<?= $row_set ['meta_d']; ?>" >
        <meta name="keywords" content="<?= $row_set ['meta_k']; ?>" >

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?= $row_set ['title'];?> - "Ариадна"</title>

        <? include ("./blocks/inhead.php"); ?>

    </head>

    <body>

        <!--меню -->
        <? include ("blocks/menu3.php");?>

        <!--хэдер-->
        <? include ("./blocks/header.php");?>

        <!--Все ниже меню в отдельный div-->
        <div id = "shadow">
            <div id = "content">
                <!--Выводим путь до категории-->
                <div class="path"><? echo $row_set['title']; ?></div>
                <!--Левая часть-->
                <div id="left">
                    <!--Текст главной страницы-->
                    <div class="main_text">
                        <?=$row_set ['text'];?>
                    </div>
                    <!--тут выводим новости-->
                    <?
                    try {
                    //получение текущего времени года
                        $vesna = '3,4,5';
                        $leto = '6,7,8';
                        $osen = '9,10,11';
                        $zima = '12,1,2';
                        $vrema_goda = '';

                        $curr_month = date ("m");

                        switch ($curr_month) {
                            case 1: $vrema_goda = $zima; $v_name = 'zim'; break;
                            case 2: $vrema_goda = $zima; $v_name = 'zim'; break;
                            case 3: $vrema_goda = $vesna; $v_name = 'ves'; break;
                            case 4: $vrema_goda = $vesna; $v_name = 'ves'; break;
                            case 5: $vrema_goda = $vesna; $v_name = 'ves'; break;
                            case 6: $vrema_goda = $leto; $v_name = 'let'; break;
                            case 7: $vrema_goda = $leto; $v_name = 'let'; break;
                            case 8: $vrema_goda = $leto; $v_name = 'let'; break;
                            case 9: $vrema_goda = $osen; $v_name = 'ose'; break;
                            case 10: $vrema_goda = $osen; $v_name = 'ose'; break;
                            case 11: $vrema_goda = $osen; $v_name = 'ose'; break;
                            case 12: $vrema_goda = $zima; $v_name = 'zim'; break;
                        }
                        $year =date ("Y");

                        //Установка текущего время года в зависимости от полученного параметра
                        if (isset($v)) {
                            switch ($v) {
                                case 'ves': $vrema_goda = $vesna; $v_name = 'ves'; break;
                                case 'let': $vrema_goda = $leto; $v_name = 'let'; break;
                                case 'ose': $vrema_goda = $osen; $v_name = 'ose'; break;
                                case 'zim': $vrema_goda = $zima; $v_name = 'zim'; break;
                            }
                        }


                        $tab_news = "news";
                        $query_news = "SELECT id, title, DATE_FORMAT(date, '%M %d, %Y') as date, text, screen, view,
								(SELECT count(c.id_msg) FROM news_comments c WHERE c.new = n.id) as count,
								(SELECT u.name FROM userlist u WHERE u.id = n.who_add) as who_add
								FROM news n
								WHERE DATE_FORMAT(date, '%m') in ($vrema_goda)
								AND DATE_FORMAT(date, '%Y') = $year
								ORDER BY id DESC";
                        //$query_news = "SELECT id, title, DATE_FORMAT(date, '%M %d, %Y') as date, text, screen, who_add, view,
                        //(SELECT count(c.id_msg) FROM news_comments c WHERE c.new = n.id) as count
                        //FROM news n
                        //ORDER BY id DESC";
                        $res_news = mysqli_query ($db, $query_news);
                        if (!$res_news) throw new Exception("Ошибка при выполнении запроса!<br>");
                        if (mysqli_num_rows($res_news) == 0) throw new Exception("Данные отсутствуют!<br> Возможно в просматриваемый вами временной промежуток не было сделанно не одной записи либо поврежденна база данных.");

                        while ($row_news = mysqli_fetch_array ($res_news)) {

                            $text = maxsite_str_word($row_news['text'], 100, ' ' ); //Обрезаем текст новости до 100 символов.

                            printf ("
	
									<div class='news'>
									
										<div class = 'news_title'>
											<a href = 'view_new.php?id=%s' title = '::Добавил: %s'> %s </a>
										</div>
										<div class = 'news_author_date'> <img class = 'clock' src = './img/clock.png' alt='clock'> <span>%s</span></div>", $row_news['id'], $row_news['who_add'] , $row_news['title'], $row_news['date']
                            );

                            if ($row_news['screen'] != "no") {
                                printf ("
										<div class = 'news_screen'>
											<img src = '%s' alt = '%s'>
										</div>", $row_news['screen'], $row_news['title']
                                );
                            }

                            printf ("
										<div class = 'news_description'> %s <a class = 'read_next' href = 'view_new.php?id=%s'>читать полностью &raquo;</a></div>
										<div class = 'news_stats'> Добавил: <span>%s</span> | Комментариев: <span>%s</span> | Просмотров: <span>%s</span> </div>
	
									</div>
									", $text, $row_news['id'], $row_news['who_add'], $row_news['count'], $row_news['view']  );


                        //echo "<div class='content_line' > </div>";
                        } //while

                        mysqli_free_result($res_news);

                        //вывод ссылок на предыдущий и следующий месяца

                        //include ("blocks/menu4.php");
                        echo "<div class='prevnext'>";

                        $query = "SELECT id FROM news WHERE DATE_FORMAT(date, '%m') in ($vesna) AND DATE_FORMAT(date, '%Y') = $year ";
                        $res = mysqli_query ($db, $query);
                        if (!$res) throw new Exception("Ошибка при выполнении запроса!<br>");
                        if (mysqli_num_rows($res) > 0) {
                            if ($v_name == 'ves') echo "<a class='sel' href = 'index.php?v=ves'>Весна</a>";
                            else echo "<a href = 'index.php?v=ves'>Весна</a>";
                            echo "&nbsp;|&nbsp;";
                        }
                        mysqli_free_result($res);

                        $query = "SELECT id FROM news WHERE DATE_FORMAT(date, '%m') in ($leto) AND DATE_FORMAT(date, '%Y') = $year";
                        $res = mysqli_query ($db, $query);
                        if (!$res) throw new Exception("Ошибка при выполнении запроса!<br>");
                        if (mysqli_num_rows($res) > 0) {
                            if ($v_name == 'let') echo "<a class='sel' href = 'index.php?v=let'>Лето</a>";
                            else echo "<a href = 'index.php?v=let'>Лето</a>";
                            echo "&nbsp;|&nbsp;";
                        }
                        mysqli_free_result($res);

                        $query = "SELECT id FROM news WHERE DATE_FORMAT(date, '%m') in ($osen) AND DATE_FORMAT(date, '%Y') = $year";
                        $res = mysqli_query ($db, $query);
                        if (!$res) throw new Exception("Ошибка при выполнении запроса!<br>");
                        if (mysqli_num_rows($res) > 0) {
                            if ($v_name == 'ose') echo "<a class='sel' href = 'index.php?v=ose'>Осень</a>";
                            else echo "<a href = 'index.php?v=ose'>Осень</a>";
                            echo "&nbsp;|&nbsp;";
                        }
                        mysqli_free_result($res);

                        $query = "SELECT id FROM news WHERE DATE_FORMAT(date, '%m') in ($zima) AND DATE_FORMAT(date, '%Y') = $year";
                        $res = mysqli_query ($db, $query);
                        if (!$res) throw new Exception("Ошибка при выполнении запроса!<br>");
                        if (mysqli_num_rows($res) > 0) {
                            if ($v_name == 'zim') echo "<a class='sel' href = 'index.php?v=zim'>Зима</a>";
                            else echo "<a href = 'index.php?v=zim'>Зима</a>";

                        }
                        mysqli_free_result($res);
                        echo "</div>";


                    //echo "<div id = 'shadow_bottom'></div>";

                    } //try
                    catch (Exception $e) {
                        echo "<div class = 'error'>".$e->getMessage()."</div>";
                    }



                    ?>
                </div> <!--Левая часть -->
                <!--Правая часть-->
                <? include ("./blocks/right.php");?>

            </div> <!--content-->

            <? include ("blocks/footer.php"); ?>

        </div> <!--shadow-->

        <?
        mysqli_free_result($res_set);
        include ("blocks/db_close.php");  /*разрываем соединение с базой данных*/ ?>

    </body>
</html>

