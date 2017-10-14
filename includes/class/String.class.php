<?php
require(dirname(__FILE__) . '/utf8/utf8_functions.php');
class Pagination
{
    protected $_config = array(
        'current_page'  => 1, // Trang hiện tại
        'total_record'  => 1, // Tổng số record
        'total_page'    => 1, // Tổng số trang
        'limit'         => 10,// limit
        'start'         => 0, // start
        'link_full'     => '',// Link full có dạng như sau: domain/com/page/{page}
        'link_first'    => '',// Link trang đầu tiên
        'range'         => 9, // Số button trang bạn muốn hiển thị 
        'min'           => 0, // Tham số min
        'max'           => 0  // tham số max, min và max là 2 tham số private
    );
    
    function get_config($key){
        return $this->_config[$key];
    }
    
    /*
     * Hàm khởi tạo ban đầu để sử dụng phân trang
     */
    function init($config = array())
    {
        /*
         * Lặp qua từng phần tử config truyền vào và gán vào config của đối tượng
         * trước khi gán vào thì phải kiểm tra thông số config truyền vào có nằm
         * trong hệ thống config không, nếu có thì mới gán
         */
        foreach ($config as $key => $val){
            if (isset($this->_config[$key])){
                $this->_config[$key] = $val;
            }
        }
        
        /*
         * Kiểm tra thông số limit truyền vào có nhỏ hơn 0 hay không?
         * Nếu nhỏ hơn thì gán cho limit = 0, vì trong mysql không cho limit bé hơn 0
         */
        if ($this->_config['limit'] < 0){
            $this->_config['limit'] = 0;
        }
        
        /*
         * Tính total page, công tức tính tổng số trang như sau: 
         * total_page = ciel(total_record/limit).
         * Tại sao lại như vậy? Đây là công thức tính trung bình thôi, ví
         * dụ tôi có 1000 record và tôi muốn mỗi trang là 100 record thì 
         * đương nhiên sẽ lấy 1000/100 = 10 trang đúng không nào :D
         */
        $this->_config['total_page'] = ceil($this->_config['total_record'] / $this->_config['limit']);
        
        /*
         * Sau khi có tổng số trang ta kiểm tra xem nó có nhỏ hơn 0 hay không
         * nếu nhỏ hơn 0 thì gán nó băng 1 ngay. Vì mặc định tổng số trang luôn bằng 1
         */
        if (!$this->_config['total_page']){
            $this->_config['total_page'] = 1;
        }
        
        /*
         * Trang hiện tại sẽ rơi vào một trong các trường hợp sau:
         *  - Nếu người dùng truyền vào số trang nhỏ hơn 1 thì ta sẽ gán nó = 1 
         *  - Nếu trang hiện tại người dùng truyền vào lớn hơn tổng số trang
         *    thì ta gán nó bằng tổng số trang
         * Đây là vấn đề giúp web chạy trơn tru hơn, vì đôi khi người dùng cố ý
         * thay đổi tham số trên url nhằm kiểm tra lỗi web của chúng ta
         */
        if ($this->_config['current_page'] < 1){
            $this->_config['current_page'] = 1;
        }
        
        if ($this->_config['current_page'] > $this->_config['total_page']){
            $this->_config['current_page'] = $this->_config['total_page'];
        }
        
        /* 
         * Tính start, Như bạn biết trong mysql truy vấn sẽ có limit và start
         * Muốn tính start ta phải dựa vào số trang hiện tại và số limit trên mỗi trang
         * và áp dụng công tức start = (current_page - 1)*limit
        */
        $this->_config['start'] = ($this->_config['current_page'] - 1) * $this->_config['limit'];
        
        /* 
         * Bây giờ ta tính số trang ta show ra trang web
         * Như bạn biết với những website có data lớn thì số trang có thể
         * lên tới hàng trăm trang, chẵng nhẽ ta show hết cả 100 trang?
         * Nên trong bài này tôi hướng dẫn bạn show trong một khoảng nào đó (range)
         * giống website freetuts.net vậy
        */
        
        // Trước tiên tính middle, đây chính là số nằm giữa trong khoảng tổng số trang
        // mà bạn muốn hiển thị ra màn hình
        $middle = ceil($this->_config['range'] / 2);

        // Ta sẽ lâm vào các trường hợp như bên dưới
        // Trong trường hợp này thì nếu tổng số trang mà bé hơn range
        // thì ta show hết luôn, không cần tính toán làm gì
        // tức là gán min = 1 và max = tổng số trang luôn
        if ($this->_config['total_page'] < $this->_config['range']){
            $this->_config['min'] = 1;
            $this->_config['max'] = $this->_config['total_page'];
        }
        // Trường hợp tổng số trang mà lớn hơn range
        else
        {
            // Ta sẽ gán min = current_page - (middle + 1)
            $this->_config['min'] = $this->_config['current_page'] - $middle + 1;
            
            // Ta sẽ gán max = current_page + (middle - 1)
            $this->_config['max'] = $this->_config['current_page'] + $middle - 1;
            
            // Sau khi tính min và max ta sẽ kiểm tra
            // nếu min < 1 thì ta sẽ gán min = 1  và max bằng luôn range
            if ($this->_config['min'] < 1){
                $this->_config['min'] = 1;
                $this->_config['max'] = $this->_config['range'];
            }
            
            // Ngược lại nếu min > tổng số trang
            // ta gán max = tổng số trang và min = (tổng số trang - range) + 1 
            else if ($this->_config['max'] > $this->_config['total_page']) 
            {
                $this->_config['max'] = $this->_config['total_page'];
                $this->_config['min'] = $this->_config['total_page'] - $this->_config['range'] + 1;
            }
        }
    }
    
