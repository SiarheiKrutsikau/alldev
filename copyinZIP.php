<!DOCTYPE html>
<!--
//Копирует рабочий проект в папку и в zip архив cо крытыми папками и файлами
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
  //рекрусивная функция поиска фаловых путей
   function addFileRecursion($zip, $dir, $start = '')
{
	if (empty($start)) 
            {
            $start = $dir;
            }
	//glob — Находит файловые пути, совпадающие с шаблоном
        //'/{.,}??*' - glob выражение позволяет копировать системные и скрытые файлы
	if ($objs = glob($dir .  '/{.,}??*', GLOB_BRACE))
        {
		foreach($objs as $obj)
                { 
                    if (is_dir($obj))
                        {
			addFileRecursion($zip, $obj, $start);
			} 
                            else 
                            {
                                $k=str_replace(dirname($start) . '/', '', $obj);
                                //echo '</br>'.($k);
				$zip->addFile($obj, $k);
                            }
		}
                
	}
}     
        
echo "<div style='color:red'>Старт копирования рабочего каталога в ZIP архив...</div></br>";
$tm=date('d.m.Y H:i:s');
echo "<div style='color:red'> $tm </div></br>";
    function copyfolder($dirin, $dirout, $troot='off')
     {
            if($troot!='off' and $troot!='on') $troot='off';
           
            // проверяет есть ли исходный каталог для копирования
        if(!is_dir($dirin))
         {
             echo "<div style='color:red'>Нет рабочего каталога. Резервное копирование прекращено.</div></br>"; exit();
         }
          elseif(!is_dir($dirout))
           {
            echo "<div style='color:red'>Нет каталога для резервное копирования. Резервное копирование прекращено.</div></br>"; exit();
           }
        else 
        {
          echo "<div style='color:green'>Каталоги для резервного копирования найдены.</div></br>";
        }
        //название нового каталога сохранения резервного копирования
        $newput=$dirout.'\\'.basename ($dirin).'Data'.date("dmY").'Time'.date("His");
   if(is_dir($newput))
      {
           //запрещено или разрешено создавать каталог доп. если существует одноименный
         if($troot=='off' and is_dir($newput))
            {
              echo "<div style='color:red'>Конечная папка уже существует! Резервное копирование прекращено.</div></br>"; exit();
            }
            elseif($troot=='on')
              {
                  //читает каталог
                  $outcayalog=scandir($dirout);
                  $max=0;
                  foreach ($outcayalog as $catalog)
                  {
                      if($catalog=='.' or $catalog=='..')continue;

                      if(strpos($catalog, '_'))
                      {

                         //если совпадают каталоги тогда берется последняя цифра после_
                          if(substr($catalog,0,strpos($catalog, '_'))==basename($newput))
                         {
                           $putdop=substr($catalog,strpos($catalog, '_')+1);
                           $max=max($putdop, $m);
                           $m=$max;
                           echo "max неуыеличин ".$max;
                         }
                      }

                  }

                  $max++; 
                  $newput=$newput.'_'.$max;

            }
       }
     
     mkdir($newput);
   //создание zip архива
     $zipname=$newput.'\\'.'Data'.date("dmY").'Time'.date("His").'.zip';
     $zip=new ZipArchive;
     $zip->open($zipname, ZipArchive::CREATE);
     addFileRecursion($zip, $dirin);
    $zip->close();	
   }
     
     
     
 
      
//пути
//каталог откуда копируется
$in    = 'D:/webprogram/OpenServer/domains';
// каталог куда копируется 
$out    = 'A:/ziprabweb';
// разрешено или нет добавлять к папке номер, если папка существует on, off
$timeroot='on'; 
copyfolder($in,$out,$timeroot);
echo "<div style='color:green'>Резервное копирование успешно завершено!</div></br>";
$tm=date('d.m.Y H:i:s');
echo "<div style='color:green'> $tm </div></br>";
        ?>
    </body>
</html>
