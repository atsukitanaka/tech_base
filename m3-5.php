
 
    <?php
     
   //送信されたデータの受け取り
        $str=$_POST["str"];
        $name=$_POST["name"];
        $dnum=$_POST["dnum"];
        $invisible=$_POST["invisible"];
        $editnum=$_POST["editnum"];
        $pass=$_POST["password"];
        $Dpass=$_POST["Dpassword"];
        $Epass=$_POST["Epassword"];
     //日時の取得
        $date=date("Y/m/d H:i:s");
        $filename="mission_3-5.txt";
        // ファイルが存在すれば投稿番号に＋１
        if(file_exists($filename)){
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            $lastline=$lines[count($lines)-1];
            $latesttxt=explode("<>",$lastline);
            $num=$latesttxt[0]+1;}
        else{$num=1;}
        // 投稿を変数に代入
        $comment=$num."<>".$name."<>".$str."<>".$date."<>".$pass;
        $commentE=$invisible."<>".$name."<>".$str."<>".$date."<>".$pass;
        
        
     //値の取得   
   
     //投稿フォーム処理
    
    if(!empty($name && $str && $pass) && empty($invisible)){
    
        $fp=fopen($filename,"a");
        fwrite($fp,$comment.PHP_EOL);
        fclose($fp);
        
    }
    
      
   
   
    //削除フォーム処理
    
    //$dnumが空じゃなければ
    if(!empty($dnum && $Dpass)){
         //ファイル読み込み関数で、ファイルの中身を1行1要素として配列変数に代入する。
        $lines=file($filename,FILE_IGNORE_NEW_LINES);
        //ファイルを開き、先ほどの配列の要素数（＝行数）だけループさせる
        $fpw=fopen($filename,"w");
        //foreach($lines as $line)
        // 区切り文字「<>」で分割して、投稿番号を取得   
         for($i = 0; $i<count($lines); $i++){
          $txt=explode("<>",$lines[$i]);
            //稿番号と削除対象番号を比較。等しくない場合は、ファイルに追加書き込みを行う
                $postnum=$txt[0];
               $PW=$txt[4];
                if($postnum != $dnum)
                    {
                    fwrite($fpw,$lines[$i].PHP_EOL);
                    }
             elseif($Dpass!=$PW){
                 fwrite($fpw,$lines[$i].PHP_EOL);
             }
         }
                    fclose($fpw);     
        //va
    }

    //編集フォーム処理
if(!empty($editnum && $Epass)){
    //投稿番号の取得
    $lines=file($filename,FILE_IGNORE_NEW_LINES);
    for($i=0; $i<count($lines) ;$i++){
        $txt=explode("<>",$lines[$i]);
        $postnum=$txt[0];
        $PW=$txt[4];
        
    
        //編集番号と投稿番号が一致すればフォームに入力
        if($postnum == $editnum && $Epass==$PW){
            $editname=$txt[1];
            $editstr=$txt[2];
            $editpass=$PW;
        
    }

}}

//【編集内容が問題ない場合：投稿番号と編集対象番号を比較して、等しい場合は、ファイルに書き込む内容を送信内容に差し替える】
if(!empty($invisible && $name && $str && $pass)){
    //投稿番号の取得
    $lines=file($filename,FILE_IGNORE_NEW_LINES);
        $fpe=fopen($filename,"w");
    for($i=0; $i<count($lines);$i++){
        $txt=explode("<>",$lines[$i]);
        $postnum=$txt[0];
        //編集番号フォーム内の番号と投稿番号が一致すれば値を差し替える
        if($postnum != $invisible){
             fwrite($fpe,$lines[$i].PHP_EOL);
        }
        else{
            fwrite($fpe,$commentE.PHP_EOL);
        }
        
       
    
    }
fclose($fpe);
}

?>
    <!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission3-3</title>
    </head>
    <body>
      <form action="" method="post">
          【投稿フォーム】<br>
         名前   ：<input type="text" name="name" value=<?php if(isset($editname)){echo $editname;} ?> >　<br>
        コメント：<input type="text" name="str" value=<?php if(isset($editstr)){echo $editstr;} ?>  > <br>
        PASS:     <input type="text" name="password" value=<?php if(isset($editpass)){echo $editpass;} ?>> <br>
                　<input type="submit" name="submit"> <br>
          
          【削除番号指定用フォーム】 <br>
        <input type="text" name="dnum" placeholder="削除対象番号"> <br>
        <input type="text" name="Dpassword" placeholder="PASSWORDS"> <br> 
        <input type="submit" name="delete" value="削除"> <br>
           
          【編集番号指定用フォーム】<br>
        <input type="text" name="editnum" placeholder="編集対象番号"> <br>
        <input type="text" name="Epassword" placeholder="PASSWORDS"> <br>
        <input type="submit" name="edit" value="編集"> <br>
        <input type="hidden" name="invisible" value=<?php if(isset($editnum)){ echo $editnum;}?> >
          
      </form>
       </body>
</html> 
 <?php
 //表示用
 if(file_exists($filename)){
     $lines=file($filename,FILE_IGNORE_NEW_LINES);
        foreach($lines as $line)
            {
            $txt=explode("<>",$line);
            for($i = 0; $i<count($txt); $i++)
                {
                echo $txt[$i]." ";
                }
            echo "<br>";
                
            }
 }
    

 
    
    ?>
    