    /*
     * Hàm lấy link theo trang
     */
    private function __link($page)
    {
        // Nếu trang < 1 thì ta sẽ lấy link first
        if ($page <= 1 && $this->_config['link_first']){
            return $this->_config['link_first'];
        }
        // Ngược lại ta lấy link_full
        // Như tôi comment ở trên, link full có dạng domain.com/page/{page}.
        // Trong đó {page} là nơi bạn muốn số trang sẽ thay thế vào
        return str_replace('{page}', $page, $this->_config['link_full']);
    }
    
    /*
     * Hàm lấy mã html
     * Hàm này ban tạo giống theo giao diện của bạn
     * tôi không có config nhiều vì rất rối
     * Bạn thay đổi theo giao diện của bạn nhé
     */
    function html()
    {   
        $p = '';
        if ($this->_config['total_record'] > $this->_config['limit'])
        {
            $p = '<ul>';
            // Nút prev và first
            if ($this->_config['current_page'] > 1)
            {
               
                $p .= '<li><a href="'.$this->__link($this->_config['current_page']-1).'">
                <i class="fa fa-angle-double-left"></i> 
                </a></li>';
            }
            
            // lặp trong khoảng cách giữa min và max để hiển thị các nút
            for ($i = $this->_config['min']; $i <= $this->_config['max']; $i++)
            {
                // Trang hiện tại
                if ($this->_config['current_page'] == $i){
                    $p .= '<li><span>'.$i.'</span></li>';
                }
                else{
                    $p .= '<li><a href="'.$this->__link($i).'">'.$i.'</a></li>';
                }
            }

            // Nút last và next
            if ($this->_config['current_page'] < $this->_config['total_page'])
            {
                $p .= '<li><a href="'.$this->__link($this->_config['current_page'] + 1).'">
                 <i class="fa fa-angle-double-right"></i>
                </a></li>';
            }
            
            $p .= '</ul>';
        }
        return $p;
    }
}

class String {
	public function crop($text,$qty) {
		$txt			=	$text;
		$arr_replace	=	array("<p>","</p>","<br>","<br />");
		$text			=	str_replace($arr_replace,"",$text);
		$dem			=	0;
		for ( $i=0 ; $i < strlen($text) ; $i++ )
		{
			if ($text[$i] == ' ') $dem++;
			if ($dem == $qty)	break;
		}
		$text		=	substr($text,0,$i);
		if ($i	<	strlen($txt))
			$text .= "... ";
		return	$text;
	}
	public function crop_style($text,$qty) {
		$txt			=	$text;
		$dem			=	0;
		for ( $i=0 ; $i < strlen($text) ; $i++ )
		{
			if ($text[$i] == ' ') $dem++;
			if ($dem == $qty)	break;
		}
		$text		=	substr($text,0,$i);
		if ($i	<	strlen($txt))
			$text .= "... ";
		return	$text;
	}
	public function cut($text,$qty) {
		$txt			=	$text;
		return substr($text,0,$qty).($qty<strlen($txt)?" ...":"");
	}

	public function analyseUrl($url) {
		$qr	=	stristr($url,"?");
		$qr	=	trim($qr,"?");
		$x	=	explode("&",$qr);
		for ($i = 0; $i <= count($x); $i++) {
			if ($x[$i] != "") {
				$y = explode("=",$x[$i]);
				$arr[$y[0]] = $y[1];
			}
		}
		return $arr;
	}

