<?php
namespace App\Controller\Component;

use Cake\Controller\Component;


class WordsComponent extends Component
{


    public function wordTranscript($word)
    {
        $trans = array("а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e", 
                       "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i","й"=>"i","к"=>"k",
                       "л"=>"l", "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
                       "с"=>"s","т"=>"t", "у"=>"u","ф"=>"f","х"=>"h","ц"=>"c",
                       "ч"=>"ch", "ш"=>"sh","щ"=>"sh","ы"=>"y","э"=>"e","ю"=>"yu",
                       "я"=>"ya",
                       "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g","Д"=>"d","Е"=>"e", 
                       "Ё"=>"yo","Ж"=>"j","З"=>"z","И"=>"i","Й"=>"i","К"=>"k", 
                       "Л"=>"l","М"=>"m","Н"=>"n","О"=>"o","П"=>"p", "Р"=>"r",
                       "С"=>"s","Т"=>"t","У"=>"u","Ф"=>"f", "Х"=>"h","Ц"=>"c",
                       "Ч"=>"ch","Ш"=>"sh","Щ"=>"sh", "Ы"=>"y","Э"=>"e","Ю"=>"yu",
                       "Я"=>"ya","ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"",
                       " "=>"-","!"=>"","("=>"",")"=>"","+"=>"","\""=>"",","=>"","«"=>"","»"=>"","."=>"-"
                       );        
        
        $word = mb_strtolower(strtr($word, $trans));
	    $word = mb_ereg_replace('(-)+', '-', $word, 'm'); 
	    return trim($word, '-');
    }
    
    
    public function changeDeclension($alias = null, $index = null)
    {
	    $array = array(
	                  'imenuemye' => array('1' => 'именуемый', '2' => 'именуемая', '3' => 'именуемое'),
	                  'gd_post' => array('1' => 'генерального директора', '2' => 'Генеральный директор'),
	                  'gb_post' => array('1' => 'главного бухгалтера', '2' => 'Главный бухгалтер')
	                  );
	    if(!$alias) {              
	        return $array; 
	    } else {
		    return $array[$alias][$index];
	    }             
    }


    /*
     * Contracts -- getSignaturesText
     */    
    public function postDeclension($alias = null, $index = null)
    {
	    $array = array(
	                  '0' => array('1' => ''),
	                  'генерального директора' => array( '1' => 'Генеральный директор'),
	                  'главного бухгалтера' => array( '1' => 'Главный бухгалтер')
	                  );
		return $array[$alias][$index];
             
    }
    
    
    
    function num2str($num) 
    {
        $nul='ноль';
        $ten=array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        );
        $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
        $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
        $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
        $unit=array( // Units
            array('копейка' ,'копейки' ,'копеек',	 1),
            array('рубль'   ,'рубля'   ,'рублей'    ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','милиарда','миллиардов',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = $this->morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        $out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }





    function num2strNumeric($num) 
    {
        $nul='ноль';
        $ten=array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        );
        $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
        $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
        $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
        $unit=array( // Units
            array('копейка' ,'копейки' ,'копеек',	 1),
            array('рубль'   ,'рубля'   ,'рублей'    ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','милиарда','миллиардов',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = $this->morph(intval($rub), '','',''); // rub
       // $out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }    
    
    
    
    /**
     * Склоняем словоформу
     * @ author runcore
     */
    function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }



    function mb_ucfirst($string) {  
         $string = mb_ereg_replace("^[\ ]+","", $string);  
         $string = mb_strtoupper(mb_substr($string, 0, 1, "UTF-8"), "UTF-8").mb_substr($string, 1, mb_strlen($string), "UTF-8" );  
         return $string;  
    }    

    /**
	 * Formatting text in tag <code_php>...text</code_php> 
	 * @param text $text
	 * return text $text  
     */    
    function setCodeColors( $text_in )
    {
	    
	    preg_match_all('|<code class="[^>]*?">(.*?)</code>|ims', $text_in, $matches);
	    
	    foreach($matches[0] as $key => $code_part) {
		    $code_part_up = $this->setColors($code_part);
		    
		    $text_in = str_replace($code_part, $code_part_up, $text_in);
	    }
       
        return $text_in;
    }    

    function setColors($text)
    {
/*

        $text = preg_replace( '|<code class="php"[^>]*?>(.*?)</code_php>|ims', '<pre class=\'php\'>$1</pre>', $text); // меняем на pre
*/
        preg_match_all('|(<code class="[^>]*?">)(.*?)</code>|ims', $text, $matches);

        $text = $matches[2][0];      

        // меняем класс для служебных слов
        $text = preg_replace( [ '|\sfunction\s[a-z_]*|i', '|\-\>[a-z_]*|i' ], '<span class=\'code_turquoise\'>$0</span>', $text);         

        $words = [ '|public|','|function|' ];
        $text = preg_replace( $words, '<span class=\'code_blue\'>$0</span>', $text); // меняем класс для служебных слов
        
        $words = [ '|form\s|','|input\s|','|button\s|','|submit|' ,'|if|','|else|','|[(*)*]|','|false|','|true|', '|null|' ];
        $text = preg_replace( $words, '<span class=\'code_turquoise\'>$0</span>', $text); // меняем класс для служебных слов
        
        $text = preg_replace( '|\$([a-z_\.]+\w*)|ims', '<span class=\'code_purple\'>$0</span>', $text); // применяем классы к переменным
        $text = preg_replace( '|\"(.*?)\"|ims', '<span class=\'code_green\'>$0</span>', $text); // применяем классы ко всему что в кавычках
        $text = preg_replace( '|\"(.*?)\"|ims', '<span class=\'code_green\'>$0</span>', $text); // применяем классы ко всему что в кавычках
        $text = preg_replace( '|\/\/ .*?\n|ims', '<span class=\'code_grey\'>$0</span>', $text); // применяем классы к комментариям
        
        return $text = $matches[1][0].$text.'</code>';	    
    }
   
    

}