	public function getSlug($txt) {
		$text	=  self::sanitize($txt);
		return $text;
	}
	public function getLinkHtml($txt, $id = 0) {
		$id     = $id + 0;
		$text	=  self::sanitize($txt);
		if($id == 0)
			return $text.'.html';
		else
			return $text.'-'.$id.'.html';
	}
	public function getUniTxt($txt) {
		return self::UNI_2_TXT($txt);
	}

	//	Private function
	public function utf8UriEncode( $utf8_string, $length = 0 ) {
		$unicode = '';
		$values = array();
		$num_octets = 1;
		$unicode_length = 0;
		$string_length = strlen( $utf8_string );
		for ($i = 0; $i < $string_length; $i++ ) {
			$value = ord( $utf8_string[ $i ] );
			if ( $value < 128 ) {
				if ( $length && ( $unicode_length >= $length ) )
					break;
				$unicode .= chr($value);
				$unicode_length++;
			} else {
				if ( count( $values ) == 0 ) $num_octets = ( $value < 224 ) ? 2 : 3;
				$values[] = $value;
				if ( $length && ( $unicode_length + ($num_octets * 3) ) > $length )
					break;
				if ( count( $values ) == $num_octets ) {
					if ($num_octets == 3) {
						$unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
						$unicode_length += 9;
					} else {
						$unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
						$unicode_length += 6;
					}
					$values = array();
					$num_octets = 1;
				}
			}
		}

		return $unicode;
	}
	public function seemsUtf8($str) {
		$length = strlen($str);
		for ($i=0; $i < $length; $i++) {
			$c = ord($str[$i]);
			if ($c < 0x80) $n = 0; # 0bbbbbbb
			elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
			elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
			elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
			elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
			elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
			else return false; # Does not match any model
			for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
				if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
					return false;
			}
		}
		return true;
	}
	public function	UNI_2_TXT ( $text ) {
		$UNI	= array ( "á","à","ả","ã","ạ","ắ","ằ","ẳ","ẵ","ặ","ấ","ầ","ẩ","ẫ","ậ","é","è","ẻ","ẽ","ẹ","ế","ề","ể","ễ","ệ","í","ì","ỉ","ĩ","ị","ó","ò","ỏ","õ","ọ","ố","ồ","ổ","ỗ","ộ","ớ","ờ","ở","ỡ","ợ","ú","ù","ủ","ũ","ụ","ứ","ừ","ử","ữ","ự","ý","ỳ","ỷ","ỹ","ỵ","Á","À","Ả","Ã","Ạ","Ắ","Ằ","Ẳ","Ẵ","Ặ","Ấ","Ầ","Ẩ","Ẫ","Ậ","É","È","Ẻ","Ẽ","Ẹ","Ế","Ề","Ể","Ễ","Ệ","Í","Ì","Ỉ","Ĩ","Ị","Ó","Ỏ","Õ","Ọ","Ố","Ồ","Ổ","Ỗ","Ộ","Ơ","Ớ","Ờ","Ở","Ỡ","Ợ","Ú","Ù","Ủ","Ũ","Ụ","Ứ","Ừ","Ử","Ữ","Ự","Ý","Ỳ","Ỷ","Ỹ","Ỵ","ă","â","ê","ô","ơ","ư","đ","Ă","Â","Ê","Ô","Ò","Ư","Đ");
		$TXT	= array ( "a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","e","e","e","e","e","e","e","e","e","e","i","i","i","i","i","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","u","u","u","u","u","u","u","u","u","u","y","y","y","y","y","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","E","E","E","E","E","E","E","E","E","E","I","I","I","I","I","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","U","U","U","U","U","U","U","U","U","U","Y","Y","Y","Y","Y","a","a","e","o","o","u","d","A","A","E","O","O","U","D");
	
		for ($i = 0; $i < count($UNI); $i++) {
			$text = str_replace($UNI[$i], $TXT[$i], $text);
		}
		return $text;
	}
	public function	UNI_2_TCVN3 ($text) {
		$UNI	= array ( "à", "á", "ả", "ã", "ạ", "ă", "ằ", "ắ", "ẳ", "ẵ", "ặ", "â", "ầ", "ấ", "ẩ", "ẫ", "ậ", "đ", "è", "é", "ẻ", "ẽ", "ẹ", "ê", "ề", "ế", "ể", "ễ", "ệ", "ì", "í", "ỉ", "ĩ", "ị", "ò", "ó", "ỏ", "õ", "ọ", "ô", "ồ", "ố", "ổ", "ỗ", "ộ", "ơ", "ờ", "ớ", "ở", "ỡ", "ợ", "ù", "ú", "ủ", "ũ", "ụ", "ư", "ừ", "ứ", "ử", "ữ", "ự", "ỳ", "ý", "ỷ", "ỹ", "ỵ", "Ă", "Â", "Đ", "Ê", "Ô", "Ơ", "Ư");
		$TCVN3	= array ( "µ", "¸", "¶", "·", "¹","¨", "»", "¾", "¼", "½", "Æ","©", "Ç", "Ê", "È", "É", "Ë","®", "Ì", "Ð", "Î", "Ï", "Ñ","ª", "Ò", "Õ", "Ó", "Ô", "Ö","×","Ý", "Ø", "Ü", "Þ","ß", "ã", "á", "â", "ä","«", "å", "è", "æ", "ç", "é","¬", "ê", "í", "ë", "ì", "î", "ï", "ó", "ñ", "ò", "ô", "­", "õ", "ø", "ö", "÷", "ù","ú", "ý", "û", "ü", "þ", "¡", "¢", "§", "£", "¤", "¥", "¦");
	
		for ($i = 0; $i < count($UNI); $i++) {
			$text = str_replace($UNI[$i], $TCVN3[$i], $text);
		}
		return $text;
	}
	public function	u2v ($text) {
		$text = utf8_encode($text);
		$UNI	= array ("Ã","Ã ","Ã","Ã¡","Ã","Ã¢","Ã","Ã£","Ã","Ã¨","Ã","Ã©","Ã","Ãª","Ã","Ã¬","Ã","Ã­","Ã","Ã²","Ã","Ã³","Ã","Ã´","Ã","Ãµ","Ã","Ã¹","Ã","Ãº","Ã","Ã½","Ä","Ä","Ä","Ä","Ä¨","Ä©","Å¨","Å©","Æ ","Æ¡","Æ¯","Æ°","áº ","áº¡","áº¢","áº£","áº¤","áº¥","áº¦","áº§","áº¨","áº©","áºª","áº«","áº¬","áº­","áº®","áº¯","áº°","áº±","áº²","áº³","áº´","áºµ","áº¶","áº·","áº¸","áº¹","áºº","áº»","áº¼","áº½","áº¾","áº¿","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á»","á» ","á»¡","á»¢","á»£","á»¤","á»¥","á»¦","á»§","á»¨","á»©","á»ª","á»«","á»¬","á»­","á»®","á»¯","á»°","á»±","á»²","á»³","á»´","á»µ","á»¶","á»·","á»¸","á»¹");
		$VNI	= array ("AØ","aø","AÙ","aù","AÂ","aâ","AÕ","aõ","EØ","eø","EÙ","eù","EÂ","eâ","Ì","ì","Í","í","OØ","oø","OÙ","où","OÂ","oâ","OÕ","oõ","UØ","uø","UÙ","uù","YÙ","yù","AÊ","aê","Ñ","ñ","Ó","ó","UÕ","uõ","Ô","ô","Ö","ö","AÏ","aï","AÛ","aû","AÁ","aá","AÀ","aà","AÅ","aå","AÃ","aã","AÄ","aä","AÉ","aé","AÈ","aè","AÚ","aú","AÜ","aü","AË","aë","EÏ","eï","EÛ","eû","EÕ","eõ","EÁ","eá","EÀ","eà","EÅ","eå","EÃ","eã","EÄ","eä","Æ","æ","Ò","ò","OÏ","oï","OÛ","oû","OÁ","oá","OÀ","oà","OÅ","oå","OÃ","oã","OÄ","oä","ÔÙ","ôù","ÔØ","ôø","ÔÛ","ôû","ÔÕ","ôõ","ÔÏ","ôï","UÏ","uï","UÛ","uû","ÖÙ","öù","ÖØ","öø","ÖÛ","öû","ÖÕ","öõ","ÖÏ","öï","YØ","yø","Î","î","YÛ","yû","YÕ","yõ");
		for ($i = 0; $i < count($UNI); $i++) {
			$text = str_replace($UNI[$i], $VNI[$i], $text);
		}
		return $text;
	}

	public function sanitize($text) {
		$text = strip_tags($text);
		$text = change_alias($text);
		$text = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $text);
		$text = str_replace('%', '', $text);
		$text = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $text);

		if (self::seemsUtf8($text)) {
			if (function_exists('mb_strtolower')) {
				$text = mb_strtolower($text, 'UTF-8');
			}
			$text = self::utf8UriEncode($text, 200);
		}
		$text = strtolower($text);
		$text = preg_replace('/&.+?;/', '', $text);
		$text = str_replace('.', '-', $text);
		$text = preg_replace('/[^%a-z0-9 _-]/', '', $text);
		$text = preg_replace('/\s+/', '-', $text);
		$text = preg_replace('|-+|', '-', $text);
		$text = trim($text, '-');
		return $text;
	}
}